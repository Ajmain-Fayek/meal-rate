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

## Git Commit Convention

Commit message format structure:

**Structure:**

```
<type>(<scope-optional>)/ <description>
```

**Types:**

- feat → New feature
- fix → Bug fix
- docs → Documentation changes
- style → Code style changes (formatting, missing semi colons, etc)
- refactor → Code changes that neither fix a bug nor add a feature
- perf → Performance improvements
- test → Adding or modifying tests
- revert → Reverting a previous commit
- build → Changes to build system or dependencies
- ci → Changes to CI configuration files and scripts
- chore → Miscellaneous tasks (maintenance, tooling, etc)

**Scops:**

- auth → Authentication, login, logout, JWT, etc
- user → User model, User profile, user management
- docs → Documentation update
- chart → Charts related
- org → Organization related logic
- db → Database schema, migration, queries
- api → API endpoints, route handlers
- ui → Frontend UI Components
- form → Form validation, input handling
- config → Project setup, environment, buld config
- deps → Dependency update
- email → Email service, Notification
- payment → Payment integration, billing
- etl → Data extraction-transformation-load
- merge → resolve conflict resolution