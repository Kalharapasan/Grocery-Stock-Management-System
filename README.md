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

## Main Areas

- `/dashboard` - application overview
- `/categories` - manage product categories
- `/products` - manage inventory items
- `/sales` - record and review sales
- `/reports/daily` - view daily reports

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

## License

This project is covered by a proprietary license. See [LICENSE.md](LICENSE.md) for the full terms and permission requirements.

