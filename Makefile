DIST_REPO=${HOME}/projects/jeancarlomachado.github.io
BLOG_REPO=${HOME}/projects/blog

all: watch

build: clear
	# cp -rf ${POSTS_DIR} $(BLOG_REPO)/_posts || true
	cd  $(BLOG_REPO) && bundle exec jekyll build

deploy:  build
	rm -rf $(DIST_REPO)/blog || true
	rm -rf $(DIST_REPO)/index.html || true
	cp -rf $(BLOG_REPO)/dist/* $(DIST_REPO)
	cd $(DIST_REPO) ; git add .
	cd $(DIST_REPO) ; git commit -m 'automatic commit' || true
	cd $(DIST_REPO) ; git push origin master


clear:
	rm -rf dist || true
watch:
	browser http://localhost:4000
	bundle exec jekyll serve

install:
	bundle install

