# 🎨 Online Paint Shop

**淡江大學資訊工程學系 112 學年度專題**

| 學號 | 姓名 |
|---|---|
| 409840070 | 郭雅馨 |
| 409840062 | 陳芃諭 |
| 409840245 | 壽永馨 |
| 409840302 | 蘇柏銘 |

指導教授：張峯誠

---

## Project Overview

An e-commerce platform for purchasing paint online, built with **CakePHP 5**, **MySQL**, and **XAMPP**. The system supports multiple user roles including customers, warehouse keepers, inspectors, and website maintenance staff.

### Key Features

- **Customer**: Browse paint products, add to cart, checkout, view order history
- **Staff (Website Maintenance)**: View all orders, update order status (pending → inspecting → shipped → delivered)
- **Warehouse Keeper**: Monitor inventory levels, restock paints when low (alert at < 17 cans)
- **Inspector**: Review and fulfill orders

---

## Tech Stack

| Component | Technology |
|---|---|
| Backend Framework | CakePHP 5 (MVC) |
| Database | MySQL (via XAMPP) |
| Web Server | Apache (via XAMPP) |
| IDE | Visual Studio Code |
| PHP Version | >= 8.1 |

---

## Database Schema

Seven tables as defined in the ERD:

| Table | Description |
|---|---|
| `customers` | Customer accounts (name, email, phone, address, password) |
| `paints` | Paint products (name, color, color_code, type, description, price) |
| `storages` | Physical warehouse shelf locations |
| `paints_storages` | Stock levels per paint per storage location |
| `orders` | Customer orders (status: pending / inspecting / shipped / delivered / returned) |
| `orders_paints` | Line items linking orders to paints (quantity, subtotal) |
| `payments` | Payment records (type: cash / credit_card / bank_transfer) |
| `shipments` | Shipment records (type: standard / express) |

---

## Setup Instructions

### 1. Install XAMPP

Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/).

> **Tip:** Always run XAMPP Control Panel as Administrator to avoid port permission errors.

Start **Apache** and **MySQL** from the XAMPP Control Panel.

### 2. Enable PHP intl extension

Open XAMPP → Config → PHP (php.ini).
Find the line:
```
;extension=intl
```
Remove the leading `;` to enable it, then restart Apache.

### 3. Create the database

Open `http://localhost/phpmyadmin` → SQL tab, then run:

```sql
-- Import the schema and seed data:
source /path/to/paint-shop/sql/paint_shop.sql
```

Or paste the contents of `sql/paint_shop.sql` directly into the SQL editor.

### 4. Install CakePHP with Composer

From the XAMPP shell, navigate to `htdocs`:

```bash
cd C:\xampp\htdocs
composer create-project --prefer-dist cakephp/app:^5.0 paint-shop
```

Or if cloning this repo:

```bash
cd C:\xampp\htdocs
git clone https://github.com/yhshou68/Paint-Shop-Cakephp.git paint-shop
cd paint-shop
composer install
```

### 5. Configure the database connection

Edit `config/app_local.php`:

```php
'Datasources' => [
    'default' => [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',          // default XAMPP has no password
        'database' => 'paint',
        'url'      => env('DATABASE_URL', null),
    ],
],
```

### 6. Bake the MVC files (optional — already included in this repo)

From the XAMPP shell inside the project directory:

```bash
bin\cake bake all
```

This generates Models, Controllers, and Templates automatically from the database tables.

### 7. Start the development server

```bash
bin\cake server
```

Then open your browser at: **http://localhost:8765**

---

## Project Structure

```
paint-shop/
├── config/
│   ├── app_local.php        # Database credentials (do not commit)
│   └── routes.php           # URL routing
├── src/
│   ├── Controller/
│   │   ├── AppController.php
│   │   ├── PagesController.php
│   │   ├── PaintsController.php
│   │   ├── CustomersController.php
│   │   ├── CartsController.php
│   │   ├── OrdersController.php
│   │   └── PaintsStoragesController.php
│   └── Model/
│       ├── Entity/          # Entity classes
│       └── Table/           # Table classes (ORM)
├── templates/
│   ├── layout/
│   │   └── default.php      # Main HTML layout
│   ├── Pages/
│   │   └── home.php         # Homepage
│   ├── Paints/              # Product list & detail
│   ├── Carts/               # Shopping cart
│   ├── Orders/              # Checkout & order history
│   ├── Customers/           # Login & register
│   └── PaintsStorages/      # Warehouse management
├── webroot/
│   ├── css/style.css        # Main stylesheet
│   └── js/app.js            # Frontend JS
├── sql/
│   └── paint_shop.sql       # Database schema + seed data
└── composer.json
```

---

## URL Routes

| URL | Description |
|---|---|
| `/` | Homepage with featured paints |
| `/paints` | All paint products |
| `/paints/{id}` | Single product detail |
| `/cart` | Shopping cart |
| `/cart/add/{id}` | Add item to cart |
| `/orders/checkout` | Checkout page |
| `/orders` | Customer order history |
| `/orders/{id}` | Single order detail |
| `/register` | Customer registration |
| `/login` | Customer login |
| `/warehouse` | Warehouse inventory (staff) |
| `/admin/orders` | Admin order management |

---

## Sample Data

The SQL seed includes 6 paints:

| Name | Color Code | Price |
|---|---|---|
| Bell Pepper Green | #5D8A5E | NT$ 350 |
| Tomato Red | #CE2939 | NT$ 350 |
| Ocean Blue | #1A6B9A | NT$ 420 |
| Sunshine Yellow | #F5C518 | NT$ 380 |
| Charcoal Grey | #4A4A4A | NT$ 400 |
| Ivory White | #FFFFF0 | NT$ 300 |

Test login: `test@example.com` / `password123`

---

## References

1. CakePHP Official Documentation — https://cakephp.org/
2. Apache Friends (XAMPP) — https://www.apachefriends.org/
3. CakePHP Installation Guide — https://book.cakephp.org/5/en/installation.html
4. MySQL Documentation — https://www.mysql.com/
5. Visual Studio Code — https://code.visualstudio.com/
6. CakePHP Wikipedia — https://en.wikipedia.org/wiki/CakePHP
7. XAMPP Wikipedia — https://zh.wikipedia.org/zh-tw/XAMPP
