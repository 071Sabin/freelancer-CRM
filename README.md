# Freelancer CRM — Laravel + Livewire

A lightweight Customer & Project Relationship Management (CRM) application built with Laravel, Livewire and Tailwind/Vite. This repository provides a small production-ready starter for managing clients, projects and freelancers via Livewire components and a minimal authentication flow.

Key highlights
- Built on Laravel (framework) with PHP 8.2 compatibility
- Reactive UI using Livewire 3 and Volt
- Server-side features: Clients, Projects, Freelancer listing, Authentication
- Simple migrations, Eloquent models, and Livewire components for fast iteration

Contents
- **Overview & Features** — What this app does and who it's for
- **Tech stack** — Libraries and versions used in the project
- **Install & Run** — Step-by-step developer setup for Windows/macOS/Linux
- **Database** — Migrations and important tables (clients, projects, freelancers)
- **Development** — Running the app, building assets, and available npm/composer scripts
- **Testing & CI** — How to run automated tests
- **Contributing** — How to help or extend the project
- **License & Authors**

---

**Project Overview**

Freelancer CRM is a focused example application intended for small teams and freelancers to track clients and projects. It demonstrates a practical Livewire-driven UI with server-side logic for CRUD-like workflows.

Primary features
- Client management with address, billing details and soft-deletes
- Project creation and association to clients (value, description, status)
- Freelancer directory (simple listing and sorting)
- Basic authentication and protected dashboard routes

**Tech stack**
- PHP 8.2+
- Laravel ^12.0 (framework)
- Livewire ^3.6 (component-driven interactivity)
- Tailwind CSS + Vite for frontend tooling
- MySQL / PostgreSQL / SQLite (any supported by Laravel)

Key dependencies (see composer.json and package.json)
- Backend: [composer.json](composer.json) — Laravel, Livewire, Sanctum, Livewire Tables
- Frontend: [package.json](package.json) — Vite, Tailwind, Bootstrap, Axios

**Code map (important files)**
- Routes: [routes/web.php](routes/web.php)
- Livewire components: [app/Livewire](app/Livewire) (e.g. `Projects`, `FreelancerDetails`, `Login`, `Register`)
- Models: [app/Models](app/Models) (`Client`, `Project`, `Freelancers`)
- Migrations: [database/migrations](database/migrations) (clients, projects)
- Views: [resources/views](resources/views) (Blade layouts and Livewire templates)

---

Getting started (developer setup)

Prerequisites
- PHP 8.2 or newer
- Composer
- Node.js (16+) and npm
- A database (MySQL, PostgreSQL, or SQLite)

Quick install

1. Clone the repository

```bash
git clone <repo-url> freelancer-crm
cd freelancer-crm
```

2. Install PHP dependencies

```bash
composer install
```

3. Copy the example env and set keys

```bash
cp .env.example .env
php artisan key:generate
# Edit .env to configure DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

4. Create the database and run migrations

For SQLite (quick local dev):

```bash
touch database/database.sqlite
php artisan migrate
```

For MySQL/Postgres: ensure the database exists then:

```bash
php artisan migrate
```

5. Install frontend dependencies and build

```bash
npm install
# Development build (hot reload)
npm run dev
# Or production build
npm run build
```

6. Run the app

For local development the project provides a `dev` script to run Vite, queue and server concurrently. Alternatively run the server alone:

```bash
php artisan serve
# then open http://127.0.0.1:8000
```

Or use the Composer `dev` task (requires `npx` and concurrently):

```bash
composer run dev
```

Routes of interest
- Public: `/` (welcome), `/login`, `/register`, `/freelancers`
- Protected (requires auth): `/dashboard`, `/clients`, `/projects`, `/settings`

**Database notes**
- `clients` migration defines: `client_name`, `company_name`, `company_email`, `billing_address`, `hourly_rate`, `currency`, `status`, `private_notes`.
- `projects` migration defines: `name`, `description`, `value`, `client_id`, `status` and uses soft deletes.
- See migrations: [database/migrations/2025_11_18_141546_clients.php](database/migrations/2025_11_18_141546_clients.php) and [database/migrations/2025_11_25_164539_create_projects_table.php](database/migrations/2025_11_25_164539_create_projects_table.php)

**Authentication**
- The project includes a minimal login flow using a `Freelancers` authenticatable model and route-based Livewire components in [app/Livewire/Login.php](app/Livewire/Login.php). Adjust guards/providers in [config/auth.php] if you integrate additional user types.

**Testing**
- Run the Laravel test suite with:

```bash
php artisan test
```

Composer & npm tasks
- `composer setup` — bootstrap full install + migrate + build (use with care)
- `composer dev` — runs the local development stack (concurrently)
- `npm run dev` — starts Vite dev server
- `npm run build` — builds frontend assets for production

**Deployment notes**
- Standard Laravel deployment practices apply. Ensure:
	- `APP_ENV=production` and `APP_DEBUG=false`
	- Run `php artisan migrate --force` on the production server
	- Build assets: `npm run build`
	- Configure a worker for queues (or use supervisor)

If you prefer containers, a simple Dockerfile + docker-compose can be added to run PHP-FPM, a web server, Node build step and a DB service.

**Contribution & Development**
- Bug reports and PRs are welcome. Follow these guidelines:
	1. Open an issue describing the change or bug
	2. Branch from `main` with a descriptive name
	3. Add tests where relevant and keep changes focused
	4. Run `composer test` and `npm run build` before submitting a PR

**License**
- This project is released under the MIT License — see `composer.json`.

**Authors & Acknowledgements**
- Original codebase and scaffolding: Laravel + Livewire community
- This repository was developed as a compact Freelancer/Client CRM example. For questions or contributions, open an issue.

