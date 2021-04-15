---
layout: post
title: Distorting reality with docker
keywords: Docker, Buildkite
---

For checking that the submitted code passes the tests we use
Buildkite on Compufácil.

The nice thing about Buildkite is the flexibility to run it
everywery in any hardware. But the fact of having to configure it
on each machine is a drahback on it's stack.

Running docker inside docker
----------------------------


To run docker inside docker in a professional way, one can share
the host socket with the client like this:

```
-v /var/run/docker.sock:/var/run/docker.sock \

```

Sharing ssh sockets
-------------------


```
eval $(ssh-agent)
ssh-add $RSA_FILE

--volume $SSH_AUTH_SOCK:/ssh-agent \
--env SSH_AUTH_SOCK=/ssh-agent \

```
