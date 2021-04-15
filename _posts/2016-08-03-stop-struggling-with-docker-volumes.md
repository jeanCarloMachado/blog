---
layout: post
title: Stop struggling with docker volumes
---

For a time I used to suffer when setting up a volume on the host
in which a client should be able to "own" it.
But giving some more experience the pattern of solution became
clear. Probably there's other ways of doing the same but this is
the way I'm used to right now.

In this example I'm going to show to mount the database folder of a
graphite service in the host to be able to reuse it on reboots.

## Detect the uid and gid of the folder on the container

```
docker exec -it 710ec sh -c "ls -l -n /var/lib/graphite"
-rw-r--r-- 1 105 106    0 May 19 00:47 search_index
drwxr-xr-x 4 105 106 4096 May 22 22:26 whisper
```

So the uid is 105 and the gid is 106.

## Create a user and a group with the ids

If your system already have those uids and gids you can skip this
step. But in most cases probability points for you to having to
create those.

```
echo "graphitedata:x:106:" >> /etc/group
newusers <<< "graphitedata:foobar:105:106:graphitedata::/bin/bash"
```

## Give the permission in the host for the user and group


```
chown -R graphitedata:graphitedata /path/to/the/host/database
```

## Point to the volume in the startup

```
docker run ... -v /path/to/the/host/database:/var/lib/graphite $imageid "..."
```

That's it, it's simple and solve the majority of my problems. If
it is useful for you too let me know :).
