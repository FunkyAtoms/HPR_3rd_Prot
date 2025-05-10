<?php
include 'connector.php';

$employeeData = null; // Variable to store fetched employee data

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['EmployeeID'])) {
    $employeeID = $_GET['EmployeeID'];

    // Fetch employee data
    $stmt = $conn->prepare("SELECT * FROM BasicInformation WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $result = $stmt->get_result();
    $employeeData = $result->fetch_assoc();

    if (!$employeeData) {
        echo "Employee not found.";
        exit();
    }

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update employee data
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

    // Update Basic Information
    $sql = "UPDATE BasicInformation 
            SET LastName = ?, FirstName = ?, MiddleInitial = ?, Position = ?, Birthdate = ?, Age = ?, Gender = ?, CivilStatus = ?, Address = ?, Height = ?, Weight = ?, FoodAllergies = ?, ContactNumber = ?, EmergencyContactPerson = ?, EmergencyContactRelationship = ?, EmergencyContactNumber = ?
            WHERE EmployeeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssi",
        $lastName,
        $firstName,
        $middleInitial,
        $position,
        $birthdate,
        $age,
        $gender,
        $civilStatus,
        $address,
        $height,
        $weight,
        $foodAllergies,
        $contactNumber,
        $emergencyContactPerson,
        $emergencyContactRelationship,
        $emergencyContactNumber,
        $employeeID
    );

    if ($stmt->execute()) {
        // Append Comorbidities
        if (isset($_POST['ComorbiditiesDetails'])) {
            foreach ($_POST['ComorbiditiesDetails'] as $index => $details) {
                $details = $conn->real_escape_string($details);
                $medication = $conn->real_escape_string($_POST['MaintenanceMedication'][$index]);
                $dosage = $conn->real_escape_string($_POST['MedicationAndDosage'][$index]);

                $sqlComorbidity = "INSERT INTO Comorbidities (EmployeeID, ComorbiditiesDetails, MaintenanceMedication, MedicationAndDosage)
                                   VALUES ('$employeeID', '$details', '$medication', '$dosage')";
                $conn->query($sqlComorbidity);
            }
        }

        // Append Operations
        if (isset($_POST['Surgeries'])) {
            foreach ($_POST['Surgeries'] as $surgery) {
                $operationName = $conn->real_escape_string($surgery['name']);
                $datePerformed = $conn->real_escape_string($surgery['date']);

                $sqlOperation = "INSERT INTO Operations (EmployeeID, OperationName, DatePerformed) 
                                 VALUES ('$employeeID', '$operationName', '$datePerformed')";
                $conn->query($sqlOperation);
            }
        }

        // Append School Clinic Records
        if (isset($_POST['ClinicRecords'])) {
            foreach ($_POST['ClinicRecords'] as $clinicRecord) {
                $visitDate = $conn->real_escape_string($clinicRecord['visitDate']);
                $complaints = $conn->real_escape_string($clinicRecord['complaints']);
                $intervention = $conn->real_escape_string($clinicRecord['intervention']);
                $nurseOnDuty = $conn->real_escape_string($clinicRecord['nurse']);

                $sqlClinicRecord = "INSERT INTO SchoolClinicRecord (EmployeeID, VisitDate, Complaints, Intervention, NurseOnDuty) 
                                    VALUES ('$employeeID', '$visitDate', '$complaints', '$intervention', '$nurseOnDuty')";
                $conn->query($sqlClinicRecord);
            }
        }

        // Redirect to the main menu with a success message
        header("Location: index.php?success=1");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <link rel="stylesheet" href="styles/global.css"> <!-- Use a global stylesheet for consistency -->
    <link rel="stylesheet" href="styles/update_employee.css">
</head>
<body>
    <div class="container">
    <!-- Step 1: Ask for Employee ID -->
    <?php if (!isset($_GET['EmployeeID']) && !isset($_POST['EmployeeID'])): ?>
        <form method="GET" action="upd_emp.php">
            <label for="EmployeeID">Enter Employee ID:</label>
            <input type="number" id="EmployeeID" name="EmployeeID" required>
            <button type="submit">Search</button>
        </form>
    <?php endif; ?>

    <!-- Step 2: Display Error Message -->
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <form method="GET" action="upd_emp.php">
            <label for="EmployeeID">Enter Employee ID:</label>
            <input type="number" id="EmployeeID" name="EmployeeID" required>
            <button type="submit">Search</button>
        </form>
    <?php endif; ?>

    <!-- Step 3: Display Employee Data for Editing -->
    <?php if (isset($_GET['EmployeeID']) && isset($_GET['data'])): ?>
        <?php $employeeData = json_decode($_GET['data'], true); ?>
        <form id="editEmployeeForm" method="POST" action="upd_emp.php">
            <input type="hidden" name="EmployeeID" value="<?php echo $employeeData['EmployeeID']; ?>">
            <input type="hidden" name="UpdateEmployee" value="1">

            <h2>Basic Information</h2>
            <label for="LastName">Last Name:</label>
            <input type="text" id="LastName" name="LastName" value="<?php echo $employeeData['LastName']; ?>" required><br>

            <label for="FirstName">First Name:</label>
            <input type="text" id="FirstName" name="FirstName" value="<?php echo $employeeData['FirstName']; ?>" required><br>

            <label for="MiddleInitial">Middle Initial:</label>
            <input type="text" id="MiddleInitial" name="MiddleInitial" value="<?php echo $employeeData['MiddleInitial']; ?>"><br>

            <label for="Position">Position:</label>
            <input type="text" id="Position" name="Position" value="<?php echo $employeeData['Position']; ?>" required><br>

            <label for="Birthdate">Birthdate:</label>
            <input type="date" id="Birthdate" name="Birthdate" value="<?php echo $employeeData['Birthdate']; ?>" required><br>

            <label for="Age">Age:</label>
            <input type="number" id="Age" name="Age" value="<?php echo $employeeData['Age']; ?>" readonly><br>

            <label for="Gender">Gender:</label>
            <select id="Gender" name="Gender" required>
                <option value="Male" <?php echo $employeeData['Gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $employeeData['Gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $employeeData['Gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select><br>

            <label for="CivilStatus">Civil Status:</label>
            <input type="text" id="CivilStatus" name="CivilStatus" value="<?php echo $employeeData['CivilStatus']; ?>" required><br>

            <label for="Address">Complete Address:</label>
            <textarea id="Address" name="Address" required><?php echo $employeeData['Address']; ?></textarea><br>

            <label for="Height">Height (ft):</label>
            <input type="number" id="Height" name="Height" value="<?php echo $employeeData['Height']; ?>" step="0.01"><br>

            <label for="Weight">Weight (kg):</label>
            <input type="number" id="Weight" name="Weight" value="<?php echo $employeeData['Weight']; ?>" step="0.01"><br>

            <label for="FoodAllergies">Food Allergies:</label>
            <input type="text" id="FoodAllergies" name="FoodAllergies" value="<?php echo $employeeData['FoodAllergies']; ?>"><br>

            <label for="ContactNumber">Contact Number:</label>
            <input type="text" id="ContactNumber" name="ContactNumber" value="<?php echo $employeeData['ContactNumber']; ?>" required><br>

            <label for="EmergencyContactPerson">Emergency Contact Person:</label>
            <input type="text" id="EmergencyContactPerson" name="EmergencyContactPerson" value="<?php echo $employeeData['EmergencyContactPerson']; ?>" required><br>

            <label for="EmergencyContactRelationship">Emergency Contact Relationship:</label>
            <input type="text" id="EmergencyContactRelationship" name="EmergencyContactRelationship" value="<?php echo $employeeData['EmergencyContactRelationship']; ?>" required><br>

            <label for="EmergencyContactNumber">Emergency Contact Number:</label>
            <input type="text" id="EmergencyContactNumber" name="EmergencyContactNumber" value="<?php echo $employeeData['EmergencyContactNumber']; ?>" required><br>

            <h2>Health Profile</h2>
            <label for="WithComorbidities">With Comorbidities:</label>
            <select id="WithComorbidities" name="WithComorbidities" required>
                <option value="Yes" <?php echo (isset($employeeData['WithComorbidities']) && $employeeData['WithComorbidities'] === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo (isset($employeeData['WithComorbidities']) && $employeeData['WithComorbidities'] === 'No') ? 'selected' : ''; ?>>No</option>
            </select><br>

            <div id="ComorbiditiesSection">
                <h3>Comorbidities</h3>
                <button type="button" id="AddComorbidity">Add Comorbidity</button>
                <div id="ComorbiditiesContainer">
                    <!-- Existing comorbidities will be dynamically added here -->
                </div>
            </div>

            <label for="UnderwentSurgery">Underwent Surgery:</label>
            <select id="UnderwentSurgery" name="UnderwentSurgery" required>
                <option value="Yes" <?php echo (isset($employeeData['UnderwentSurgery']) && $employeeData['UnderwentSurgery'] === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo (isset($employeeData['UnderwentSurgery']) && $employeeData['UnderwentSurgery'] === 'No') ? 'selected' : ''; ?>>No</option>
            </select><br>

            <div id="SurgerySection">
                <h3>Surgeries</h3>
                <button type="button" id="AddSurgery">Add Surgery</button>
                <div id="SurgeryContainer">
                    <!-- Existing surgeries will be dynamically added here -->
                </div>
            </div>

            <h2>School Clinic Record</h2>
            <button type="button" id="AddClinicRecord">Add Clinic Record</button>
            <div id="ClinicRecordContainer">
                <!-- Existing clinic records will be dynamically added here -->
            </div>

            <button type="submit">Update</button>
        </form>
    <?php endif; ?>

    <!-- Back button -->
    <a href="index.php">Back to Main Menu</a>
    <script src="scripts/update_employee.js"></script>
</body>
</html>