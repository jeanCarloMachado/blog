---
layout: post
title: Use Vim mode on Sublime
---

Um bom editor de textos/IDE sempre está por trás de um bom
desenvolvedor. Essa poderia ser a *golden rule* da programação.
Meu editor de texos é o Sublime, trata-se de um projeto recente com
funcionalidades similares à editores como: Atom, TextMate, etc. Não
obstante, fatores à dizer: excelente performance em projetos gigantes,
múltiplos cursores, rapidez em localizar arquivos, etc, aumentam muito
minha produtividade sendo diferenciais chave da minha escolha pelo
Sublime (mesmo este não sendo open-source).

Entretanto, como um tradicional cara *Unix like* aprecio enormemente
o jeito Vim de editar texto. Não me entenda errado, não sou nenhum
evangélico de Vim (*hater* de mouse), muito menos um expert no
assunto. Mas o jeito do vim, quando navegando e editando um arquivo, é
muitas vezes mais produtivo do que a navegação/edição tradicional:
simplista e feita para estudantes de publicidade usuários do Microsoft
Word e senhoras sem *background* em TI :P.

O Vim como editor de textos é ótimo mas falha em diversos aspectos
que uma IDE moderna trata trivialmente, como: gestão de múltiplos
arquivos, buffers, suporte à mouse, etc. Este post tenciona apresentar
alguns destes ótimos recursos do Vim e surgerir a integração destes
no Sublime para que obtenhamos o melhor dos dois mundos.

O grande trunfo do Vim é que ele contém algumas características de
linguaguem e, como toda a linguagem, você junta elementos simples para
criar padrões complexos e extremamente customizáveis.

###  Classes Gramaticais

Na "linguagem" Vim você encontra as seguintes classes gramaticais:

**Verbos**: y *copiar*, p *colar*, c *mudar* , d *deletar*, / *buscar* ,
= *identar*, etc

**Substantivos**: w *palavra*, s *sentença*, p *parágrafo*, b *bloco*,
linha, etc

**Advérbios**: i *dentro*, a *ao redor*, t *até encontrar caractere x*


###  Palavras compostas

Algumas funcionalidades comuns (que tomariam várias palavras) são
reduzidas à atalhos, alguns deles seguem abaixo.

``} bloco superior, { bloco inferior``

``0 início da linha, $ final da linha``

``gg início do documento, G final do documento``

``u transformar em caixa baixa, U tranformar em caixa alta``

``yy copie a linha inteira``

``. repita a última frase``

``* busca pela palavra sob o cursor e move para a primeira ocorrência
acima``

``# busca pela palavra sob o cursor e move para a primeira ocorrência
abaixo``

``== reidenta a linha atual``

`` guu linha atual para caixa baixa``

`` gUU linha atual para caixa alta``



###  Modos

Para completar a funcionalidade de um editor, o Vim introduz o conceito
de Modos que são contextos onde o significado das palavras podem mudar.

1 v *seleção*

2 ESC *navegação*

3 : *comandos*

###  Exemplos

Alguns exemplos de utilização são: * **xp** swap de caracteres ae
fica ea; * **rX** substitua o caractere no cursor por X; * **c/foo**
altere o texto até a primeira ocorrência de foo; * **viwy** entre
no modo de seleção, selecione dentro da palavra e copie. (copia a
palavra sobre o cursor); * **0v}p** vá para o início da linha, entre
em modo de seleção, suba um bloco e cole o conteúdo da memória; *
**ci"** troque o conteúdo dentro das aspas; * **yy3pESCgg.** copie a
linha atual e cole-a 3 vêzes abaixo, entre no modo de navagação,
vá até o início do arquivo e repita a operação (copie a linha
atual e cole-a 3 vêzes abaixo); * **ESC3j12lv3wd** entre no modo de
navegação, desça 3 linhas, vá 12 caracteres à esquerda, entre no
modo de seleção, selecione 3 palavras e as delete; * **ESCggvGU**
entre no modo de navegação, vá para o início do arquivo, entre no
modo de seleção, vá para o final do arquivo, transforme o selecionado
em uppercase (mude todo o documento para caixa alta).



Fica aqui exposto que, uma vez dominado a utilização básica do
Vim, fica muito mais rápido fazer operações complexas através da
"linguagem" Vim.

## Vim no Sublime

Vim e Sublime são feitos para a mesma coisa: editar textos; em outras
palavras são concorrentes. Contudo, existem plugins no Sublime para
imitar a linguagem do Vim. O padrão é o Vintage - que vem integrado
com o Sublime - mas este sofre carência de funcionalidades. O melhor
plugin que conheço de suporte à Vim é o Vintageous, dos recursos do
Vim que conheço, nenhum falta à este plugin. O Vim no Sublime abre
um leque de oportunidades novas quando utilizado junto com múltiplos
cursores, mas isso é assunto para outro post.
