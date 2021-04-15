---
layout: post
title: Why I'm leaving Linux
keywords: Linux, desktops
---

I remember in the beginning of my career going to FISL and seeing a
lecture from a Red Hat developer, without understanding almost anything,
and thinking: I want to be a kernel developer like him one day. For 6
long years I kept true to this goal. Now, that dream not only does not exist
anymore, I'm quitting as a Linux laptop user. Let me explain you why.

First of all Linux interfaces sucks. What is decent in modern standards
is buggy (like pantheon), and what is stable is ancient (like LXDE). For
long my opinion is that to be a real Linux user one should use as few
GUI as possible. And I applied this philosophy to it's limits. I spent
about 4 years on the same minimal ArchLinux installation dropping every
unnecessary piece of software.

But if you enter the path of being a CLI hacker you end-up having to
do everything yourself. Sure, you get a lot of power and understanding. But
things that should be simple end up being extremely complex like:
setting up printers, managing displays, connecting Bluetooth devices,
configuring email, etc.

And there are times that things don't work at all. Something in the Kernel
change and you end up getting problems forever. I recall losing 2/3 of
my battery duration between the change from kernel 3.* to kernel 4.*.
Never to recover.

But the worse by far is when some shit happens and you have an
appointment where your machine is necessary. I have two exemplary
experiences, never to forget, which elucidate how much a Linux hacker
suffer.

Twice I was going to the podium and the remote display connection
failed. Once I was up to give a course and while my students arrived at
the room I - extremely nervous - recompiled the kernel to luckily get the HDMI working.

Another time, during a conference in which I was expected to give a
hands on talk, I was about to start and discovered that they had only
VGA. Unfortunately after kernel 4 VGA stopped working. This time I could
not fix the problem at all and had to borrow a friend's computer to be
able to do a much less impressive version of the lecture I prepared.

But why this things happen to Linux? Are kernel developers sloppy? No.
The answer is simpler than that: the Linux kernel is optimized for
servers, not for desktops. If you loses battery life probably was because
someone decided to trade it off with performance, latency or another
thing that is much more important on servers. And they don't care much
about adding that driver you need since it will affect 0% of the user
base while they can improve a minuscule part of the networking subsystem
and affect everyone.

But one would expect that desktop centered distributions like Ubuntu
would take the time to improve users life. Turns out that distributions
are much occupied packaging software from thousands of parties and
testing if they work together. So even basic tweaks like optimizing
cache pressure is not done in almost any distro. So your beloved
notebook have a ultra-optimized piece of software that is extremely good
at doing repetitive tasks to millions of clients. But really poor to
handle your 15 applications without you noticing the cache swaps.

Having a Linux installation can be an enlightening experience. I do
recommend it if you are a novice interested in backend development. I
learned a lot about OS's, shell, Unix, and my career would not have been as
good as it is without Linux. You can even beat all averageness with
it. 90% of the time. I did it. But ultimately, if you want to get things
done, and avoid the 10% true misery, you must outgrow it.
