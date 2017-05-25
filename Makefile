all: build serve

build: clear
	jekyll build
	cp /home/jean/projects/resume/resume.pdf /home/jean/projects/blog/_build/
serve:
	jekyll serve
clear:
	rm -rf _build
deploy: build
	cd /home/jean/projects/blog
	rm about.md || true
	cp -rf  ${ABOUT_FILE} about.md
	rm -rf _posts || true
	cp -rf  ${POSTS_DIR} _posts
	rsync -a _build/ root@$(BLOG_IP):/var/www/html
