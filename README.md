# MerchFlow (EPA E‑Commerce Platform)

## Project description

MerchFlow is a multi‑store e‑commerce platform built for a UK Level 4 Software Development Apprenticeship **End‑Point Assessment (EPA)**. It includes:

- **Customer storefront** (Nuxt): browse products, basket, checkout with Stripe, orders, and addresses.
- **Merchant area** (Nuxt): manage stores, catalogue, and orders for owned stores.
- **REST API** (Yii2): JSON API under `/api/v1` for auth, catalogue, customer, and merchant flows.
- **Superadmin** (Yii2 + Bootstrap): separate web app for platform administration (runs in its own Docker service).

The **frontend** is [Nuxt 4](https://nuxt.com/) with [Nuxt UI](https://ui.nuxt.com/) and Tailwind CSS. The **backend** is [Yii 2](https://www.yiiframework.com/) with MySQL, RBAC, and [Stripe](https://stripe.com/) for payments.

Further EPA write‑up and evidence notes live under [`epa-report/`](epa-report/).

---

## Deployed frontend

**Production / staging URL:** _Add your deployed Nuxt site URL here (for example `https://app.example.com`)._

This repository does not pin a single canonical public URL. After you deploy the Nuxt build, update this section so reviewers and teammates know where to click.

| App          | Typical local URL                          |
| ------------ | ------------------------------------------ |
| Storefront   | `http://localhost:3000` (Nuxt dev server)  |
| REST API     | `http://localhost:21080/api/v1`            |
| Superadmin   | `http://localhost:20080`                   |

---

## Quick start (first time, local)

From the repository root:

```bash
# 1. Yii local environment (creates yii, *-local.php, web entry scripts)
cd backend
php init --env=Local --overwrite=All

# 2. Point the API at Docker MySQL (see “Database configuration” below)
#    Edit backend/common/config/main-local.php — use host=mysql for Compose.

# 3. Start stack, install PHP deps, migrate, seed demo data
docker compose up -d
docker compose exec api bash -lc "composer install"
docker compose exec api bash -lc "php yii migrate --interactive=0"
docker compose exec api bash -lc "php yii seed/all"

# 4. Frontend
cd ../frontend
npm install
# Create frontend/.env — see “Frontend (Nuxt)” below
npm run dev
```

During **migrate**, a one‑off superadmin user may be created; the console prints its email and password (save them for [Superadmin](#superadmin-local)).

---

## Demo / test accounts

### Local (after `php yii seed/all`)

Seeders create users with password **`Password123!`**. Each run prefixes emails with `seed_YYYYMMDD_HHMMSS_` (for example `seed_20260519_143022_amina.diallo+seed1@example.com`).

| Role     | Base email (prefix added at seed time)     | Password        |
| -------- | ------------------------------------------ | --------------- |
| Customer | `amina.diallo+seed1@example.com`           | `Password123!`  |
| Merchant | `mateo.rossi+seed2@example.com`            | `Password123!`  |

List the full emails in your database:

```bash
cd backend
docker compose exec mysql mysql -uecom_platform -psecret ecom_platform_db \
  -e "SELECT id, role, email FROM user ORDER BY id"
```

Use the **customer** account for the storefront and checkout; use the **merchant** account for store and product management (`/merchant`).

Treat seeded passwords as **non‑secret** if this repository is public. Do not reuse them elsewhere.

### Deployed / shared QA

If you maintain separate demo logins on staging or production (not created by this repo’s seeders), document them in your deployment notes or update this section when you set a canonical public URL.

---

## Superadmin (local)

- **URL:** `http://localhost:20080`
- **Account:** Created by migration `m260416_000003_seed_random_superadmin_user` when no superadmin exists yet. **Email and password are printed in the terminal** when you run `php yii migrate` — copy them from that output.
- Superadmin users **cannot** sign in to the Nuxt storefront (API returns forbidden for that role).

To open a shell in the superadmin container:

```bash
cd backend
docker compose exec superadmin bash
```

---

## Local development

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or compatible Docker engine + Compose)
- [Node.js](https://nodejs.org/) **20+** recommended (Nuxt 4)
- `git`

Optional: local PHP **7.4+** if you prefer running `php init` on the host instead of inside a container.

### 1. Backend (API, superadmin, MySQL)

#### Yii `init` (required on a fresh clone)

`backend/yii`, `*-local.php` configs, and some `web/index.php` files are **not** committed. Initialise the **Local** environment once:

```bash
cd backend
php init --env=Local --overwrite=All
```

(Use `--overwrite=n` if you need to preserve existing local files.) You can also run `php init` inside the API container after `docker compose up -d`.

#### Docker Compose

```bash
cd backend
docker compose up -d
```

Services and ports (see `backend/docker-compose.yml`):

| Service      | Host port | Purpose                                        |
| ------------ | --------- | ---------------------------------------------- |
| `api`        | **21080** | REST API (`http://localhost:21080/api/v1`)       |
| `superadmin` | **20080** | Superadmin Yii app                             |
| `mysql`      | **3307**  | MySQL (mapped from container `3306`)           |

Install PHP dependencies and run migrations **inside the API container** (app code is mounted from `./backend`):

```bash
docker compose exec api bash -lc "composer install"
docker compose exec api bash -lc "php yii migrate --interactive=0"
```

#### Seed demo data

Populate users, addresses, stores, products, baskets, and sample orders:

```bash
docker compose exec api bash -lc "php yii seed/all"
```

Other seed commands (see `backend/console/controllers/SeedController.php`):

| Command | Purpose |
| ------- | ------- |
| `php yii seed/user-addresses` | Users, addresses, linkups |
| `php yii seed/catalog` | Stores, categories, products |
| `php yii seed/baskets` | Baskets and line items |
| `php yii seed/orders` | Orders and line items |
| `php yii seed/clear-all 1` | Truncate seeded domain tables (destructive) |

#### Database configuration (`main-local.php`)

`backend/common/config/main-local.php` is **not** committed (see `backend/common/config/.gitignore`). After `php init`, edit it so the API and console can reach MySQL.

For the **Docker Compose** stack, use the `mysql` service hostname and credentials from `docker-compose.yml`:

```php
<?php
return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=mysql;dbname=ecom_platform_db',
            'username' => 'ecom_platform',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
    ],
];
```

If you run Yii or MySQL **only on the host** (not in Docker), use `127.0.0.1`, port **3307** in the DSN if you map MySQL as in the compose file, and align user/password with your local MySQL.

#### Stripe (optional for local card flows)

Create `backend/api/config/params-local.php` (also gitignored) with test keys from the [Stripe Dashboard](https://dashboard.stripe.com/):

```php
<?php
return [
    'stripe.secretKey' => 'sk_test_…',
    'stripe.webhookSecret' => 'whsec_…', // optional locally if you rely on sync endpoints instead
];
```

### 2. Frontend (Nuxt)

```bash
cd frontend
npm install
```

Create `frontend/.env` (or export env vars) so the app can reach the API and Stripe:

```bash
# Base URL for the JSON API (no trailing slash). Must include /api/v1.
NUXT_PUBLIC_API_BASE_URL=http://localhost:21080/api/v1

# Stripe publishable key (pk_test_… / pk_live_…)
NUXT_PUBLIC_STRIPE_PUBLISHABLE_KEY=pk_test_…
```

Start the dev server:

```bash
npm run dev
```

The dev server URL is printed by Nuxt (commonly `http://localhost:3000`). The frontend defaults to `http://localhost:21080/api/v1` if `NUXT_PUBLIC_API_BASE_URL` is unset.

Production‑like build and preview:

```bash
npm run build
npm run preview
```

### 3. Tests and formatting

**Frontend unit tests** (Vitest), from `frontend`:

```bash
npm test
# or: npm run test:watch
```

**Backend tests** (Codeception), from `backend` with Composer dev dependencies installed:

```bash
docker compose exec api bash -lc "./vendor/bin/codeception run"
```

Suites are configured per app under `api/`, `common/`, and `superadmin/` (`codeception.yml` in each).

**Format frontend** (requires Prettier available via `npx`, for example a global install):

```bash
cd frontend
npx prettier . --write
```

---

## Repository layout (high level)

| Path                         | Description                                      |
| ---------------------------- | ------------------------------------------------ |
| `frontend/`                  | Nuxt storefront + merchant UI                    |
| `backend/api/`               | Public REST API application                      |
| `backend/common/`            | Shared models, mail, config                      |
| `backend/console/`           | Migrations, `yii` console, seed commands           |
| `backend/superadmin/`        | Admin Yii application                            |
| `backend/docker-compose.yml` | Local MySQL + API + superadmin images            |
| `epa-report/`                | EPA evidence and report notes                    |

---

## Licence

Backend PHP follows the Yii framework **BSD‑3‑Clause** licence (see `backend/LICENSE.md`). Check `frontend/package.json` and lockfile for frontend dependency licences.
