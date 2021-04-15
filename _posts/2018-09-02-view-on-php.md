---
layout: post
title: My take on PHP
keywords: my personal view on php
---

I have a strange relationship with PHP.

For one I feel gratitude towards it. After all most of my career up to this point is using it. So much that I become very good at it and a recognizable community member.

To avoid some ad hominem attacks (and to brag a bit) some credentials: I've been developing PHP for about 6 to 7 years as my main language. I contributed to PHP core. Sent patches for fixing not coherent behavior in some functions, also some tests and doc improvements. I contribute to many of the most important open-source projects in PHP: Doctrine, Phpunit and Zend Framework to mention some. I've been speaking at many PHP conferences with topics regarding clean code, functional programming, architecture, and some others. I met or know personally many of the more famous community figures including Rasmus.

But also, I've spent a lot of time studying about programming languages in general and trying different one's which led me to the inescapable conclusion that PHP is a unwise choice for writing software.

So let's go through my rationale.

## The good

First let's go through the virtues of the language.

1. PHP has an incredible community. Being a Brazilian programmer I can attest that the PHP community there is amazing. I got to know a lot of friendly very smart people in my days of PHP there.

2. By having a vibrant community you might find a lot of packages, solving many problems that you might be interested on. Integration with other technologies is also fairly complete.

3. Also PHP is very good for quick prototypes and move fast and break things mentality.

I go as far as to say you can write very good software with PHP. It's just harder than it should be. Let's see some whys.

## The bad

This list is by no means exhaustive, but I consider this problems  very basic and too hard to solve at this later stage of PHP.

I agree with Paul Graham that good languages are made by hackers, as
opposed by committees. Tough PHP got too far on that direction. PHP is
poorly designed.

1. The native functions don't respect nomenclature eg: array_filter/array_map arguments order. You have always to keep an eye when your date functions return values or references. Error checking is always a surprise, sometimes you expect an exception and get an error, other times the other way around.

2. Good languages allows you to have many serendipity moments. I'm not here to defend any language (on the contrary). But by knowing a subset of Ruby functions I can infer many others that I suspect that exist and guess what? Most of the times I'm right, and they work out of the box. This hardly happen in PHP.

3. The type-system is very primitive. I will not get in details here but you can see some internet jokes. Type-system science is pretty advanced by now and all languages would benefit to use more of it. Union types comes top in mind.

4. PHP clearly started with high influences from C (which is awesome), but in 5.* forward you can see influences mainly from Java (which is horrible). And concepts that only make sense in a statically-checked language were imported without too much thought. The concept of interface bears hardly any advantage in matters of consistency checking since the interpreter only show you the errors at execution time. In Java, on the other hand, they can be checked at compile time helping the developer to find the errors much early in the development cycle.  One can argue that interfaces allow contract design with third parties, something that PSR's are doing very well. But this is not the primary use-case for most developers. They think that they are making they code less error prone and more modern by adding interfaces everywhere, but in truth they are most of the time adding leaky verbose abstractions, paying a huge price in readability. Yes, one should design by interfaces but duck typing those interfaces are more then enough, indeed is ideal here.

5. At last, a decent signal to infer language quality is the quantity of reserved words it has. The more the worse. For one, there's the cognitive load of having to memorize them. Also the cost of onboarding on the language. But deeper than that, if you have well thought foundations you can rely on the abstractions you built to add new behaviour.

 - C++ ~= 90 reserved words
 - PHP ~= 74
 - Python ~= 33


----


PHP has some great aspects. I could mention many worse languages than PHP, Fortran for one. But I argue that the great things about PHP are present in many other languages and some of those other don't have these basic failures.

One very clear case to me is Python. Python have the 3 good aspects above and none of the mentioned problems. I'll say it explicitly: Python has a even bigger community, even more packages and allows you to write even better move fast software. Sure, Python is not perfect - the multi threading difficulties come to mind. But by not having these basic flaws and by having at least the same good aspects it IS better than PHP. Actually Python has many other virtues that make it excel much beyond PHP. **I challenge you: name me one domain that PHP excels Python**. The reverse is very easy: data-science, ML, desktop apps, etc.

Let's play with an analogy. Say you are a professional gamer. And you are looking to buy a new laptop. This has to be a very thoughtful decision, after all you want to spend some years with this machine. Let's suppose we narrow down the options to 3. All at the same price.

1. Computer FO has no GPU at all, and a low quality keyboard

2. Computer PH has a very good GPU but has a low quality keyboard

3. Computer PY has a at least as good GPU, and a way better keyboard and as bonus it comes with a professional mouse

Everyone can see that FO is bad. Surely you can spend amazing times playing your favourite game with PH and PY. But the choice is asymmetrical. You may very well already own a PH computer and don't feel compelled to throw it away while it works. But when you have to get a new one there's no rational way to choose PH or FO.

## Wrapping up

The only one choice that should be hard to change in a well designed system is the programming language. One of the great arguments of web programming back on the day was that you could do the backend in the best way possible, not being binded by the operational system language. This is still true. You can commit to the best, or at least with something that is not obviously worse than others.

There are so many cool options out there, wanna some suggestions? Try: Python, Go, C, C#, Swift, Rust, Elm, Clojure, F#, OCaml, Haskell. After savoring what is possible you will be able to see that we are far from the top in terms of language. Yes, we still have to live with our legacy but don't choose PHP to write anything new. And thank you a lot PHP community, but I'm moving forward.

