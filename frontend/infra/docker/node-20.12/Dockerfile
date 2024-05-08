FROM node:20.12.2-bookworm-slim

RUN apt-get update \
    && apt-get -y install sudo \
    && apt-get clean

RUN echo root:node | chpasswd \
    && echo node:node | chpasswd \
    && usermod -a -G sudo node