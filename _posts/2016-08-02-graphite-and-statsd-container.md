---
title: Simple graphite with Statsd container
layout: post
---

Some time ago, I wrote [this](https://hub.docker.com/r/jeancarlomachado/graphite_statsd/) container to be able to use graphite with statsd.

It follows [this](https://duckduckgo.com/l/?kh=-1&uddg=https%3A%2F%2Fwww.digitalocean.com%2Fcommunity%2Ftutorials%2Finstalling-and-configuring-graphite-and-statsd-on-an-ubuntu-12-04-vps) tutorial of installation provided by digital ocean
so you don't have to worry to much it's simply working.


To start it one can use the following:

```
imageid=$(docker images \ 
| grep graphite_statsd \ 
| cut -d " " -f18)
docker run
-p 6667:8125/udp -p 4040:80 \ 
-v /home/ubuntu/agregation-data:/var/lib/graphite \
$imageid "
service postgresql start   \
& service apache2 start \
    & service carbon-cache start \
    & sleep 10 & \
    /usr/bin/nodejs \ 
    /usr/share/statsd/stats.js \
    /etc/statsd/localConfig.js"
```

And to agregate data the following

```
echo  "gandalf:222|3" | nc -u -w0 127.0.0.1 6667
```

That's it, maybe on the future I'll write about some settings one
may do on statsd to get better precision on graphite.
