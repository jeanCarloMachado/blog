BLOG_HOST=$(shell blog-docker-host)
export BLOG_HOST

all: docker

docker:
	sudo systemctl start docker
	docker-compose stop
	docker-compose up -d
	blog-database-copy
	blog-database-reset
	cd frontend && gulp

dist:


