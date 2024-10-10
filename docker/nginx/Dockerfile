FROM nginx:1.24

RUN sed -i "s/user  nginx;/user  root;/g" /etc/nginx/nginx.conf
RUN echo "upstream php-upstream { server app-sochi:9000; }" > /etc/nginx/conf.d/upstream.conf
RUN apt update && apt install iputils-ping nano -y
