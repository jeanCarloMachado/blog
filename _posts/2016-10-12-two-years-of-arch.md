---
layout: post
title: Two years of Arch
keywords: Archlinux, Experience, Unix, Advanced systems
---

I cannot offer greater evidence that I'm with the same installation
for two years than the date of creation of the file system and here
it goes:

```
sudo tune2fs -l /dev/sda2 | grep created
Filesystem created:       Fri Oct 10 09:14:32 2014
```

Two years and two days to be more exact. Nevertheless I'm going to
summarize for you, dear reader, about my experiences during this special
period.

First time I installed Arch on my Macbook Air I get it wrong, and I did
the same for the following three times. But, when it first booted, it was
a great feel of power. And, after that breakpoint, followed tree months of
much tweaking and trying to setup up a proper system until it
started to get stable.

## Graphic environments

If I recall it correctly, I first tried LXDE, trying to make a
stand upon Arch's simplicity [philosophy](https://wiki.archlinux.org/index.php/The_Arch_Way_(%D0%A1%D1%80%D0%BF%D1%81%D0%BA%D0%B8)). Surprisingly I endured a
lot and, as time went by, my LXDE started to become each time more
custom and less cluttered.

At some moment I customized it to the point of removing almost all
it's parts, remaining only Openbox, that constitutes it's skeleton.

After sticking a while without much advancing with Openbox I
resolved to try other things. I tried i3, xmonad, rat-poison,
no-graphical interface, KDE, Pantheon and others more that I'll
probably not recall.

Right now I'm sticking with my plain and old Openbox altogether
with Pytyle that finally made me adopt a lofty taste for tiling
window managers.

I'm using a login manager as well, to be able to login in others WM's I
keep around but I rarely do so.

### Solarized and shut

Pretty early on this journey I resolved to adopt Solarized as my
default theme. And impressively I was able to stick with it. This
means not wasting precious time tweaking and re-tweaking each bit
and piece of my computer style.

This is a big issue that some developers see on Linux.
The fact that you are left to do whatever you want on the system
then you spend all your hours tweaking it instead of doing proper
work.

## Tools

This time in Arch coincides with the time I'm using Vim and I
think there's some sort of correlation on why I was able to stick
with both for all this time.

Vim proved itself as being a really powerful, robust and flexible tool
that stands high with the Unix Way I hold so dear. Today I'm almost like
an advanced user with it and I'm also considering making a talk about
this experience.

Beyond the editor I'm using Terminator as my default terminal, my
shell is Zsh, Tmux is a essential part of my tool set as well. My file manager is
the old Thunar, my browser is Chromium and my chat is Irssi.

I also have tons of shell scripts, functions
and aliases that you might check on my
[Github](https://github.com/jeanCarloMachado/personalScripts).

## Issues

From the beginning to pretty much some few months ago I had a serious
issue about ACPI events after resuming. My virtual terminals and
dmesg would be cluttered with some strange log about my ATA not being
functioning properly. I found a solution a couple of months ago and
since then I don't have any major problems.

After Kernel 4.4, if I recall correctly, the support for Mac's
webcam is complete so now my mom is much happier as well.

When I first installed Arch I was able to got almost 15 hours of
battery if I took the proper care. Right now I can stand for about
5 hours. This might not be a great deal but it certainly could be
better. This problem became apparent after the migration to Kernel
4.\* but I can't do much about it right now.

## Learning

Some things worth mentioning I learned with Arch are the
following:
- The virtue of reading the docs. Arch simply has the best
  documentation available for the greater amount of software one
  can collect. It teaches how things work, why they are like they
  are, and many times a little history about the software.
- The art of being a responsible manager of operational systems.
  Before Arch I was never able to stand for so long in  the same
  OS. This came after having to do things by myself and realizing
  that wanting to things to "just work" without understanding it's
  underlyings is pure delusion for any developer.

I'm also grateful to have mastered really powerful tools that each
developer should at least know of the existence and ponder it against
it's own tool set.

## Conclusion

After this long journey I cannot feel of myself like an old
veteran which is tired of the war. On the contrary, there's so
much to learn! This is probably the core stone of all this
journey - the willing to understand the underlying of this magic
software world.

I don't hold the illusion that one day Arch will go mainstream. It's
a system for advanced or dedicated users and it's always gonna be so.
And I don't like to evangelize about it. More than that, I can't see
why people think that, contrary than in all other things, evangelize
in software is a good thing :P. But if someone would ask me advice
in which distro to pick I would probably recommend a flavor of Arch:
[Antergos](http://status.antergos.com/) which holds much of the things I
feel are important in operational systems.

I'm pretty effective in the majority of things I do. In reality, when
I'm in the "flow" its almost impossible to keep up with my productivity.
My tools are like an extension of my body and they respond accordingly.
It's all a matter of reducing cognitive restrain between what I want to do
and what I really have to do to get there.

The things I'm interested now are so much deep than before. I
don't attend to the old repertoire of formatting the machine each
6 months, I have better use of my time.

For now I hold my stand that is worth the endeavor.

