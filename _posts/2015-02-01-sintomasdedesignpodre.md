---
layout: post
title: Sintomas de design podre
---


Existem quatro sintomas primários que nos ajudam a identificar quando nosso design está apodrecendo. São ortogonais, mas relacionados de formas óbvias. Os sintomas são: rigidez, fragilidade, imobilidade, e viscosidade.


## Rigidez

É a tendência do software ser difícil de mudar, mesmo que de maneira simples. Cada mudança causa uma cascata de mudanças subsequentes em módulos independentes. O que começa como uma simples mudança de dois dias em um módulo cresce em uma maratona de mudanças de várias semanas alterando módulo atrás de módulo.

Quando o software se comporta dessa forma os gerentes temem deixar os engenheiros arrumar problemas não críticos. Essa relutância deriva do fato que eles não sabem, com segurança, quando os engenheiros terminarão. Se os gerentes liberarem os engenheiros para resolverem tais problemas eles podem ficar ocupados por longos períodos.

Quando o temor dos gerentes é tão agudo que eles se recusam a permitir mudanças no software é que a rigidez se estabelece. Aquilo que começou como deficiência no design terminou como uma controversa política gerencial.

## Fragilidade

Intimamente relacionada com a rigidez é a fragilidade. É a tendência do software quebrar em diversos lugares toda a vez que ele muda. Com frequência as quebras ocorrem em áreas que não tem relacionamento conceitual com a área que mudou. Esses erros vão encher os corações dos gerentes com mal pressentimentos. Toda a vez que eles autorizam uma mudança eles temem que o software irá quebrar de alguma forma inexplicável. Conforme a fragilidade vai aumentando, a probabilidade de quebra aumenta, assimptoticamente se aproximando de 1. Esse tipo de software é impossível de manter. Cada ajuste faz ele piorar, introduzindo novos problemas para serem resolvidos. Tal software faz os gerentes e clientes suspeitarem que os desenvolvedores perderam o controle. Desconfiança reina e a credibilidade é perdida.

## Imobilidade

É a inabilidade de reusar software de outros projetos ou de outras partes do mesmo projeto. Geralmente acontece de um engenheiro descobrir que precisa de um módulo similar ao que outro engenheiro escreveu. Não obstante, também geralmente acontece que o módulo em questão tem muita bagagem desnecessária. Depois de muito trabalho, os engenheiros descobrem que o trabalho requerido para separar as partes desejadas é muito grande para ser tolerado. E o software é simplesmente reescrito ao invés de reusado.

## Viscosidade

Ela vem de duas formas: viscosidade de design, e viscosidade de ambiente. Quando em face a uma mudança, engenheiros geralmente encontram mais de uma maneira de efetuá-la . Algumas das formas preservam o design, outras não (os "hacks"). Quando os métodos preservados do design são mais difíceis de usar do que os "hacks" a viscosidade do design está alta. É mais fácil fazer a coisa errada do que a certa.

Viscosidade de ambiente acontece quando o ambiente de desenvolvimento é lento e ineficiente. Por exemplo, se os tempos de compilação são muito longos os engenheiros vão ser tentados a fazer mudanças que não forcem grandes recompilações, mesmo que essas alterações não sejam as melhores do ponto de vista de design. Se o controle de versão requer horas para checar apenas uns poucos arquivos os engenheiros serão tentados a fazer modificações que requeiram o menor número de arquivos possível, ignorando se o design é preservado ou não.

---

Esses quatro sintomas são sinais de arquitetura degradada. Qualquer aplicação que exiba-os está sofrendo de design apodrecido.

Esta é uma parte que extraí do livro: *Design Principles and Design Patterns* de *Robert C. Martins*. Espero este *post* de alguma forma colabore para a constante luta contra o design ruim.
