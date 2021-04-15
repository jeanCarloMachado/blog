---
layout: post
title: The pragmatic programmer notes
---

Here are some of the key aspects of this amazing book: The pragmatic programmer.
If you like these sparse ideas and want to go a step further I recommend that you buy the book.

## Characteristics of pragmatic programmers

- Early adopter/fast adapter;
- Inquisitive;
- Critical Thinker;
- Realistic;
- Jack of all trades;

---

Within the overall structure of a project there is always room for individuality and craftsmanship. This is particular by true given the current state of software engineering. One hundred years from now, our engineering may seem as archaic as the techniques used by medieval cathedral builders seem to today's civil engineers, while our craftsmanship will still be honored.

---

Before you approach anyone to tell them why something cant be done, is late, or is broken, stop and listen to yourself. Talk to the rubber duck on your monitor, or the cat. Do your excuse sound reasonable, or stupid? How's it going to sound to your boss?

Run through the conversation in your mind. What is the other person likely to say? Will they ask, "Have your tried this.."  or "Didn't you consider that?" How will you respond? Before you go and tell them the bad news, is there anything else you can try? Sometimes, you just know what they are going to say, so save them the trouble.

---

One broken window - a badly designed piece of code, a poor management decision that the team must live with for the duration of the project - is all it takes to start the decline. If you find yourself working on a project with quite a few broken windows, it's all too easy to slip into the mindset of "All the rest of this code is crap, I'll just follow suit."

---

## Portfolio

- Serious investors invest regularly - as a habit
- Diversification is the key to long-term success
- Smart investors balance their portfolio between conservative and high-risk, high-reward investments
- Inventors try to buy low and sell high for maximum return
- Portfolios should be reviewed and rebalanced periodically


---

## Opportunities for Learning

So you are reading voraciously, you are on the top of all latest breaking developments in your field (not an easy thing to do), and somebody asks you a question. You don't have the faintest idea what the answer is, and freely admit as much.

Don't let it stop there. Take it as a personal challenge to find the answer.

If you cant find the answer yourself, find out who can. Don't let it rest. Talking to other people will help build your personal network, and you may surprise yourself by finding solutions to other, unrelated problems along the way. And the old portfolio just keeps getting bigger.


If you ask someone a question, you feel they're impolite if they don't respond. But how often do you fail to get back to people when they send you and e-mail or a memo asking for information or requesting some action? In the rush of everyday life, it's easy to forget. Always respond to e-mails, even if the response is simple "I'll get back to you later." Keeping people informed makes them far more forgiving of the occasional slip, and makes them feel that you haven't forgotten them.


---

## Orthogonality of systems

Two or more things are orthogonal if changes in one do not affect any of the others. In a well designed system, the database code will be orthogonal to the user interface: you can change the interface without affecting the database, and swap the database without affecting the interfaces.

### Benefits:

- Eliminate effects between unrelated things.
- Changes are localized.
- Promotes reuse.
- Disease sections of code are isolated.
- The result system is less fragile.
- Better tested.
- Not tightly to a particular vendor.

Have you noticed how some project teams are efficient, with everyone knowing what to do and contributing fully, while the members of other teams are constantly bickering and don't seem able out of each others way?

Often this is an orthogonality issue. When teams are organized with lots of overlap, members are confused about responsibilities. Every change needs a meeting of the entire team because any of the team might be affected.

---

### Law of Demeter

If you need to change an object's state, get the object to do it for you. This way code remains isolated from the other's code's implementation and increases the chances that you will remain orthogonal.

Avoid similar functions - **duplicated code is a symptom of structural problems**.

*Building unit tests is itself an interesting test of orthogonality. What does it take to build and link a unit test? Do you have to drag in a large percentage of the rest of the system just to get the test compile or link? If so, you have found a module that is not well decoupled from the rest of the system.*

Bug fixing is also a good time to assess the orthogonality of the system as a whole. When you come across a problem, asses how localized the fix is. Do you change just one module, or the changes scattered thought the entire system? When you make a change, does it fix everything or the problems mysteriously arise? This is a good opportunity to bring automation to bear. If you use a source code control system tag bug fixes when you check the code back in after testing. You can run monthly reports analyzing trends in the number of source code files affected by each bug fix.


---
## Estimation

By learning to estimate, and by developing this skill to the point where you have an intuitive feel for the magnitudes of things, you will be able to show an apparent magical ability to determine their feasibility. When someone says "well" send the backup over an ISDN line to the central site, "you'll be able to know intuitively this is practical. When you're coding, you'll be able to know intuitively whether this is practical. When you're coding, you'll be able to know which subsystems need optimizing and which ones can be left alone.

The first part of any estimation exercise is building an understanding of what's being asked. As well as the accuracy issues discussed above, you need to have a grasp of the scope of the domain. Often this is implicit in the question, but you need to make it in a habit to think about the scope before starting to guess.

### Build a model

Model building can be both creative and useful in the long term. Often the process of building the model leads to discoveries of underlying patterns and processes that weren't apparent on the surface.


### Keep track of your estimating prowess

We think it's a great idea to record your estimates so you can see how close you we're. If an overall estimate involved calculating sub estimates, keep track of these as well.

When an estimate turns out wrong, don't just shrug and walk away.

### What to say when asked for an estimate

You say "I'll get back to you"

You almost always get better results if you slow the process down and spend some time going through the steps we describe in this section.Estimates given at the coffee machine will (like the coffee) come back to haunt you.

---

## Keep Knowledge in Plain Text

Benefits:
- Insurance against obsolescence
- Leverage (every tool in the computer universe can operate on plain text)
- Easier testing

### The problem of GUI's

A benefit of GUIs is WYSIWYG - what you see is what you get. The disadvantage is WYSIAYG - what you see is *all* you get.

Actions one cannot do with a GUI.

- Find all .c files modified more recently than your makefile
- Construct a zip/tar archive of my source
- Which Java files have not been changed last week?
- Of those files, which the awt libraries?
- A list of all unique package names explicitly imported by your Java code.

---

## One Editor

Choose an editor, know it thoroughly, and use it for all editing tasks. If you use a single editor (or set of key bindings) across all text editing activities, you don't have to stop and think to accomplish text manipulation: the necessary key strokes will be a reflex. The editor will be an extension of your hand; the keys will sing as they slice their way through text and thought. That's our goal.

A language to learn this year? Learn the language your editor uses.

---

## Source code control

Make sure that everything is under source code control -  documentation, phone number lists, memos to vendors, makefiles, build and releases procedures, that little shell script that burns the CD master - everything.

---


## Debugging

In the technical arena, you want to concentrate on fixing the problem, not the blame.

Before you start debugging, it's important to adopt the right mindset. You need to turn off many of the defenses you use each day to protect your ego, tune out any project pressures you may be under, and get yourself comfortable. Above all, remember the first rule of debugging:

- Don't Panic

If your first reaction on witnessing a bug or seeing a bug report is "that's impossible", you are plainly wrong. Don't waste a single neuron on the train of thought that begins "but that can't happen" because quite clearly it *can*, and has.

 - Artificial tests don't exercise enough of an application. You must brutally test both boundary conditions and realistic end-user usage patterns. You need this systematically.

### Bug Reproduction

We want more than a bug that can be reproduced by following some long series of steps; we want a bug that can be reproduced with a single command. It's a lot harder to fix a bug if you have to go through 15 steps to get to the point where the bug shows up. Sometimes by forcing yourself to isolate the circumstances that display the bug, you'll even gain an insight on how to fix it.

If you have no obvious place to start looking, you can always rely on a good old-fashioned binary search.

The amount of surprise you feel when something goes wrong is directly proportional to the amount of trust and faith you have in the code being run. That's why, when faced with a "surprising" failure, you must realize that one or more of your assumptions is wrong. Don't gloss over a routine or piece of code involved in the bug because you "know" it works. Prove it. Prove it in the context, with this data, with these boundary conditions.

If the bug is the result of bad data that was propagated through a couple of levels before causing the explosion, see if better parameter checking in those routines would have isolated it earlier.

If it took a long time to fix this bug, ask yourself why. Is there anything you can do to make fixing this bug easier the next time around? Perhaps you could build in better testing hooks, or write a log file analyzer.

Finally, if the bug is the result of someone's wrong assumption, discuss the problem with the whole team: if one person misunderstands, then it's possible many people do.

---

## Code generators

### Passive Generators

Passive code generators are run once to produce a result. From that point forward, the result becomes freestanding - it is divorced from do code generator.

Uses:

- Creating new source files;
- Performing one-off conversions among programming languages;
- Producing lookup tables and other resources that are expensive;

### Active Generators

Active code generators are used each time their results are required. The result is a throw away - it can always be reproduced by the code generator. Often, active code generators read some form of script or control file to produce their results.

While passive code generators are simply a convenience their active cousins are a necessity if you want to follow the DRY principle. With an active code generator, you can take a single representation of some piece of knowledge and convert it into all forms your application needs. This is not duplication, because the derived forms are disposable and are generated as needed by the code generators (hence the word active).

Whenever you find yourself trying to get two disparate environments to work together, you should consider active code generators.

---

## Pragmatic paranoia

Pragmatic programmers don't trust themselves, either.

---

## Design by Contract

Be strict in what you sill accept before you begin, and promise as little as possible in return. Remember, if your contract indicates that you'll accept anything and promise the world in return, then you've got a lot of code to write.

The greatest benefit of using DBC may be that it forces the issue of requirements and guarantees to the forefront. Simply enumerating at design time what the input domain range is, what the boundary conditions are, and what the routine promises to deliver - or, more importantly, what it doesn't promise to deliver - is a huge leap forward in writing better software. By not stating this things, you are back to programming by coincidence, which is where many projects start, finish and fail.

It's much easier to find and diagnose the problem by crashing early, at the site of the problem.

---

## Law of Demeter for functions

Any method of an object should call only methods belonging to: itself, any parameters received, any objects it creates and any directly held component objects.

---

## Meta programming

We want to go beyond using meta data for simple preferences. We want to configure and drive the application via meta data as much as possible. Our goal is to think declaratively (specifying what is to be done, not how) and create highly dynamic and adaptable programs. We do this by adopting a general rule: program for the general case, and put the specifics somewhere else - outside the compiled code base. Put abstractions in code detail in Meta data.

Benefits:

It forces you to decouple your design, which results in a more flexible and adaptable program.

It forces you to create a more robust abstract design by deferring details - deferring them all the way out of the program.

- You can customize the application without recompiling it.
- You can also use this level of customization to provide easy work around for critical bugs in live production systems.
- Meta data can be expressed in a manner that's much closer to the problem domain that in general-purpose programming language might be.
- You may even be able to implement several different projects using the same application engine, but with different meta data.

---

## Programming by Coincidence

Developers who don't actively think about their code are programming by coincidence - the code might work, but theres no particular reason why.


Why should you take the risk of messing with something that's working?

- It may not really be working - it might just look like this
- The boundary condition you rely on may be just an accident. In different circumstances it might behave differently.
- Undocumented behaviour may change with the next release of the library
- Additional and unnecessary calls make your code slower
- Additional calls also increase the risk of introducing new bugs on their own.


For code you write that other will call, the basic principles of good modularization and of hiding implementation behind small, well-documented interfaces can all help. A well-specified contract can help eliminate misunderstandings.


---

## How to program deliberately

We want to spend less time churning out code, catch and fix errors as early in de development cycle as possible, and create fewer errors to begin with. It helps if we can program deliberately:

- Always be aware of what you are doing. Fred let things get slowly out of hand, until he ended up boiled.
- Don't code blindfolded. Attempting to build an application you don't fully understand, or to use a technology you aren't familiar with, is an invitation to be misled by coincidences.
- Proceed from a plan, whether that plan is in your head, on the back of a coktail napkin, or on a will-sized printout from a CASE tool.
- Rely on reliable things. Don't depend on accidents or assumptions. If you can't tell the difference in particular circumstances, assume the worst.
- Document your assumptions. Design by contract, can help to clarify your assumptions in own mind, as well as help communicate them to others.
- Don't just test your code, but test your assumptions as well. Don't guess; actually try it. Write an assertion to test your assumptions. If your assertion is right, you have improved the documentation in your code. If you discover your assumption is wrong, then count yourself lucky.

- Prioritize your effort. Spend time on the important aspects; more than likely, these are the hard parts. If you don't have fundamentals or infrastructure correct, brilliant bells and whistles will be irrelevant.

- Don't be a slave to history. Don't let existing code dictate future code. All code can be replaced if it's no longer appropriate. Event within one program, don't let what you've already done constrain what you do next - be ready to refactor. This decision may impact the project schedule. The assumption is that the impact will be less than the cost of not making the change.

Pragmatic programmers think critically about all code, including our own. We constantly see room for improvement in our programs and our designs.

---

## Refactoring


Time pressure is often used as an excuse for not refactoring. But this excuse just doesn't hold up; fail to refactor now, and there'll be a far greater time investment to fix the problem down the road - when there are more dependencies to reckon with. Will there be more time available then? Not in our experience.

Keep track of the things that need to be refactored. If you can't refactor something immediately, make sure that it gets placed in the schedule. Make sure that the users of the affected code know that it's scheduled to be refactored and how this might affect them.

---


## Testing against Contract

We like to think of unit testing as testing against contract. We want to write test classes that ensure that a given unit honors it's contract. This will tell us two things: whether the code meet the contract, and whether the contract means what we think it means. We want to test that the module delivers the functionality it promises over a wide range of test cases and boundary conditions.

Once the subcomponents have been verified, then the module itself can be tested. This technique is a great way to reduce debugging effort: we can quickly concentrate on the likely source of the problem and not waste time reexamining it's subcomponents.

Why do we go to all this trouble? Above all, we want to avoid creating a "time bomb"- something that sits around unnoticed and blows up at an awkward moment later in the project. By emphasizing testing against contract, we can try to avoid as many of those downstream disasters as possible.

---


## Adhock testing
During debugging, we may end up creating some particular tests on-the-fly. These may be as simple as print statement, or a piece of code entered interactively in a debugging or IDE environment.

At the end of the debugging session you need to formalize the adhock test. If the code broke once, it's likely to break again. Don't just throw away the test you created; add it to the existing unit test.

---

## Pragmatic teams

### No broken windows

Quality is a team issue. Teams as a hole should not tolerate broken windows - those small imperfections that no one fixes. The team must take responsibility for the quality of the product, supporting developers who understand the *no broken windows* philosophy, and encouraging those who haven't yet discovered it.

Keep metrics on new requirements (p. 209). The team needn't reject changes out of hand - you simply need to be aware that they are happening. Otherwise, it will be you in the hot water.

The closer to the user you're allowed, the more senior you are.

Civilization advances by extending the number of important operations we can perform without thinking. - Alfred North Whitehead

---

## Metrics to examine code

- Ciclomatic complexity
- Inheritance fan-in (number of base classes) and fan-out (number of derived modules using this one as parent)
- Response set (Decoupling and law of Demeter);
- Class coupling ratios

If you find a module whose metrics are marked different from all the rest, you need to ask yourself if it's appropriate. For some modules, it may be ok to "blow the curve". But those who don't have a good excuse, it can indicate problems.

If a bug slips through the net of existing tests, you need to add a new test to trap it next time.

---

## It's all writing

Typically, developers don't give much thought documentation. At best it is an unfortunate necessity; at worst it is threatened as a low-priority task in the hope that management will forget about it at the end of the project.

Pragmatic programmers embrace documentation as an integral part of the overall development process. Writing documentation can be made easier by not duplicating effort or wasting time, and by keeping documentation close at hand - in the code itself if possible.

Treat English as just another programming language.

### Comments

In general, comments should discuss why something is done, it's purpose and it's goal. The code already shows how it's done, so commenting on this is redundant - and a violation of the DRY principle.


Commenting source code gives you the perfect opportunity to document those elusive bits of a project that can't be commented anywhere else: engineering trade offs, why decisions where made, what other alternatives where discarded and so on.

One of the most important pieces of information that should appear in the source file is the author's name - not necessarily who edited it last, but the honor. Attaching responsibility and accountability to the source code does wonders in keeping people honest.

### Executable documents

Suppose we have a specification that lists the columns in a database table. Well then have a separate set of SQL commands to create the actual table in the database, and probably some kind of programming language record structure to hold the contents of a row in the table. The same information is repeated tree times. Change any one of these tree sources, and the other two are immediately out of date. This is a clear violation of the DRY principle.

To correct this problem, we need to choose the authoritative source of information. This may be the specification, it may be a database schema tool, or it may be some third source altogether. Let's choose the specification document as the source. It's now our model for this process. We then need to export the information it contains as different views - a database schema and a high-level language record, for example.

Documentation and code are different views of the same underlying model, but the view is all that should be different. Don't let documentation be a second class citizen, banished from the main project workflow. Treat documentation with the same care you treat code, and the users (and maintainers who follow) will sing your praises.

---

## Relatively easy things to delight the common user

- Balloon or tool tip help;
- Keyboard shortcuts
- A quick reference guide as a supplement to the users manual;
- Colorization
- Log files analyzers
- Automated installation
- Tools for checking the integrity of the systems
- The ability to run multiple versions of the systems for training
- A splash screen customized for their organization

All of these things are relatively superficial, and don't really overburden the system with feature bloat. However, each tells the users that the development team cared about producing a great system, one that was intended for real use. Just remember not to break the system adding these new features.

We want to see pride and ownership. "I wrote this, and I stand behind by work." Your signature should come to be recognized as an indicator of quality. People should see your name on a piece of code and expect it to be solid, well written, tested, and documented. A really professional job. Written by a professional. A pragmatic programmer.

---


## Professional Societies

There are two world-class professional societies for programmers: the Association for Computing Machinery (ACM) and the IEEE Computer Society. We recommend that all programmers belong to one (or both) of these societies. In addition, developers outside the United States may want to join their national societies, such as BCS in the United Kingdom.

Membership in a professional society has many benefits. The conferences and local meetings give you great opportunities to meet people with similar interests, and the special interest groups and technical committees give you the opportunity to participate in setting standards and guidelines used around the world. You will also get a lot out of their publications, from high-level discussions of industry practise to low-level computing theory.

---

## Building a Library

We're big on reading. A good programmer is always learning. Keeping current with book and periodicals can help.

### Periodicals

- IEEE Computer
- IEEE Software
- Communications of the ACM
- SIGPLAN
- Dr Dobbs Journal
- The Perl Journal
- Software Development Magazine

### Books

- Object Oriented Software Construction
- Design Patterns
- Analysis Patterns
- The Mytical Man Month
- Dynamics of Software Development
- Surviving Object-Oriented Projects: A Managers Guide
- Unix
- C++
- Slashdot
- Cetus Links


That's it thanks for the attention.
