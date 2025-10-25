# Waitly Email System

Multi-tenant SaaS email template system with intelligent localization fallback.

**Repository**: [github.com/taxidriver2192/waitly-email-system](https://github.com/taxidriver2192/waitly-email-system)  
**For**: Morten & the Waitly team  
**Purpose**: Case submission showing backend structure and fallback logic

---

## Quick Start

**Prerequisites:**
- Docker & Docker Compose installed
- Git installed

**Setup:**
```bash
# 1. Clone the repository
git clone git@github.com:taxidriver2192/waitly-email-system.git
cd waitly-email-system

# 2. Install dependencies
composer install

# 3. Start Docker containers
./vendor/bin/sail up -d

# 4. Generate application key
./vendor/bin/sail artisan key:generate

# 5. Run migrations and seeders
./vendor/bin/sail artisan migrate --seed

# 6. Install and build frontend assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

**Access the application:**
- **Users**: http://localhost:8080/users
- **Email Testing**: http://localhost:8080/email-test

### If Laravel Sail is not installed

If you don't have Laravel Sail installed, you can install it globally:
```bash
composer global require laravel/sail
```

## How It Works

### The Fallback Logic (4 Tiers)
The system prioritizes like this:

1. **Company + Requested Language** ← Best match
2. **Company + English** ← Company custom, language fallback
3. **Platform + Requested Language** ← System default, language preserved
4. **Platform + English** ← Final safety net (never fails)

### Database Structure
```
companies
├── email_templates
│   └── email_template_translations (language variants)
└── users
```

Platform defaults use `company_id = NULL` to keep things clean and separate.

---

## Testing It

### Web Interface
- Company & language dropdowns
- Live preview showing which tier you hit

### CLI (See All 4 Tiers)
```bash
./vendor/bin/sail artisan email:test acme welcome_user en      # Tier 1
./vendor/bin/sail artisan email:test acme welcome_user es      # Tier 2
./vendor/bin/sail artisan email:test techstart welcome_user es # Tier 3
./vendor/bin/sail artisan email:test acme password_reset fr   # Tier 4
```

---

## Design Choices

- **Single database** – Simpler for a 2-3 hour scope; multi-tenant complexity via `company_id`
- **Normalized schema** – Separates templates from translations so languages scale independently
- **NULL for platform defaults** – Clear semantic meaning: no company = system default
- **4-tier fallback** – Covers all real scenarios; users never get broken emails

---

## Demo Included
- 3 companies with different customization levels
- 4 languages (Danish, English, Spanish, French)
- 2 template types (Welcome, Password Reset)
- Pre-seeded scenarios that hit all 4 fallback tiers

---

## Tech Stack
- Laravel 12
- MySQL 8.0
- Laravel Sail (Docker)
- Tailwind CSS
- Pure Laravel (no extra packages)

---

## Key Files to Review
- `app/Services/EmailTemplateService.php` – The fallback logic
- `database/migrations/` – Schema decisions
- `database/seeders/` – Demo data and scenarios
- `routes/web.php` – Entry points
