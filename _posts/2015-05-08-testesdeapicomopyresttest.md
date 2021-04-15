---
layout: post
title: Testes de API com  o Pyresttest
---

No projeto que estou desenvolvendo, nos deparamos com uma situação onde uma nova tarefa afetou o funcionamento de uma gama de outros serviços e, por consequência, a API HTTP teve de mudar. Se este conjunto de alterações fosse intruduzido no master logo depois do desenvolvimento o frontend ficaria quebrado até que as adaptações fossem refletidas no angular.

Visto que estávamos nos estágios iniciais do desenvolvimento, não foi considerado prudente começar a versionar os serviços na URL como é o de costume nas *APIs*. Outrossim, resolvemos mudar a API e introduzir no processo um conjunto de testes integracionais a nível HTTP, para garantir que, no momento em que a interface seja for alterada, intencionalmente ou não, todos fiquem sabendo.

Vale dizer que a prevenção de quebra na API não é o único objetivo de testes de integração. Segundo o Wikipedia "o propósito de testes integracionais é validar requisitos funcionais, performance e confiabilidade dos itens de um sistema em grande escala". Dessa forma, efetuamos uma busca por soluções que satisfaçam estas características.

### [PYRESTTEST](https://github.com/svanoort/pyresttest)
O Pyresttest é um projeto open-source escrito em Python, como o nome já indica, com o objetivo de prover um framework para testes e benchmarks de APIs REST. Escolhemos este em detrimento à outras tecnologias como o Postman e outros por ser gratuito, open source e de fácil aprendizagem outrossim, por comtemplar todas as características que testes integracionais devem comportar.

Os testes do Pyresttest são descritos em YAML ou JSON e nenhuma programação é necessária para fazê-los funcionar. A comunidade é atenciosa e altamente responsiva.

Em meu primeiro contato com a aplicação não era possível utilizar variáveis nos headers das requisições. Como isso era um fator de grande importância no caso do projeto que desenvolvo abri uma issue no Github e, em questão de uma semana, o problema estava resolvido. Reportei outras issues e todas foram respondidas ou atentidas prontamente.

#### [INSTALAÇÃO](https://github.com/svanoort/pyresttest#user-content-installation-troubleshooting-and-special-cases)

Para instalar o pyrestest você precisa utilizar o comandos abaixo, importante ressaltar que o Python esperado é o Python 2.7 longe de ser o padrão nas distribuições Linux modernas.
```bash
$ git clone https://github.com/svanoort/pyresttest.git
$ cd pyresttest
$ sudo Python2.7 setup.py install
```

---
##### Python != 2.7
Se você não utiliza o Python 2.7 como padrão, uma saída é criar um ambiente virtual como segue:

1 - Instale o virtual-env para a sua versão de Python.
No archlinux:
```
$ sudo pacman -Syu python-virtualenv
```
2 - Crie um ambiente virtual
```
pyresttest$ virtualenv -p /usr/bin/Python2.7 --distribute temp-Python
```
*A pasta temp-tython será criada e para utilizar o ambiente virtual você terá que rodar os comandos relativos à ela*

3 - Ative o ambiente virtual
```
pyresttest$ source temp-python/bin/activate
```
*Se você rodar o Python --version você verá que a versão mudou: Python 2.7.9*
Você também irá notar algo do tipo em seu terminal: *``(temp-Python)``[jean@JeanAir ApiTest]$*


OBS: Para desabilitar o ambiente virtual utilize o comando:
```
$ deactivate
```
---

Instale as dependências do Python utilizadas pelo Pyresttest

```
pyresttest$ pip install pyyaml pycurl jsonschema
```
Instale o Pyresttest

```
pyresttest$ sudo Python2.7 setup.py install
```
Rode a instalação do pyrestest (descrita acima), após a instalação você pode utilizar os testes livremente.
Exemplo rodando um teste:

```
testsfolder$ Python3.7 /usr/bin/resttest.py http://clipp-back.dev ./finance.get-summary-expense_test.yaml --interactive=true
```


#### UTILIZAÇÃO
Apesar de a documentação comentar a possibilidade, não tive contato com o Pyresttest em json. O problema é que os exemplos se encontram, exclusivamente, em YAML. Sendo assim, o resto do post também apresentará o conteúdo em YAML.

Existem 5 elementos de nível principal na API:
- config or configuration: configuração global
- test: a definição de um teste
- benchmark: a definição de um benchmark
- url: a URL para efetuar alguma operação (não consegui fazer funcionar ainda)
- import: a possibilidade de importar uma configuração pré-determinada para possibilitar o reúso (não consegui fazer funcionar ainda)

#### TESTES
Abaixo segue o primeiro teste, uma forma de autenticação.
authenticate_test.yaml
```
- config:
## 
    - testset: "Authenticate"
- test:
    - group: "Application"
    - name: "Authenticate"
    - url: "/rpc/v1/application.authenticate.json"
    - method: "POST"
    - body: "login=admin@domain.com&password=adminpasswd"
    - expected_status: [200]
```
O exemplo é bem intuitivo, basicamente você configura um teste na seção ```test```, este deve conter uma estutura HTTP com URI, cabeçalho e body (opcionalmente).
As configurações ```testset``` e ```group``` são formas de agrupar os testes e não afetam o funcionamento do teste.
A primeira maneira de testar é validando o STATUS HTTP, neste caso 200. Na maiora das vezes, testar apenas o status HTTP não é o suficiente, precisamos saber se o body contém os dados necessários para a correta conformidade com seus requisitos. Para validar o corpo de um resultado HTTP existem os validators.

##### VALIDATORS

Os validators servem para validar os dados retornados por uma requisição HTTP.
Existem dois validators principais.
- Comparadores: Servem para comparar algum dado do resultado a um especificado
- Extratores: Servem para determinar se algum dado existe no resultado

```
- config:
    - testset: "Reseller"
- test:
    - group: "Application"
    - name: "Get Representation List"
    - url: "/rpc/v1/application.get-representation_list-client.json"
    - method: "POST"
    - body: "month=12&year=2014"
    - expected_status: [200]
    - headers: {"Authorization": "$access_token", "Content-Type": "application/x-www-form-urlencoded"}
    - validators:
        - compare: {jsonpath_mini: "0.subscription_id",     comparator: "eq",     expected: 3}
        - compare: {jsonpath_mini: "0.plan",     comparator: "eq",     expected: "Package1"}
        - compare: {jsonpath_mini: "0.client.id",     comparator: "eq",     expected: 2}
        - compare: {jsonpath_mini: "0.client.name",     comparator: "eq",     expected: "Client2"}
        - compare: {jsonpath_mini: "0.status.id",     comparator: "eq",     expected: 9}
        - compare: {jsonpath_mini: "0.status.description",     comparator: "eq",     expected: "Overdue"}
        - compare: {jsonpath_mini: "0.expiration_date",     comparator: "eq",     expected: "2014-12-01"}
        - compare: {jsonpath_mini: "0.punctuation",     comparator: "eq",     expected: 7000}
        - compare: {jsonpath_mini: "0.money",     comparator: "eq",     expected: 700}
```

Este teste faz um requisção autenticada (enviando o $access_token),  e espera um conjunto de dados; neste caso, um array json com vários campos por linha.
A primeira linha contém uma validação para cada campo. A chave ``jsonpath_mini`` define como os dados devem ser minerados, neste caso, através do caminho json. No exemplo está-se lendo cada coluna da primeira linha do resultado e comparando-se os valores com os esperados.
OBS: O ``$access_token`` não faz parte da notação do Pyresttest, é apenas uma chave que eu uso para localizar onde o access token deve residir e dou replace em runtime pela access token gerada em uma autenticação feita em CURL. Esta "gambi" foi introduzida porque inicialmente o Pyresttest não suportava variáveis de ambinte em cabeçalhos HTTP. Atualmente opções mais elegantes estão disponíveis.

##### MÚLTIPLOS TESTES

É possível ter vários testes e benchmarks no mesmo arquivo. Segue um exemplo:

```
- config:
    - testset: "Reseller Ranking Positions"
- test:
    - group: "Application"
    - name: "Get country ranking position of client"
    - url: "/rpc/v1/application.get-country_ranking_position-client.json"
    - method: "POST"
    - body: "country_id=1"
    - expected_status: [200]
    - headers: {"Authorization": "$access_token", "Content-Type": "application/x-www-form-urlencoded"}
    - validators:
        - compare: {jsonpath_mini: "position",     comparator: "eq",     expected: 1}
- test:
    - group: "Application"
    - name: "Get state ranking position of client"
    - url: "/rpc/v1/application.get-state_ranking_position-client.json"
    - method: "POST"
    - body: "state_id=23"
    - expected_status: [200]
    - headers: {"Authorization": "$access_token", "Content-Type": "application/x-www-form-urlencoded"}
    - validators:
        - compare: {jsonpath_mini: "position",     comparator: "eq",     expected: 1}
```
Cabe ao programado escolher a separação de melhor se adeque a suas necessidades. Gosto de deixar testes e benchmarks em arquivos separados pois facilita na hora de integrar com o Jenkins.

##### RODANDO OS TESTES

Para rodar um arquivo contendo um teste basta chamar o executável do Pyresttest com a URL de destinho e o arquivo contendo o teste.
```
$ resttest.py http://clipp-back.dev get-current_level-client_test.yaml
```
#### BENCHMARKS

Validar a performance de partes do sistema também é papel de testes integracionais. Através dos benchmarks do pyrestest, você consegue responder perguntas como:
- Qual a carga máxima de usuários que este meu serviço suporta paralelamente?
- Qual o tempo médio de execução deste serviço?

Segue o primeiro benchmark

```
- config:
    - testset: "Authenticate"
- benchmark:
    - name: "Authenticate benchmark"
    - url: "/rpc/v1/application.authenticate.json"
    - method: "POST"
    - body: "login=admin@domain.com&password=adminpasswd"
    - warmup_runs: 7
    - 'benchmark_runs': '101'
    - output_file: 'bench-result/authenticate.csv'
    - metrics:
        - total_time
        - total_time: mean
        - total_time: median
        - size_download
        - speed_download: median
```

- ``warmup_runs`` é o número  total de vezes que o programa rodará antes de começar a coletar dados, adequado para a criação de cache;
- ``bench_runs`` é o total de vezes que os testes rodarão, o valor default é 100;
- ``output_file`` (opcional), define onde os dados de benchmark serão armazenados;
- ```metrics``` são os dados de performance coletados, pode-se coletar os próprios resultados das chamadas ou utilizar [métricas já definidas do Pyresttest](https://github.com/svanoort/pyresttest#user-content-metrics).

```
- config:
    - testset: "Get User Menu Tree"
- benchmark:
    - name: "Get User Menu Tree benchmark"
    - url: "/rpc/v1/application.get-menu_tree.json"
    - method: "POST"
    - headers:
        - Authorization: "$access_token"
    - warmup_runs: 0
    - 'benchmark_runs': '10'
    - output_file: 'bench-result/get-menu-tree_bench.csv'
    - metrics:
        - total_time
        - total_time: mean
        - total_time: median
        - size_download
        - speed_download: median
```

Como aqui disposto, algumas métricas interessantes do Pyresttest são:
- ``total_time``: tempo total
- ``total_time: mean``: média do tempo total
- ``total_time: median``: mediana do tempo total

A saída padrão de um benchmark é um arquivo csv como o seguinte:

```
Benchmark,Get User Menu Tree benchmark
Benchmark Group,Default
Failures,0
Results,
size_download,total_time
193.0,0.038495
193.0,0.031943
193.0,0.032668
193.0,0.035171
193.0,0.032769
193.0,0.033024
193.0,0.032837
193.0,0.032726
193.0,0.034357
193.0,0.032352
Aggregates,
total_time,mean,0.033634199999999996
total_time,median,0.032803
speed_download,median,5883.0
```

Os dados são facilmente mineráveis e, muito provavelmente, uma boa fonte de relaórios.

##### RODANDO OS BENCHMARKS

Para rodar um arquivo contendo um benchmark basta chamar o executável do Pyresttest com a URL de destinho e o arquivo contendo o benchmark.
```
$ resttest.py http://clipp-back.dev get-menu-tree_bench.yaml
```

#### Concluindo...
O Pyresttest é uma boa opção para quem preza legibilidade, liberdade e custo. A comunidade é prestativa e tende a satisfazer as necessidades dos usuários, quando estas condizem com o esperado da aplicação. Em suma, recomendo e gostaria de saber sua opinião sobre o assunto, já utilzou a ferramenta?
Conhece alguma similar ou melhor.
