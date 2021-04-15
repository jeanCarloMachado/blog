---
layout: post
title: 3 years of same Archlinux installation
keywords: archlinux, years of usage
---


So today is the third year of my Archlinux installation. It
has been a long journey with many ups and downs. In this post
I'll share with you some of this tale.

If you want to see my resume of the second year you can find it
[here](http://jeancarlomachado.com.br/blog/two-years-of-arch.html).

## Openbox

Differently from last year I left Pytyle abandoning tiling window
managers at all. I'm using a single monitor and I cannot find motives
to use more than two windows at the same time ever.

Openbox is an amazing piece of software that has been with me since
the beginning. Since last year I've being running out of shortcuts
combinations on my keyboard (imagine that). So I discovered Openbox
[prefixes](http://openbox.org/wiki/Help:Bindings#Chrooting_key_chains)
and that solved my problem. Now I have a Clippboard prefix, CompuFácil
prefix, links prefix, that expand the collection of possibilities. 
Take a look at my [Openbox configuration](https://github.com/jeanCarloMachado/dotfiles/blob/master/openbox/rc.xml).

## Clippboard

I've being long refining my clippboard management process. I think
managing properly your clippboard is a core-stone skill developers
must master. I'm beginning to think that this subject deserves a
talk by itself. At the heart of it I use copyq and [I recommend you
to do so](http://jeancarlomachado.com.br/blog/The_most_useful_tool_that_you_probably_dont_use.html).
To give you a point of contact of what I'm talking about, I have
shortcuts for:

 - Open in vim the current selection
 - Translate the current selection
 - Google the current selection
 - Move an older selection to the top

## Vim

My setup is totally terminal oriented and all of it floats around vim.
My vim is totally amazing, I really recommend you to [take a look at it](https://github.com/jeanCarloMachado/vimrc).
I achieved higher levels of productivity with it that I ever thought it
was possible.  The main feature of my vim is that is easy to create new text
objects and operations over text selections.

## Theme tweaking

It's been a long time since I changed any theme related thing in my
desktop. I simply removed all interface elements when they aren't
needed. So I don't get annoyed that they don't look as I would like them
to. When I'm editing text the only thing I see is vim, nothing
more. Then I'm browsing the browser, etc.

## Stack

These are the software I use:

 - vim
 - tmux
 - zsh
 - openbox
 - linux-lts 
 - terminator
 - franz (chat)
 - chromium
 - nautilus (file manager)
 - spotify
 - irssi (chat)
 - zathura  (pdf)
 - lxpanel (sidebar)
 - fittstool


## Issues

Sometimes things break and break hard. Until the half of the year I was
suffering a disk shortage. Then I made a fsck and freed half of my disk
sectors that were marked as unusable (don't ask me why). And it's working properly long since.

### Issues remaining

1. The mainline kernel don't even boot on my machine anymore. But I'm happy with the LTS nevertheless. 

2. My chromium had a regression and the webcam and
microphone do not longer works on it.

3. My SSD card don't load after suspending. But this is a bug on
   the Macbook hardware and happens on MacOS as well.

## Conclusion

I'm amazingly productive with my stack and I doubt that
experienced programmers on other OS'ses can be this much.
But I recognize that Linux is extremely complex for
new comers. Even more a stack terminal-oriented like mine.
It takes too much effort to become really powerful. But once you
get there there's no end to the improvements you can make on your
computer.

I'm kind of proud of never more having to format my
machine every six months. I consider a kind of failure when a developer
"reinstall everything" it's like giving up.
Unix systems were made to endure. If you can't keep yours, how you would
expect to maintain a system to your users? 

Anyway, only with Archlinux I was able to do
that. I think it has something to do with it's
[principles](https://wiki.archlinux.org/index.php/Arch_Linux#Principles)
. And something to do with me getting more mature. Willing to understand
things, taking the time to read and improve by baby-steps.

I think that's it. In a year certainly I'll have another post like
this. The only motive to change my installation is a hardware
failure/change. And even in this case I might use the same
installation on a new piece of silicon.
