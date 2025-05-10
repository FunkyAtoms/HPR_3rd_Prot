<?php
include 'connector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic Information
    $employeeID = $_POST['EmployeeID'];
    $lastName = $_POST['LastName'];
    $firstName = $_POST['FirstName'];
    $middleInitial = $_POST['MiddleInitial'];
    $position = $_POST['Position'];
    $birthdate = $_POST['Birthdate'];
    $age = $_POST['Age'];
    $gender = $_POST['Gender'];
    $civilStatus = $_POST['CivilStatus'];
    $address = $_POST['Address'];
    $height = $_POST['Height'];
    $weight = $_POST['Weight'];
    $foodAllergies = $_POST['FoodAllergies'];
    $contactNumber = $_POST['ContactNumber'];
    $emergencyContactPerson = $_POST['EmergencyContactPerson'];
    $emergencyContactRelationship = $_POST['EmergencyContactRelationship'];
    $emergencyContactNumber = $_POST['EmergencyContactNumber'];

    // Handle Profile Image Upload
    $profileImagePath = null;
    if (isset($_FILES['ProfileImage']) && $_FILES['ProfileImage']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $profileImagePath = $uploadDir . basename($_FILES['ProfileImage']['name']);
        move_uploaded_file($_FILES['ProfileImage']['tmp_name'], $profileImagePath);
    }

    if ($profileImagePath === null) {
        $profileImagePath = ''; // Set to an empty string if no image is uploaded
    }

    // Save Basic Information
    $sql = "INSERT INTO BasicInformation (EmployeeID, LastName, FirstName, MiddleInitial, Position, Birthdate, Age, Gender, CivilStatus, Address, Height, Weight, FoodAllergies, ContactNumber, EmergencyContactPerson, EmergencyContactRelationship, EmergencyContactNumber, ProfileImagePath) 
            VALUES ('$employeeID', '$lastName', '$firstName', '$middleInitial', '$position', '$birthdate', '$age', '$gender', '$civilStatus', '$address', '$height', '$weight', '$foodAllergies', '$contactNumber', '$emergencyContactPerson', '$emergencyContactRelationship', '$emergencyContactNumber', '$profileImagePath')";

    if ($conn->query($sql) === TRUE) {
        // Save With Comorbidities
        $withComorbidities = $_POST['WithComorbidities'];
        $sqlWithComorbidities = "INSERT INTO WithComorbidities (EmployeeID, HasComorbidities) 
                                 VALUES ('$employeeID', '$withComorbidities')";
        $conn->query($sqlWithComorbidities);

        // Save Underwent Surgery
        $underwentSurgery = $_POST['UnderwentSurgery']; // Assuming this field exists in the form
        $sqlUnderwentSurgery = "INSERT INTO UnderwentSurgery (EmployeeID, HasUndergoneSurgery) 
                                VALUES ('$employeeID', '$underwentSurgery')";
        $conn->query($sqlUnderwentSurgery);

        // Save Comorbidities (if any)
        if ($withComorbidities === 'Yes' && isset($_POST['Comorbidities'])) {
            foreach ($_POST['Comorbidities'] as $comorbidity) {
                $comorbidityDetails = $conn->real_escape_string($comorbidity['details']);
                $maintenanceMedication = $conn->real_escape_string($comorbidity['medication']);
                $medicationAndDosage = $conn->real_escape_string($comorbidity['dosage']);
                
                // Insert new comorbidity record
                $sqlComorbidity = "INSERT INTO Comorbidities (EmployeeID, ComorbiditiesDetails, MaintenanceMedication, MedicationAndDosage) 
                                   VALUES ('$employeeID', '$comorbidityDetails', '$maintenanceMedication', '$medicationAndDosage')";
                $conn->query($sqlComorbidity);
            }
        }

        // Save Operations (if any)
        if (isset($_POST['Surgeries'])) {
            foreach ($_POST['Surgeries'] as $surgery) {
                $operationName = $conn->real_escape_string($surgery['name']);
                $datePerformed = $conn->real_escape_string($surgery['date']);
                
                // Insert new operation record
                $sqlOperation = "INSERT INTO Operations (EmployeeID, OperationName, DatePerformed) 
                                 VALUES ('$employeeID', '$operationName', '$datePerformed')";
                $conn->query($sqlOperation);
            }
        }

        // Save School Clinic Records (if any)
        if (isset($_POST['ClinicRecords'])) {
            foreach ($_POST['ClinicRecords'] as $clinicRecord) {
                $visitDate = $conn->real_escape_string($clinicRecord['visitDate']);
                $complaints = $conn->real_escape_string($clinicRecord['complaints']);
                $intervention = $conn->real_escape_string($clinicRecord['intervention']);
                $nurseOnDuty = $conn->real_escape_string($clinicRecord['nurse']);
                
                // Insert new clinic record
                $sqlClinicRecord = "INSERT INTO SchoolClinicRecord (EmployeeID, VisitDate, Complaints, Intervention, NurseOnDuty) 
                                    VALUES ('$employeeID', '$visitDate', '$complaints', '$intervention', '$nurseOnDuty')";
                $conn->query($sqlClinicRecord);
            }
        }

        // Save Comorbidities (if any)
        if (isset($_POST['ComorbiditiesDetails'])) {
            foreach ($_POST['ComorbiditiesDetails'] as $index => $details) {
                $details = $conn->real_escape_string($details);
                $medication = $conn->real_escape_string($_POST['MaintenanceMedication'][$index]);
                $dosage = $conn->real_escape_string($_POST['MedicationAndDosage'][$index]);

                // Insert new comorbidity record
                $sql = "INSERT INTO Comorbidities (EmployeeID, ComorbiditiesDetails, MaintenanceMedication, MedicationAndDosage)
                        VALUES ('$employeeID', '$details', '$medication', '$dosage')";
                $conn->query($sql);
            }
        }

        // Process Comorbidities
        if (isset($_POST['ComorbiditiesDetails'])) {
            foreach ($_POST['ComorbiditiesDetails'] as $index => $details) {
                $details = $conn->real_escape_string($details);
                $medication = $conn->real_escape_string($_POST['MaintenanceMedication'][$index]);
                $dosage = $conn->real_escape_string($_POST['MedicationAndDosage'][$index]);

                $sql = "INSERT INTO Comorbidities (EmployeeID, ComorbiditiesDetails, MaintenanceMedication, MedicationAndDosage)
                        VALUES ('$employeeID', '$details', '$medication', '$dosage')";
                $conn->query($sql);
            }
        }

        // Process Surgeries
        if (isset($_POST['OperationName'])) {
            foreach ($_POST['OperationName'] as $index => $name) {
                $name = $conn->real_escape_string($name);
                $date = $conn->real_escape_string($_POST['DatePerformed'][$index]);

                $sql = "INSERT INTO Operations (EmployeeID, OperationName, DatePerformed)
                        VALUES ('$employeeID', '$name', '$date')";
                $conn->query($sql);
            }
        }

        // Save Operations (if any)
        if (isset($_POST['OperationName'])) {
            foreach ($_POST['OperationName'] as $index => $name) {
                $name = $conn->real_escape_string($name);
                $date = $conn->real_escape_string($_POST['DatePerformed'][$index]);

                // Insert new operation record
                $sql = "INSERT INTO Operations (EmployeeID, OperationName, DatePerformed)
                        VALUES ('$employeeID', '$name', '$date')";
                $conn->query($sql);
            }
        }

        // Process Clinic Records
        if (isset($_POST['VisitDate'])) {
            foreach ($_POST['VisitDate'] as $index => $visitDate) {
                $visitDate = $conn->real_escape_string($visitDate);
                $complaints = $conn->real_escape_string($_POST['Complaints'][$index]);
                $intervention = $conn->real_escape_string($_POST['Intervention'][$index]);
                $nurse = $conn->real_escape_string($_POST['NurseOnDuty'][$index]);

                $sql = "INSERT INTO SchoolClinicRecord (EmployeeID, VisitDate, Complaints, Intervention, NurseOnDuty)
                        VALUES ('$employeeID', '$visitDate', '$complaints', '$intervention', '$nurse')";
                $conn->query($sql);
            }
        }

        // Save School Clinic Records (if any)
        if (isset($_POST['VisitDate'])) {
            foreach ($_POST['VisitDate'] as $index => $visitDate) {
                $visitDate = $conn->real_escape_string($visitDate);
                $complaints = $conn->real_escape_string($_POST['Complaints'][$index]);
                $intervention = $conn->real_escape_string($_POST['Intervention'][$index]);
                $nurse = $conn->real_escape_string($_POST['NurseOnDuty'][$index]);

                // Insert new clinic record
                $sql = "INSERT INTO SchoolClinicRecord (EmployeeID, VisitDate, Complaints, Intervention, NurseOnDuty)
                        VALUES ('$employeeID', '$visitDate', '$complaints', '$intervention', '$nurse')";
                $conn->query($sql);
            }
        }

        // Redirect to the main menu with a success message
        header("Location: index.php?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>