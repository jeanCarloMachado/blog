---
title: Como aprender PHP
layout: post
---

Recebi um pedido de dicas de como aprender PHP, vou tentar expor aqui minhas opiniões à respeito. Preferi me expressar através de um post pois posso refiná-lo com o tempo, e talvez outras pessoas também venham a se beneficiar.

Tentei dispor as dicas por importância de ordem linear descendente, você não precisa considerar as dicas do final do arquivo se for um absoluto iniciante. Conforme for adquirindo experiência elas se tornarão mais relevantes.

## Coloque a mão na massa

A forma mais eficiente que encontrei para aprender qualquer linguagem de programação é de fato criando algo com ela.  O primeiro passo é o mais difícil, se você está aprendendo sozinho recomendo que pegue um tutorial na internet que produza algo palpável. Depois que você começar produzir algo, você rompe a inércia e seu interesse fluí naturalmente.

### Tutoriais

Alguns tutorias que me parecem interessantes:

* [PHP For the Absolute Beginner](http://devzone.zend.com/6/php-101-php-for-the-absolute-beginner/)

Este é um trabalho hospedado na própria Zend - mantedora do PHP - certamente vale à pena dar uma olhada;

PHP é uma linguagem bem estabelecida, chances são que você nunca vai aprender tudo sobre ela, o importante é começar a mexer. Ninguém vai muito longe se quiser sair desde o início utilizando TDD, ORM, Framework, PSR's e por aí vai.

Meu primeiro projeto em PHP foi um sistema de blog para a faculdade. Totalmente escravo, com PHP embebido no meio do HTML, várias escolhas ruins de design, e todas as más práticas de programação imagináveis. Mesmo assim, me empolguei tanto que virou uma 'rede social' com amigos, grupos e mais umas coisas *Orkut-like*.

### Dicas

Se você não quer começar totalmente torto como eu fiz recomento o [PHP The Right Way](http://www.phptherightway.com/), com dicas do iniciante ao avançado. Mesmo assim não abuse, o melhor é começar torto mesmo e ir lapidando suas habilidades conforme adquire experiência.

## Aprenda a linguagem não seus frameworks

PHP tem inúmeros frameworks, alguns deles são de fato muito bons, mas só aprende PHP quem utiliza PHP. Comece sem utilizar nenhuma ferramenta de terceiro, nem *Composer*, assim, conforme você vai evoluindo, você vai sentir a necessidade por determinadas ferramentas e em suas pesquisas encontrará soluções elegantes cada problema.

## Orientação à objetos

Aprender orientação à objetos não é uma opção. Desde o PHP5, a grande maioria dos esforços de desenvolvimento foi para fazer do PHP uma linguagem orientada à objetos bem estabelecida.

## Faça sua biblioteca de objetos

Reaproveite seu trabalho de um projeto para outro. Pode chegar um tempo que você não mais utilizará essas classes. Mas aprender como manter uma coleção de objetos reusáveis certamente faz parte do processo! [Aqui](https://github.com/jeanCarloMachado/system_framework) consta a minha biblioteca - não à utilizo mais - mas serve bem como histórico de meu aprendizado.

## Utilize um sistema Unix
Eu ainda estou para conhecer um programador PHP decente que programe utilizando Windows. Seja MacOS ou Linux você está bem servido.

## Não utilize IDE's Java
Esqueça o Eclipse e o *Netbeans*. Esses caras são feitos para programadores preguiçosos e linguagens mal feitas como Java. Com PHP sinto que o quão mais próximo dos arquivos reais você estiver melhor. Editores como o Sublime ou o Sublime são boas opções para iniciantes, intermediários e avançados.

## Acostume-se com o terminal
Se puder utilizar *BASH* em seu dia-a-dia melhor, combina muito bem com PHP. Mas o importante aqui é saber rodar os comandos básicos, absorvê-los. São muitos os casos que você precisará ou estará melhor servido utilizando terminal: rodando testes unitários, *composer*, *Git*  ,etc.

## Aprenda Git
Git já é parte essencial de ser programador, independentemente da linguagem. Mas se você está só começando, isso pode esperar. Crie seu primeiro projeto antes de entrar nos detalhes de controle de versão, assim você já terá experienciado o porquê da necessidade/demanda de algo como o Git.

## Aprenda HTTP
O único lugar que PHP deu de fato certo foi como uma linguagem do lado do servidor. E ela está se especializando cada vez mais nisso.

## Comunidade

Minha experiência é que grupos de Facebook são sempre falhos quando para aprender algo. Se quiser falar de fato com os melhores do PHP recomendo que utilize o IRC, em canais como o #ZFtalk e, apensar cheio de ruído, o ##PHP.

## Inspire-se nos grandes players
Recomendo seguir pessoas como o Ocramious, Mattew da Zend, Rob Allen entre tantos outros.
Eminetto e Galvão, para citar alguns *players* importantes nacionalmente.

# Conclusão

Ninguém se torna um mestre de uma hora para outra, não obstante, com interesse, se chega à qualquer lugar. Espero que essas dicas ajudem os interessados à começar com PHP. Todos precisamos começar com uma linguagem eu comecei com C, mas PHP é uma ótima opção; é fácil e ao mesmo tempo profunda. Entretanto, recomendo que quem está iniciando que não fique preso ao PHP ou à linguagem que for. Só aprendendo como outras linguagens solucionam o mesmo problema é que de fato nos tornamos excelentes na sua solução. Ruby e NodeJS são ótimas alternativas à PHP que todo o bom programador PHP deve conhecer, pelo menos superficialmente.


Dúvidas, críticas e sugestões são sempre bem vindas.
