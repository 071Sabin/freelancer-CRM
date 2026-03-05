# ClientPivot CRM

ClientPivot is a Laravel 12 + Livewire 3 CRM tailored for freelancers and small service teams to manage clients, projects, invoices, and client communication from one workspace.

It includes end-to-end flows for:
- client lifecycle management
- project tracking
- invoice creation and PDF export
- secure client portal sharing
- WhatsApp-based project updates
- per-user invoice settings and branding

## Core Features

### Authentication and Workspace Access
- Custom Livewire login and registration screens.
- Auth-protected workspace routes (`/dashboard`, `/clients`, `/projects`, `/invoices`, `/settings`).
- Session logout with token regeneration.

### Dashboard
- Live KPIs for:
  - total clients
  - in-progress projects
  - active projects
  - latest projects snapshot

### Client Management
- Full CRUD with soft deletes.
- Structured client profile fields:
  - contact + company metadata
  - billing address
  - default hourly rate
  - default currency
  - status (`active`, `inactive`, `lead`)
  - private notes
- Server-side data table with:
  - search
  - status filters
  - deleted-only filter
  - bulk delete actions

### Project Management
- Full CRUD with soft deletes.
- Project model includes:
  - UUID-based external reference
  - value and hourly rate
  - currency linkage
  - deadline + status
  - client and owner relationships
- Data table includes:
  - searchable/sortable project and client columns
  - status filtering
  - bulk delete actions
- Auto-sync from selected client:
  - currency
  - hourly rate
- WhatsApp integration:
  - sends project portal link on create/update
  - supports resend from table actions
  - graceful simulation mode if keys are not configured

### Invoicing
- Invoice lifecycle with status model:
  - `draft`, `sent`, `partially_paid`, `paid`, `overdue`, `void`, `canceled`
- Concurrency-safe invoice numbering:
  - per-user settings row lock (`lockForUpdate`)
  - unique per-user invoice number constraint
- Invoice editing supports:
  - dynamic line items
  - tax, discount, and late fee calculations
  - due-date auto-compute from default settings
  - total/balance computation
- Invoice listing table includes:
  - payment progress UI
  - overdue highlighting
  - status filtering (with overdue logic)
  - bulk delete actions
- PDF export via DomPDF from both form flow and table actions.

### Invoice Settings Suite
- General settings:
  - invoice prefix + next number
  - default currency
  - locale/timezone
  - company profile and address fields
- Payment settings:
  - default tax rate
  - default discount rate
  - default due days
  - partial payment toggle
  - late fee type/rate/amount
- Branding settings:
  - upload and replace invoice logo

### Integrations (BYOK)
- Per-user encrypted keys in `integrations` table.
- AI provider selection:
  - OpenAI
  - Gemini
- WhatsApp Cloud API credentials:
  - access token
  - phone number ID
  - business account ID
- Sensitive fields are encrypted at model-cast level.

### Secure Client Portal
- Public, UUID-based project portal route: `/p/{uuid}`.
- Displays:
  - project summary
  - client details
  - billing/invoice summary
- Used directly in WhatsApp project update messages.

## Architecture Overview

### Stack
- PHP `^8.2`
- Laravel `^12.0`
- Livewire `^3.6`
- Livewire Flux + Volt
- Rappasoft Livewire Tables
- Tailwind CSS + Vite
- MySQL (default) via Laravel DB layer
- DomPDF (`barryvdh/laravel-dompdf`)

### Domain Modules
- `Clients`
- `Projects`
- `Invoices`
- `Invoice Settings`
- `Integrations`
- `Client Portal`

### Data Model Highlights
- Ownership scoped by `user_id` across business entities.
- Soft deletes on core CRM entities (`clients`, `projects`, `invoices`).
- Invoice subsystem includes dedicated tables for:
  - items
  - taxes
  - payments
  - attachments
  - custom fields
  - activity logs
  - status histories
- Currency master table with seeded global currency list.

## Security and Access Control
- Policy classes enforce record ownership checks for:
  - clients
  - projects
  - invoices
  - integrations
- Integration secrets are encrypted at rest using Eloquent encrypted casts.
- External project sharing uses UUID-based links (not incremental IDs).

## Local Development Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL (or other supported Laravel DB)

### Quick Start
1. Install dependencies:
   ```bash
   composer install
   npm install
   ```
2. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Configure DB in `.env`, then run:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
4. Start development services:
   ```bash
   composer run dev
   ```

`composer run dev` runs:
- Laravel server
- queue listener
- Vite dev server

### One-Command Bootstrap
```bash
composer run setup
```
This installs PHP/Node dependencies, generates key, migrates, and builds assets.

## Docker Setup

Project includes `Dockerfile` and `compose.yaml` (Laravel Sail-style services).

Important behavior:
- container startup script runs:
  - `php artisan migrate:fresh --force`
  - `php artisan db:seed --force`
- this **resets database data on startup**.

Use this flow only when data reset is acceptable (e.g., local/dev sandbox).

## Seed Data

`DatabaseSeeder` seeds:
- one user
- sample clients
- sample projects
- currency master records

Default seeded user:
- Email: `sabin@gmail.com`
- Password: `sabin123`

## Available Routes

### Public
- `/` (welcome)
- `/about`
- `/pricing`
- `/login`
- `/register`
- `/p/{uuid}` (client portal)

### Authenticated
- `/dashboard`
- `/clients`
- `/projects`
- `/invoices`
- `/invoices/settings`
- `/invoices/settings/payments`
- `/invoices/settings/branding`
- `/settings`

### API
- `/api/user` (Sanctum-protected)

## Testing

Run full test suite:
```bash
php artisan test
```

Current repository includes Laravel auth/profile feature tests plus baseline examples.

## Useful Commands

```bash
# format code
./vendor/bin/pint

# run tests
php artisan test

# production asset build
npm run build
```

## Project Structure

- `app/Livewire` - feature components and forms
- `app/Models` - domain models and relationships
- `app/Policies` - authorization policies
- `app/Services/WhatsAppService.php` - outbound WhatsApp message service
- `database/migrations` - schema design
- `database/seeders` - sample and master data
- `resources/views/livewire` - feature UI templates
- `resources/views/invoices/pdf.blade.php` - PDF invoice template
- `routes/web.php` - web route map

## Scope Notes

Implemented in UI/business flow:
- clients
- projects
- invoices
- settings
- integrations
- portal sharing

Data-model-ready (schema exists, UI/automation can be extended further):
- invoice payments ledger
- invoice attachments
- invoice custom fields
- invoice activity and status audit trails
