---
layout: post
title: Decoupling strategies for Zend Framework 2 applications
---

I'm recently reflecting on ways do reduce coupling on ZF2 applications.

I started writing a Payment module for Compufácil, some of the
struggling I found are the reason for this post.

# Strategies of Decoupling

## Communicating only through interfaces

At first I like this idea and I tried to implement this.

### Strengths - Adheres to the interface segregation principle - Allows
full decoupling

### Weakness - Is too hard to write too much interfac                  es

## Using Event Manager

### Strengths

### Weaknesses - Performance problems - Zend event manager is ugly

## Using Services Aliases

### Strengths

### Weaknesses - Performance problems - Zend event manager is ugly

# References http://akrabat.com/an-introduction-to-zendeventmanager/

