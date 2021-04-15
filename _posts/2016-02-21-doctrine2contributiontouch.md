---
layout: post
title: Doctrine 2 contribution touch
---

One of my goals for 2016 is to be a par excellence open source
contributor. The project I'm aiming to focus my work is on the Doctrine
2, for lots of reasons. Firstly because it's an excellent project with
lots of the top PHP developers. Did you know that @ocramius is the most
assiduous contributor on Github? Secondly I use it on a daily basis
at work, so the more I'm proficient at it, the better asset am I for
Compufácil.

But the purpose of this post is to elaborate on some experience I
got from collaborating to it till now. I have almost a year in
front of me to be an impactful Doctrine 2 developer, so for now
don't expect great achievements.

The majority of the results worth noting are on myself. Firstly I
read the docs. Not all of it till now, but all of the Common, 
DBAL, and the major part of the ORM. This rendered me some nice
insights on Doctrine that I didn't have previously.

Some examples of things I learned thought the documentation are
described below. For the more experienced developers some of the 
things I found where might not be any news, but I'm currently on my
first project using doctrine ORM, so I got some surprises on the
docs.

### Debugging Doctrine Entities

Each doctrine entity have lots of things appended to it, so a
simple  *var_dump* on them will probably overflow your memory.
Thinking on that, the *Commom* package provides a debug function
that can be used as showed below:

```
Doctrine\Common\Util\Debug::dump()
```

### Don't call persist on managed entities

After a find, for example, you don't need to call persist to flush
the entity state since the entity is already on Doctrine map of
managed entities.

```
<?php
$user = $entityManager->find("Person", 1);
$user->setName("Guilherme");
$entityManager->flush();
```

### Know the size of your UnitOfWork

A too big UnitOfWork will result in high writing times. So is good 
for the developer to keep in mind  it's current size. To do so the
developer can use the method described below.

```
$uowSize = $em->getUnitOfWork()->size();
```

### Use abbreviations on CLI

Doctrine's CLI interface supports abbreviations. Finally I
understood the why of those ugly separators on the words.

An example:

```
doctirne-bin o:v
```

To mean:

```
doctirne-bin orm:validate-schema
```

---


So this are some tips I got from reading the docs. There's a lot
more there than what I registered here, certainly worth reading.
From reading the docs I found some mistakes there, basically
broken links. So I fixed those, in the ORM and on DBAL. It was not
as simple as you might think, the docs uses Sphinx to compile the
Web and an PDF version. So I had to learn how to setup Spinx and a
little bit of it's syntax. These fixes rendered me two pull
requests, so from it forward I'm a real contributor of Doctrine
project \0/.


After the docs I started studying the code. Mainly the ORM's one.
From it I got lots of insights as well. A major one is related to
the tests suite performance. Doctrine ORM has about 3k tests and
runs on 10s, on Compufácil we have 800 tests which take 40
seconds. Really there's room for improvement. Mainly related to
the use of mocks based on interfaces instead of testing directly on
the implementations.

Another tip I got, probably an obvious one, but i didn't know
anyway, is the use of phpunit's fail.

### Use fail

Fail as the name suggests is an API for the developer to say that
an test failed. Before knowing it used to write:

```
static::assertTrue(false);
```

But with it the code seems much more elegant, and supports an
argument with the failure reason.

```
static::fail("Optionally with the reason of the failure");
```

## Exception collections


From code inspection I also get an insight about how to organize 
exceptions. Doctrine uses a single class for many related
exceptions instead of using a single one for for a single exception
like I used to do.

An example of this pattern is the file ``lib/Doctrine/ORM/ORMException.php``. They use static functions
to tweak the message and code of the returning instance. Like a 
factory method.

Inspecting some pull requests I found [this
link](http://rosstuck.com/formatting-exception-messages/) explaining
better this pattern usage.


After some code inspection I started to look on something to code.
Firstly I looked at the issues, but the majority of them seemed to
much for me to take as a first code contact.  So I went to check
the pull requests, and there I found a mine of gold. There's lots
of pull requests with the tag *missing tests*, this is a good
opportunity for guys like me trying to enter Doctrine's
development.

I looked for some older pull requests with missing tests (so I'm
almost sure that developers will not bother if I stared adding
code in their pull requests, since they probably already forgot
about them). And I found some, like an pull request about the
criteria API not working on not owning sides. I added a test to it
and, after some time of wait it was accepted without any
complains. So for this point on I'm actually an developer
contributor of Doctirne's 2 \0/.

After that I added another test about an exception that is yet to
be approved but probably will. Inspecting pull requests I found 
a PR relating to a problem that where already fixed, so I commented on
it and it was removed from the list of open pull requests as well.


It's too early for me to consider this journey a successful one but
I already learned a lot about open source, about Doctrine, about the
rigorous git workflow of it. An I've been able to help Doctrine, even if
on a small scale. I hope that in a near future I'll be able to do even
greater improvements on this wonderful project.

So if I could give an council, even if I'm not a too successful example, for people expecting to 
enter open source development. Start small, probably by the
documentation.  And follow to the pull requests, look if there are
some old (probably abandoned one's) which you can do a simple
improvement. After that follow to the simple issues, and keep
going.

That's it. Thanks for your attention.



