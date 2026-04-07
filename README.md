# Online Paint Shop

> Tamkang University — Department of Computer Science and Information Engineering
> Academic Year 112 — Capstone Project

An online e-commerce platform for purchasing paint, built with **CakePHP 5**, **MySQL**, and **XAMPP**. Customers can browse and order paint products from home, while staff members manage orders, inventory, and fulfillment through a dedicated backend.

---

## Live Demo

**Try the interactive browser demo directly — no installation required:**

[https://yasin0512.github.io/Online-Paint-Shop-CakePHP-project](https://yasin0512.github.io/Online-Paint-Shop-CakePHP-project)

### What you can do in the demo

| Feature | Description |
|---|---|
| Browse products | View all 6 paint colors with color swatches, prices, and stock status |
| Filter | Filter by Interior / Exterior / In stock |
| Quick add | Click the + button on any card to instantly add to cart |
| Product detail | Click a paint card for full details, description, and quantity selector |
| Shopping cart | View items, quantities, subtotal, shipping, and total |
| Checkout | Select payment method and shipping type, then place an order |
| Order history | Track all past orders with status indicators (Pending / Shipped / Delivered) |

> The demo runs entirely in the browser with simulated data. No backend or database connection is required to view it.

---

## Team

| Student ID | Name |
|---|---|
| 409840070 | Yasin Guo (郭雅馨) |
| 409840062 | Peng Yu Chen (陳芃諭) |
| 409840245 | Yung-Hsin Shou (壽永馨) |
| 409840302 | Po Ming Su (蘇柏銘) |

Advisor: Prof. Feng-Cheng Chang (張峯誠)

---

## Features

### Customer
- Browse paint products with color swatches, color codes, and pricing
- Filter products by type (Interior / Exterior) or availability
- Add items to cart with quantity control and stock validation
- Place orders with delivery address, payment method, and shipping type selection
- View personal order history and track order status

### Website Maintenance Staff
- View all customer orders
- Verify order details and update order status (Pending → Inspecting → Shipped → Delivered)

### Warehouse Keeper
- Monitor stock levels across all storage locations
- Receive low-stock alerts when inventory drops below 17 cans
- Perform restocking operations (default: 50 cans per order)

### Inspector
- Pick items from shelves based on order details
- Report picking incidents and update fulfillment status

---

## Tech Stack

| Component | Technology |
|---|---|
| Backend Framework | CakePHP 5 (MVC) |
| Database | MySQL |
| Local Server | Apache (via XAMPP) |
| IDE | Visual Studio Code |
| PHP Version | >= 8.1 |

---

## Database Schema

8 tables based on the Entity-Relationship Diagram:

| Table | Description |
|---|---|
| `customers` | Customer account information |
| `paints` | Paint products (color, color code, type, price) |
| `storages` | Warehouse shelf locations |
| `paints_storages` | Stock quantity per paint per storage location |
| `orders` | Customer orders with status tracking |
| `orders_paints` | Order line items (product, quantity, subtotal) |
| `payments` | Payment records (cash / credit card / bank transfer) |
| `shipments` | Shipment records (standard / express) |

---

## Installation

### 1. Install XAMPP

Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/).

> ⚠️ Always run XAMPP Control Panel as **Administrator** to avoid port permission errors.

Start both **Apache** and **MySQL** from the XAMPP Control Panel.

---

### 2. Enable the PHP intl Extension

Open XAMPP Control Panel → Config → PHP (php.ini) and find:

```
;extension=intl
```

Remove the leading `;`, save the file, then restart Apache.

---

### 3. Set Up the Database

Open `http://localhost/phpmyadmin`, go to the SQL tab, paste the contents of `sql/paint_shop.sql`, and execute. This will create all tables and insert the sample data.

---

### 4. Clone the Repository and Install Dependencies

```bash
cd C:\xampp\htdocs
git clone https://github.com/yasin0512/Online-Paint-Shop-CakePHP-project.git paint-shop
cd paint-shop
composer install
```

---

### 5. Configure the Database Connection

Copy the example config file:

```bash
copy config\app_local.php.example config\app_local.php
```

Edit `config/app_local.php`:

```php
'Datasources' => [
    'default' => [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',       // XAMPP default: no password
        'database' => 'paint',
    ],
],
```

---

### 6. Start the Development Server

```bash
bin\cake server
```

Open your browser and go to: **http://localhost:8765**

---

## Project Structure

```
paint-shop/
├── config/
│   ├── app_local.php.example   # Database config template
│   └── routes.php              # URL routing
├── src/
│   ├── Controller/             # Controllers
│   └── Model/
│       ├── Entity/             # Entity classes
│       └── Table/              # ORM Table classes
├── templates/
│   ├── layout/default.php      # Main HTML layout
│   ├── Pages/                  # Homepage
│   ├── Paints/                 # Product list and detail
│   ├── Carts/                  # Shopping cart
│   ├── Orders/                 # Checkout and order history
│   ├── Customers/              # Login and registration
│   └── PaintsStorages/         # Warehouse management
├── webroot/
│   ├── css/style.css           # Stylesheet
│   └── js/app.js               # Frontend scripts
├── sql/
│   └── paint_shop.sql          # Database schema and seed data
└── composer.json
```

---

## Routes

| Path | Description |
|---|---|
| `/` | Homepage |
| `/paints` | Product listing |
| `/paints/{id}` | Product detail page |
| `/cart` | Shopping cart |
| `/orders/checkout` | Checkout |
| `/orders` | My orders |
| `/register` | Customer registration |
| `/login` | Customer login |
| `/warehouse` | Warehouse inventory management |
| `/admin/orders` | Staff order management |

---

## Sample Data

6 paint products are included in the seed data:

| Name | Color Code | Type | Price |
|---|---|---|---|
| Bell Pepper Green | #5D8A5E | Interior | NT$ 350 |
| Tomato Red | #CE2939 | Interior | NT$ 350 |
| Ocean Blue | #1A6B9A | Exterior | NT$ 420 |
| Sunshine Yellow | #F5C518 | Interior | NT$ 380 |
| Charcoal Grey | #4A4A4A | Exterior | NT$ 400 |
| Ivory White | #FFFFF0 | Interior | NT$ 300 |

**Test account:** `test@example.com` / `password123`

---

## References

- [CakePHP Documentation](https://book.cakephp.org/5/en/index.html)
- [CakePHP Installation Guide](https://book.cakephp.org/5/en/installation.html)
- [Apache Friends (XAMPP)](https://www.apachefriends.org/)
- [MySQL](https://www.mysql.com/)
- [Visual Studio Code](https://code.visualstudio.com/)