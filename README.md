

---

# Employee Management System

This is a simple Employee Management System built with PHP, MySQL, and FPDF for generating PDF reports. The system allows you to add, view, update, and remove employee records, as well as manage health profiles, surgeries, and clinic records.

---

## Table of Contents

1. Requirements
2. Setting Up XAMPP
3. Setting Up the MySQL Database
4. Installing the FPDF Library
5. Running the Application
6. Project Structure
7. Troubleshooting

---

## Requirements

- XAMPP (PHP 7.4 or higher, MySQL)
- Web browser (e.g., Chrome, Firefox)
- Text editor or IDE (e.g., Visual Studio Code)
- Internet connection (for downloading dependencies)

---

## Setting Up XAMPP

1. **Download XAMPP:**
   - Download XAMPP from the [official website](https://www.apachefriends.org/index.html).

2. **Install XAMPP:**
   - Follow the installation instructions for your operating system.

3. **Start Apache and MySQL:**
   - Open the XAMPP Control Panel.
   - Start the **Apache** and **MySQL** services.

4. **Access phpMyAdmin:**
   - Open your browser and go to `http://localhost/phpmyadmin`.

---

## Setting Up the MySQL Database

1. **Create a New Database:**
   - In phpMyAdmin, click on the **Databases** tab.
   - Create a new database named `employee_management`.

2. **Import the Database Schema:**
   - Click on the `employee_management` database.
   - Go to the **Import** tab.
   - Select the `database.sql` file from the project directory and click **Go**.

3. **Database Tables:**
   - The `database.sql` file will create the following tables:
     - `BasicInformation`
     - `WithComorbidities`
     - `Comorbidities`
     - `UnderwentSurgery`
     - `Operations`
     - `ClinicRecords`

---

## Installing the FPDF Library

1. **Download FPDF:**
   - Download the FPDF library from the [official website](http://www.fpdf.org/).

2. **Extract FPDF:**
   - Extract the downloaded ZIP file.

3. **Add FPDF to the Project:**
   - Copy the `fpdf` folder into the HPR_3 directory.

4. **Include FPDF in Your Code:**
   - Use the following line to include FPDF in your PHP files:
     ```php
     require('fpdf/fpdf.php');
     ```

---

## Running the Application

1. **Place the Project in the XAMPP Directory:**
   - Copy the project folder (`HPR_3`) to the htdocs directory.

2. **Access the Application:**
   - Open your browser and go to `http://localhost/HPR_3/index.php`.

3. **Using the Application:**
   - **Add Employee:** Add new employee records.
   - **View Employee:** View employee details.
   - **Update Employee:** Update existing employee records.
   - **Remove Employee:** Delete employee records.
   - **Generate PDF:** Generate PDF reports for employee details.

---

## Project Structure

```
HPR_3/
├── database.sql               # Database schema
├── index.php                  # Main menu
├── add_employee.php           # Add employee form
├── view_employee.php          # View employee details
├── update_employee.php        # Update employee form
├── remove_employee.php        # Remove employee records
├── generate_pdf.php           # Generate PDF reports
├── scripts/
│   └── add_employee.js        # JavaScript for dynamic form handling
├── styles/
│   ├── add_employee.css       # CSS for add employee page
│   ├── view_employee.css      # CSS for view employee page
│   ├── remove_employee.css    # CSS for remove employee page
├── fpdf/
│   └── fpdf.php               # FPDF library
└── README.md                  # Project documentation
```

---

## Troubleshooting

1. **Apache or MySQL Not Starting:**
   - Ensure no other applications (e.g., Skype) are using ports 80 or 3306.
   - Change the port in the XAMPP Control Panel if necessary.

2. **Database Import Errors:**
   - Ensure the `database.sql` file is correctly formatted.
   - Check for existing tables with the same name and drop them before importing.

3. **FPDF Errors:**
   - Ensure the `fpdf` folder is in the correct directory (HPR_3).
   - Verify that the `require('fpdf/fpdf.php');` path is correct.

4. **File Not Found Errors:**
   - Ensure all files are placed in the HPR_3 directory.
   - Check the file paths in your PHP code.

---

## Additional Notes

- **Browser Compatibility:**
  - The application is tested on modern browsers like Chrome and Firefox.
- **Security:**
  - This project is for educational purposes and does not include advanced security features like input validation or authentication.

---

Let me know if you need further assistance!
