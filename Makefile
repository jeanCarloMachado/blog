all: build serve

build:
	jekyll build
serve:
	jekyll serve
clear:
	jekyll clean

deploy:
	rsync -a _build/ root@$(BLOG_IP):/var/www/html
