# Administrator Guide

## Overview

The Student Database Management System is a PHP and MariaDB web application used to manage student records. This guide describes how to configure and maintain the application.

---

## Application Configuration

### Database Configuration

Database connection settings are stored in `config.php`.

Example:

```php
$host = "localhost";
$dbname = "student_db";
$username = "phpuser";
$password = "php123";
```

Administrators should update these values to match their MariaDB configuration.

---

### Web Server Configuration

The application should be deployed inside the web server document root.

Examples:

**Apache (Linux / Raspberry Pi)**

```text
/var/www/html/student-database-management
```

**XAMPP (Windows)**

```text
C:\xampp\htdocs\student-database-management
```

---

### Database Structure

The application uses a single table named `students`.

Fields:

| Field      | Description                   |
| ---------- | ----------------------------- |
| id         | Internal primary key          |
| student_id | Student identification number |
| name       | Student name                  |
| department | Student department            |
| gpa        | Student GPA                   |
| status     | Academic status               |

---

## Application Maintenance

### Starting Services

Linux / Raspberry Pi:

```bash
sudo systemctl start apache2
sudo systemctl start mariadb
```

---

### Checking Service Status

```bash
sudo systemctl status apache2
sudo systemctl status mariadb
```

Verify that both services are running before accessing the application.

---

### Database Backup

Create a database backup:

```bash
mysqldump -u phpuser -p student_db > backup.sql
```

Restore a backup:

```bash
mysql -u phpuser -p student_db < backup.sql
```

---

### Updating the Application

Pull the latest changes from the repository:

```bash
git pull
```

Restart Apache after updating:

```bash
sudo systemctl restart apache2
```

---

### Common Issues

#### Database Connection Failed

Verify:

* MariaDB is running.
* The database exists.
* Credentials in `config.php` are correct.

#### Apache Default Page Appears

Ensure the application files are located in the correct document root and that `index.php` is present.

#### Access Denied for User

Verify that the MariaDB user exists and has permissions on the `student_db` database.

---

## Raspberry Pi Deployment

The application has been tested on a Raspberry Pi Zero 2 W using:

* Apache
* PHP
* MariaDB

For classroom demonstrations, the application can operate without Internet access and supports link-local networking.
