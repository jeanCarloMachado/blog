---
layout: post
title: Why I've always sucked at software estimation
keywords: estimating, software engineering
---

Looking back at my career, is clear to me that most of the time I failed
miserably when estimating software delivery dates. Worse of all is that
my estimations are usually underestimations. And this can be really
painful. You try hard to keep up with your word and live in chaos
near the deadline and afterwards. When you're the manager this problem
amplifies because you're conditioning others to your predicament. But
what is the root of the problem? It's not like I've been dishonest,
neither I lack efficiency or focus. And yet I still think that my
predictions are accurate in some sense.

Not long ago I realized that what I've been doing as an estimator is
estimating the time needed to develop something. Not the time necessary
to put it on production. And turns out that there is a HUGE
difference between both.

I'll call the time needed to build something **construction time**.
There are clear aspects that one can fail in estimating construction
time. Some examples are: not realizing that the problem is NP-Complete while trying to
build a deterministic solution or failing to account the time needed to
learn something necessary. And good software estimators have to have a
good grasp of that. I do.

But there are much more things beyond construction time for you to get a
proper **production date**. Some that come to mind:

 - Failures on the stack infrastructure (when you do not own it)
 - The time you need to wait to someone to review your changes
 - Any changes that might happen in the review loop
 - Meetings that appears in the middle of journey, unexpected personal appointments
 - Something you find in the middle of your progress that you find useful to discuss


I'm no good at estimating any of those, and I dare to bet that no one
is. So I think there's a mismatch of what people can actually predict
and what people expect when they get an estimation.

But, how to solve this conundrum?

One might fix that by simply adding a "chunk" of time extra to the
estimations. Like the heuristic of: always double your estimation cost.
But this solution don't resonate to me. First, this does not seem
honest. And in a way I'm rejecting my analysis and putting some
arbitrary time frame that I have absolute no idea of what it represents.

I think the best solution is a re-framing of the answer. We have to make
clear what we actually mean by predicting that a given piece of
software will take a certain amount of time to be completed.

Talking in terms of hours instead of dates is a better way of putting
things. Instead of saying *this piece of software will be delivered
Monday* is much more useful to say *this piece of software will demand 8
hours of uninterrupted attention to be constructed*. You might very well
only get those 8 hours on Wednesday.

This way you don't compromise yourself with a deadline that might make
you miserable and yet convey the sense cost of building x. This approach
also adds the benefit of revealing possible problems in the process. If
you only got 8 hours of uninterrupted work in 5 days ahead there's a
high probability that something is dysfunctional with yourself or your
work environment.

Many people might be unsatisfied by an estimation in terms of
construction time instead of production date. But my experience is
that the most reasonable stakeholders will understand the situation (and
appreciate your clarification and honesty). What they really want is a
sense of cost, and when you deliberately give it terms of a date you're
setting a trap for yourself. It's much better to have an accurate sense
of cost instead of a dreamy deadline. 

I hope this reflection might help you next time you're tempted to give an
estimation in terms of dates. And if you have additional insights on how not to
suck at software estimation please share in the comments.

