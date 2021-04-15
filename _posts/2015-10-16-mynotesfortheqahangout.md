---
layout: post
title: My notes for the QA Hangout
---

I participated on a hangout about QA with PHP, you can check it
out [here](https://www.YouTube.com/watch?v=lSP70aT5f2Y). I think
It was a good one, we had even the right of a
[review](http://www.jack.eti.br/hangout-qa-em-php-ferramentas-tecnicas-e-processos/). 

The following content is a collections of notes I build to orient
my talk on the event.

## Braimstorm

- Test ONLY business logic;

- Write a new test VS add an assertion in the existing one
    Always reduce to a valuable busiess requirement

- Test the smaller scope possible on your small tests
    If you prove the part you are proving the hole as
    well;

- Start small
    On new features I usually put the test class and the class on
    the same file till I'm encouraged enough by it's features to
    split;

- Avoid databases if you can
    It's slow and Doctrine somethimes trows exceptions so we have to rebuild the
    entire setup;

- Coverage
    Use data structures that make special cases go away - Which is the ideal size to get started with the logic?

- Write only tests that fail

- Tests size
    Google don't divide the tests in unity, integration,etc. They
    use the small, medium and big.
    I use an annotation size to define it

-  At google testing is called engineering of productivity

- Medium tests can be used to test a hole feature
    Convert you browser request into a test when something fails. In
    php there is the var_export funciton that generates an array.

- Make easy the reuse of features on tests
    On Compufácil we use a collection of traits on tests so we can
    avoid the trouble of instanciating may things. The traits
    accept mixed arguments and try to do the best to create the
    entity with only what the developer is wanting to pass to the
    test.

- The refactor is a troublesome step
    If you see you can abstract, maybe your test will be totally
    desintegrated.
    So is nice to dismember the feature you want to test from the
    begining so you avoid some trouble with abstractions.

- Abuse of the concept of factories. If you use a library to
  manage dependencies better, so on the factory you can load
  environments variables and configurations to make your object
  proper to run tests and go in production.

- Don't test what the language can do for you:
php 7 brings scalar types and return types that can assert speed up testing  

### PHP7

Scalar types and return types for testing
Expectations - to assert setup code
Anonymous classes;

## Steps TDD
    - Write a test
    - Make it pass with the fewer trouble possible
    - Refactor
    - Start again

### Benefits
    Confident refactoring

### Tools
    php-beautifier and phpcs to check for style problems 
    pdepend - to generate statistics
    pyresttest - to test API's
    vfsStream - to test files
    mockery - to create mocks
    phpcop - to change dates

## Books

Test-Driven Development By Example - Kent Beck
How google tests software  - James Whittaker



