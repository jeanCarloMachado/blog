---
layout: post
title: curl, Bash and Firefox mutualism
---

As my career directs me to an API First way of working I start to
looking for ways to improve my development processes related to HTTP
requests.

One really nice work flow for debugging services is through
CURL+Bash+Firefox 'mutualism'. I'll describe the precess I usually take
below.

## The Request

When I need to test a request there's two common cases. First, I never
used the request before so I have to write one from stratch with CURL.
When the service is already being used I can simply [get a copy of the
CURL request made by the browser](http://i.imgur.com/hb1d23Z.png).

Any way, I usually end up with a request like this.

```
curl -X POST -H "Authorization: token" \
-H "Content-Type: application/x-www-form-urlencoded" \
http://clipp.dev/report/v1/finance.get_revenue.html  -d "filters[]"
```

## Automating the parts

The next step I take is to update dynamic parts of the request through scripts.

```
curl -X POST -H "Authorization: $(clipp-get-token)" \
-H "Content-Type: application/x-www-form-urlencoded" \
http://clipp.dev/report/v1/finance.get_revenue.html  -d "filters[]"
```
In this case I created a Bash script called *clipp-get-token*, it's
purpose is to return me a properly formatted and valid authentication
token so I don't have to bother with token timeouts.

The relevant part of the script is as it follows.
```
result=`curl -X POST -H "Content-Type: application/x-www-form-urlencoded" \
-d "login=$user&password=$passwd" http://clipp.dev/rpc/v1/application.authenticate.json`
result=`echo $result | cut -d':' -f3 | cut -d'"' -f2`
echo "$result"
```

## The Result

The final step of the "mutualism" is, when appropriate, to redirect
back to Firefox the request result so the browser is able to render it
properly. There are many hard ways of doing that, like saving the CURL
output on a file and opening it with Firefox. Hopefully I found out a
way to send the CURL output to Firefox as a stream of text instead of a
file.

To achieve that, you must use firefox as it follows:
```
echo "stream" | firefox-developer "data:text/html;base64,$(base64 -w 0 <&0)"

```

*Note:* It only works with pipe, I'm yet to find a way to achieve the
same with a redirection ``<<``.

This is specially useful when the server returns HTML because inspecting
it on the terminal it's not so good. But works as well with XML, even
JSON is returned in a nice visual way.
To illustrate a complete example of the flow is the request below.

```
curl -X POST -H "Authorization: $(clipp-get-token)" \
-H "Content-Type: application/x-www-form-urlencoded" \
http://clipp.dev/report/v1/finance.get_revenue.html  -d "filters[]" | sfox
```

Sfox for *stream firefox* is simply a alias for the string previously
showed, this way is clear and concise.

```
alias sfox='firefox-developer "data:text/html;base64,$(base64 -w 0 <&0)"'
```


## Conclusion

I like CURL on the terminal mainly because it's more reliable for
testing than on the application itself. The application is more propense
to frontend bugs.

Another good point of CURL is that it's pure plain text so making
scripts on Bash to it is extremly easy.

Going further on my mutualism analogy, I could make an script to remove
Firefox "crap headers" from the request. Another good point of research
is to use the output as a parameter on an URL to be consumed and viewed
through Firefox.

Is up to the developer creativity to use old tools with new purposes and
achieve new heights.


Critics, advices and comments are appreciated.
