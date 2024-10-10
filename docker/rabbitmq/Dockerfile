FROM rabbitmq:3.6-management

#
## Fix bug common packages
###
RUN sed -i -e s/deb.debian.org/archive.debian.org/g /etc/apt/sources.list &&  \
    sed -i -e s/security.debian.org/archive.debian.org/g /etc/apt/sources.list &&  \
    sed -i -e '/stretch-updates/d' /etc/apt/sources.list

RUN apt-get update \
	&& apt-get install -y wget

ENV RABBITMQ_HOME /usr/lib/rabbitmq/lib/rabbitmq_server-3.6.*

RUN rabbitmq-plugins enable rabbitmq_management

#RUN cd $RABBITMQ_HOME/plugins \
#    && wget http://www.rabbitmq.com/community-plugins/v3.6.x/rabbitmq_delayed_message_exchange-0.0.1.ez \
#	&& rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange

RUN rm -rf /var/cache/apt/archives/*
