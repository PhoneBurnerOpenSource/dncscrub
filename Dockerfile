# syntax=docker/dockerfile:1.4
FROM php:8.2-cli as php

WORKDIR /app

ENV PATH /app/bin:/app/vendor/bin::/home/dev/.composer/vendor/bin/:$PATH

RUN groupadd --gid 1000 dev && useradd --system --create-home --uid 1000 --gid 1000 --shell /bin/bash dev

RUN apt-get update && apt-get install -y \
    apt-transport-https \
    autoconf  \
    build-essential \
    curl \
    git \
    libzip-dev \
    unzip \
    zip \
    zlib1g-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

USER dev
