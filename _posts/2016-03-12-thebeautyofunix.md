---
layout: post
title: The beauty of Unix
---

The Unix Way is powerful. After some time adhering to its philosophy you
may be surprised by how much it can do for you. Things you build
or use can be assembled in new intricate ways in which the authors
never expected.

Last week I was in need to convert a curl data from the browser to a PHP
array, so I could use it to debug Compufácil at phpunit. But the thing
is, the request has a lot of data, so doing it by hand would be a pain in
the ass.

Look at the size of such a request, equivalent to that one I needed:

```
myRequest="curl
'http://app.compufacil.dev/rpc/v1/inventory.post-purchase.json'
-H 'Host: homolog.compufacil.com.br' -H 'User-Agent: Mozilla/5.0
(X11; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0' -H
'Accept: application/json, text/plain, */*' -H 'Accept-Language:
pt_BR' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type:
application/x-www-form-urlencoded' -H 'Authorization-Compufacil:
apiCode' -H 'Referer:
http://homolog.compufacil.com.br/app/' -H 'Cookie:
_ga=GA1.3.427769913.1455651539; _gat=1; language=pt_BR;
sessionId=eb8d7e2d5bd7450ce585e1509cc64e1c6140b999;subscription_status=2
00; isAdmin=true' --data
'shippingInfo%5Baddress%5D=&shippingInfo%5Bphone%5D=&shippingInfo%5Bemai
l%5D%5Baddress%5D=gandalf%40a.com&shippingInfo%5Bemail%5D%5Btype%5D=2&sh
ippingInfo%5Bemail%5D%5Bid%5D=282&shippingInfo%5BcontactPerson%5D=&produ
ctOfTradeCollection%5B0%5D%5Bprice%5D=110.01&productOfTradeCollection%5B
0%5D%5Bquantity%5D=1&productOfTradeCollection%5B0%5D%5Bproduct%5D%5Bid%5
D=2444&eletronicInvoiceSerie=1&discount=0&freightPrice=0&extraValue=0&ca
tegory%5Bid%5D=1184&paymentMode%5Bid%5D=1445&paymentMode%5Brange%5D%5B0%
5D%5Bvalue%5D=27.51&paymentMode%5Brange%5D%5B0%5D%5Bdate%5D=2016-03-12&
paymentMode%5Brange%5D%5B1%5D%5Bvalue%5D=27.5&paymentMode%5Brange%5D%5B1
%5D%5Bdate%5D=2016-04-12&paymentMode%5Brange%5D%5B2%5D%5Bvalue%5D=27.5&p
aymentMode%5Brange%5D%5B2%5D%5Bdate%5D=2016-05-12&paymentMode%5Brange%5D
%5B3%5D%5Bvalue%5D=27.5&paymentMode%5Brange%5D%5B3%5D%5Bdate%5D=2016-06-
12&account%5Bid%5D=621&buyer%5Bid%5D=1046&eletronicInvoiceModel=32&eletr
onicInvoiceNumber=1231&flowGroup%5Bid%5D=57&observation=My%20staff&disco
untIsPercentage=false'"array 
```

As you probably noticed, i saved it's value in an varible ($myRequest)
so i don't have to repeat myself with it along the post. Any way, I'll
show you here, step by step how I turned it into a PHP array.

First I needed only the data, so I have to extract if from the rest:

```
echo $myRequest | rev | cut -d" " -f1 | rev
shippingInfo%5Baddress%5D=&shippingInfo%5Bphone%5D=&shippingInfo%5Bemail
%5D%5Baddress%5D=gandalf%40a.com&shippingInfo%5Bemail%5D%5Btype%5D=2&shi
ppingInfo%5Bemail%5D%5Bid%5D=282&shippingInfo%5BcontactPerson%5D=&produc
tOfTradeCollection%5B0%5D%5Bprice%5D=110.01&productOfTradeCollection%5B0
%5D%5Bquantity%5D=1&productOfTradeCollection%5B0%5D%5Bproduct%5D%5Bid%5D
=2444&eletronicInvoiceSerie=1&discount=0&freightPrice=0&extraValue=0&cat
egory%5Bid%5D=1184&paymentMode%5Bid%5D=1445&paymentMode%5Brange%5D%5B0%5
D%5Bvalue%5D=27.51&paymentMode%5Brange%5D%5B0%5D%5Bdate%5D=2016-03-12&pa
ymentMode%5Brange%5D%5B1%5D%5Bvalue%5D=27.5&paymentMode%5Brange%5D%5B1%5
D%5Bdate%5D=2016-04-12&paymentMode%5Brange%5D%5B2%5D%5Bvalue%5D=27.5&pay
mentMode%5Brange%5D%5B2%5D%5Bdate%5D=2016-05-12&paymentMode%5Brange%5D%5
B3%5D%5Bvalue%5D=27.5&paymentMode%5Brange%5D%5B3%5D%5Bdate%5D=2016-06-12
&account%5Bid%5D=621&buyer%5Bid%5D=1046&eletronicInvoiceModel=32&eletron
icInvoiceNumber=1231&flowGroup%5Bid%5D=57&observation=My%20staff&discoun
tIsPercentage=false
```

Reverting the string and splitting it by the space getting the first occurrence, after that reverting back did the trick for me.

Now with the content in hand the next challenge is to decode it to get the natural form of the data.


I know that PHP has a funciton to do that, so I wrote a small PHP script to do that for me.


```
# !/usr/bin/env php
# file url-decode
<?php

$data = $argv[1] ?? null;
if (empty($data)) {
    $data = fgets(STDIN);
}

$data = rawurldecode($data);
echo $data;

```

This small script simply get the data from an argument or from stdin and decode it.


So this is our point now:

```
echo $myRequest | rev | cut -d" " -f1 | rev | url-decode
shippingInfo[address]=&shippingInfo[phone]=&shippingInfo[email][address]
=gandalf@a.com&shippingInfo[email][type]=2&shippingInfo[email][id]=282&s
hippingInfo[contactPerson]=&productOfTradeCollection[0][price]=110.01&pr
oductOfTradeCollection[0][quantity]=1&productOfTradeCollection[0][produc
t][id]=2444&eletronicInvoiceSerie=1&discount=0&freightPrice=0&extraValue
=0&category[id]=1184&paymentMode[id]=1445&paymentMode[range][0][value]=2
7.51&paymentMode[range][0][date]=2016-03-12&paymentMode[range][1][value]
=27.5&paymentMode[range][1][date]=2016-04-12&paymentMode[range][2][value
]=27.5&paymentMode[range][2][date]=2016-05-12&paymentMode[range][3][valu
e]=27.5&paymentMode[range][3][date]=2016-06-12&account[id]=621&buyer[id]
=1046&eletronicInvoiceModel=32&eletronicInvoiceNumber=1231&flowGroup[id]
=57&observation=My staff&discountIsPercentage=false
```

From here I had to convert this data in an PHP array. But it happend
that I already did something similar before. Once I wrote a script to
convert JSON's to PHP arrays, so I thought I might use it, but for doing
so I would need this data as JSON.

Luckly, it happens that I already wrote another tool to convert form-data to
JSON as well.

So here is the script to convert form-data to JSON:

```
# !/usr/bin/env php
# file url-to-json
<?php

$result = [];


$data = $argv[1] ?? null;
if (empty($data)) {
    $data = fgets(STDIN);
}

parse_str($data, $result);
echo json_encode($result, true);

```

And after its usage the data is the following:


```
$echo $myRequest | rev | cut -d" " -f1 | rev | url-decode | url-to-json
{"shippingInfo":{"address":"","phone":"","email":{"address":"gandalf@a.
com","type":"2","id":"282"},"contactPerson":""},"productOfTradeCollecti
on":[{"price":"110.01","quantity":"1","product":{"id":"2444"}}],"eletro
nicInvoiceSerie":"1","discount":"0","freightPrice":"0","extraValue":"0"
,"category":{"id":"1184"},"paymentMode":{"id":"1445","range":[{"value":
"27.51","date":"2016-03-12"},{"value":"27.5","date":"2016-04-12"},{"val
ue":"27.5","date":"2016-05-12"},{"value":"27.5","date":"2016-06-12"}]},
"account":{"id":"621"},"buyer":{"id":"1046"},"eletronicInvoiceModel":"3
2","eletronicInvoiceNumber":"1231","flowGroup":{"id":"57"},"observation
":"My staff","discountIsPercentage":"false\n"}%
```

And finally the script to convert JSON to a PHP array:


```

# !/usr/bin/env php
# file export-php-from-json
<?php

$data = $argv[1] ?? null;
if (empty($data)) {
    $data = fgets(STDIN);
}

if (empty($data)) {
    echo "You must pass a valid JSON";
    exit(1);
}

$data = json_decode($data, true);

echo var_export($data);

```

Using it all together:

```
echo $myRequest | rev | cut -d" " -f1 | rev | url-decode | url-to-json | export-php-from-json 
array (
  'shippingInfo' => 
  array (
    'address' => '',
    'phone' => '',
    'email' => 
    array (
      'address' => 'gandalf@a.com',
      'type' => '2',
      'id' => '282',
    ),
    'contactPerson' => '',
  ),
  'productOfTradeCollection' => 
  array (
    0 => 
    array (
      'price' => '110.01',
      'quantity' => '1',
      'product' => 
      array (
        'id' => '2444',
      ),
    ),
  ),
  'eletronicInvoiceSerie' => '1',
  'discount' => '0',
  'freightPrice' => '0',
  'extraValue' => '0',
  'category' => 
  array (
    'id' => '1184',
  ),
  'paymentMode' => 
  array (
    'id' => '1445',
    'range' => 
    array (
      0 => 
      array (
        'value' => '27.51',
        'date' => '2016-03-12',
      ),
      1 => 
      array (
        'value' => '27.5',
        'date' => '2016-04-12',
      ),
      2 => 
      array (
        'value' => '27.5',
        'date' => '2016-05-12',
      ),
      3 => 
      array (
        'value' => '27.5',
        'date' => '2016-06-12',
      ),
    ),
  ),
  'account' => 
  array (
    'id' => '621',
  ),
  'buyer' => 
  array (
    'id' => '1046',
  ),
  'eletronicInvoiceModel' => '32',
  'eletronicInvoiceNumber' => '1231',
  'flowGroup' => 
  array (
    'id' => '57',
  ),
  'observation' => 'My staff',
  'discountIsPercentage' => 'false
',
)%
```

To get even easier whe might write an alias for it:

```
alias curl-to-array=' rev | cut -d" " -f1 | rev | url-decode |
url-to-json | export-php-from-json'
```

Now you only need ``echo $myRequest | curl-to-array`` to turn any
curl request in a PHP array format.


So this is it. I wrote a generic tool to convert requests exported by
the browser into PHP format by writing a simple script, some shell
commands and two other simple scripts I wrote in another time for other
purposes. And this is the beuty I mean, as the time goes on you find new
purposes to old simple tools adehring to the Unix principles of wrinting
little programs where which one do only one thing well, assembling them
in new ways.
