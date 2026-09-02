# E-Commerce Application

A full-featured e-commerce web application built with **Laravel 12**, featuring a customer-facing storefront and a separate admin dashboard for managing products, orders, categories, and support tickets.

## Features

### Storefront (Customer)
- Browse products by category, view "Super Deals" and featured products
- Product search and detailed product view pages
- Shopping cart (add, view, remove, empty)
- Wishlist / favorites
- Checkout with **Stripe** payment integration (success/cancel handling)
- Order shipping details and order history ("My Orders")
- User authentication (register, login, password reset) via **Laravel Breeze**
- User account and profile management
- Support ticket system (create, view, reply, close)
- Contact Us form

### Admin Dashboard
- Role-based access control via **Spatie Laravel-Permission** (`admin` / `user` roles)
- Manage categories (add, edit, delete)
- Manage products (add, edit, delete)
- Manage featured products
- View and manage customer orders
- General site settings management
- View and manage Contact Us submissions
- Manage users
- Handle customer support tickets (view, reply, close)
- Admin profile management

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade templates, Tailwind CSS, Alpine.js
- **Build tool:** Vite
- **Auth & Permissions:** Laravel Breeze, Spatie Laravel-Permission
- **Payments:** Stripe PHP SDK
- **Database:** SQLite by default (configurable to MySQL/others)
- **Testing:** Pest PHP

## Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- A database (SQLite by default, or MySQL/PostgreSQL/etc.)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/zaidhindi/E-Commerce-Application.git
   cd E-Commerce-Application
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JS dependencies**
   ```bash
   npm install
   ```

4. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database** in `.env` (SQLite is used by default — create the database file if needed):
   ```bash
   touch database/database.sqlite
   ```
   Or update `DB_CONNECTION` and related variables in `.env` to use MySQL/PostgreSQL instead.

6. **Add your Stripe keys** to `.env` for payment functionality (e.g. `STRIPE_KEY`, `STRIPE_SECRET`).

7. **Run migrations**
   ```bash
   php artisan migrate
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Serve the application**
   ```bash
   php artisan serve
   ```

   Or run everything (server, queue listener, logs, and Vite) together:
   ```bash
   composer run dev
   ```

## Project Structure Highlights

- `app/Http/Controllers/FrontendController.php` — handles all customer-facing storefront logic
- `app/Http/Controllers/BackendController.php` — handles all admin dashboard logic
- `app/Models/` — Eloquent models: `Products`, `Category`, `Cart`, `Favorite`, `Order`, `OrderShip`, `ContactUs`, `Support`, `GeneralSetting`, `ProductViewd`, `User`
- `routes/web.php` — all frontend and backend routes, protected with `auth`, `verified`, and `role` middleware
- `resources/views/frontend/` — customer-facing Blade views
- `resources/views/backend/` — admin dashboard Blade views

## License

This project is open-sourced software.
