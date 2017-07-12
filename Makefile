all: build

build: clear
	cp -rf /home/jean/Dropbox/posts _posts || true
	docker run -v /home/jean/projects/blog:/mounted --entrypoint=/bin/sh blog_builder:latest -c "cd /mounted ; jekyll build"
	cp /home/jean/projects/resume/resume.pdf /home/jean/projects/blog/_build/
clear:
	rm -rf _build || true
	rm -rf _posts || true
deploy:  build
	cd /home/jean/projects/blog
	rsync -a _build/ root@$(BLOG_IP):/var/www/html
