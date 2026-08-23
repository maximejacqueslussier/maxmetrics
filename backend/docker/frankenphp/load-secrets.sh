#!/bin/sh

if [ -n "${APP_SECRET_FILE:-}" ]; then
	export APP_SECRET="$(cat "$APP_SECRET_FILE")"
fi

if [ -n "${JWT_SECRET_FILE:-}" ]; then
	export JWT_SECRET="$(cat "$JWT_SECRET_FILE")"
fi

if [ -n "${POSTGRES_PASSWORD_FILE:-}" ]; then
	export POSTGRES_PASSWORD="$(cat "$POSTGRES_PASSWORD_FILE")"
fi
