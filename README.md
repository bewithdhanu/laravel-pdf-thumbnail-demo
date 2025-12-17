## Laravel (no database) via Docker Compose

This repo boots a **fresh Laravel app** inside `./src` using Docker Compose and **does not include any database containers**.

### Prerequisites
- Docker Desktop (or Docker Engine) with Compose v2

### Start

```bash
docker compose up --build
```

- The first run will create a Laravel project in `./src` (via `composer create-project`).
- The bootstrap flow intentionally avoids creating any database files / running migrations.
- App will be available at `http://localhost:8000`.

### Demo route (PDF → thumbnail)

- Visit `http://localhost:8000/pdf-thumbnail`
- Upload a PDF, and it will render and display a generated thumbnail using the package from [`shishima123/laravel-thumbnail`](https://github.com/shishima123/laravel-thumbnail).

### Stop

```bash
docker compose down
```

### Notes
- No database services are defined in `docker-compose.yml`.
- If you want to keep the generated Laravel app in git, commit the contents of `./src` after the first run.


