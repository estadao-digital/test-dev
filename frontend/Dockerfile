FROM node:14.13.1 AS compile-image

ENV APP_ROOT /src

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
ADD . ${APP_ROOT}

RUN npm install
RUN npm run build

FROM nginx:1.19-alpine
COPY nginx.conf /etc/nginx/nginx.conf
COPY --from=compile-image /src/dist/ /usr/share/nginx/html
