FROM node:14.15.4-alpine3.12

RUN apk add bash

RUN npm install react-scripts@3.0.1 -g --silent

USER node

WORKDIR /home/node/app

ADD . .



