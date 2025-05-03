-- Create the database
CREATE DATABASE EmployeeManagement;

-- Use the database
USE EmployeeManagement;

-- Table: Basic Information
CREATE TABLE BasicInformation (
    EmployeeID INT AUTO_INCREMENT PRIMARY KEY,
    LastName VARCHAR(100),
    FirstName VARCHAR(100),
    MiddleInitial CHAR(1),
    Position VARCHAR(100),
    Birthdate DATE,
    Age INT,
    Gender ENUM('Male', 'Female', 'Other'),
    CivilStatus VARCHAR(50),
    Address VARCHAR(255),
    Height FLOAT,
    Weight FLOAT,
    FoodAllergies VARCHAR(255),
    ContactNumber VARCHAR(15),
    EmergencyContactPerson VARCHAR(100),
    EmergencyContactRelationship VARCHAR(50),
    EmergencyContactNumber VARCHAR(15),
    ProfileImagePath VARCHAR(255)
);

-- Table: With Comorbidities
CREATE TABLE WithComorbidities (
    EmployeeID INT,
    HasComorbidities ENUM('Yes', 'No'),
    FOREIGN KEY (EmployeeID) REFERENCES BasicInformation(EmployeeID) ON DELETE CASCADE
);

-- Table: Comorbidities
CREATE TABLE Comorbidities (
    ComorbidityID INT AUTO_INCREMENT PRIMARY KEY,
    EmployeeID INT,
    ComorbiditiesDetails VARCHAR(255),
    MaintenanceMedication ENUM('Yes', 'No'),
    MedicationAndDosage VARCHAR(255),
    FOREIGN KEY (EmployeeID) REFERENCES BasicInformation(EmployeeID) ON DELETE CASCADE
);

-- Table: Operations
CREATE TABLE Operations (
    OperationID INT AUTO_INCREMENT PRIMARY KEY,
    EmployeeID INT,
    OperationName VARCHAR(255),
    DatePerformed DATE,
    FOREIGN KEY (EmployeeID) REFERENCES BasicInformation(EmployeeID) ON DELETE CASCADE
);

-- Table: School Clinic Record
CREATE TABLE SchoolClinicRecord (
    RecordID INT AUTO_INCREMENT PRIMARY KEY,
    EmployeeID INT,
    VisitDate DATE,
    Complaints VARCHAR(255),
    Intervention VARCHAR(255),
    NurseOnDuty VARCHAR(100),
    FOREIGN KEY (EmployeeID) REFERENCES BasicInformation(EmployeeID) ON DELETE CASCADE
);