---
layout: post
title: Simple presentation template with Markdown and Pandoc
---

---
layout: post
title: Blogging Like a Hacker
---

I've made some presentations following the template described where, so
I want to register the process here to avoid forgetting it. And maybe
someone might find it useful as well.

What I like in the approach here described is it's
simplicity. There some more advanced techniques like
[this](https://gist.github.com/lmullen/c3d4c7883f081ed8692a) that are probably better for complex presentations.

What you need:

1. Markdown presentation;
2. A latex header;
3. A makefile;


##  Presentation format

```
# Main Title

# Second slide

Content

. . .

Content on second slide that appears only after click

#  Third slide

Content

#  Fourh slide

code


```
*File: presentation.md*


##  Latex header

```
\usetheme{m}
\usepackage{array}
\usepackage{graphicx}
\usepackage[utf8]{inputenc}
\usepackage[portuges]{babel}
\title{Front in floripa}
\author{Jean Carlo Machado}
\date{Dezembro, 2015}
\usepackage[overlay,absolute]{textpos}
\TPGrid[10 mm,8 mm]{9}{8}
\usefonttheme{professionalfonts}
\usepackage{ragged2e}
\justifying
\addtobeamertemplate{block begin}{}{\justifying}
```
*File: presentation.tex*


##  Makefile

```
all: presentation

presentation:
    pandoc --latex-engine=xelatex -t beamer -H presentation.tex presentation.md -o presentation.pdf

clean:
    rm -rf presentation.pdf
```

That's it, with this tree files you are able to get a presentation
like
[this](http://www.slideshare.net/jeancarlomachado/clean-code-51677135).

To run the code just do a ``make``.
