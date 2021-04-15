---
layout: post
title: A container for Statsd with Mongo Backend
---

At Compufácil we are starting using docker on development
environments, so this week I had to find or
create a container that uses Mongo for our Statsd stack.

After some time looking for a Statsd+Mongo I realised
that there was none, so I started building one by my own.

I must say that configuring nodejs is not a so simplistic task on
docker's Ubuntu. But after some time, and a last delay due to udp
port and docker (that I didn't know I had to set) all was done.

And it's working amazingly. You can checkout the [source code](https://github.com/jeanCarloMachado/statsdmongo)
and [the docker hub repository](https://hub.docker.com/r/jeancarlomachado/statsdmongo/). If you liked it let me know :).

An last note: it's incredible how much disk docker uses when
you need to build the image on your machine. I need to research
lighter alternatives to this process, by know I'll keep cleaning my
disk from time to time.
