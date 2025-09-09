# MealRate Project Setup Guide

## Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) installed
- PHP >= 7.4
- MySQL

## Installation

1. **Clone the repository**
  ```bash
  git clone <repository-url>
  ```

2. **Move to project directory**
  ```bash
  cd mealRate
  ```

3. **Copy project files to XAMPP htdocs**
  Place all files in `C:/xampp/htdocs/mealRate/`.

4. **Create the database**
  - Open phpMyAdmin (`http://localhost/phpmyadmin`)
  - Create a new database (e.g., `mealrate`)
  - Import the provided SQL file if available.

5. **Configure database connection**
  - Edit `config.php` or relevant file with your DB credentials.

## Running the Project

- Start Apache and MySQL from XAMPP Control Panel.
- Visit `http://localhost/mealRate/` in your browser.

## Troubleshooting

- Ensure Apache and MySQL are running.
- Check file permissions.
- Review error logs in XAMPP if issues occur.
