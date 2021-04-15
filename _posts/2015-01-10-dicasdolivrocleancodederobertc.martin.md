---
layout: post
title: Dicas do livro Clean Code de Robert C. Martin
---

Coletei algumas notas [deste livro](http://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882) as quais valem o custo da transcrição.

A tradução destas passagens é fruto do meu esforço e provavelmente elas não são
tão boas quanto as originais. Não obstante, considero que este material serve
como um memorando conveniente dos pontos chave para a criação de código limpo.

---

Devemos ser honestos nas pequenas coisas. Isso significa sermos honestos com o
código, com nossos colegas sobre o estado do código e, acima de tudo, sermos
honestos conosco sobre o código. Nós fizemos o máximo, assim como os
escoteiros, para deixarmos "o campo mais limpo do que o encontramos"?
Refatoramos nosso código antes de fazer o *Pull Request*? Essas não são
preocupações periféricas, são questões centrais dos valores ágeis. É uma
prática recomendada do *SCRUM* incluir a refatoração dentro do conceito de
"pronto". Código limpo não insiste em perfeição, apenas em honestidade e em
fazer o melhor que nós podemos. Errar é humano; perdoar é divino. No *SCRUM* nós
deixamos tudo visível. Nós areamos a lavanderia suja. Somos honestos pois
sabemos que o estado de nosso código nunca é perfeito. Nos tornamos mais
humanos, mais dignos do divino, e mais próximos da grandiosidade nos detalhes.

---

Eu gosto que meu código seja elegante e eficiente. A lógica deve ser simples de
modo que os bugs tenham dificuldade em se esconder, as dependências mínimas e
fáceis de manter, gestão de erros completa e estrategicamente articulada,
performance próxima do ótimo para não tentar as pessoas a fazer bagunça com
otimizações sem princípios. Código limpo faz uma coisa só mas faz bem feita.

Código ruim tenta fazer muito, tem intenções fora de ordem e ambiguidade de
propósito. Código limpo é código focado. Cada função, cada classe, cada módulo
expõe uma atitude a qual permanece focada, não interrompida por detalhes
exteriores.

**Bjarne**

---

Duplicação e expressividade tomam um longo tempo até eu considerar um código
limpo. Melhorar código sujo com apenas essas duas coisas em mente faz uma
diferença extraordinária.

Duplicação; quando a mesma coisa é feita de novo e de novo é um sinal que uma
ideia na sua mente não está bem representada no código. Eu tento entender o que
é, então busco representar a ideia mais claramente.

Expressividade para mim inclui nomes com sentido. Até eu ficar contente a
tendência é eu a trocar os nomes de funções e classes inúmeras vezes.
Com ferramentas modernas renomear é um tanto fácil, então eu não fico incomodado em fazê-lo repetidamente.
Não obstante, expressividade vai além de nomes.
Eu também analiso se um método ou objeto faz mais do que apenas uma coisa.
Caso sim, eles devem ser quebrados em dois ou mais elementos.

---

Uma forma de saber se uma função esta fazendo mais de uma coisa é se você consegue extrair outra função dela com um nome que não e meramente uma redeclaração da sua implementação.

---

Classes e objetos devem ter nomes compostor por substantivos ou frases de substantivos como:
Cliente, *WikiPage*, *Conta* e *AdressParser*. Evite nomes como: *Manager*, *Processor*,
*Data* ou *Info* em suas classes. O nome de uma classe não deve ser um verbo.

---


Quando construtores são sobre escritos utilize *Factories abstratas* com métodos
que descrevem os argumentos. Por exemplo,

```
    Complex.fulcrumPoint = Complex.FromRealNumber(23.0);
```

é geralmente melhor do que

```
    Complex fulcrumPoint = new Complex(23.0);

```

---

O número ideal de argumentos para uma função é ZERO. Depois um seguido
proximamente por dois argumentos. Funções com três argumentos devem ser
evitadas sempre que possível. Mais do que três argumentos em funções requer
justificação especial de outra forma não devem ser utilizados.

---

Argumentos de *flag* são feios. Passar um booleano em uma função é uma prática
terrível. Booleanos imediatamente complicam a assinatura do método,
descaradamente proclamando que a função faz mais de uma coisa. Faz X se
a ``flag`` é verdadeira e Y se é falsa.

---

Em geral, argumentos de saída devem ser evitados. Se sua função precisa
modificar o estado de algo, ela deve modificar o estado do seu objeto!

---

O uso primário de comentários se dá para compensar nossa falha em expressar-nos
corretamente no código. Em outras palavras, se é necessário comentar, a
probabilidade é grande de que seu código tenha um design ruim.

---

Comentários mal acurados são muito piores do que nenhum comentário. Eles mentem
e enganam. Criam expectativas que não podem ser atendidas. Eles expõem e
recomendam o uso de regras antigas que não precisam ou não devem mais ser
utilizadas.

---

**Comentários mandatórios**

É um mal costume ter regras que especificam que cada função precisa der um
*dockblock*, ou que cada classe deve ter um comentário no topo. Este tipo de
comentário apenas enche o código de sujeira, propaga mentiras, e tende a criar
confusão e desorganização.

Por exemplo, requerer *dockblocks* para cada função nos leva a abominações
como as abaixo. Este *dockblock* simplesmente não incrementa em nada a leitura,
serve apenas para ofuscar o código e criar mentiras em potencial.

```
/**
 *
 * @param $title The title of the CD
 * @param $author The author of the CD
 * @param $tracks The number of tracks of the CD
 * @param $durationInMinutes The duration of the CD in minutes
 *
 */
 public addCd($title, $author, int $tracks, int $durationInMinutes)
 {
    Cd $cd = new Cd;
    $cd->title = $title;
    $cd->author = $author;
    $cd->tracks = $tracks;
    $cd->duration = $durationInMinutes;
 }
```

---

**A metáfora do Jornal**

Pense em um artigo de jornal bem escrito. Você o lê verticalmente. No topo,
você espera um cabeçalho que vai lhe informar do que se trata a história e
permitirá a você decidir se é algo que você deseja ler. O primeiro parágrafo
lhe dá a sinopse de toda a história, escondendo os detalhes minuciosos.
Conforme você prossegue para baixo, os detalhes vão aumentando até que você tem
todas as datas, nomes, citações, hipóteses e outras minuciosidades.

Em geral é uma boa analogia esperar que nossas classes sejam como artigos de
jornal. Os nomes devem ser simples mas explanatórios. Os nomes por si, devem ser o
suficiente para nos dizer se estamos na classe correta ou não. As partes
superiores do código devem ser capazes de nos informar os conceitos e
algoritmos de alto nível. Os detalhes devem crescer conforme vamos descendo na
classe, até que no final nós encontramos os mais refinados detalhes do fonte.

Um jornal é composto por vários artigos; a maioria bem pequenos. Alguns são um
pouco maiores. Bem poucos contém texto suficiente para encher uma página. Isso
torna o jornal usável. Se o mesmo fosse apenas uma história contendo um
aglomerado desorganizado de fatos, datas, e nomes, simplesmente ninguém iria
lê-lo.

---

Conceitos que são grandemente relacionados devem ser mantidos verticalmente
próximos. Claramente esta regra não funciona para conceitos que pertencem a
arquivos separados. Mas conceitos altamente relacionados não devem ser
separados em arquivos diferentes a não ser que exista uma explicação bem
específica para tanto. De fato, essa é uma das razões que variáveis protegidas
devem ser evitadas.

---

Em geral nós desejamos que funções chamem dependências que apontem na direção
"para baixo". Em outras palavras, uma função chamada deve estar abaixo na
declaração do que a função que a chamou. Isso cria um bom fluxo no código do
mais abstrato ao mais específico.

---

Objetos expõem comportamento e escondem dados. Dessa forma fica fácil adicionar
novos tipos de objetos sem modificar os comportamentos existentes. Isso também
dificulta a inclusão de novos comportamentos nos objetos existentes. Estrutura
de dados expõem dados e não tem comportamento significativo. Tornando fácil
adicionar novos comportamentos para as estruturas de dados existentes, mas
dificultando a adição de novas estruturas de dados para funções existentes.

Para uma dada parte de um sistema nós às vezes necessitamos de
flexibilidade para adicionar novos tipos de dados, então devemos
preferir estruturas de dados. Outras vezes, nós precisamos adicionar
novos comportamentos, então devemos preferir objetos.

Bons desenvolvedores de software entendem estas características e escolhem o
procedimento correto de acordo com o trabalho em mãos.

---

Objetos escodem seus dados atrás de abstrações e expõem funções que operam
neles. Estruturas de dados expõem seus dados e não têm nenhuma função
importante.

Infelizmente muitos desenvolvedores não veem claramente a distinção entre um e
outro tratando estruturas de dados como objetos (colocando regras de negócios
nelas). Isso é ruim pois cria conceitos híbridos entre estrutura e objeto.

---

Cada exceção que você lançar deve prover contexto o suficiente para determinar
a fonte e a localização do erro.

Crie mensagens de erro informativas e as passe juntamente com as exceções.
Mencione a operação que falhou e o tipo de falha.

---

Código com regras externas precisa de clara separação e testes que definem suas
expectativas. Devemos evitar deixar grande parte do nosso código saber
sobre particularidades de terceiros. É melhor depender em algo que você
controle pois de outra forma isso vai acabar controlando você.

Nós gerenciamos particularidades externas em poucos locais no código. Podemos
até encapsulá-las em um adaptador para converter nossa interface perfeita com
as especificidades da interface de terceiro. Dessa forma nosso código fala
melhor por nós, promove consistência de utilização e requer poucos pontos de
manutenção quando o código de terceiro mudar.

---

Código de teste é tão importante quanto código de produção. Não se trata de uma
importância secundária. Requer estudo, design e cuidado. Precisa ser mantido
tão limpo quanto código de produção.


Código de teste utiliza padrões de engenharia diferenciados do código de
produção. Ele ainda precisa ser simples, sucinto e expressivo, mas não
necessariamente tão eficiente. No final das contas, ele roda no ambiente de
testes e este ambiente tem necessidades diferenciadas do ambiente de produção.


Esta é a natureza do padrão duplo. Existem coisas que você nunca faria em um
ambiente de produção que são perfeitamente aceitáveis em testes. Essas coisas
usualmente envolvem memória e eficiência de *CPU*. Mas nunca envolvem aspectos
com clareza de código.

---

Testes não devem depender um do outro. Um teste não deve definir as condições
para o próximo. Você deve ser capaz de rodar cada teste independentemente e na
ordem que desejar. Quando testes dependem um do outro a falha do primeiro
causa um cascateamento de problemas tornando os diagnósticos difíceis e
escondendo defeitos.

---

Organização de classes

É importante ter convenções para estruturar classes. No padrão Java uma classe
deve começar com uma lista de variáveis. Iniciando por constantes públicas, variáveis
privadas, seguidas por variáveis com instâncias privadas. Raramente
há alguma boa razão para a existência de variáveis públicas.

Funções públicas devem seguir a lista de variáveis. É interessante colocar as
funções privadas, chamadas por funções públicas, logo abaixo da função chamadora;
dessa forma a continuidade da leitura (como um artigo de jornal) é assegurada.

---

Muitos desenvolvedores temem que um grande número de classes - com um
único propósito cada - torna mais difícil a compreensão global do funcionamento do que um pequeno
número de classes com lógica misturada.
Eles estão preocupados que talvez tenham de navegar de classe em classe para descobrir como as peças estão
dispostas.

Não obstante, um sistema com muitas classes pequenas não tem mais partes móveis
do que um sistema com poucas e grandes classes. Há a mesma quantidade de coisas
para saber sobre um sistema com classes grandes do que com um sistema com
várias classes pequenas. Então é a questão é a seguinte: você quer que suas
ferramentas fiquem organizadas em caixas com pequenos compartimentos
contendo nomes bem definidos? Ou você prefere poucos compartimentos apenas
para colocar tudo dentro?

Qualquer sistema razoável vai conter uma grande gama de lógica e complexidade.
A primeira meta na administração dessa complexidade é organizá-la de forma
que o desenvolvedor saiba onde procurar as coisas e que precise entender
apenas a complexidade das coisas diretamente relacionadas ao que ele procura. Em
contraste, um sistema com grandes classes de múltiplos propósitos insiste que
tenhamos que nos esgueirar por vários conceitos que nós não necessariamente
precisaríamos ou desejássemos saber no momento.

Para colocar claramente: nós queremos que nossos sistemas sejam compostos por
várias classes pequenas, não poucas grandes. Cada classe encapsula uma única
responsabilidade, tem apenas uma única razão para mudança, e colabora com umas
outras poucas classes a fim de atingir os desejados comportamentos do sistema.

---

**Manter coesão resulta em várias classes pequenas**

Apenas o ato de quebrar grandes funções em várias menores já causa a
proliferação de classes. Considere uma função grande como várias variáveis
declaradas dentro dela. Vamos dizer que você quer extrair uma pequena parte
desta função em uma função separada. Não obstante, o código que você deseja
extrair utiliza quatro variáveis. Você deve passar todas as quatro variáveis
como argumentos para a nova função?

Não! Se promovermos essas quatro variáveis para variáveis de instância, aí nós
podemos extrair o código sem passar um argumento sequer. Isso fará que fique
ainda mais fácil quebrar a função em pedaços ainda menores.

Infelizmente, isso também significa que nossas classes perdem coesão pois
acumulam mais e mais variáveis de instância. Mas espere! Se existe um pequeno
conjunto de variáveis de desejamos compartilhar entre algumas funções isso
significa um candidato forte para uma nova classe. Quando classes perdem
coesão, devemos divida-as em classes menores.

---

Nós geralmente esquecemos que o melhor é adiar decisões até o último momento
possível. Isso não é preguiçoso ou irresponsável; outrossim, nos possibilita
tomar decisões com a melhor informação possível. Uma decisão prematura é uma
decisão feita com conhecimento insuficiente.

---

Aprenda a biblioteca padrão de sua linguagem - conheça os algoritmos
fundamentais. Entenda como algumas das funcionalidades oferecidas pela
biblioteca resolvem os problemas.

---

**Utilize o conceito de menor surpresa**

Quando um comportamento óbvio não é implementado os leitores e usuários do
código não podem mais depender de sua intuição sobre os nomes das funções. Eles
perdem sua confiança no autor e retomam a leitura dos detalhes do código.

---

Cada vez que você ver um código duplicado saiba que ele representa uma
oportunidade perdida de abstração. Aquele código pode muito provavelmente virar uma
sub-rotina ou até uma nova classe. Encapsulando duplicações dessa forma você
aumenta o vocabulário de seu design; e outros programadores podem se beneficiar
das abstrações que você criou. Programar se torna rápido e menos tendencioso a
erros devido ao acréscimo do nível de abstração.

---

Quando um método usa assessores de outro objeto para manipular dados
dentro daquele objeto, ele inveja o escopo de classe daquele outro objeto. Ele
gostaria de estar dentro daquela outra classe para que tivesse acesso direto às
variáveis que aquele objeto manipula.

---

Variáveis com nomes mais explanatórios são geralmente melhores do que variáveis com nomes simples.
É memorável o quanto um módulo opaco pode se tornar transparente apenas por quebrar os
cálculos em variáveis intermediárias bem nomeadas.

---

Criar variáveis protegidas por padrão não é encapsular o suficiente.

---

Se você precisa inspecionar a implementação (ou documentação) de uma função
para saber o que ela faz então você deveria trabalhar mais tempo na busca por
melhores nomes ou no rearranjo das funcionalidade para que as mesmas possam
ser dispostas em funções com nomes melhores.

---


Espero que esses conceitos lhe sejam úteis assim como veem sendo para mim.

Críticas e comentários são sempre muito bem vindos.
