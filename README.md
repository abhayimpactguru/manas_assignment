# ImpactGuru Mini CRM

A Customer Relationship Management system built with Laravel.

## Features

- Customer Management (CRUD, search, profile images)
- Order Management (CRUD, status tracking, filters)
- User Management (Admin/Staff roles)
- Dashboard with statistics
- REST API with Sanctum authentication
- Export to CSV/PDF

## Requirements

- PHP >= 8.1
- Laravel 12.x
- Node.js >= 16.x

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Visit: http://localhost:8000

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@impactguru.com | password |
| Staff | staff@impactguru.com | password |

## Role Permissions

| Action | Admin | Staff |
|--------|-------|-------|
| View/Add/Edit Customers | Yes | Yes |
| Delete Customers | Yes | No |
| View/Add/Edit Orders | Yes | Yes |
| Delete Orders | Yes | No |
| Manage Users | Yes | No |
| Export Data | Yes | Yes |

## API Endpoints

```
POST   /api/login              - Get token
POST   /api/logout             - Revoke token
GET    /api/user               - Get authenticated user
GET    /api/customers          - List customers
POST   /api/customers          - Create customer
GET    /api/customers/{id}     - Get customer
PUT    /api/customers/{id}     - Update customer (Admin)
DELETE /api/customers/{id}     - Delete customer (Admin)
```

## Tech Stack

- Laravel + Blade + Tailwind CSS
- Laravel Breeze (Auth)
- Laravel Sanctum (API)
- DomPDF + Maatwebsite Excel (Exports)
