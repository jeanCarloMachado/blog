---
layout: post
title: Remove early
---

It's so common on software craftsmanship, to make things obsolete.
Ideas that aren't applicable anymore, pieces of rotting - not
tested - code, etc.

People are generally afraid of removing these files because they
might need them afterwards. Some part of the code that they didn't
know might need them, or the requirements might change (again).

My opinion is that one should remove files as soon as we realise
the file is obsolete. And by obsolete you can think of pieces of
code you don't need anymore and further, anything
that if you remove don't break any test.

The reason for this is posture is that we forget about what is obsolete soon.
And if we keep pilling the number of useless files on our
repository, soon it will became unmanageable.

As pragmatic programmers we all use version control systems, these
systems are way better in remember things than ourselves. So we
erase not needed files and trust that, if we regret after, the silicon
memory of our CVS's will save us.

Let's lose the fear of erasing from now on ok? It's way better
sometimes having to undo some erase than living in a system full
of useless files - adding complexity for something that is already
complex enough.
