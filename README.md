# Bean Counter — Coffee Shop Menu System

A simple PHP + PDO + MySQL web application for managing a coffee shop's menu, built around a one-to-many relationship between **Menu Categories** and **Menu Items**.

## Entities

- **Parent entity:** Menu Category — one category can have many menu items.
- **Child entity:** Menu Item — each item belongs to exactly one category, linked through a `category_id` foreign key.
- **User entity:** Stores registered users (first name, last name, email, username, hashed password, address, age) and tracks which user created or last updated each record.

## Features

- User registration, login, and logout with hashed passwords (`password_hash` / `password_verify`).
- Session-based authentication — visitors are redirected to the login page if they try to access the system without logging in.
- Full CRUD (Create, Read, Update, Delete) on both Categories and Menu Items.
- Every insert and update is tracked with `added_by` and `last_updated_by` columns referencing the logged-in user, plus an automatic `last_updated` timestamp.
- Responsive UI styled with custom CSS.

## Tech Stack

- PHP (PDO for database access)
- MySQL
- HTML/CSS

## Setup

1. Import `database.sql` into MySQL — this creates the `coffeeshop` database along with the `users`, `categories`, and `menu_items` tables.
2. Update the database credentials in `dbconfig.php` if needed (default: `localhost`, user `root`, no password).
3. Place the project folder inside your server's root (e.g. `htdocs` for XAMPP).
4. Visit `register.php` to create an account, then log in at `login.php`.

## Folder Structure

```
coffeeshop/
├── assets/
│   └── style.css
├── categories/
│   ├── add.php
│   ├── edit.php
│   ├── delete.php
│   └── list.php
├── items/
│   ├── add.php
│   ├── edit.php
│   ├── delete.php
│   ├── list.php
│   └── _form.php
├── includes/
│   ├── header.php
│   └── footer.php
├── dbconfig.php
├── database.sql
├── index.php
├── login.php
├── register.php
└── logout.php
```
