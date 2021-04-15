---
layout: post
title: Remove Firefox useless curl headers with this
---

I wrote
[this](https://github.com/jeanCarloMachado/personalScripts/blob/master/c
url-remove-headers) small program, as part of my self-teaching
experience with perl, to solve one tricky problem I used to face.
When using Firefox I'm able to dump the requests that are made to
Compufácil, but Firefox inserts lots of useless headers that only serve
to turn the request impossible to read.

This program gets this request full of crappy headers and leaves only
the ones I didn't blacklisted.


Let's go to an example:

(This is the common request Firefox dumps me)

``` curl-remove-headers "curl
'http://clipp.dev/RPC/v1/application.get-latest_messages-user.json'
-H 'Host: clipp.dev' -H 'User-Agent: Mozilla/5.0 (X11; Linux
x86_64; rv:40.0) Gecko/20100101 Firefox/40.0' -H 'Accept:
application/json, text/plain, */*' -H 'Accept-Language:
pt_BR' --compressed -H 'IGNORE_LOADING: true' -H
'Authorization-Compufacil: 8fa10a93dd4e91dbc4b00c477da85b44a9a1cbb7'
-H 'Referer: http://clipp.dev/app/' -H 'Cookie:
_ga=GA1.2.1889325007.1434573991; hblid=wQXcje4Y6M40D0I32M21A6GSESGBd102;
olfsk=olfsk5011984582094807; wcsid=Kf5TvYDyGiwd8AbC2M21A4GQESGB00eE;
_oklv=1441281680828%2CKf5TvYDyGiwd8AbC2M21A4GQESGB00eE;
_okdetect=%7B%22token%22%3A%2214412816212760%22%2C%22proto%22%3A%22http%
3A%22%2C%22host%22%3A%22clipp.dev%22%7D;
_okbk=cd4%3Dtrue%2Cvi5%3D0%2Cvi4%3D1441281622752%2Cvi3%3Dactive%2Cvi2%3D
false%2Cvi1%3Dfalse%2Ccd8%3Dchat%2Ccd6%3D0%2Ccd5%3Daway%2Ccd3%3Dfalse%2C
cd2%3D0%2Ccd1%3D0%2C; _ok=5027-100-10-2842; language=pt_BR;
sessionId=8fa10a93dd4e91dbc4b00c477da85b44a9a1cbb7; isAdmin=true' -H
'Connection: keep-alive' -H 'Pragma: no-cache' -H 'Cache-Control:
no-cache' -H 'Content-Length: 0'"

```

And the output

``` curl
'http://clipp.dev/RPC/v1/application.get-latest_messages-user.json'
--compressed -H 'Authorization-Compufacil:
8fa10a93dd4e91dbc4b00c477da85b44a9a1cbb7' ```

For more of how to use Firefox and curl see [this
post](http://jeancarlomachado.com.br/#!/post/99) post.


That's it and DFTBA.
