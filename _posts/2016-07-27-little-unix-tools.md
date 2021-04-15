---
title: Cool personal unixy tools
layout: post
keywords: Unix, utilities, Unix Way
---


In this post I'll detail some of my Unix tools collection I grew up over time.

## Copy to clipboard using pipe

When you want to copy something from a shell result use this:

```
#!/bin/bash

data=${1:-$(cat /dev/stdin)}
xsel --clipboard <<< "$data"
xsel --primary <<< "$data"
xsel --secondary <<< "$data"
```

```
echo "foo" | mycopy #will copy foo to the clippboard
```


## Edit binary everywhere

Since I use a lot of scripts on my workstation I want to be able
to edit them on demand without having to move where they are.

```
#!/bin/bash

command=$1

file=$(whereis $command | cut -d' ' -f2)
vim $file
```

To edit the vibin command with itself (recursively).

```
vibin vibin
```

## Regex test

If you wanna a quick way of debugging a regex:

```
#!/bin/bash

if [[ $# -lt 2 ]]; then
    echo "Usage: $0 PATTERN STRINGS..."
    exit 1
fi

regex=$1

shift

while [[ $1 ]]
do
    if [[ $1 =~ $regex ]]; then
        echo "Value: $1 matches regex: $regex"
    else
        echo "Value: $1 does not match regex: $regex"
    fi
    shift
done
```

## Human readable JSON

Python has this nice utility to parse JSON in a human readable way, so I
made an alias to be able to use it without thinking.

```
alias json-beautifier='python -m json.tool'
```

Usage:

```
echo '{"foo":"bar"}' | json-beautifier

{
    "foo": "bar"
}
```

## XML to JSON

Want a JSON from a XML? Pipe it through this command.

```
#!/usr/bin/env php
<?php

$identifier = $argv[1] ?? file_get_contents("php://stdin");

if (empty($file) || !file_exists($file)) {
    echo "You must pass a valid XML";
    exit;
}

$content = file_get_contents($file);
$content = simplexml_load_string($content);

echo json_encode($content);
```


## Translate text

```
#! /usr/bin/env bash
# af ar az be bn bg bs ca cub zh-CN zh-TW cs cy da de en en_us en_gb en_au 
# el es et eu fa fi fr ga gl gu ht hi hmn hr hu hy is id it iw ja jw ka km 
# kn ko la lv lt mk mr ms mt no nl pl pt ro ru sr sk sl sq sw sv ta te th 
# tl tr uk ur vi yi

inputLang="en"
outputLang="pt"
text=$1


case "$#" in
'2' )
    # echo "Two arguments"
    if [[ $1 = "pt" ]]; then
       inputLang='en'
       outputLang='pt'
    else
       inputLang='pt'
       outputLang='en'
    fi

    text=$2
    ;;

'3' )
    # echo "Tree args"
    inputLang=$1
    outputLang=$2
    text=$3
    ;;
'1' )

    [[ "$1" =~ ^e\  ]] && {
       inputLang='pt'
       outputLang='en'
       text=${1:2}
    }

    [[ "$1" =~ ^p\  ]] && {
       inputLang='en'
       outputLang='pt'
       text=${1:2}
    }
    ;;
esac


result=$(curl -s -i --user-agent "" -d "sl=$inputLang" \ 
    -d "tl=$outputLang" --data-urlencode "text=$text" \
    https://translate.google.com)
# echo $result
encoding=$(awk  \
'/Content-Type: .* charset=/ {sub(/^.*charset=["'\'']?/,"");
sub(/[ "'\''].*$/,""); print}'  \
<<<"$result")

result=$(iconv -f $encoding <<<"$result" |  awk \ 
'BEGIN {RS="</div>"};/<span[^>]* id=["'\'']?result_box["'\'']?/' \ 
| html2text | head -n 1)

echo $result

```

To translate use:

```
translate en pt "dog"
translate pt en "cachorro"
```

## Global Snippets

This is the coolest one in my opinion. It's a snippet manager,
you type a part of the name and the program paste the value in the
program you are currently using.

It depends upon dmenu, xdotool, xclipp and mycopy (the one above).

```
#!/bin/bash

if [ -f $HOME/.dmenurc ]; then
  . $HOME/.dmenurc
else
  DMENU='dmenu -i'
fi

key=`cat ~/.snippets | cut -d '=' -f1 | $DMENU $* -p "Get value"`

value=$(cat ~/.snippets | grep $key | cut -d'=' -f2 | get-line 1)
mycopy "$value"

echo "$value"

sh -c 'sleep 0.9; xdotool type "$(xclip -o -selection clipboard)"'

```

You declare your snippets this way:

```
#file ~/.snippets
cpf=6666
name=Jean Carlo Machado
NAME=JEAN CARLO MACHADO
ie=6666
mail=contato@jeancarlomachado.com.br
author=* @author Jean Carlo Machado <contato@jeancarlomachado.com.br>
mi=$this->markTestIncomplete();
username=foobar
coderockrmail=jean@coderockr.com
secondmail=j34nc4rl0@gmail.com
birthday=666
phone=6666
street=foo
bairro=bar
```
So you invoke the program with a shortcut and select the key or
type a part of it and the value will be pasted.

----

That's it, I hope it helps someone to be more productive.
If you have any cool unixy tool let me know.
