---
layout: post
title: Calculating processing time complexity
keywords: O notation, algorithms complexity

---

I'm gonna solve a complexity analysis problem today. The objective of
this process is to get a result of the complexity of the given algorithm
in the O notation. Mastering the concepts here demonstrated enables one
to measure the cost of any algorithm for any given input.

## O notation

For starters, the O notation demonstrates the theoretical cost of some
algorithm, not the real one. Its goal is to get a generalizable approach
to access complexity of algorithms. So the O notation discards every
aspect that is specific to a given machine in which the algorithm
is running on. It measures only the amount of "work" necessary for
processing a bunch of data. With that, one is able to know the cost of
the algorithm as the size of data grows.

Some examples of the O notation you might find everywhere are:

$ O(1) $

Means that the time for some function to return the data does not grow
with the size to the input.


$ O(log  n) $

Means that the time to compute the function increases in
a logarithmic magnitude in comparison to the input.

$ O(n) $


Means that the time to compute some function increases
linearly as the input increases.

$ O(n!) $


Means that its computing time increases by factorial terms
(exponentially).


I built a comparison of the growing curves for the above
notations.
![O notation comparison](http://i.imgur.com/2Yl0XjB.png)


## The algorithm

Now let's take a look at the algorithm we will access complexity.

```c
#include <stdio.h>
#include <stdlib.h>

#define TABLE_SIZE 2

void display_boolean_table(char *vector, int iterator, int size)
{
    int i;

    if (iterator > 0) {
        vector[size-iterator] = '0';
        display_boolean_table(vector, iterator-1, size);
        vector[size-iterator] = '1';
        display_boolean_table(vector, iterator-1, size);
    } else {
        for (i=0; i < size; i++) {
            printf("%c", vector[i]);
            printf("\n");
        }
    }
}

int main(int argc, char *argv[]) {
    char* vector;
    vector = malloc(sizeof (char) * TABLE_SIZE);
    display_boolean_table(vector, TABLE_SIZE, TABLE_SIZE);
    free (vector);
    return 0;
}
```

This algorithm prints a boolean table given the TABLE_SIZE.
If it has a size of 2, the output will be like this:

```sh
0
0
0
1
1
0
1
1

```


## Recurrence relationship

So, the first step is to find the recurrence relationship. The
recurrence relationship is an mathematical approximation of the
time taken by the algorithm.

$ T(n)  = 2T(n-1) + O(1)$

$ T(0)  = O(T) $

The recurrence relationship above is demonstrating that the
cost to compute an input of size `n` is two times the size of `n`,
since the function is calling itself two times
inside the algorithm. But at each recursive call the iterator is
decremented, so the cost must be `-1`. So we got `2T(n-1)`. For the
`O(1)` part, it composes the rest of the processing
(without recursive calls and without the else.

For the last part of the formula, that is executed when `iterator =
0`, the have `O(T)`. Which implies that the cost to execute the
`for` loop  is equal the size of the input, so `O(n)`.

We are not done. With the recurrence relationship we get a math
approximation of the algorithm itself. But to get a good notion of cost
we need a more generalized version of it. For that we use something
similar a proof by induction.

## Get the "base" of T(n)

We have to find a value for `T(n)` to see if we can infer a
pattern of its output. So let's assume a value for n and
simplify it until we get a proper sequence of `T(n)`. Let's start
with 4.

$ T(4) = 2T(3) + 1 $

So, to know `T(4)` we need to know `T(3)`. More exactly, we need
to know `2T(3)`. So let's place it on the left side of our formula
and apply the necessary modifications on the right.

$ 2T(3) = 2^2T(2) + 2 $

So two times `T(3)` is two times `T(2)` plus `2`. Now we need to
know the value of $ 2^2T(2) $, let's repeat the operation.

$ 2^2T(2) = 2^3T(1) + 2^2 $


Once again we repeat the operation, until we get on `T(0)` which
we already know the value `T(0) = O(T) = 4`.

$ 2^3T(1) = 2^4T(0) + 2^3 $


So let's cancel the duplicates in both sides to get our proper
sequence.

$ T(4) = \cancel{2T(3)} + 1 $

$ \cancel{2T(3)} = \cancel{2^2T(2)} + 2 $

$ \cancel{2^2T(2)} = \cancel{2^3T(1)} + 2^2 $

$ \cancel{2^3T(1)} = 2^4T(0) + 2^3 $


So in the end we get a proper growing sequence.

$ T(4) = 1 + 2 + 2^2 + 2^3 + 2^4.4 $

Generalize T(n) by it's base output
-----------------------------------

With this pattern in hand we can generalize the cost per increment of n.

$ T(n) = \sum_{i=0}^{n-1} 2^i  + 2^nn $

And we can simplify the sum like the following:

$  \sum_{i=0}^{n-1} 2^i  = 2^n - 1 $


So we got:

$ T(n) = 2^n - 1  + 2^nn $

Finally we got an interesting generalization. We just have to extract
the O notation from it. We want to know the theoretical cost of running
the algorithm as the input grows. For that we just need the most costly
part.

And in this case the most costly part of the function is $2^nn$.
In technical terms $2^nn$ grows asymptotically the rest of the
function. So for the sake of complexity analysis the result is $O(2^nn)$.

This cost is exponential so we may say properly that the algorithm is
inefficient.

I plotted the time cost of the function for 20 iterations. Take a
look:

![Time cost](http://i.imgur.com/t4FgDpc.png)

And the complete equation compared with it's O notation relevant
part. Note how they practically don't diverge, since the $ 2^nn $
is much more expensive then the rest.

![Time cost comparisom](http://i.imgur.com/XJNhb2d.png)


That's all, any doubts comment below.
