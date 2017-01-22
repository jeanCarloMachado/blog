all: build serve

build: clear
	jekyll build
	docker run -v $(pwd):/srv/jekyll -it "jekyll/jekyll" "jekyll build"
	cp /home/jean/projects/writing/resume.pdf /home/jean/projects/blog/_build/
serve:
	jekyll serve
clear:
	rm -rf _build
deploy: build
	cd /home/jean/projects/blog
	rsync -a _build/ root@$(BLOG_IP):/var/www/html
