# Blog

My personal blog

The running site can be found on > http://jeancarlomachado.net


## To develop

```
make docker
docker run -it 
docker run -it -p 4000 --net=host -v $(pwd):/jeanblog blog

```

## To distribute

Copy contents from dist/ to the repo: jeancarlomachado.github.io
Commit and push
