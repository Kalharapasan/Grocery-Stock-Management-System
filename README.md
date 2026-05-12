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

## Screenshots

<table>
	<tr>
		<td align="center"><img src="https://github.com/user-attachments/assets/2859b731-1630-4785-aaa2-5934452e617f" alt="Dashboard" width="340" height="190" /></td>
		<td align="center"><img src="https://github.com/user-attachments/assets/3734b43b-fd6a-4739-8807-fd3943c5f34e" alt="Products" width="340" height="190" /></td>
	</tr>
	<tr>
		<td align="center"><img src="https://github.com/user-attachments/assets/1ddaf776-677a-4607-9f6b-b7afbca269e6" alt="Categories" width="340" height="190" /></td>
		<td align="center"><img src="https://github.com/user-attachments/assets/8ef0a3b8-dcd6-42ed-b633-ff7a1aed8149" alt="Reports" width="340" height="190" /></td>
	</tr>
	<tr>
		<td align="center"><img src="https://github.com/user-attachments/assets/475b182e-219a-4e90-b9c3-1bdc32bb355d" alt="Login" width="340" height="190" /></td>
		<td align="center"><img src="https://github.com/user-attachments/assets/ad4434d3-8541-476b-aafb-088d0c6d9ccd" alt="Register" width="340" height="190" /></td>
	</tr>
	<tr>
		<td align="center"><img src="https://github.com/user-attachments/assets/81a75cf4-eea6-4851-b330-7c7c132cd5c5" alt="Add Category" width="340" height="190" /></td>
		<td align="center"><img src="https://github.com/user-attachments/assets/8de06f5c-6efd-4ed0-b95f-49e4902c7261" alt="Add Product" width="340" height="190" /></td>
	</tr>
	<tr>
		<td align="center"><img src="https://github.com/user-attachments/assets/8e17db29-a311-4bed-9cc3-4c5f9ef571dd" alt="Categories View" width="340" height="190" /></td>
		<td align="center"><img src="https://github.com/user-attachments/assets/035d4fc8-80cc-48eb-8d60-7a38c22ce618" alt="Sales" width="340" height="190" /></td>
	</tr>
</table>

## Tech Stack

- Laravel 12
- PHP 8.2+
- Vite
- Tailwind CSS
- Bootstrap 5
- Alpine.js

## Project Structure

```text
.
|-- app/
|   |-- Http/
|   |   |-- Controllers/
|   |   |   |-- Auth/
|   |   |   |   |-- AuthenticatedSessionController.php
|   |   |   |   |-- ConfirmablePasswordController.php
|   |   |   |   |-- EmailVerificationNotificationController.php
|   |   |   |   |-- EmailVerificationPromptController.php
|   |   |   |   |-- NewPasswordController.php
|   |   |   |   |-- PasswordController.php
|   |   |   |   |-- PasswordResetLinkController.php
|   |   |   |   |-- RegisteredUserController.php
|   |   |   |   |-- VerifyEmailController.php
|   |   |   |-- CategoryController.php
|   |   |   |-- DashboardController.php
|   |   |   |-- ProductController.php
|   |   |   |-- ProfileController.php
|   |   |   |-- ReportController.php
|   |   |   |-- SaleController.php
|   |   |   |-- StockMovementController.php
|   |   |-- Requests/
|   |   |   |-- Auth/
|   |   |   |   |-- LoginRequest.php
|   |   |   |-- ProfileUpdateRequest.php
|   |   |   |-- StoreCategoryRequest.php
|   |   |   |-- StoreProductRequest.php
|   |   |   |-- StoreSaleRequest.php
|   |   |   |-- UpdateCategoryRequest.php
|   |   |   |-- UpdateProductRequest.php
|   |-- Models/
|   |   |-- Category.php
|   |   |-- Product.php
|   |   |-- Sale.php
|   |   |-- SaleItem.php
|   |   |-- StockMovement.php
|   |   |-- User.php
|   |-- Providers/
|   |   |-- AppServiceProvider.php
|   |-- View/
|       |-- Components/
|-- bootstrap/
|   |-- app.php
|   |-- providers.php
|   |-- cache/
|-- config/
|-- database/
|   |-- factories/
|   |   |-- CategoryFactory.php
|   |   |-- ProductFactory.php
|   |   |-- UserFactory.php
|   |-- migrations/
|   |   |-- 0001_01_01_000000_create_users_table.php
|   |   |-- 0001_01_01_000001_create_cache_table.php
|   |   |-- 0001_01_01_000002_create_jobs_table.php
|   |   |-- 2026_05_02_203559_create_categories_table.php
|   |   |-- 2026_05_10_190230_create_products_table.php
|   |   |-- 2026_05_10_190243_create_stock_movements_table.php
|   |   |-- 2026_05_10_190248_create_sales_table.php
|   |   |-- 2026_05_11_195832_add_expiry_date_to_products_table.php
|   |   |-- 2026_05_11_200158_update_sales_table_add_financials.php
|   |-- seeders/
|       |-- DatabaseSeeder.php
|-- public/
|   |-- build/
|   |-- index.php
|-- resources/
|   |-- css/
|   |   |-- app.css
|   |-- js/
|   |   |-- app.js
|   |   |-- bootstrap.js
|   |-- views/
|       |-- auth/
|       |   |-- confirm-password.blade.php
|       |   |-- forgot-password.blade.php
|       |   |-- login.blade.php
|       |   |-- register.blade.php
|       |   |-- reset-password.blade.php
|       |   |-- verify-email.blade.php
|       |-- categories/
|       |-- components/
|       |   |-- application-logo.blade.php
|       |   |-- auth-session-status.blade.php
|       |   |-- danger-button.blade.php
|       |   |-- dropdown-link.blade.php
|       |   |-- dropdown.blade.php
|       |   |-- input-error.blade.php
|       |   |-- input-label.blade.php
|       |   |-- modal.blade.php
|       |   |-- nav-link.blade.php
|       |   |-- primary-button.blade.php
|       |   |-- responsive-nav-link.blade.php
|       |   |-- secondary-button.blade.php
|       |   |-- text-input.blade.php
|       |-- layouts/
|       |   |-- app.blade.php
|       |   |-- guest.blade.php
|       |   |-- navigation.blade.php
|       |-- products/
|       |-- profile/
|       |-- reports/
|       |-- sales/
|       |-- dashboard.blade.php
|       |-- welcome.blade.php
|-- routes/
|   |-- auth.php
|   |-- console.php
|   |-- web.php
|-- storage/
|   |-- app/
|   |   |-- private/
|   |   |-- public/
|   |-- framework/
|   |   |-- cache/
|   |   |-- sessions/
|   |   |-- testing/
|   |   |-- views/
|   |-- logs/
|-- tests/
|   |-- Feature/
|   |   |-- Auth/
|   |   |-- ExampleTest.php
|   |   |-- ProfileTest.php
|   |-- Unit/
|       |-- ExampleTest.php
|-- artisan
|-- composer.json
|-- composer.lock
|-- package.json
|-- package-lock.json
|-- phpunit.xml
|-- postcss.config.js
|-- README.md
|-- tailwind.config.js
|-- vite.config.js
|-- LICENSE.md
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

