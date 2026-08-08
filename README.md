# Toko Obat Jaya Mulya

A Laravel-based Point of Sale (POS) and medicine stock management system designed to support pharmacy/drugstore operations — from product management and cashier transactions to sales reporting.

## Features

### Admin
- Admin dashboard
- Medicine data management
- User CRUD (create, read, update, delete)
- Transaction monitoring
- Print transaction receipts
- Sales reports
- Medicine stock management

### Cashier
- Cashier dashboard
- POS / sales transaction system
- Medicine search
- Transaction history
- Print payment receipts

---

## Tech Stack

- Laravel 12
- Laravel Blade
- Laravel Sanctum
- MySQL
- PHP 8.2.12
- Composer 2.8.9

---

## User Roles

### Admin
Has full access to:
- Medicine data
- User data
- Reports
- All transactions

### Cashier
Has access to:
- POS / transactions
- Medicine data
- Transaction history
- Receipt printing

---

## Prerequisites

Before you begin, make sure you have the following installed:

- PHP 8.2 or higher
- Composer 2.x
- MySQL
- Git

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/NabilKevin/toko_obat_jaya_mulya.git
cd toko_obat_jaya_mulya
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Copy the Environment File

```bash
cp .env.example .env
```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Configure the Database

Edit the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Make sure a MySQL database with that name already exists before proceeding.

### 6. Run Migrations

```bash
php artisan migrate
```

If seeders are available and you want sample data (e.g., a default admin account):

```bash
php artisan migrate --seed
```

### 7. Run the Application

```bash
php artisan serve
```

By default, the application will be available at `http://localhost:8000`.

---

## Route Overview

### Authentication
- Login
- Logout

### Admin Routes
- Dashboard
- Medicine management
- User management
- Transactions
- Reports
- Receipt printing

### Cashier Routes
- Dashboard
- POS
- Medicine search
- Transactions
- Receipt printing

---

## Project Structure

This project uses:
- Laravel Blade for the frontend
- Authentication middleware and role-based authorization
- Sanctum authentication
- MVC architecture

---

## Security

- Authentication is handled via Laravel Sanctum
- Role-based middleware:
  - `isAdmin`
  - `isKasir`

---

## Troubleshooting

- **`php artisan migrate` fails to connect to the database** — double-check that MySQL is running and that `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` are correct.
- **"Class not found" or dependency errors after cloning** — run `composer install` again and make sure your PHP version matches the requirement (8.2.12+).
- **Blank page / 500 error on first run** — make sure `php artisan key:generate` has been run and that storage/cache folders are writable (`chmod -R 775 storage bootstrap/cache` on Linux/macOS).

---

## Future Improvements

- Export reports to PDF/Excel
- Barcode scanner integration
- Stock alert system
- Dashboard analytics
- Multi-branch support

---

## License

This project currently has no license specified. Consider adding one (e.g., MIT) if you plan to share or open-source this project.

---

## Repository

GitHub Repository: https://github.com/NabilKevin/toko_obat_jaya_mulya
