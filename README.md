# MaxMetrics

MaxMetrics is a multi-page health and fitness dashboard with a React frontend and a Symfony GraphQL API.

## Docker architecture

The Compose stack contains five focused services:

- `gateway`: the only public service; Caddy terminates HTTPS and routes the `www` and `api` hostnames.
- `frontend`: Vite with hot reload in development and an immutable static Caddy image in production.
- `backend`: FrankenPHP serving Symfony over the private application network.
- `migrate`: a one-shot Symfony container that applies Doctrine migrations before the backend starts.
- `database`: PostgreSQL with data stored in the `database_data` named volume.

Only ports 80 and 443 on the gateway are published. PostgreSQL, the frontend, and the backend are not directly reachable from the host.

## Local development

Copy the environment template and choose local-only secrets:

```shell
cp .env.example .env
```

Resolve both development hostnames to the Docker host. On Linux and macOS, add this line to `/etc/hosts`:

```text
127.0.0.1 www.maxmetrics.local api.maxmetrics.local
```

Build and start the stack:

```shell
docker compose up --build --wait
```

The application is available at `https://www.maxmetrics.local`, and GraphQL is available at `https://api.maxmetrics.local/graphql`.

### Trust the local HTTPS certificate

Caddy stores its local root certificate in the `caddy_data` volume. Copy it from the gateway and install it in the operating system or browser trust store:

```shell
docker compose cp gateway:/data/caddy/pki/authorities/local/root.crt ./maxmetrics-local-root.crt
```

The trust-store installation step is operating-system specific. Remove the copied certificate after importing it. Never install this development CA on a production machine.

Useful commands:

```shell
docker compose ps
docker compose logs -f gateway frontend backend migrate database
docker compose down
```

`docker compose down` preserves PostgreSQL and Caddy volumes. Use `docker compose down --volumes` only when intentionally deleting local database data and certificates.

### Run commands inside the frontend or backend

Prefer `docker compose exec` over `docker exec` because Compose resolves the generated container name for you. The service must already be running.

Open an interactive shell in the development frontend:

```shell
docker compose exec frontend sh
```

Run a single frontend command without opening a shell:

```shell
docker compose exec frontend npm run lint
docker compose exec frontend npm run build
```

Open an interactive shell in the backend:

```shell
docker compose exec backend bash
```

Run Symfony or Composer commands directly:

```shell
docker compose exec backend php bin/console
docker compose exec backend php bin/console doctrine:migrations:status
docker compose exec backend composer validate
```

The equivalent raw Docker command uses the generated container name, which is `maxmetrics-frontend-1` or `maxmetrics-backend-1` with the default project name:

```shell
docker exec -it maxmetrics-frontend-1 sh
docker exec -it maxmetrics-backend-1 bash
```

For production, include the same Compose files and environment file used to start the stack. The production frontend contains Caddy and the compiled static files, but it does not contain Node or npm:

```shell
docker compose --env-file .env.prod.local -f compose.yaml -f compose.prod.yaml exec frontend sh
docker compose --env-file .env.prod.local -f compose.yaml -f compose.prod.yaml exec backend sh
```

## Production deployment

Production expects a single Docker Compose host, public DNS records for both hostnames, and inbound TCP ports 80/443 plus UDP port 443. Copy the production template to an untracked file and replace every placeholder:

```shell
cp .env.prod.example .env.prod.local
```

Validate, build, and start the production stack without loading the development override:

```shell
docker compose --env-file .env.prod.local -f compose.yaml -f compose.prod.yaml config
docker compose --env-file .env.prod.local -f compose.yaml -f compose.prod.yaml build
docker compose --env-file .env.prod.local -f compose.yaml -f compose.prod.yaml up -d --wait
```

Caddy obtains and renews public certificates automatically. The migration service must exit successfully before the backend and gateway start. Inspect a failed migration with:

```shell
docker compose --env-file .env.prod.local -f compose.yaml -f compose.prod.yaml logs migrate
```

Back up the PostgreSQL data in `database_data` before deployments that include schema migrations. Application secrets and database passwords belong only in `.env.prod.local` or an equivalent deployment secret store; never commit them.

## Validation outside Docker

Run commands from the relevant application directory:

```shell
cd frontend
npm run lint
npm run build
```

```shell
cd backend
vendor/bin/phpcs
```
