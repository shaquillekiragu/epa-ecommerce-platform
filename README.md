# MerchFlow (EPA E‑Commerce Platform)

## Project description

MerchFlow is a multi‑store e‑commerce platform built for a UK Level 4 Software Development Apprenticeship **End‑Point Assessment (EPA)**. It includes:

- **Customer storefront** (Nuxt): browse products, basket, checkout with Stripe, orders, and addresses.
- **Merchant area** (Nuxt): manage stores, catalogue, and orders for owned stores.
- **REST API** (Yii2): JSON API under `/api/v1` for auth, catalogue, customer, and merchant flows.
- **Superadmin** (Yii2 + Bootstrap): separate web app for platform administration (runs in its own Docker service).

The **frontend** is [Nuxt 4](https://nuxt.com/) with [Nuxt UI](https://ui.nuxt.com/) and Tailwind CSS. The **backend** is [Yii 2](https://www.yiiframework.com/) with MySQL, RBAC, and [Stripe](https://stripe.com/) for payments.

---

## Demo / test accounts

These credentials are for **shared demo or QA** environments. Do not reuse these passwords elsewhere, and treat them as **non‑secret** if this repository is public.

| Role       | Email           | Password     |
| ---------- | --------------- | ------------ |
| Customer   | `dam@gmail.com` | `A1b2c3d4e5!` |
| Merchant   | `uk13@gmail.com` | `A1b2c3d4e5!` |

Use the customer account to exercise the storefront and checkout; use the merchant account for store and product management.

---

## Deployed frontend

**Production / staging URL:** _Add your deployed Nuxt site URL here (for example `https://app.example.com`)._

This repository does not pin a single canonical public URL. After you deploy the Nuxt build, update this section so reviewers and teammates know where to click.

---

## Local development

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or compatible Docker engine + Compose)
- [Node.js](https://nodejs.org/) **20+** recommended (Nuxt 4)
- `git`

Optional: local PHP if you prefer running `php init` on the host instead of inside a container.

### 1. Backend (API, superadmin, MySQL)

From the repository root:

```bash
cd backend
docker compose up -d
```

Services and ports (see `backend/docker-compose.yml`):

| Service    | Host port | Purpose                                      |
| ---------- | --------- | -------------------------------------------- |
| `api`      | **21080** | REST API (`http://localhost:21080/api/v1`) |
| `superadmin` | **20080** | Superadmin Yii app                          |
| `mysql`    | **3307**  | MySQL (mapped from container `3306`)       |

Install PHP dependencies and run migrations **inside the API container** (the app code is mounted from `./backend`):

```bash
docker compose exec api bash -lc "composer install"
docker compose exec api bash -lc "php yii migrate --interactive=0"
```

**First‑time Yii `init`:** if `backend/yii` or entry scripts under `api/web` / `superadmin/web` are missing, initialise the **Local** environment from the `backend` directory (on the host with PHP, or via `docker compose exec api bash`):

```bash
cd backend
php init --env=Local --overwrite=All
```

(Adjust `--overwrite` if you need to preserve existing local files.)

#### Database configuration (`main-local.php`)

`backend/common/config/main-local.php` is **not** committed (see `backend/common/config/.gitignore`). Create it so the API and console can reach MySQL.

For the **Docker Compose** stack, the API container should use the `mysql` service hostname and the credentials from `docker-compose.yml`:

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

### 3. Useful commands

- **Backend tests** (from `backend`, with dependencies installed): Codeception suites under `api`, `common`, and `superadmin` — see each area’s `codeception.yml` and `tests/` folders.
- **Format frontend** (Prettier), from `frontend`:

  ```bash
  npx prettier . --write
  ```

---

## Repository layout (high level)

| Path            | Description                                      |
| --------------- | ------------------------------------------------ |
| `frontend/`     | Nuxt storefront + merchant UI                    |
| `backend/api/`  | Public REST API application                      |
| `backend/common/` | Shared models, mail, config                    |
| `backend/console/` | Migrations, `yii` console, seed commands        |
| `backend/superadmin/` | Admin Yii application                      |
| `backend/docker-compose.yml` | Local MySQL + API + superadmin images |

---

## Licence

Backend PHP follows the Yii framework **BSD‑3‑Clause** licence (see `backend/LICENSE.md`). Check `frontend/package.json` and lockfile for frontend dependency licences.
