# User Guide

## Student Database Management System

-----

## Table of Contents

- [Overview](#overview)
- [Accessing the Application](#accessing-the-application)
- [Navigating the Interface](#navigating-the-interface)
- [Managing Students](#managing-students)
  - [Viewing the Student List](#viewing-the-student-list)
  - [Adding a New Student](#adding-a-new-student)
  - [Editing Student Information](#editing-student-information)
  - [Deleting a Student Record](#deleting-a-student-record)
- [Searching for a Student](#searching-for-a-student)
- [Academic Status Classification](#academic-status-classification)

-----

## Overview

The Student Database Management System is a web-based application for storing and managing student academic records. It allows you to add, view, edit, and delete student data, as well as search by name or student ID. The system also automatically determines each student’s academic status based on their GPA.

-----

## Accessing the Application

1. Open your web browser.
1. Navigate to the application URL (e.g., `http://localhost/student-database-management` or your server’s address).
1. You will be directed to the main student list page (`index.php`).

> **Note:** Ensure the server and database are running before accessing the application. Refer to `Installation.md` for setup instructions.

-----

## Navigating the Interface

The main page (`index.php`) displays the full list of enrolled students along with their information and available actions. From here, you can:

- Add a new student using the **Add Student** button.
- Edit or delete existing records using the action buttons in each student’s row.
- Search for a specific student using the search bar.

-----

## Managing Students

### Viewing the Student List

Upon opening the application, the homepage displays a table of all students with the following fields:

|Field          |Description                          |
|---------------|-------------------------------------|
|Student ID     |Unique identifier for the student    |
|Name           |Full name of the student             |
|GPA            |Grade Point Average                  |
|Academic Status|Automatically determined based on GPA|

-----

### Adding a New Student

1. On the main page, click the **Add Student** button.
1. You will be taken to the `add_student.php` page.
1. Fill in the required fields:
- **Student ID**
- **Student Name**
- **GPA**
1. Click **Submit** to save the new record.
1. You will be redirected back to the student list with the new entry added.

-----

### Editing Student Information

1. On the student list, locate the student you wish to update.
1. Click the **Edit** button in that student’s row.
1. You will be taken to the `edit_student.php` page with the current information pre-filled.
1. Modify the desired fields.
1. Click **Update** to save your changes.
1. You will be redirected back to the student list with the updated information.

-----

### Deleting a Student Record

1. On the student list, locate the student you wish to remove.
1. Click the **Delete** button in that student’s row.
1. Confirm the deletion when prompted.
1. The record will be permanently removed from the database.

> **Warning:** Deletion is irreversible. Make sure you are removing the correct record before confirming.

-----

## Searching for a Student

1. On the main page, locate the **Search** bar at the top of the student list.
1. Type a student’s **name** or **Student ID** into the search field.
1. The table will filter to show only matching results in real time (or upon pressing Enter/Search).
1. Clear the search field to return to the full student list.

-----

## Academic Status Classification

The system automatically calculates and displays each student’s academic status based on their GPA. The classification follows standard academic standing thresholds:

|GPA Range  |Academic Status        |
|-----------|-----------------------|
|3.50 – 4.00|Excellent|
|3.00 – 3.49|Good Standing          |
|Below 3.00 |Warning     |


> **Note:** The exact GPA thresholds may vary depending on the configuration set by the administrator. Refer to `AdminGuide.md` for details on modifying status classifications.
