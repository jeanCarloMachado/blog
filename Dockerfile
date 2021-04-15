FROM jekyll/jekyll:latest
RUN gem install addressable -v 2.5.0 ; \
      gem install sass -v 3.4.23 ; \
      gem install rb-fsevent -v 0.9.8 ; \
      gem install ffi -v 1.9.17 ; \
      gem install rb-inotify -v 0.9.7 ; \
      gem install kramdown -v 1.13.2 ; \
      gem install jekyll -v 3.3.1 ; \
      gem install jekyll-sitemap -v 1.0.0 ; \
      gem install libv8 -v 3.16.14.17
RUN gem install ref -v 2.0.0 ; \
      gem install therubyracer -v 0.12.3

COPY . /jeanblog
WORKDIR /jeanblog
RUN bundle install
ENTRYPOINT bundle exec jekyll serve
