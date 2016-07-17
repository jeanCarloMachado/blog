all: build serve

build:
	jekyll build

serve:
	jekyll serve
clear:
	jekyll clean

deploy:
	rsync -a build/ root@$(BLOG_IP):/var/www/html
