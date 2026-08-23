# syntax=docker/dockerfile:1

FROM node:24.19.0-alpine AS base

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

FROM base AS dev

COPY . .

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]

FROM base AS build

ARG VITE_MAXMETRICS_API_URL
ENV VITE_MAXMETRICS_API_URL=$VITE_MAXMETRICS_API_URL

COPY . .
RUN npm run build

FROM caddy:2.11.4-alpine AS prod

COPY docker/Caddyfile /etc/caddy/Caddyfile
COPY --from=build /app/dist /srv
