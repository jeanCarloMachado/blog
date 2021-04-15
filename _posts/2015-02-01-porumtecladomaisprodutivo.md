---
layout: post
title: Por um teclado mais produtivo
---

Aposto que não é somente comigo que grande parte das teclas de teclado ficam subutilizadas. Para não dizer mal utilizadas; em alguns casos como o *CapsLock*. Pensando nisso, fiz um conjunto de modificações em meu teclado facilmente replicáveis em sistemas Linux.

Meu sistema operacional: o *Archlinux*, e qualquer outra distro que se preze, utiliza o XKB para gerenciar teclados no X. Os comandos descritos abaixo vão funcionar para esses casos e somente na sessão atual. Para fazer com que as alterações persistam as sessões basta salvar o(s) comando(s) desejado(s) no arquivo ``~/.xinitrc``.

## Capslock

Desde que comecei a utilizar o computador utilizei o *Capslock* para digitar qualquer coisa em CAIXA ALTA. Nunca gostei dessa prática, mas também nunca tive motivos o bastante para parar de fazê-la. Não obstante, desde que adotei o Vim como ambiente de desenvolvimento e escrita, o *Capslock* se torna um estorvo por inserir comandos indesejados - visto que V e v no vim são comandos totalmente distintos.

Levando isso em consideração decidi desabilitar o *Capslock*:

### Desabilitando

```
setxkbmap -option caps:none
```

### Trocando *layouts*
Até então, eu vinha trocando os *layouts* ``pt,en`` de meus teclados utilizando o ``alt+shift``, visto que o *Capslock* ficou livre de suas responsabilidades, resolvi utilizá-lo para trocar de *layout*.

```
setxkbmap -layout 'us,br' -option 'grp:caps_toggle,grp_led:caps'
```

Para trocar com o ``alt+shift`` (modo antigo):

```
setxkbmap -option grp:switch,grp:alt_shift_toggle,grp_led:scroll us,br
```

## Reiniciando o X

Até então eu vinha sentindo falta do comando tradicional para reiniciar a sessão

```
setxkbmap -option terminate:ctrl_alt_bksp
```

## Colando no terminal

O comando para colar no terminal é ``shift+insert``, só que no teclado no macbook ``insert`` não existe. Abaixo segue uma solução de mapeamento do ``insert`` no lugar do ``command`` da direita. Dessa forma é possível colar no terminal utilizando as teclas ``shift`` da esquerda mais ``command`` da direita.

```
xmodmap -e "keycode 134 = Insert NoSymbol Insert"
```

Em teoria o ``xmodmap`` funciona se colar o comando no ``~/.xinitrc`` - só que não no meu caso.

A melhor alternativa que encontrei para persistir este comando foi colocando-o da seguinte forma no meu ``~/.bashrc``

```
if [ -n "$DESKTOP_SESSION" ]; then
    /usr/bin/xmodmap -e "keycode 134 = Insert NoSymbol Insert"
fi
```


Espero que estas dicas lhe sejam úteis. Caso tenha alguma dica de como otimizar o teclado - por favor, deixe-me saber.
