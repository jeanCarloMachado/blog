all: watch

build: clear
	cp -rf ${POSTS_DIR} _posts || true
	bundle exec jekyll build
	cp /home/jean/projects/resume/resume.pdf /home/jean/projects/blog/dist/

watch:
	browser http://localhost:4000
	bundle exec jekyll serve

clear:
	rm -rf dist || true
	rm -rf _posts || true
deploy:  build
	cd /home/jean/projects/blog
	rsync -a dist/ root@$(BLOG_IP):/var/www/html
