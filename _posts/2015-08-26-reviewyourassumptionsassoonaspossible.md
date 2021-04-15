---
layout: post
title: Review your assumptions as soon as possible
---

When debugging one must detach from what he things is certain - it's
premises.

Today we where seeing a inexplicable error on Ci. An integration
test was failing because it could not find a method that we renamed
previously. All it's occurrences we're removed as well. So there was not
way how it could be looking for it. Looking for the called method on the
source returned nothing, as expected.

After much debugging, we reached a point in debugging that the only
remaining option was restarting the server. When we did it, it turns out
that the problem vanished.

(My hypothesis is that there were some cache related to the **/tmp**
folder that we are not aware of yet.)

But what matters is: it always make sense, don't buy the inexplicable,
your tools are right as well, interchanging them will not help. Review
your premises.

The sooner you realize some of your premises are wrong the less stressed
you will be.

I follow a rule of thumb: if I can't find an error reviewing the same
part for more than tree times I must review my premises.
