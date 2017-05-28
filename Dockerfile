FROM php:7.1.0-apache

MAINTAINER Steven Taylor <taylorsj1980@gmail.com>

#   Add environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

#   Update terminal prompt
RUN echo "\n# Update terminal colours - added by docker" >> ~/.bashrc
RUN echo "export PS1='\[\033[36m\]\u\[\033[m\]@\[\033[32m\]container:json-formatter \[\033[33;1m\][\w]\[\033[m\] $ '" >> ~/.bashrc

#   Add aliases
RUN echo "\n# Update aliases - added by docker" >> ~/.bashrc
RUN echo "alias ll='ls -la'" >> ~/.bashrc

#   Expose ports
EXPOSE 80
