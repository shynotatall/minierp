# Mini ERP System (Laravel 11)

A simple Mini ERP system built using **Laravel 11**, featuring Inventory Management, Sales Orders, PDF Generation, and RESTful APIs secured by **Laravel Sanctum**.

---

## 🚀 Features

- **Authentication & Role Management** (Laravel Breeze)
  - Two roles: `Admin`, `Salesperson`
  - Role-based access control
- **Dashboard Summary**
  - Total Sales Amount
  - Total Orders
  - Low Stock Alerts
- **Inventory Management (Products)**
  - CRUD for Products (Name, SKU, Price, Quantity)
  - Stock automatically reduced after Sales Order confirmation
- **Sales Orders**
  - Create Sales Orders with multiple products
  - Calculate total price
  - PDF export via dompdf
- **RESTful APIs** (Sanctum protected)
  - GET /api/products
  - POST /api/sales-orders
  - GET /api/sales-orders/{id}

---

## 🏗️ Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Blade + Bootstrap
- **Authentication:** Laravel Breeze (Web) + Sanctum (API)
- **PDF Generation:** dompdf
- **Database:** MySQL

---

## ⚙️ Installation

```bash
git clone https://github.com/shynotatall/minierp.git

cd minierp
composer install
cp .env.example .env
php artisan key:generate
