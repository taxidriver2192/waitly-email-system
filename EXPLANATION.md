# Design Decisions & Assumptions

## Database Architecture
- **Single database approach**: Simpler than multi-database for 2-3 hour scope, scales to 100+ tenants
- **Normalized schema (3NF)**: Separate translations table for scalability and maintainability
- **company_id = NULL**: Indicates platform default templates, clean separation of concerns

## Fallback Logic
- **4-tier cascading system**: Ensures emails always have content, prevents broken user experience
- **English as universal fallback**: Industry standard, guarantees system functionality

## Technology Choices
- **Laravel 12**: Latest stable framework, zero breaking changes from Laravel 11
- **MySQL 8.0**: Production-ready relational database with proper indexing
- **Laravel Sail**: Docker environment ensures consistent development experience
- **No third-party packages**: Pure Laravel demonstrates framework mastery

## Assumptions
- **English is always the fallback language**: Industry standard for SaaS platforms
- **Platform defaults must exist in English**: Enforced by seeders, prevents system failures
- **Variables use {{ variable_name }} syntax**: Standard templating approach
- **Email content stored in database**: Enables runtime customization without code changes

## Scalability Considerations
- **Eager loading**: Prevents N+1 queries, optimized for performance
- **Proper indexing**: Foreign keys and lookup columns indexed for speed
- **Service layer pattern**: Clean separation allows easy testing and maintenance
