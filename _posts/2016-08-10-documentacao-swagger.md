---
layout: post
title: Documentação com o Swagger
---
Em aplicações API first como a Compufácil a fase de integração
entre API e consumidor é crítica, visto que o primeiro cliente de
toda a API são os desenvolvedores que vão realizar a integração.

Para ofercer uma boa experiência, designers de API geralmente recorrem
a APIs padronizadas e uma boa documentação. Porém, conforme o
software evolui, esses documentos tendem a ficar desatualizos. Como
diz o ditado: [a melhor documentação é o código](https://medium.freecodecamp.com/code-briefing-good-code-is-it's-own-best-documentation-d064ca2077ae#.8mggbaaxj).

Nesse espírito conseguimos resolver o problema da documentação de API do
Compufácil através do [Swagger](http://swagger.io/). Com ele
conseguimos oferecer uma interface onde todos os serviços públicos da
API são listados e podem ser executados. Dessa forma os desenvolvedores
podem checar o funcionamento real da aplicação, sem precisar comparar
o funcionamento com uma documentação.

Abaixo segue um exemplo da utilização do Swagger UI no Compufácil.

![http://jeancarlomachado.com.br/swagger.gif](http://jeancarlomachado.com.br/swagger.gif)

Para testar você mesmo a API do Compufácil é só acessar [esse link](http://developer.compufacil.com.br/API/#!/default).
