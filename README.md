# Grocery Stock Management

A Laravel-based grocery stock management system for tracking products, categories, stock movement, sales, and daily reporting.

## Features

- Authentication and verified-user access for the main application area
- Dashboard overview for quick operational visibility
- Category management
- Product management
- Stock in and stock out actions for inventory updates
- Sales creation, listing, and sale details
- Daily reports for operational review
- User profile management

## Tech Stack

- Laravel 12
- PHP 8.2+
- Vite
- Tailwind CSS
- Bootstrap 5
- Alpine.js

## Project Structure

```text
app/
	Http/Controllers/   Application controllers
	Models/             Eloquent models for categories, products, sales, and stock
	Providers/          App service providers
bootstrap/            Framework bootstrap files
config/               Application configuration
database/
	factories/          Model factories for testing and seeding
	migrations/         Database schema changes
	seeders/            Seed data
public/               Web entry point and compiled assets
resources/
	css/                Application styles
	js/                 Frontend scripts
	views/              Blade templates
routes/               Web, auth, and console routes
storage/              Logs, cached files, and uploaded content
tests/                Automated tests
```

## Functionality

- User authentication with verified access for protected areas
- Category management for organizing products
- Product management with SKU, unit, pricing, cost, stock, and threshold tracking
- Stock in and stock out movements for inventory updates
- Sales entry with customer details, item lines, and totals
- Daily reporting for monitoring store activity
- Dashboard overview for quick operational status

## Database Overview

- categories - stores category name and description
- products - stores product details, SKU, unit, price, cost price, stock level, threshold, and image
- stock_movements - stores stock in/out activity, quantity, reference, and notes
- sales - stores sale header details such as customer, user, total amount, and notes
- sale_items - stores the sold products, quantities, unit prices, and line totals

## Key Business Rules

- Every product belongs to one category.
- Stock movement records are linked to both a product and the authenticated user.
- Sales can contain multiple item lines through sale items.
- Low-stock alerts are based on each product's threshold value.

## Main Areas

- `/dashboard` - application overview
- `/categories` - manage product categories
- `/products` - manage inventory items
- `/sales` - record and review sales
- `/reports/daily` - view daily reports

## Core Data Models

- Category - groups products by type
- Product - stores SKU, pricing, stock, expiry date, and inventory thresholds
- StockMovement - records stock in and stock out events
- Sale - stores customer and payment details for each transaction
- SaleItem - stores the items sold within a sale

## Typical Workflow

1. Create product categories.
2. Add products and set stock, pricing, and expiry information.
3. Record stock in and stock out movements as inventory changes.
4. Create sales transactions from available stock.
5. Review the dashboard and daily reports to monitor performance.

## Requirements

- PHP 8.2 or later
- Composer
- Node.js and npm
- A database supported by Laravel

## Installation

1. Install PHP dependencies:

	```bash
	composer install
	```

2. Install frontend dependencies:

	```bash
	npm install
	```

3. Create your environment file and generate an app key:

	```bash
	copy .env.example .env
	php artisan key:generate
	```

4. Configure your database in `.env`, then run migrations:

	```bash
	php artisan migrate
	```

5. Build the frontend assets:

	```bash
	npm run build
	```

## Running Locally

Start the Laravel server:

```bash
php artisan serve
```

In another terminal, run the Vite development server:

```bash
npm run dev
```

## Development Scripts

- `composer run dev` starts the app, queue listener, log viewer, and Vite together
- `composer run test` clears config and runs the test suite
- `npm run dev` starts the Vite development server
- `npm run build` creates a production frontend build

## Notes

- The root route redirects to the dashboard.
- Authenticated and verified users can access the main inventory and sales features.
- Product records can be flagged as low stock or expired based on the configured thresholds and expiry dates.
- The system is designed for store-side inventory control, sales recording, and basic reporting.

## License

This project is covered by a proprietary license. See [LICENSE.md](LICENSE.md) for the full terms and permission requirements.

