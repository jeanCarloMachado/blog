---
layout: post
title: Use or no use
---

After much discussing on pull requests and private chats here I'll
clarify my posture when dealing with the "use" statement versus the FQDN form of 
importing classes.

I would like to describe my opinions as the most pragmatic possible
keeping clean code rules in mind. I'll explain further this opinion.

My posture can be generalized by the following rule: *if one use a
class once it's more economic, and don't loose clarity, to use the  
FQDN form; but if one use it twice or more it's cheaper to use the use
statement*. 

Let's go to an example.

```
<?php

namepace MyProject;

use MyProject\Car\PortInterface;

class Car
{
    private $engine;
    private $leftPort;
    private $rightPort;

    public function __construct(
        \MyProject\Car\EngineInterface $engine,
        PortInterface $leftPor, 
        PortInterface $rightPort
    )
    {
        $this->engine = $engine; 
        $this->leftPort = $leftPort; 
        $this->rightPort = $rightPort; 
    }

}

```

As you can see, the port class is used twice and because of that I used
the *use* statement. Now, since the Engine class I used a single time, I
preferred to place the full FQDN.


```
echo "\MyProject\Car\EngineInterface" | wc -m
31
```
The engine as used above has 31 chars, on the use form I would
have 35.

```
echo "use MyProject\Car\EngineInterface;" | wc -m
35
```

In the case of the ports, with the use I have 14 for each usage plus 33, totaling 61.

```
echo "PortInterface" | wc -m
14

echo "use MyProject\Car\PortInterface;" | wc -m
33
```


I would get 29, times two using FQDN, totaling 58
chars.

```
echo "\MyProject\Car\PortInterface" | wc -m
29

```

61 is a little bigger than 58 but you can see how the use scales
well for more occurrences. One might even use the alias resource
to shorten the string for *Port* instead of *PortInterface* gaining
18 chars!

---

But some people might argue that I shouldn't be so character
pedantic. So let's revise some other arguments.

Anonymous - Maybe you should consider the namespace header as a form of
centralizing all the dependencies?

*Since we are software craftsmen we are dealing with few
dependencies and small classes so there's no point in keeping them
on the top, if a simple inspect on the file can give us the same clarity. And
if one needs to count the coupling there's tools for doing that.*

Anonymous - Maybe you should use the use alias resource as an easy
way of swapping concrete classes? When an implementation changes
it will be easier to change only the header of the document and
not bothering of looking for the FQDN's on the file.

*One should depend only upon abstractions not concreteness,
and abstractions don't change.
And even if you depend upon some sporadic concreteness the as
a clean coder your classes will be little so no problem in changing a
few occurrences.*

Anonymous: It's more performatic to use only FQDN's.

*I'm not really sure about if it really is. Anyway, as a writer of
software aming for people, that eventually will run on computers,
one should keep in mind that micro optimizations like that are never
welcome. It's much better to think for clarity, instead of performance
in these cases.*

Stated that I think my point remains true. The best selection script to
choose between FQDN's and uses is the programmer ease and readability.
And thinking on that, my opinion is that first time use the FQDN, if the
class repeats itself then move it to the header.

Probably there some edge cases that these statements don't apply,
but generally I think they do. And I don't see them as a kind of
rule. The only rule is do do the code as cleaner as reasonably possible.

