DIST_REPO=${HOME}/projects/jeancarlomachado.github.io
BLOG_REPO=${HOME}/projects/blog

all: watch

docker:
	docker build . -t blog

build_and_watch:
	docker run -it -p 4000 --net=host -v $(BLOG_REPO):/jeanblog blog

deploy:
	cp -rf $(BLOG_REPO)/dist/* $(DIST_REPO)
	cd $(DIST_REPO) ; git add .
	cd $(DIST_REPO) ; git commit -m 'automatic commit' || true
	cd $(DIST_REPO) ; git push origin master



watch:
	browser http://localhost:4000
	bundle exec jekyll serve


