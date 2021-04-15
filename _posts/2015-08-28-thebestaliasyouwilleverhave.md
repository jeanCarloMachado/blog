---
layout: post
title: The best alias you will ever have
---

I said it would be the best alias you would ever had but I was lying.

But it's not because it isn't the best, it's because it's not an alias,
it's an function. But you can create an alias for it anyway.


*What is it?* Well it's an function to create aliases.


With it you can type:

```
ali g git

```
and it will create an new alias called *g* that points to git.

You can also:

``` ali gcm "git commmit -m" ```

In these case for commands that has arguments or other commands
together.


*Why it's great?*

Because it allows you to create aliases for each command you use
frequently.

To clarify, it's not my own idea, I find an equivalent code someplace on
Reddit on a golden day.


*The function*

Where it goes, place it where your command interpreter can find. In my
case on the ``.zsh_rc`` file.

``` function ali() { echo "alias $1='${@:2}'" >> ~/.zsh_aliases echo
"made alias:" echo "alias $1='${@:2}'" source ~/.zsh_aliases } ```

*Note*: If you use bash, you can switch all *zsh_* for *bash*.


So, I use lots of shell to earn a living, being quick using commands is
essential for me.

In my experience 3 chars is the ideal amount of letters for the frequent
commands so I create aliases for many of them.

In the end of the day you might end up with a
bit list with almost two hundred aliases like
[myself](https://github.com/jeanCarloMachado/dotfiles/blob/master/aliase
s.sh).

Sure some of them I don't use anymore, but the majority of them are
essential in my performance. From time to time you can clean the ones
you don't use anymore. Maybe till creating an alias for editing and
sourcing the aliases file.

Like this one:

``` ali vialias 'vim ~/projects/dotfiles/aliases.sh; source
~/projects/dotfiles/aliases.sh' ```

Thanks for your attention.



