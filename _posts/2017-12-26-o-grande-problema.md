---
layout: post
title: O grande problema da programação
keywords: O grande problema
---


Desde que comecei a me interessar por programação o assunto: "como fazer um
software que eu não venha a odiar" sempre pairou no topo das minhas preocupações.
Com o tempo formei fortes opiniões.  Dei algumas [palestras de clean code](https://www.slideshare.net/jeancarlomachado). Mas não foi até recentemente que tive uma epifania sobre o maior problema que torna nossa profissão miserável.

De longe o maior problema na vida do programador é a **vontade do programador de 
ser proativo construindo coisas que ele não precisa no momento**. Sim,
[proatividade pode ser ruim](http://www.jeancarlomachado.com.br/blog/thedestructivepowerofproactiveincompetents.html). E *o maior inimigo do programador é ele mesmo*.

Esse problema se aprensenta de várias formas:

- criar um sistema mais "flexível" para os requisitos que podem aparecer
- adicionar código que vai entrar na próxima tarefa
- otimizar qualquer parte do sistema para usuários que você ainda não tem
- instalar frameworks "fullstack" sem precisar usar eles completamente


E as consequências desse tipo de atitude incluem (mas não se limitam) a:

- código desnecessariamente complexo de entender e manter
- abstrações quebradas, que não servem ao propósito
- runtime lento
- alto acoplamento

Por muito tempo eu adotei esse tipo de prática e consigo até descrever o
processo mental que leva a esse tipo de coisa:

1. tenho que resolver esse problema
2. vou procurar por algum padrão que esse problema se encaixe pra ver se consigo
    reusar alguma coisa
3. nesse momento não tem nenhum, mas eu sei que na próxima tarefa tem algo
   similar.  Vou fazer x nessa parte do componente pra depois ficar mais fácil
4. vou fazer o compontente pra essa tarefa

Tô aqui pra defender que o passo 3 é sempre prejudicial.

O problema de assumir coisas é que a disciplina de software é complexa demais
pra conseguirmos ser acurados. São muitas as variáveis que vão decidir pra onde
um sofware vai evoluir. E geralmente o software não evolui pra onde queremos. Uncle Bob acerta quando diz que o melhor arquiteto
é aquele que consegue [fazer que as decisões não precisem ser tomadas](http://blog.cleancoder.com/uncle-bob/2016/01/04/ALittleArchitecture.html).
E nada pior que tomar decisões quando ainda não temos o [maior número de informações](http://www.jeancarlomachado.com.br/blog/thelastresponsiblemoment.html) disponíveis.

Muitos desenvolvedores talvez não sintam a dor desse problema (ou não
identificaram a raíz do problema). Especialmente se trocam de projeto
continuamente. A dor de ter "pensado adiante" ocorre com muito mais
clareza em produtos. Quando o lifetime é muito grande. Quando você tem
que lidar com decisões de meses atrás. Aí fica muito claro pra você
que não importa quanta "boa vontade" você teve em planejar pro futuro.
Ele é muito diferente do que você planejou. E geralmente muito mais simples.

![good bike bad bike](https://i.imgur.com/hzMjBjY.jpg)

O nome da prática que defendo aqui é [YAGNI](https://en.wikipedia.org/wiki/You_aren%27t_gonna_need_it). Não assumir que você vai precisar de coisas que você não tem certeza. YAGNI não é uma defesa de código que não pode ser tocado.
Não quer dizer que você não pode refatorar. Se for pra aumentar a clareza do que
já existe você [DEVE refatorar](http://www.jeancarlomachado.com.br/blog/quando-refatorar.html). YAGNI é sobre não assumir coisas sem evidências. Uma forma de honestidade consigo mesmo e com o código.

Considero o YAGNI um hábito fundamental. Quando você se alinha
com esse princípio outras práticas se tornam quase mandatórias.
YAGNI te força a escrever testes pra conseguir refatorar na mudança
dos requisitos. Força a apreciar [interfaces específicas e minimalistas](http://www.jeancarlomachado.com.br/blog/interfaceless_prog
ramming.html) que são facilmente substituíveis. Força compor essas
pequenas interfaces ao invés de criar dependências verticias.

Resumindo, quer escrever bom software? Não caia na armadilha de assumir coisas :).
