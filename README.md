# Waitly Email System

Multi-tenant SaaS email template system with intelligent localization fallback.

## Quick Setup

```bash
# 1. Install dependencies
composer install

# 2. Start Docker containers
./vendor/bin/sail up -d

# 3. Generate app key
./vendor/bin/sail artisan key:generate

# 4. Run migrations and seeders
./vendor/bin/sail artisan migrate --seed

# 5. Install frontend dependencies
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

## Testing the System

### Web Interface
- **Users**: http://localhost:8080/users
- **Email Testing**: http://localhost:8080/email-test
  - Interactive form with company/language selection
  - Actually sends emails (same as CLI)
  - Shows email preview and fallback level

### CLI Testing (All 4 Fallback Levels)
```bash
./vendor/bin/sail artisan email:test acme welcome_user en      # Level 1: Company custom
./vendor/bin/sail artisan email:test acme welcome_user es      # Level 2: Company fallback  
./vendor/bin/sail artisan email:test techstart welcome_user es # Level 3: Platform default
./vendor/bin/sail artisan email:test acme password_reset fr   # Level 4: Final fallback
# Automatically selects a random user from the specified company
```

### View Email Logs
```bash
./vendor/bin/sail logs
# Both CLI and web form log identical information
```

## Architecture Decisions

### Why This Structure?
- **Single database**: Simpler than multi-database for 2-3 hour scope
- **Normalized schema**: Separate translations table for scalability
- **company_id = NULL**: Clean way to identify platform defaults
- **4-tier fallback**: Ensures emails always work, prevents broken user experience

### Database Design
```
companies → email_templates → email_template_translations
    ↓              ↓                    ↓
  users    email_template_types    languages
```

### Fallback Logic
1. **Company + Requested Language** - Best case scenario
2. **Company + English** - Company fallback when localization missing
3. **Platform + Requested Language** - System default with localization
4. **Platform + English** - Guaranteed fallback (never fails)

## Demo Data Included
- **3 Companies**: Acme (has custom welcome), Global Industries, TechStart
- **4 Languages**: Danish, English, Spanish, French
- **2 Template Types**: Welcome User, Password Reset
- **Realistic scenarios**: Tests all 4 fallback levels

## Tech Stack
- **Laravel 12** - Latest stable framework
- **MySQL 8.0** - Production-ready database
- **Laravel Sail** - Docker development environment
- **Tailwind CSS** - Modern responsive UI
- **Pure Laravel** - No third-party packages, demonstrates framework mastery
