---
layout: post
title: The most useful tool that you probably don't use (AKA clipboard manager)
keywords: Clipboard managers
---

Practically every developer I know don't use any form of clipboard
manager. Yet, being used to them, I know how much valuable they are for
my day-to-day productivity.

How common is for one to copy something, for later use, then to
override it with another content before pasting. Like, if you're
refactoring something and then you cut a section of it to place in
another function. But then, you accidentally override it with another
selection. Your code is gone and you have to undo your changes in order
to get it back.

Or if you did some change in a function tree hours ago and it has to be
repeated in this new section you're looking. You're sure you copied that
content from somewhere but it's boring to go to look for it again.

To solve those classes of problems and a hole collection of related ones
people created clipboard managers. And the one I appreciate the most is
[CopyQ](https://hluk.github.io/CopyQ/).

CopyQ runs as a daemon and every time I hit Super+c
it shows a popup with the history of my clipboard (bind the
stroke with the `copyqshow` command). By typing
enter I get the last result, by typing some string it will filter the
results with that content. Beyond that, CopyQ is multi-platform,
open-source, has a cli version, vi key bindings and solarized
colorscheme.

It's also possible to write plugins for CopyQ. I once wrote one
to use as a snippet manager, to paste pre-defined values based
on binded keys (like my address, CPF, Id). Notwithstanding later
I dropped it for a simpler version in bash that you can find
[here](https://github.com/jeanCarloMachado/personalScripts/blob/master/d
menu-snippet).

I sincerely believe that this kind of small improvements in little areas
of our work spaces are the one's that enable the [10 times better programmer](http://antirez.com/news/112?utm_content=buffer44093&utm_medi um=social&utm_source=twitter.com&utm_campaign=buffer) sort of thing.
So I hope to have made a good case for Clipboard managers. You should
at least try it, sure it will not cost anything. On arch is as
straightforward as:

    yaourt -Sa copyq

That's all folks.

