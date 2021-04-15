---
layout: post
title: Vamos falar de composição
keywords: Composição
---

Na faculdade e na indústria nos deparamos com muitas "boas práticas" que a
experiência mostra serem longe do ideal. Nesse post quero explorar isso no
quesito composição.

## Req1 - Buscar Usuário

Considere o problema de buscar o perfil de um usuário no banco de dados.
A opinião "mainstream" do que é considerado boas práticas é bem representado
pelo código abaixo (com sérias simplificações). Preciso pegar o perfil de um
usuário. Crio uma classe que recebe o banco (ou alguma abstração do banco) e
efetuo a busca.

```php
class Profile {
    public function __construct($db)
    {
        $this->db = $db;
    }

    function get(int $id) {
        return $this->db->query('Select * from User where id = %i', $id);
    }
}
```

Não tenho tantos problemas até aí. Vou reservar as críticas pra depois.
Agora vamos imaginar que temos um requisito extra.

## Req2 - Guardar em cache

Precisamos guardar em cache o perfil do usuário. De modo que depois de
requisitar a primeira vez ele não vá até o banco novamente.
Bom, dado o código acima, imagino que a solução que 99% dos devs iriam seguir
seria algo nessa linha:

```php
class Profile {
    public function __construct($db, $cache)
    {
        $this->db = $db;
        $this->cache = $cache;
    }

    function get(int $id) {
        if ($this->cache->has($id)) {
            return $this->cache->get($id);
        }
        $user = $this->db->query('Select * from User where id = %i', $id);

        $this->cache->put($id, $user);

        return $user;

    }
}
```

Qual o problema dessa solução? Bom, primeiramente uma solução assim vai requerer
bastante mocks pra testar. Sou forte defensor da heurística **o que torna se
código difícil de testar está errado**. Mas tem algo mais fundamental aí que é o
assunto desse post. O que é a operação de pegar o perfil quando pensamos
*intuitivamente*? Envolve cache? Não. O código construído dessa maneira "empilha"
complexidade e semântica de negócio, deixando de lado a intuição em favor da
necessidade de negócio. Quanto mais requisitos temos que atender, mais quebramos
as expectativas do leitor.

Esse tipo de arquitetura dá origem ao problema chamado "banana gorilla".
Quando no meu sistema pedi uma banana e recebi uma banana, só que junto
veio um gorila segurando ela.

![bannana gorilla](https://i.imgur.com/kZisnyS.jpg)

Será que tem uma forma melhor?


Vamos tentar fazer esse código novamente, de um jeito diferente.

## Req1 - Buscar Usuário

O que envolve a busca do usuário na sua *essência*?
*Envolve configurar corretamente um dispositivo de IO (nesse caso o banco) para
retornar os dados corretos pra nós*. E qual a forma mais simples de fazer isso?

```php
function getProfile(callable $persitence, int $id) {
    return $persistence('Select * from User where id = %i', $id);
}
```
Só uma função comunica tudo que precisamos. E note o uso do
callable. Não estou mais usando a api do banco no get-profile. Assumo
que ela venha pronta pra mim, algo nessa linha: `$persistence =
[$db, "query"];`. Mas o mais importante: é dessa forma que pensamos
intuitivamente na operação de pegar um perfil.

Só que ainda tem um problema. No modelo tradicional conseguimos separar o que é
construção do que é uso. O banco de dados entra na construção do objeto e em
"runtime" você só precisa passar o id. Como é que fazemos isso com uma função?

## Aplicação parcial

Várias linguagens de programação tem o conceito chamado de aplicação parcial.
Onde você reduz uma função de múltiplos argumentos pra múltiplas funções de um
argumento.

```php
$append3 = function($a, $b, $c) {
    return [$a, $b, $c];
};
$append1And2 = partial($append3)(1)(2);
$append1And2(5)
//[1,2,5]
$append1And2(9)
//[1,2,9]
```

Uma implementação básica de aplicação parcial é assim:

```php
function partial(callable $callable, ...$args) {
    $arity = (new \ReflectionFunction($callable))
        ->getNumberOfRequiredParameters();
    return $args[$arity - 1] ?? false
    ? $callable(...$args)
    : function (...$passedArgs) use ($callable, $args) {
        return partial($callable,
            ...array_merge($args, $passedArgs)
        );
    };
}
```

Não é importante entender como a função partial funciona. O
importante é compreender como usá-la. Com aplicação parcial em mãos
conseguimos separar a construção da nossa função de seu uso.

```php
$getProfileConcrete = partial('getProfile')([$db, 'query']);
$getProfileConcrete(666);
//[
//  'id' => 666,
//  'name' => 'Gandalf',
//]
```

Feito. Agora cumprimos o primeiro requisito da forma mais simples possível.
Vamos ao segundo.

## Req2 - Guardar em cache


Primeiramente temos que pensar qual é a essência do problema que
estamos resolvendo. O cache está servindo o propósito de quando os
dados de uma chamada já estão dispiníveis pegar do cache, senão
pegar da própria chamada. Existe um design pattern exatamente com esse
propósito chamado [memoize](https://en.wikipedia.org/wiki/Memoization).

```php
function memoize($func)
{
    return function() use ($func)
    {
        static $cache = [];

        $args = func_get_args();
        $key = md5(serialize($args));

        if ( ! isset($cache[$key])) {
            $cache[$key] = call_user_func_array($func, $args);
        }

        return $cache[$key];
    };
};
```


Como apontei anteriormente o fato do guardar em cache estar dentro do get
profile era um problema. Com o memoize é o contrário que acontece. O memoize
recebe uma função e só executa ela (caso necessário). A diferença nesse caso é o
acoplamento. Antes a função get-profile tinha  uma operação específica de cache
dentro dela. Agora temos uma implementação genérica de cache que pode ser usada
em qualquer função.

E como juntamos as duas coisas?

```php
$getProfileConcrete = partial('getProfile')([$db, 'query']);
$getProfileConcreteMemoized = memoize($getProfileConcrete);
$getProfileConcreteMemoized(666);
//GO TO THE DATABASE
//[
//  'id' => 666,
//  'name' => 'Gandalf',
//]
$getProfileConcreteMemoized(666);
//DON'T GO TO THE DATABASE
//[
//  'id' => 666,
//  'name' => 'Gandalf',
//]
```

Agora compomos a função get profile com o memoized gerando uma nova função:
`getProfileConcreteMemoized`. O comportamento é exatamente o mesmo do exemplo
(1) . Quanto ao funcionamento, antes contruíamos tudo de antemão no construtor
e, em runtime, executávamos a api. Agora vamos reduzindo as funções aplicando
suas dependências até sobrar apenas a interface que queremos expor em runtime
`callable(int $id)`. Se precisamos fazer algo extra na função colocamos funções
ao redor dela.

Vamos revisar os problemas levantados anteriormente. Antes era difícil testar,
agora é trivial, *nada precisa ser mocado*, visto que as funcões fazem
apenas uma coisa. **As funções são intuitivas**. Quem vai disputar que a
implementação mais simples de get-profile é a demonstrada acima? E isso é um
fator vital na construção de sistemas que duram. O fato de ser difícil (e feio)
adicionar complexidade por dentro (complexidade vertical), ao invés de por
fora (complexidade horizontal). Pra adicionar mais requisitos ao get profile é
trivial.

É só seguir a seguinte fórmula:

**1 - Qual é a interface mais simples e indiscutível do problema que eu preciso
resolver?**

Vamos dizer que é um logger

```php
$logger = function(string $str);
```

Bom, a interface mais simples é receber uma string pra logar.
Se for um log de arquivo talvez tenha que ser maior:

```php
$fileLoger = function($fileName, string $str) {
    file_put_contents($fileName, $str);
};
```

**2 - Use aplicação parcial pra injetar dependências**

Na hora de usar só estamos interessados em passar uma string, então vamos
reduzir com aplicação parcial:

```php
$fileLoggerContrete = partial($fileLogger)('/tmp/foo');
```

Feito. Temos um logger.
**3 - Junte as funções com composição horizontal**


```php
$serviceLogger = (callable $logger, $serviceName, callable $service) {
    return function ($args) use ($logger, $service, $serviceName) {
        $logger("Service ".$serviceName." called with params ".serialize($args));
        return call_user_func($service, $args);
    }
};

$loggedGetProfile = $serviceLogger(
    $fileLoggerContrete,
    'getProfile',
    $getProfileConcreteMemoized
);

//GO TO THE DATABASE
//[
//  'id' => 666,
//  'name' => 'Gandalf',
//]
// AND LOG
// Service getprofile called with params {666}
```

Pronto! Implementamos um get-profile que guarda em cache e faz log sem precisar
sujar o código get-profile. Melhor que isso. Todos esses componenetes criados
são de propósito genérico e podem compor outros serviços sem nenhuma duplicação.
Outro ponto iteressante é que reduzindo as api's as seus callables fundamentais
não temos nenhum acoplamento a biblioteca de terceiros no código em si.

Ouvi boatos que aplicação parcial está vindo para o PHP como um componente da
linguagem. Se isso acontecer vamos começar a ver cada vez mais implementações
nesse estilo. Mas nada impede de começarmos agora :).


