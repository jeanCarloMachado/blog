DIST_REPO=${HOME}/projects/jeancarlomachado.github.io
BLOG_REPO=${HOME}/projects/blog

all: watch

build:
	docker run -it -p 4000 --net=host -v $(pwd):/jeanblog blog

deploy:  build
	rm -rf $(DIST_REPO)/blog || true
	rm -rf $(DIST_REPO)/index.html || true
	cp -rf $(BLOG_REPO)/dist/* $(DIST_REPO)
	cd $(DIST_REPO) ; git add .
	cd $(DIST_REPO) ; git commit -m 'automatic commit' || true
	cd $(DIST_REPO) ; git push origin master


docker:
	docker build . -t blog


watch:
	browser http://localhost:4000
	bundle exec jekyll serve


