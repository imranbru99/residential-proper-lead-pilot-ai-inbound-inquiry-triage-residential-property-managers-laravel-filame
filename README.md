# ResidentialProperLeadPilot — AI Inbound Inquiry Triage CRM for Residential Property Managers

**ResidentialProperLeadPilot** is a Laravel + Filament SaaS that classifies website, phone, and email inquiries into qualified CRM opportunities for residential property managers — then operates on properties, residents, maintenance requests, and vendor work orders with AI assist, human approval, fair-housing guardrails, and a full audit trail.

## SEO / Niche Keywords

residential property managers, property management CRM, inbound inquiry triage, leasing lead automation, resident maintenance requests, vendor work orders, multifamily leasing AI, SFR portfolio management, fair housing compliance software, AppFolio alternative triage, Buildium lead intake, AI lead scoring property management, Laravel Filament SaaS, modular business automation, TCPA consent follow-ups, property management sales operations, AI classification leasing tours, emergency maintenance triage, owner management inquiries, rental application pipeline

### Related keyword tags
`residential-property-managers` `real-estate-property` `inbound-inquiry-triage` `sales-operations` `ai-lead-classification` `crm-opportunities` `maintenance-requests` `vendor-work-orders` `fair-housing` `tenant-privacy` `appfolio` `buildium` `laravel` `filament` `docker` `mysql` `redis` `modular-saas` `multi-role-users` `audit-log` `ai-automation`

## Problem solved

For residential property managers: classify website, phone and email inquiries and create qualified CRM opportunities; operate on properties, residents, maintenance requests and vendor work orders.

**MVP:** 1 intake trigger → AI draft/action → human approval → audit log

## Features & modules

### Core (ON by default)
- Inbound Inquiry Triage (website / phone / email / SMS / referral)
- AI Classification (leasing tours, applications, availability, rent pricing, maintenance emergency/general, owner management, vendor bids, renewals)
- Human Approval Workflow
- CRM Opportunities
- Properties
- Residents & Prospects
- Maintenance Requests
- Vendors
- Vendor Work Orders
- Audit Log
- Messaging Consent
- Fair Housing Guardrails
- Follow-Up Drafts
- Universal Slug Engine
- AI Hub Provider Switch
- Drutogoti Speed Layer
- Admin Panel Extras

### Optional (OFF by default)
- Resident Portal
- Attendance Hub
- Unicode PDF Exports
- AI Catalog / Listing Enrichment
- AppFolio Integration
- Buildium Integration
- QuickBooks / Accounting Integration
- Email Inbox Integration
- Multi-Property Portfolio routing

Modules are toggleable in Filament **Module Settings** (config + DB flags). Packagist packages `imrandevbd/*` were unavailable publicly; local equivalents live under `app/Services`.

## Multi-type demo users

Password for all: **`password`**

| Role | Email |
|------|-------|
| Admin | admin@residentialproperleadpilot.test |
| Owner | owner@residentialproperleadpilot.test |
| Staff | staff@residentialproperleadpilot.test |
| Vendor | vendor@residentialproperleadpilot.test |
| Resident | resident@residentialproperleadpilot.test |

## Public pages

- `/` — Home / brand hero
- `/features` — Full feature catalog
- `/modules` — Every module ON/OFF
- `/workflow` — MVP workflow
- `/pricing` — Pilot pricing
- `/demo` — Live AI intake form
- `/contact` — Hire / contact
- `/admin` — Filament admin panel

## Docker run

Ports (Rank 23): **app 8123**, **MySQL 33093**, **Redis 63813**

```bash
docker compose up -d --build
```

Then open http://localhost:8123

Entrypoint runs `migrate` + `db:seed` automatically against MySQL (not SQLite).

### Stack
- PHP 8.4 + Laravel 13 + Filament 4
- MySQL 8.4
- Redis 7
- Docker Compose (`ext-intl` installed for Filament)

## Screenshots

See `docs/screenshots/` for home, features, modules, admin login, admin dashboard, and inquiries triage captures.

## Tech notes
- Author: Imran Ahmed `<me@imrandev.bd>`
- Build prompt archive: `docs/BUILD_PROMPT.md`
- Risk: MED/HIGH — housing, fair-housing and tenant privacy

## Contact / Hire
- Developer: Imran Ahmed (IMRAN Dev BD)
- Website: https://imrandev.bd/contact
- Email: me@imrandev.bd
- GitHub: https://github.com/imranbru99
