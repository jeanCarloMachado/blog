---
layout: post
title: My Experience at GetYourGuide
keywords: Reporting getyourguide
---


I'm a Brazilian guy who dreams about making people’s lives better through science and technology. I recently turned my life upside-down by moving to Berlin to work at GetYourGuide. Over these past few months, I’ve gathered my first impressions working here as a Senior Backend Engineer. 

## The Culture 

There's compelling evidence that the number one reason why people quit their jobs is problems with other people. The one aspect that struck me the most about GetYourGuide was the company’s high standards for the human side of the business. This is by far the best place I've worked in terms of culture. We have 5 core values that are demonstrated in our daily work and are carefully examined during our "bar raiser" hiring process. Diversity is present and cultivated. Our culture is our biggest treasure.

The company is big, and I know just a fraction of the people. That being said, there are a lot of organization-level opportunities for getting to know everyone. Every Friday there's beer and pizza, language courses on a weekly basis, randomized group lunches, team events, and more. In the first week I went to a poetry “battle” with my colleagues. It's hard to ever imagine doing something similar in Brazil since I'm not the most sociable person around. Yet, I found it easy to connect with people, and we had a good time.

## Getting Technical 

Now, regarding the technical piece: first and foremost, we are truly data-driven. A/B testing is at the core of our operations. In my 3 months here, I’ve made many changes to the site, and all of them followed an experiment. Being a science enthusiast myself, I could not appreciate this more.

In software engineering, we have a stack to be envied for new projects: Kubernetes, ~50 microservices in Python, Scala, Node, and others. We also query our data lake with Spark, which is super cool.

Of course, there is a lot of legacy code which can slow us down, but this is a good problem to have. It means we are a successful case: companies who don't have legacy code are either being born or they’re already dead. We strive to improve the legacy code and are also moving things to microservices. To give an example, I'm currently working on a proposal for using a better dependency inversion tool that will enable us to make complexity explicit and test more.


## Even Better If... 

One thing I was suspicious about at first was that unit-testing (and TDD) is not a commonplace practice. The company rationale for this is that changing things through the use of AB testing enables us to fall back to the original version (A) if something goes wrong in the experiment (B). After looking at this empirically, it seems to actually be true. The site hardly breaks, and, when it does, we have well-defined procedures to make it transparent and prevent it from happening again. With that said, I regard TDD as more of a design tool rather than a correctness test, and I will try to encourage it's usage. 

I also believe we would benefit by using more static checking, single binary deploys, and declarative programming practices, which I will promote in our weekly tech talks and in practice. Given our culture and the people I work alongside, I feel very open and encouraged to challenge the status quo.

Code review in Get Your Guide takes much longer than I’m used to. It's not a simple matter of validating that code is well-written. The reviewer also has ownership over the business solution he approves. This means the knowledge sharing is deeper than at other companies I’ve worked at.

My first real software delivery was replacing a big piece of our classifier's logic to cluster activities. After some necessary introduction and sanity checks, the person who onboarded me let me build the solution I thought was best. It is vital to have this kind of empowerment from the start, and I was grateful for it.

Now I'm working on the recommendations for sold-out activities since data shows there's room for improvement there. In the process, I'm helping to put a new recommendations microservice in production because it will allow us to experiment faster. I feel it is important to take technical actions only when they are justifiable through business value, and we have this balance here.

## Conclusion

In the end, it is all about providing incredible experiences to travelers around the world. This mission is so cool, it’s impossible not to fall in love with. We are a company full of travels. And, as a company, we relate to our customers and also need the solution we’re building.  

I'm happy I decided to join Get Your Guide. We have great challenges and the right mindset to tackle them. I'm learning a lot and I have the space to make some difference, which I'll strive to do on my journey here.

