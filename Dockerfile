FROM php:7-fpm

ENV LANG       en_US.UTF-8
ENV LC_ALL     en_US.UTF-8

RUN apt-get update && rm -rf /var/lib/apt/lists/*
