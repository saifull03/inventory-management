# Inventory Management System

A modern, full-featured web application built on **Laravel 13**, **Tailwind CSS**, and **Vite** designed to streamline stock tracking, warehouse organization, employee management, and report export.

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.3-blue.svg)](https://php.net)
[![Database](https://img.shields.io/badge/Database-SQLite-green.svg)](https://www.sqlite.org/)
[![License](https://img.shields.io/badge/License-MIT-brightgreen.svg)](https://opensource.org/licenses/MIT)

---

## 🚀 Key Features

*   **📊 Interactive Dashboard**: Displays key inventory metrics (total products, warehouses, categories, and item types), visual breakdown of products per item type, and a table of the latest products added.
*   **🏭 Warehouse Management**: Log and track multiple storage facilities with auto-generated unique warehouse codes (e.g., `WH-001`).
*   **🏷️ Category & Item Type Management**:
    *   **Categories**: Categorize inventory items (e.g., Laptops, Phones).
    *   **Item Types**: Set up asset classes (e.g., Electronics, Accessories) with custom prefixes.
*   **⚙️ Dynamic Product Code Generation**: Automatically generates formatted product codes (e.g., `ELEC0001`, `ACC0001`) in real-time on the frontend based on the selected Item Type prefix, enforced securely on the backend model lifecycle.
*   **📦 Product Directory**: Track product models, brands, serial numbers, purchase price, purchase date, status (e.g., *In Stock*, *Reserved*), and assigned location/category.
*   **👥 Employee Directory**: CRUD interface for managing employee profiles, departments, designations, and contacts, complete with auto-generated employee IDs (e.g., `EMP-001`).
*   **📈 Reporting & Data Export**: Review stock distribution across warehouses and categories, and export the entire product inventory as a clean, downloadable CSV file.
*   **🔒 Security & Authentication**: Robust user registration, login, session management, and profile controls powered by Laravel Breeze.

---

## 🛠️ Technology Stack

*   **Backend**: PHP 8.3+, Laravel 13.x
*   **Frontend**: Vite, Tailwind CSS, Blade Templates, Vanilla JS
*   **Database**: SQLite (default, configurable to MySQL/PostgreSQL)
*   **Testing**: PHPUnit

---

## 📦 Getting Started

### Prerequisites

Ensure you have the following installed on your local machine:
*   PHP $\ge$ 8.3
*   Composer
*   Node.js & NPM

### Setup & Installation

You can set up the entire project, including migrations and asset compilation, using a single setup script:

1.  **Run the automated setup command**:
    ```bash
    composer run setup
    ```
    *This script installs dependencies, sets up the `.env` configuration file, generates the application key, creates/migrates the SQLite database, installs NPM packages, and builds the frontend assets.*

2.  **Seed the database with sample data**:
    ```bash
    php artisan db:seed
    ```
    *This creates a default test user (`test@example.com` / password configured through Breeze or register a new one) along with sample warehouses, categories, item types, products, and employees.*

3.  **Run the local development server**:
    ```bash
    composer run dev
    ```
    *This runs the PHP server, Vite development server, queue listener, and Laravel Pail logging system concurrently.*

    Open your browser and navigate to `http://127.0.0.1:8000`.

---

## 🧪 Testing

The codebase includes feature tests to verify CRUD functionality, product code generation, and access control. To run the test suite:

```bash
composer run test
```

---

## 🗂️ Project Structure

Below is an overview of the key directories in the application:

```text
├── app/
│   ├── Http/Controllers/   # Dashboard, Product, Employee, Report, Warehouse, and Category controllers
│   └── Models/             # Eloquent Models (Product, Employee, Warehouse, Category, ItemType, User)
├── database/
│   ├── migrations/         # Database table definitions
│   └── seeders/            # Sample data seeds for testing and development
├── resources/
│   ├── js/                 # Javascript assets (real-time product code generation logic, etc.)
│   └── views/              # Blade layouts, components, and views
├── routes/
│   ├── auth.php            # Laravel Breeze authentication routes
│   └── web.php             # Web controller routes (under auth middleware)
└── tests/
    ├── Feature/            # Integration and feature tests (Employee, Inventory, ItemType)
    └── Unit/               # Basic unit tests
```

---

## 📜 Commands Reference

| Command | Description |
| :--- | :--- |
| `composer run setup` | Automatic installation of dependencies, environment setup, database migration, and asset compilation. |
| `composer run dev` | Starts the concurrent development environment (server, vite, queue listener, logs). |
| `composer run test` | Runs the test suite via PHPUnit. |
| `php artisan db:seed` | Seeds the database with standard dummy data. |
| `php artisan migrate:fresh --seed` | Resets the database and seeds it from scratch. |
