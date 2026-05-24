# Student Database Management System

##  Project Description
This project is a simple Student Database Management System designed to manage student academic records.  
The system allows users to store and manage student information including GPA, and automatically determines the academic status based on GPA values.

This project is developed for practicing collaborative web development using Git, PHP, and relational databases, following the 3-tier web architecture.

---

##  Features
- Add new student data
- View list of students
- Edit student information
- Delete student records
- Search student by name or ID
- Automatic GPA-based academic status classification

---

##  Purpose
This project is created for educational purposes to practice:
- Git workflow
- Web development using PHP
- Database integration
  
---

##  GPA & Academic Status Logic
The system automatically assigns academic status based on GPA:

- GPA ≥ 3.5 → Excellent
- GPA ≥ 2.0 → Good
- GPA < 2.0 → Warning

This feature helps to quickly identify student performance levels.

---

##  Technologies Used
- PHP (Backend Logic)
- MySQL (Relational Database)
- HTML/CSS (Frontend Interface)
- Git & GitHub (Version Control)

---

##  System Architecture
This project follows the 3-tier architecture model:

1. **Presentation Layer**
   - HTML/CSS user interface

2. **Logic Layer**
   - PHP handles data processing and business logic

3. **Data Layer**
   - MySQL database stores student records

---

##  Target Application
The target application is a lightweight student management system that can be used to manage academic records efficiently.  
It is designed to be simple and suitable for deployment on low-resource systems such as Raspberry Pi Zero 2W.

---

##  Future Improvements
- Add login system (admin authentication)
- Add department management
- Add dashboard statistics
- Improve UI with Bootstrap



- 3-tier architecture design

## File Function
| File | Function |
|------|---------|
| index.php | Display student list |
| add_student.php | Add new student |
| config.php | Database connection |
| style.css | Website styling |
| database.sql | Database structure |
| README.md | Project documentation |
