---
layout: post
title: Full crud with pyresttest
---


On Compufácil we use pyresttest as part of our testing environment.
In our context its used to validate the integration of the API and to
help with some clues of performance through benchmarking.

I already wrote about pyresttest
[here](http://jeancarlomachado.com.br/#!/post/41), but I touched the
tests API superficially so now I intend to show how to test a full crud
with it.

```
- config:
    - testset: "Finance"
    - generators:
        - 'ACCESSTOKEN': {type: 'env_variable', variable_name: ACCESSTOKEN}
- test:
    - auth_username: "$BASIC_AUTH_USERNAME"
    - auth_password: "$BASIC_AUTH_PASSWORD"
    - group: "Category"
    - name: "Post Category"
    - url: "/rpc/v1/finance.post-category.json"
    - method: "POST"
    - expected_status: [200]
    - body: {template: "name=category&type=1&active=false"}
    - headers: {template: {"Authorization-Compufacil": "$ACCESSTOKEN"}}
    - validators:
        - compare: {jsonpath_mini: "status",     comparator: "eq",     expected: 1}
    - extract_binds:
            - 'CURRENTID': {'jsonpath_mini': 'id'}
```

This is a simple creation, the important part here is that we are
capturing the id through the extract_binds method so we can work
with this entity further.

```
- test:
    - auth_username: "$BASIC_AUTH_USERNAME"
    - auth_password: "$BASIC_AUTH_PASSWORD"
    - group: "Category"
    - name: "Get Category by ID"
    - url: "/rpc/v1/finance.get-category.json"
    - method: "POST"
    - expected_status: [200]
    - body: {template: "id=$CURRENTID"}
    - headers: {template: {"Authorization-Compufacil": "$ACCESSTOKEN"}}
    - validators:
        - extract_test: {jsonpath_mini: "0.name",  test: "exists"}
        - extract_test: {jsonpath_mini: "1.name",  test: "not_exists"}
```

Now we are getting the result from the GET API using the post
resulted id.

```
- test:
    - auth_username: "$BASIC_AUTH_USERNAME"
    - auth_password: "$BASIC_AUTH_PASSWORD"
    - group: "Category"
    - name: "Put Category"
    - url: "/rpc/v1/finance.put-category.json"
    - method: "POST"
    - expected_status: [200]
    - body: {template: "id=$CURRENTID&name=CategoryTestUpdated&active=true&type=1"}
    - headers: {template: {"Authorization-Compufacil": "$ACCESSTOKEN"}}
    - validators:
        - compare: {jsonpath_mini: "status",     comparator: "eq",     expected: 1}
```

The same rule applies here but for an update.

```
- test:
    - auth_username: "$BASIC_AUTH_USERNAME"
    - auth_password: "$BASIC_AUTH_PASSWORD"
    - group: "Category"
    - name: "Delete Category"
    - url: "/rpc/v1/finance.delete-category.json"
    - method: "POST"
    - expected_status: [200]
    - headers: {template: {"Authorization-Compufacil": "$ACCESSTOKEN"}}
    - body: {template: "ids[0]=$CURRENTID"}
    - validators:
        - compare: {jsonpath_mini: "status",     comparator: "eq",     expected: 1}
```


To finalize, simply deleting the entity.


That's it, if you know some additional trick about pyresttest let
me know.
