# LiChun Restaurant — Web Application

A full-stack website for a Chinese restaurant, built with PHP and MySQL.

## Features

- Restaurant menu with dish pages and photos
- Customer reviews displayed on the homepage
- Table reservation system
- News / announcements section
- Full admin panel — add, edit, and delete dishes, reservations, reviews, and news

## Tech Stack

- **PHP** — backend logic and templating
- **MySQL** — database
- **HTML / CSS / JavaScript** — frontend

## Project Structure

```
├── PHP/            # Backend logic and page controllers
│   └── includes/   # Form handlers (menu, reviews, reservations, news)
├── CSS/            # Stylesheets per page
├── HTML/           # Main entry point
└── images/         # Restaurant photos and documentation assets
```

## Getting Started

Requirements: PHP 8+, MySQL, Apache or Nginx (or use XAMPP / Laragon locally).

```bash
git clone https://github.com/kajzen/WEB.git
cd WEB
# Import the SQL schema into your database
# Configure DB credentials in PHP/includes/dhp.inc.php
# Start your local server and open HTML/restaurant-LiChun-project.php
```
