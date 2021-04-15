---
layout: post
title: Quando refatorar
keywords: Refatoração, boas práticas
---

Quando alguém fala em refatorar algo geralmente fico com um pé
atrás. É muito fácil achar motivos ruins para refatorar e muito
difícil de achar bons.

Segue alguns motivos que geralmente me deparo:

1. o código está "legado" [NOK]
2. o código não está nas melhores práticas [NOK]
3. o requisito mudou drasticamente [OK]
4. foi escrito de forma ilegível, totalmente **go horse** [OK]

## O código está “legado”

Existe uma falácia por aí que o código que eu não escrevi é código
legado. Somos muito rápidos para formar uma opinião negativa sobre
o código de outra pessoa. Mas geralmente não entendemos tão bem do
problema quanto a outra pessoa. Ela que fez a solução está em uma
posição muito melhor do que você pra dizer quais são os detalhes ao
redor destes requisitos. Como diz o ditado: "você só sabe o que você
constrói".

A grande maioria das vezes *menosprezamos a complexidade dos
problemas que queremos resolver*. Estimamos que
vamos conseguir resolver em pouco tempo mas na verdade leva muito
mais e muitas vezes o resultado final pode não ser lá um grande
avanço. 

## O código não está nos últimos padrões

Muitos programadores são tentados a refatorar apenas para deixar
o código no formato do que consideram as "melhores práticas de
programação". Eu acho isso um desperdício de intelecto.

Se você é como eu, quando terminar de "refatorar" você já vai ter
aprendido uma nova "melhor prática" e vai querer começar a fazer tudo
novamente. Se seguir nesse ciclo você vai aprender 90 formas diferentes
de fazer CRUD - nada mais.

Sistemas que somos pagos para fazer são pedaços de lógica que são
feitos para resolver problemas de pessoas do mundo real. Não são
laboratórios de programadores. Muito menos uma prova que paradigma
X é melhor que Y. Ou então uma imitação categoricamente perfeita dos conceitos do mundo real.

## Bons motivos para refatorar

Quando algum requisito mudar drasticamente e essa área do código
precisa de melhorias, esse eu acho um ótimo momento para refatorar.
Você vai ter que gastar um tempo nessa feature e todo o conhecimento
agregado naquele código não faz mais sentido. Nesse momento você
aplica as melhores práticas de programação que conhece. Chamo isso de
*refatoração oportunística*. Quando você alinha sua vontade com o
que é o melhor para o sistema.

Outro bom motivo é quando alguém escreveu um código ilegível e
essa parte do código gera muitos bugs. Em outras palavras: quando
o custo de manutenção de um pedaço de código se torna mais alto
que a sua reconstrução. Mas é muito difícil pegar código assim.
Só um programador muito ruim ou de muita má vontade escreve código
ilegível. E se você trabalha para uma empresa que contrata esse tipo
de gente não tem refatoração que vai te salvar.

## Conclusão

Programadores em geral tem que parar de se preocupar em desenvolver
uma obra de arte no código. O que realmente importa é o valor para
o usuário. Essa filosofia de focar no "valor de negócio" quando
programamos faz parecer que nunca teremos tempo de melhorar nossos
skills técnicos mas isso *não é verdade*. Quando adotamos essa
mentalidade de "resolvedor de problemas" entregamos valor depressa.
Iteramos rapidamente, e podemos focar em questões cada vez mais
intrincadas e cheias de desafios técnicos e de negócio. E tem o bônus
que nos destacamos com a gerência e avançamos na carreira :).
