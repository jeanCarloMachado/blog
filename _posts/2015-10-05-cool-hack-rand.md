---
layout: post
title: A cool hack for rand
---

This trick is useful when one's need a 50% of chance of something
in PHP.

```
$yesOrNo = rand()&1;
```

This is equivalent to:

```
$yesOrNo = rand(0, 1);
```

But fast. It's faster quicker than the conventional because
it avoids method parsing.

So next time you need it, remember this cool trick.
