# Installation Guide

This guide explains how to install and run the Student Database Management System on Windows, Linux, macOS, or Raspberry Pi.

## Prerequisites

Before you begin, ensure you have the following installed:

* PHP 7.4 or higher

  * Required extensions: PDO, PDO_MySQL
* MariaDB 10.x or higher
* Apache or another PHP-compatible web server
* Git

### System Requirements

* Operating System: Linux, macOS, Windows
* RAM: 512 MB minimum
* Storage: 50 MB minimum

---

## Step 1: Clone the Repository

Clone the project repository:

```bash
git clone https://github.com/leirvag-van/student-database-management.git
cd student-database-management
```

---

## Step 2: Create the Database

Log in to MariaDB:

```bash
sudo mysql
```

Create the project database:

```sql
CREATE DATABASE student_db;
USE student_db;
```

Create the students table:

```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    gpa DECIMAL(3,2) NOT NULL,
    status VARCHAR(20) NOT NULL
);
```

Create a database user:

```sql
CREATE USER 'phpuser'@'localhost' IDENTIFIED BY 'php123';
GRANT ALL PRIVILEGES ON student_db.* TO 'phpuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## Step 3: Configure Database Connection

Open `config.php` and update the database settings:

```php
$host = "localhost";
$dbname = "student_db";
$username = "phpuser";
$password = "php123";
```

---

## Step 4: Deploy the Application

Copy the project files into your web server directory.

### Windows (XAMPP)

Copy the project folder to:

```text
C:\xampp\htdocs\student-database-management
```

### Linux / Raspberry Pi

Copy the project folder to:

```text
/var/www/html/student-database-management
```

---

## Step 5: Start Services

Ensure Apache and MariaDB are running.

### Linux / Raspberry Pi

```bash
sudo systemctl start apache2
sudo systemctl start mariadb
```

Verify:

```bash
sudo systemctl status apache2
sudo systemctl status mariadb
```

### Windows (XAMPP)

Start Apache and MySQL from the XAMPP Control Panel.

---

## Step 6: Access the Application

Open a web browser.

### XAMPP

```text
http://localhost/student-database-management
```

### Linux / Raspberry Pi

```text
http://localhost/student-database-management
```

Or from another device on the network:

```text
http://<server-ip-address>/student-database-management
```

---

## Step 7: Verify Installation

The installation is successful if:

* The homepage loads correctly.
* Students can be added.
* Students can be edited.
* Students can be deleted.
* Student data is stored in the MariaDB database.

---

## Raspberry Pi Deployment Notes

For the project demonstration, the application was deployed on a Raspberry Pi Zero 2 W using:

* Apache Web Server
* PHP
* MariaDB

The application can operate without Internet access and supports link-local networking as required by the project specification.

For clarification, we added step 3 due to an error that appeared during our testing of the application.
