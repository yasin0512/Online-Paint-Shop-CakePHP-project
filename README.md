# Online Paint Shop

> Tamkang University — Department of Computer Science and Information Engineering
> Academic Year 112 — Capstone Project

An online e-commerce platform for purchasing paint, built with CakePHP 5. Customers can browse and order paint products from home, while staff members manage orders, inventory, and fulfillment through a dedicated backend.

---

## Team

| Student ID | Name |
|---|---|
| 409840070 | 郭雅馨 Yasin Guo |
| 409840062 | 陳芃諭 Peng Yu Chen |
| 409840245 | 壽永馨 Yung-Hsin Shou |
| 409840302 | 蘇柏銘 Po Ming Su |

Advisor: Prof. Feng-Cheng Chang

---

## Features

### Customer
- Browse paint products with color swatches, color codes, and pricing
- Add items to cart and adjust quantities
- Place orders with delivery address and payment method selection
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

| Name | Color Code | Price |
|---|---|---|
| Bell Pepper Green | #5D8A5E | NT$ 350 |
| Tomato Red | #CE2939 | NT$ 350 |
| Ocean Blue | #1A6B9A | NT$ 420 |
| Sunshine Yellow | #F5C518 | NT$ 380 |
| Charcoal Grey | #4A4A4A | NT$ 400 |
| Ivory White | #FFFFF0 | NT$ 300 |

**Test account:** `test@example.com` / `password123`

---

## References

- [CakePHP Documentation](https://book.cakephp.org/5/en/index.html)
- [CakePHP Installation Guide](https://book.cakephp.org/5/en/installation.html)
- [Apache Friends (XAMPP)](https://www.apachefriends.org/)
- [MySQL](https://www.mysql.com/)
- [Visual Studio Code](https://code.visualstudio.com/)
