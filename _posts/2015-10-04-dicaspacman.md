---
layout: post
title: Dicas Pacman
---

Estes são alguns comandos que eu não gostaria de esquecer quando
estou dando manutenção para minha máquina com Archlinux. Vou
listá-los aqui para facilitar a busca posterior.

## Pesquisar os pacotes locais

Obtém uma lista com todos os pacotes instalados no sistema.

```
pacman -Qs
```

### Só o nome do pacote

Retorna somente o nome dos pacotes instalados que comecem com php.

```
pacman -Qs -q php-
```


## Pesquisar pacotes online

```
pacman -Ss
```

## Qual pacote determinado arquivo pertence

```
pacman -Qo /a/file/name
```


## Listagem de pacotes orfãos

Pacotes que não são mais necessários como dependência.

```
pacman -Qdt
```

## Árvore de dependências de pacote

```
pactree python
```


## Arquivos de determinado pacote instalado

```
pacman -Ql oh-my-zsh-git
```


## Reinstalar pacotes com determinado padrão de nome


Para reinstalar todos os pacotes relacionados a plugins de audio.

```
 sudo pacman -Qqs gst | sudo pacman -Syu -
```

### Instalar pacotes locais

```
wget https://aur.archlinux.org/cgit/aur.git/snapshot/package-query.tar.gz
tar xfz package-query.tar.gz
cd package-query
makepkg -sri
```

