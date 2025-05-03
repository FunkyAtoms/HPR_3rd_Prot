<?php
ob_start(); // Start output buffering
require_once 'libs/fpdf/fpdf.php'; // Include FPDF library
include 'connector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EmployeeID'])) {
    $employeeID = $_POST['EmployeeID'];

    // Fetch employee data
    $stmt = $conn->prepare("SELECT * FROM BasicInformation WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $employeeData = $stmt->get_result()->fetch_assoc();

    // Fetch With Comorbidities
    $stmt = $conn->prepare("SELECT * FROM WithComorbidities WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $comorbiditiesStatus = $stmt->get_result()->fetch_assoc();

    // Fetch comorbidities
    $stmt = $conn->prepare("SELECT * FROM Comorbidities WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $comorbidities = $stmt->get_result();

    // Fetch surgeries
    $stmt = $conn->prepare("SELECT * FROM Operations WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $surgeries = $stmt->get_result();

    // Fetch school clinic records
    $stmt = $conn->prepare("SELECT * FROM SchoolClinicRecord WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $clinicRecords = $stmt->get_result();

    $stmt->close();
    $conn->close();

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add Logo
    $logoPath = 'logo/KNE Logo.png'; // Replace with the actual path to your logo
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 95, 5, 20, 20); // X=95 centers the logo, Y=5 places it at the top, Width=20, Height=20
    }

    $pdf->SetY(25);

    // Add Header Text with Different Font Sizes
    $pdf->SetY(25); // Move the Y position down to start the header text below the logo

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 5, 'Department of Education', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(0, 4, 'REGION X', 0, 1, 'C');
    $pdf->Cell(0, 3, 'DIVISION OF CAGAYAN DE ORO CITY', 0, 1, 'C');
    $pdf->Cell(0, 3, 'CENTRAL DISTRICT', 0, 1, 'C');
    $pdf->Cell(0, 3, 'CITY CENTRAL SCHOOL', 0, 1, 'C');

    // Title
    $pdf->SetFont('Arial', 'B', 10); // Set font size to 5 for the title
    $pdf->Cell(0, 10, 'Employee Health Record', 0, 1, 'C');
    $pdf->Ln(10);

    // Profile Image and Basic Information
    if (!empty($employeeData['ProfileImagePath'])) {
        $imagePath = $employeeData['ProfileImagePath']; // Adjust the path to your image folder
        if (file_exists($imagePath)) {
            $pdf->Image($imagePath, 150, 60, 40, 40); // X=150, Y=30, Width=40, Height=40
        } else {
            $pdf->SetFont('Arial', 'I', 5); // Set font size to 5 for fallback text
            $pdf->SetXY(150, 60);
            $pdf->Cell(40, 10, 'Profile image not found.', 0, 1);
        }
    } else {
        $pdf->SetFont('Arial', 'I', 5); // Set font size to 5 for fallback text
        $pdf->SetXY(150, 60);
        $pdf->Cell(40, 10, 'No profile image available.', 0, 1);
    }
    
    // Basic Information
    $pdf->SetY(60);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'BASIC INFORMATION', 0, 1);
    $pdf->SetFont('Arial', '', 8); // Set font size to 5 for content
    $pdf->Cell(0, 10, 'NAME OF EMPLOYEE: ' . $employeeData['FirstName'] . ' ' . $employeeData['LastName'], 0, 1);
    $pdf->Cell(0, 10, 'POSITION: ' . $employeeData['Position'], 0, 1);
    $pdf->Cell(0, 10, 'BIRTHDATE: ' . $employeeData['Birthdate'], 0, 1);
    $pdf->Cell(0, 10, 'AGE: ' . $employeeData['Age'], 0, 1);
    $pdf->Cell(0, 10, 'GENDER: ' . $employeeData['Gender'], 0, 1);
    $pdf->Cell(0, 10, 'COMPLETE ADDRESS: ' . $employeeData['Address'], 0, 1);
    $pdf->Cell(0, 10, 'CONTACT NUMBER: ' . $employeeData['ContactNumber'], 0, 1);
    $pdf->Cell(0, 10, 'Emergency Contact: ' . $employeeData['EmergencyContactPerson'] . ' (' . $employeeData['EmergencyContactRelationship'] . '), ' . $employeeData['EmergencyContactNumber'], 0, 1);
    $pdf->Ln(10);

    // Comorbidities
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'HEALTH PROFILE', 0, 1);

   // Create Table for "With Comorbidities"
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(65, 10, 'WITH COMORBIDITIES (HEALTH PROBLEM)', 1); // Column 1
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(10, 10, $comorbiditiesStatus ? $comorbiditiesStatus['HasComorbidities'] : 'No status available', 1); // Column 2
    $pdf->Ln(20); // Add some space after the table

    if ($comorbidities->num_rows > 0) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(60, 10, 'DETAILS', 1);
        $pdf->Cell(60, 10, 'WITH MAINTENANCE MEDICATION', 1);
        $pdf->Cell(60, 10, 'DOSAGE', 1);
        $pdf->Ln();
        while ($row = $comorbidities->fetch_assoc()) {
            $pdf->Cell(60, 10, $row['ComorbiditiesDetails'], 1);
            $pdf->Cell(60, 10, $row['MaintenanceMedication'], 1);
            $pdf->Cell(60, 10, $row['MedicationAndDosage'], 1);
            $pdf->Ln();
        }
    } else {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'No comorbidities listed.', 0, 1);
    }
    $pdf->Ln(10);

    // Surgeries
    // Underwent Surgery Section
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Underwent Surgery', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Status: ' . ($underwentSurgery === 'Yes' ? 'Yes' : 'No'), 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Surgeries', 0, 1);
    if ($surgeries->num_rows > 0) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(40, 10, 'NAME OF OPERATION', 1);
        $pdf->Cell(40, 10, 'DATE PERFORMED', 1);
        $pdf->Ln();
        while ($row = $surgeries->fetch_assoc()) {
            $pdf->Cell(40, 10, $row['OperationName'], 1);
            $pdf->Cell(40, 10, $row['DatePerformed'], 1);
            $pdf->Ln();
        }
    } else {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'No surgeries listed.', 0, 1);
    }
    $pdf->Ln(10);

    // School Clinic Records
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 10, 'SCHOOL CLINIC RECORD', 0, 1);
    if ($clinicRecords->num_rows > 0) {
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(40, 10, 'DATE OF VISIT', 1);
        $pdf->Cell(50, 10, 'COMPLAINTS', 1);
        $pdf->Cell(50, 10, 'INTERVENTION', 1);
        $pdf->Cell(50, 10, 'NURSE ON DUTY', 1);
        $pdf->Ln();
        while ($row = $clinicRecords->fetch_assoc()) {
            $pdf->Cell(40, 10, $row['VisitDate'], 1);
            $pdf->Cell(50, 10, $row['Complaints'], 1);
            $pdf->Cell(50, 10, $row['Intervention'], 1);
            $pdf->Cell(50, 10, $row['NurseOnDuty'], 1);
            $pdf->Ln();
        }
    } else {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'No school clinic records found.', 0, 1);
    }

    ob_end_clean(); // Clear the output buffer
    $pdf->Output('Employee_Health_Record.pdf', 'I');
}
?>