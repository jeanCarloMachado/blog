all: build serve

build: clear
	jekyll build
serve:
	jekyll serve
clear:
	rm -rf _build
deploy: build
	rsync -a _build/ root@$(BLOG_IP):/var/www/html
