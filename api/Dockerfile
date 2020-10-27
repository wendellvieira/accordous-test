FROM bitnami/laravel:8-debian-10

WORKDIR /app

RUN sudo apt-get update

RUN sudo apt-get install -y libreoffice

COPY . .

CMD ["php", "artisan", "queue:work"]
