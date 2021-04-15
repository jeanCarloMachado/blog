---
layout: post
title: The right tool for the right job FALLACY
keywords: tools, software
---


*Use the right tool for the right job* I recall using this old adage
myself many times. This piece of "wisdom" is
often used as a cover for something nasty and we may be paying a price
for it. More often than it should, this phrase is used to convey the
sense that *all the tools have a proper case where they excel*. I'm here to
argue that this is simply NOT the case.

 - Assembly
 - Fortran
 - Lisp
 - Ada
 - Perl
 - Java
 - ASP
 - PHP
 - JavaScript

As this list goes on will be harder for you to agree with me, but my
vision is that there is no good reason to use any of this languages to
build new systems anymore.

Imagine writing a new web API in assembly? Or C? Most of the developers
will agree that is not reasonable. But once assembly was the default
language to build *everything*. Better tools appeared and it's simply not
the case anymore. Unfortunately it becomes harder to reach a consensus that there
are better languages than those on bottom of the list.

The problem is that programming languages differ in ways most developers
don't want to talk about. Mainly because they are, more often than
not, in a poor programming language, relatively speaking. And, since
is *hard* to learn a new language, let alone the most powerful one's,
programmers get attached to what they already mastered. They will see as
worse languages the one's on the list prior the one's they use, but will
disagree with the better one's that come after.

This attachment is the very root of one of the nastier problems of
the field. There are a bunch of new techniques demonstrably better of
building software. But the industry (and college education) is stuck in
the seventies. Literally, it seems that we need the old generation of
developers to retire and the college staff to be renewed in order to see
substantial progress.


![Beuvais cathedral](https://i.imgur.com/Ru7crkq.jpg)

> *Just like the builders of Europe’s great Gothic cathedrals we've been honing our craft to the limits of material and structure. There is an unfinished Gothic cathedral in Beauvais, France, that stands witness to this deeply human struggle with limitations. It was intended to beat all previous records of height and lightness, but it suffered a series of collapses. Ad hoc measures like iron rods and wooden supports keep it from disintegrating, but obviously a lot of things went wrong. From a modern perspective, it’s a miracle that so many Gothic structures had been successfully completed without the help of modern material science, computer modelling, finite element analysis, and general math and physics. I hope future generations will be as admiring of the programming skills we’ve been displaying in building complex operating systems, web servers, and the internet infrastructure. And, frankly, they should, because we’ve done all this based on very flimsy theoretical foundations. We have to fix those foundations if we want to move forward.* - Bartosz Milewski's


And many times you'll see arguments like *but Javascript has a imense
community* or *is cheaper to pay and find PHP developers*. Undoubtedly
this is all true. But these statements are not arguments in favor of these languages. 
If you really need a piece of open-source that is in Javascript build a
micro-service around it, but don't dirt all your codebase because of this
requirement. And the simple fact that is easier to find PHP developers
is evidence that the average developer is part of the problem. The average is bad,
and cheap. But if you really want to build the best software you have
to reach the best developers. And they know their fights, their price (and their
languages).

Only the elite of software development and academy researchers can see
clearly the advancements made on languages like:

- Haskell
- Rust
- F#


There is an spectrum of elegance in programming languages. And
it's a long journey to understand why type safety, type inference,
flat-architectures, lazy evaluation languages make the top of them. But
one must strive for it. Let's stop learning a new framework *du jour* per week and
stick with the fundamentals. The software field don't have time to enter
every lib hype. We have decades of software engineer practices to master
in order get near the state of the art. Don't be afraid to say that X
is better than Y. Once we were afraid to say that traditional control
structures were better and goto's. There are better languages, better
paradigms, better developers. Get better.


Nevertheless there's yet space for finding the right tool for the right job (some of
you can stop hating me now). It's reasonable to choose python for ML, go
for thin webservices, bash for scripting, Rust for performance, Haskell
for complex problems. But we have to make clear that - *even if
there is no single right way of doing something, certainly there are much
more plain wrong ways of doing so*.



