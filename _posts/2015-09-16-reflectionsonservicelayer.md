---
layout: post
title: Reflections on Service layer
---

I'm used to opportunistic refactoring, and developing using TDD
opportunities are always presenting itself.

On Compufácil we have a service layer, it's like a "put almost
everything inside" term (excluding data structures).
The merits of this approach apart, I'm seeing a pattern to repeat 
itself when I'm refactoring services.

There's usually a service that's responsible for one aspect of the
business logic. As the system grows, the services aspects grows,
and the services responsibilities as well.

When I detect two related responsibilities on a service that
are distinct from the rest of class I usually refactor, removing
the related responsibilities from a class of it's own.

The problem is, beyond the separation of classes, the choices
became less
obvious. Sometimes this new class already uses some of the logic
from it's originator class, so I have to call the more generic,
originator class, from inside the more specific (refactored) one.
But the logic also inverts, there are times when I need the
specialized from inside the generic.

In these cases the sense of smelling design emerges. When you have
a cyclic dependency is like you should not have two classes at
all.

The problem is that the separated classes are not so distinct to
elaborate a perfect one way relationship between them.

I feel like, the more specialized should depend upon
the more abstract and not the other way around. But sometimes the
"more generic one's" are not more generic in the strict sense.
Using a service layer concept the term generic seems to accept a
second meaning: uncategorized messy functions.
The services layer seems to blur the direction of reuse.

But maybe it's a futile concern, maybe the only factor I'm missing
is a little bit of refactoring on the new class to specify it's
relationship with the more generic one.

Anyway, I feel a room for improvement, could it be that what is
missing is
a way to day implicitly which class depend of which. Maybe through
diagrams, maybe through a dependency inversion system, maybe
through annotations. The maybe persists.

I'll research more on the topic soon, if I find a "better
approach" I'll certainly  register it here.

