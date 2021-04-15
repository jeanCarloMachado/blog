---
layout: post
title: O grande redesign
keywords: clean code
---

Se você é um programador por dois ou três anos, você provavelmente já
foi atrasado de forma significativa por um código mal feito de outra
pessoa. Se você é um programador por mais de dois ou três anos você
provavelmente já atrasou alguém por código mal feito. O grau de atraso
pode ser significante. Durante o período de um ano ou dois, times que
eram rápidos no início de um projeto podem ver-se movendo ao passo do
caramujo. Cada modificação no código quebra outras duas ou três partes
do programa. Nenhuma mudança é trivial. Cada adição ou modificação no
sistema requer que a massa confusa, os remendos e as amarras sejam
"entendidas" para que mais confusão, remendos e amarras sejam
adicionados. Com o tempo a gambiarra se torna tão grande, tão profunda e
tão alta que não se consegue mais limpar. Não há nenhuma saída.

Enquanto a gambiarra é produzida, a produtividade do time continua a
cair*,* assimptotaticamente aproximando-se de zero. Enquanto a
produtividade decai, os gerentes fazem a única coisa que podem;
adicionam mais equipe para o projeto na esperança do aumento da
produtividade. Mas aquela nova equipe não é versada no design do
sistema. Eles não sabem a diferença entre as mudanças que comportam o
intento do design e as mudanças que o inibem.

Logo, eles, e todos no time, estão sob uma horrível pressão para
aumentar a produtividade. Então todos eles fazem mais e mais gambiarras,
dirigindo a produtividade para zero.

**O grande redesign dos céus**

Eventualmente o time se rebela. Eles informam o gerente que não podem
continuar a desenvolver aquele código odioso. Eles demandam um design
novo. Os gerentes não querem gastar os recursos em um novo sistema, mas
eles não podem negar que a produtividade está terrível. Eventualmente
eles se entregam às demandas dos desenvolvedores e autorizam o grande
redesign dos céus.

Um novo time ninja é selecionado. Todos querem fazer parte daquele lindo
projeto virgem. Eles começam novamente e criam algo verdadeiramente
belo. Mas apenas os melhores e mais brilhantes são escolhidos para o
time ninja. Todos os demais devem continuar a manter o projeto antigo.

Agora os dois times estão em uma corrida. O time ninja precisa construir
um novo sistema que faz tudo o que o antigo faz. Não apenas isso, eles
precisam se manter-se atualizados nas modificações que continuamente são
feitas no sistema antigo. Os clientes não vão migrar de sistema até que
o novo faça tudo que o antigo fazia.

Essa corrida pode levar um longo tempo. Eu já vi isso levar 10 anos. E,
quando o novo sistema está finalmente pronto, os membros do time ninja a
muito se foram, e os novos membros demandam que um redesign porque o
atual está uma gambiarra.

Se você já experienciou ao menos uma pequena parte desta história que eu
acabei de contar,  então você já sabe que gastar tempo mantendo o código
limpo não só vale à pena; é uma questão de sobrevivência profissional.

Você já perambulou por alguma gambiarra tão grave que lhe custou semanas o
que deveria ter sido feito em horas? Você viu já algo que deveria ser
uma linha de modificação tomar, pelo contrário, centenas de linhas nos
mais variados módulos? Esses sintomas são muito comuns.

Por que isso acontece com código? Porque bom código apodrece tão
rapidamente? Nós programadores temos diversas desculpas para isso. Nós
reclamamos que o design mudou de uma forma inesperada e degradou o
conceito inicial. Nós culpamos os sprints que são muito apertados.
Acusamos os gerentes estúpidos e os clientes intolerantes. Mas a culpa,
querido programador, é nossa. Nós não somos profissionais o suficiente.

Isso pode ser difícil de engolir. Como pode essa gambiarra ser minha
culpa? E quanto aos requisitos? E quanto ao sprint? E os gerentes? Eles
não tem parte na culpa?

Não. Os gerentes procuram conosco as informações que eles precisam para
prometer algo ao cliente. E, mesmo que eles não procurem, não nos cabe
ficarmos quietos e não informar-lhes o que pensamos. Os usuários nos
procuram para validar o modo que os requerimentos serão dispostos no
sistema. Os gerentes de projeto nos indagam sobre os prazos do sprint.
Nós estamos profundamente engajados no planejamento do projeto e
compartilhamos uma grande carga de responsabilidade por qualquer
eventual falha. Especialmente se essas falhas estão relacionadas a
código ruim.

"Espere!", você diz. "Se eu não fizer o que meus gerentes dizem eu vou
para a rua". Provavelmente não. A maioria dos gerentes querem a verdade,
mesmo que eles não aparentem gostar dela. A maioria dos gerentes querem
bom código, mesmo que eles sejam obcecados com o prazo. Eles podem
defender o prazo e os requisitos com paixão; mas esse é o trabalho
deles. *Seu trabalho é defender o código com o mesmo entusiamo*.

Para consolidar o argumento; e se você fosse um médico e tivesse um
paciente que demandasse que você parasse com o processo
de lavar as mãos ao preparar-se  para a cirurgia, alegando que isto toma
muito tempo? Claramente o paciente é o chefe; e ainda assim o médico
deve recusar-se absolutamente. Por quê? Porque o médico sabe mais do
que o paciente sobre os riscos que doença e infecção. Não seria
profissional para o médico concordar com a requisição do paciente.

Da mesma forma, não é profissional para os programadores se renderem à
vontade dos gerentes que não entendem os riscos da gambiarra.

Programadores se veem em um dilema de valores fundamentais. Todos os
desenvolvedores com mais do que uns poucos anos de experiência sabem que
gambiarras anteriores os atrasam. E ainda todos os desenvolvedores
sentem a pressão de fazer gambiarras para cumprir os prazos. Em outras
palavras, eles não tomam o tempo para avançar rápido.

Verdadeiros profissionais sabem que a segunda parte do dilema é errada.
Você não vai cumprir o prazo  fazendo gambiarra. De fato, a gambiarra vai te
atrasar instantaneamente e vai te fazer perder o prazo. A única forma de
cumprir o prazo - a única forma de ir rápido - é mantendo o código tão
limpo quanto o possível a todo o momento.

Este texto é uma tradução livre tirada do livro **Clean Code: A Handbook
of Agile Software Craftmanship**.

