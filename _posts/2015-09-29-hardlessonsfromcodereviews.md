---
layout: post
title: Hard lessons from code reviews
---

These are some hard lessons from my year long experience with code reviews.

# Break your pull requests

The smaller the pull request the better. Reviewers obligated to
browser dozens of files, will end up reviewing superficially.

Rule: If you realise a pull request will end up too big for a unique review,
it's better to break it in two or more.

I'm totally in opportunistic refactoring, so abstaining from sending
improvements in code while I'm working on a feature isn't an option,
but - for the sake of the review - we must break the pull requests.

# The hangman

Many times I was labeled the "hangman" of the reviews. Truth
is that every single time I tolerate some "minor problem" I
regret.

In the end I'll end up having to work on the files that contains
these issues and I'll have to fix it by my own. Otherwise the
amount of problems will be keep pilling up and I will be forced to
rewrite every single piece of the software.

Reinforcing, all the times your feeling in a good mood with your
partner developer and you don't want to mess with his pride fulling
his pull request with "minor issues", think again, don't hesitate. If you
don't talk about it when the shit appears you probably will end up
cleaning it yourself.

Don't bother as well about the length of the conversation on the
pull request, it demonstrates your commitment about project. If you
have to do thirty comments, do it. Maybe in the next time you get
more quality (or less code).

A pull request without comments by one and full of comments by
other, may demonstrate that someone is not interested enough in the
code to complain about recurrent things.

Rule: If it's an recurrent problem, the you find in a PR, and it's fix or
notification can be automated, or at least documented, you must do it.

In the end of the day, being a hangman, in the sense of caring
about the code, is the only responsible thing to do.
