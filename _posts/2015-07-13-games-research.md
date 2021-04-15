---
layout: post
title: A collection of summaries about Html Game Development
---

### Games independentes - LEMES, David Oliveira Este é um trabalho meio
extenso, 159 páginas para ser exato. Apesar do nome um tanto genérico,
o conteúdo dirige-se mais para a criação de games com "ambientes
virtuais", tipo simulação, rpg. Não obstante, sempre que possível, o
autor tenta tangenciar com o assunto "indie".

A coisa que achei mais legal sobre o trabalho é sua numerosa quantidade
de listas legais. Desde a definição das categorias dos jogos até os
formatos de áudio e seus codecs.

Exemplo: >O que os jogadores querem? - Desafio - Socializar -
Experiência solitária - Respeito (ranking) - Fantasia


O trabalho também contém uma grande quantidade de dicas sobre vários
aspectos da criação de jogos.

Para exemplificar, o autor fala que a criação de enigmas por nível
é algo importante (no level-design), e indica que estes enigmas: não
tenham resultados booleanos (vitória ou derrota), que não contem
tempo, e que não matem o jogador, entre outras dicas.

Outra dica válida, sobre programação:

>Começar a desenvolver um game ao mesmo tempo que aprender uma
linguagem não é recomendado em nenhum momento por um simples motivo:
a medida que se aprende a desenvolver em determinada linguagem, o
conhecimento torna a resolução de problemas mais fácil e por
consequência, evita-se o retrabalho.

O autor ressalta também a importância da gerência do jogo.
Sublinhando a necessidade imprescindível de um documento de design.

A conclusão contém umas definições interessantes com o intuito de
"reforçar" o que foi dito esparsamente. Ex: >Organizar as ideias é
o primeiro passo para começar a produção de um game. Esta ideia se
enquadrará em um gênero de game. É interessante notar que por trás
de cada gênero de jogo exite uma mecânica e um gênero narrativo que
faz com que o game funcione como tal. A mecânica de um jogo é seu
conjunto de regras, possibilidades de ações e decisões, e variedade
de respostas do sistema no game.


O trabalho no geral disponibiliza um bom conteúdo teórico sobre
aspectos gerais dos jogos, não adentrando especificamente em qualquer
assunto - como programação ou design. No geral, me parece ser uma boa
referência para trabalhos interessados em jogos.

### Building a Cross-Platform Mobile Game with HTML5 - BARNETT, Joshua

Basicamente o autor explora os prós e contras da construção de      .
jogos multiplataforma em HTML5 indo ao encontro de suas tecnologias    .
chave com uma boa revisão e construção de um protótipo Aborda      .
precisamente o processo de construção do jogo, do ponto de vista do  .
desenvolvedor, chegando a detalhes bem específicos. Como por exemplo  .
qual a IDE utilizada, por quais motivos. Quais os passos tomados       .
durante o desenvolvimento, suas mudanças de opinião que quanto à    .
tecnologias, etc                                                       .


Alguns aspectos especiais deste trabalho constam abaixo.

#### Aborda pontos vitais na construção de experiências gratificantes
em Jogos

Sublinha que o *feedback* é a chave dos jogos multiplataforma. O
*feedback* não contínuo e randômico tem melhor efeito que o oposto.

> O processo de design deve ser um meio de combinar lógica e
informação, para criar uma forma satisfatória em que basear as
características jogo.

>O processo de o jogador entender por si a mecânica do jogo é um
componente vital para a sua satisfação. Se ele não entender as
regras do jogo quase que instantaneamente muitas pessoas vão perder o
interesse e desistir rapidamente.

>Quando repetidamente testando, os desenvolvedores ficam acostumados com
o jogo. Isso leva-os a subestimar os problemas de acessibilidade do jogo
enfrentados pelos novos jogadores.

#### Conta com boas definições técnicas sobre o HTML

Exemplo: > Essencialmente, Gulp trabalha com *streams* de arquivos para
dentro e fora dos módulos do node possibilitando que a aplicação
se transforme em uma variedade de combinações. Uma vez que a
transformação é completa, a saída pode ser escrita em um arquivo no
sistema. Essa forma de trabalhar com *streams* é possibilitada pelo
Node.js, sendo altamente eficiente comparado com a maioria dos sistemas
de *build*, visto que não existem arquivos temporários para serem
escritos em disco (tudo é feito em tempo de execução utilizando
objetos de virtuais).

#### Alguns detalhes interessantes da história do HTML

> A API de áudio web parece ser uma melhor alternativa à *tag* de
áudio. Não obstante, essas tecnologia é muito mas nova que o elemento
``<audio>`` e ainda precisa ser implementados na maioria dos navegadores
comerciais, com exceção do Safari do iOS versão 6.0-7.0.

#### Algumas conclusões bacanas

> O processo de desenvolvimento de aplicações HTML5 está em constante
fluxo de aperfeiçoamento e novos métodos, técnicas, e ferramentas
estão aparecendo todo o tempo. Desenvolvedores precisam escolher um
conjunto de ferramentas que os possibilite expressar sua criatividade,
possibilitando-os a trabalhar com produtividade e eficiência. Isso é
sem dúvida algo fortemente influenciado pelas preferências pessoais,
experiência e opiniões à respeito de boas práticas.


Em geral, minha opinião é que este trabalho é um bom exemplo do que
se atinge com empenho. Está bem escrito, aborda os pontos certos e é
profundo o suficiente para sustentar trabalhos futuros.

## DEVELOPING EFFECT OF HTML5 THECHNOLOGY IN WEB GAME - Yu Zhang, 2012

Pelo enunciado, o trabalho busca discutir meios de melhorar a
arquitetura dos jogos aplicando as tecnologias do HTML5. Mas no final de
contas, trata-se muito mais de uma breve revisão de alguns componentes
chave do HTML5. Não há nenhuma menção durante o desenvolvimento do
trabalho da construção de algo prático.

Alguns pontos interessantes:

Zhang declara que os maiores problemas dos jogos são o conteúdo,
experiência e operação.

> Jogo web é a combinação de um site com um jogo.


O autor comenta que são poucos os trabalhos científicos aplicando o
HTML5, a grande maioria trata apenas de aspectos mercadológicos do
HTML5.


> Desenvolvedores de jogos web podem rapidamente satisfazer as
necessidades de seus jogadores, mantendo-os leais a tecnologia HTML5.


Referenciado o iRsearch, aponta que mais de 450 milhões de usuários
tem capacidade de aceleração de gráficos 3D.


> Devido ao nível de suporte em cada navegador ser inconsistente, a
popularização do HTML5 para jogos ainda vai tomar um grande tempo.


Para resumir, achei este trabalho carente de cientificidade; não
obstante, algumas declarações são interessantes e dignas de nota.

---

## Smat Phones Application development using HTML5 and related
technologies: A tradeoff between cost and quality - Hasan et al, 2012
<!-- revisar referências 11 e 7 -->

Os autores avaliam aplicações em HTML5 através dos fatores de
qualidade da ISO9126 (funcionalidade, usabilidade, eficiência,
manutenibilidade, confiabilidade e portabilidade) e os possíveis custos
em comparação com desenvolvimento nativo.


> A maior dificuldade em capturar uma base de usuários é que o mercado
de dispositivos móveis é muito fragmentado e não existe uma única
plataforma popular.


Contém boas especificações técnicas das tecnlogias estudadas.

> Uma das grades limitações do HTML era a ausência de capacidade
de armazenamento de dados. Armazenamento no lado do cliente é um
requerimento básico para qualquer aplicação moderna. Essa área
era ode as aplicações nativas detinham grande vantagem sobre as
aplicações web. O HTML5 solucionou este problema introduzindo várias
formas de armazenamento de dados.

> O maior problema com as API's de áudio e de vídeo do HTML5 é
a disputa entre os codecs dos navegadores. Por exemplo, Mozilla e
Opera suportam Theora, já o Safari suporta H.264 que também é
suportado pelo IE9. Ambos, Iphone e Android suportam H.264 em seus
navegadores. A W3C recomenda OggVorbis e OggTheora para áudio e vídeo
respectivamente.


> CSS3 é dividido em vários módulos. Cada módulo é independente e
existem cerca de 50 deles.


> Apesar da grande maioria dos recursos dos dispositivos estar presente
em HTML5 ainda existem muitas funcionalidades faltando para este tipo
de aplicação. Por exemplo, não podemos mudar a imagem de fundo do
dispositivo, ou adicionar toques etc. Similarmente, existem muitas
APIs de nuvem como os serviços de impressão do ICloud ou Google
cloud que estão disponíveis para aplicações nativas mas não para
HTML5. Outros serviços utilitários como o C2DM do Google que está
disponível para desenvolvedores Android para utilizar serviços de
*push* também não estão disponíveis para o HTML5.

<!-- > Construir aplicações com tecnologias da Web é sempre diferente
e desafiador. -->


Explora bem os aspectos de qualidade relevantes para aplicações em
HTML5, baseando-se na ISO9126.

> De acordo com uma pesquisa, para um usuário uma tarefa é
instantânea se ele leva até 0.1 segundos para ser executada. Se a
tarefa toma aproximadamente um segundo então a demora será notada mas
o usuário não se incomodará com ela. Entretanto, se a tarefa leva
aproximadamente 10 segundos para terminar o usuário então começa a
ficar aborrecido e esse é o limite que algum feedback deve ser dado
para um usuário.

Conta com uns comparativos de performance por navegador interessantes os
quais foram aplicados ao protótipo desenvolvido na pesquisa.

> A flexibilidade de manutenção de código em JavaScript é muito
dependente do expertise da pessoa que está escrevendo o código.
Escrever código "sustentável" em JavaScript é mais difícil se
comparado com Java ou C# mas, aplicando bons padrões de design, é bem
possível escrever bom JavaScript.


Por fim, conlui prevendo um bom futuro para as tecnologias e quantifica
o custo efetivo encontrado na pesquisa do HTML5 em relação a
alternativas nativas.


> Conforme JavaScript vai ganhando importância rápido progresso é
feito por diferentes empresas a fim de prover boas ferramentas de debug
e inspecionamento para JavaScript.


> O tempo de desenvolvimento de uma aplicação em HTML5 é 67% menor
que aplicações nativas. Isso mostra o custo efetivo de aplicações
baseadas em HTML5. A real vantagem de aplicações em HTML5 é o suporte
horizontal entre as plataformas - que é a maior razão por trás do
custo efetivo.

Minha opinião é que é um ótimo trabalho, talvez requeira maior rigor
nas metricas comparativas; não obstante, é bem instrutivo, aborda os
temas de maneira sensata e racional. Recomendo a leitura!


##  Viability of developing cross-platform mobile business applictions
using HTML5 mobile framework - Morony Joshua

Estuda um caso real para a construção de aplicações de negócio em
HTML5 como solução de base de código única.


Existe uma noção muito enraizada de que portabilidade e funcionalidade
são uma dicotomia entre web e nativo.

Determina a viabilidade se a aplicação puder ser desenvolvida sem
nenhuma outra tecnologia além de JavaScript CSS e HTML.

JavaScript já é capaz de competir com código compilado.

 <!-- Conta com um gráfico interessante sobre as estratégias de
desenvolvimento mobile. -->

Lista as vantagens da web segundo a pesquisa:

- Única base de código com grande percentual de reúso, não requer
manter SDK's;

- Evolução constante com grande número crescente de API's de
dispositivos inteligentes sendo disponibilizado para JavaScript;

- Tem potencial de diminuir o tempo e custo de desenvolvimento;

- A opinião comum tende a favorecer aplicações nativas.

Características nativas: Grande funcionalidade, melhor performance e
experiência de usuário.

Característica da web: suporte através das plataformas

Aborda muitos frameworks nativos multiplataforma.

Aponta que uma das militações do JavaScript é a falta de tipagem o
que dificulta no debug.


Lista as estratégias ao desenvolver multiplataforma para mobile:

- Frameworks que utilizam tecnologias e renderizam a aplicação
- Frameworks que através de um navegador interpretam código
- Frameworks que dinamicamente oferencem um sdk e convertem diretamente
- Frameworks que para código nativo

Existem vários elementos de aplicações mobile que os usuários
consideram padrão, recriar esses itens com HTML5 é complexo. Abstrair
através de frameworks torna esse processo muito mais fácil.

Frameworks mobile:

Sench touch; jQuery mobile jQT Intel App Framework PhoneGap Build
Appcelerator Titanium Xamarin Corona Unity 3D

Elabora uma lista de funcionalidades comuns em aplicações mobile:

Captura de foto Captura de vídeo Captura de áudio Vibração Acesso  ;
a lista de contatos Persistência de dados Banco de dados relacional   ;
Acesso a fotos Geolocation Aceleração Orientação Toque Compara de  ;
dentro da aplicação Integração com Facebook                        ;

Compara o que foi determinado disponível para as plataformas alvo
(Android e IOS).

O autor foca muito na solução sencha, a ponto de deixar a solução
web em segundo lugar.

### Conclui que HTML5 não é viável em geral para aplicações
de negócios - por uma perspectiva de funcionalidades.

## Cascading Style Sheets, PhD thesis - Håkon Wium Lie

Mailing lists we're crucial for bringing together the web community in
the early years, and hypertext archives of mailing lists quickly sprang
up in the early 1990s. Today, a decade later, these archives provide
valuable insights to web's design and development.

The term *style sheet* is used in traditional publishing as a way to
"ensure consistency" [Chicago, 1993] in documents.

With the introduction of the web the focus of style sheets is shifted
from being an author's tool in the authoring process to being a tool for
content reuse after the content has been generated.

## Graphical Potential Games - Ortiz

## A situation-aware cross-platform architecture for ubiquitous game - Jung Hyun Han

A situation aware architecture for cross-platform online games. Enabling
the users to seamlessly move between heterogeneous platforms.

Ubiquitous games are the ones that can be played anywhere, anytime.

A common problem of ubiquitous game are conflict resolution between devices.

The paper aims to present a conflict resolution mode for a ubiquitous game.
