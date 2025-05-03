<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="styles/add_employee.css">
</head>
<body>
    <div class="container">
        <h1>Add New Employee</h1>
        <form id="employeeForm" method="POST" action="insert_employee.php" enctype="multipart/form-data">
            <h2>BASIC INFORMATION</h2>
            <label for="EmployeeID">EMPLOYEE ID:</label>
            <input type="text" id="EmployeeID" name="EmployeeID" required><br>

            <label for="LastName">LAST NAME:</label>
            <input type="text" id="LastName" name="LastName" required><br>

            <label for="FirstName">FIRST NAME:</label>
            <input type="text" id="FirstName" name="FirstName" required><br>

            <label for="MiddleInitial">MIDDLE INITIAL:</label>
            <input type="text" id="MiddleInitial" name="MiddleInitial"><br>

            <label for="Position">POSITION:</label>
            <input type="text" id="Position" name="Position" required><br>

            <label for="Birthdate">BIRTHDATE:</label>
            <input type="date" id="Birthdate" name="Birthdate" required><br>

            <label for="Age">AGE:</label>
            <input type="number" id="Age" name="Age" readonly><br>

            <label for="Gender">GENDER:</label>
            <select id="Gender" name="Gender" required>
                <option value="Male">MALE</option>
                <option value="Female">FEMALE</option>
                <option value="Other">OTHER</option>
            </select><br>

            <label for="CivilStatus">CIVIL STATUS:</label>
            <input type="text" id="CivilStatus" name="CivilStatus" required><br>

            <label for="Address">COMPLETE ADDRESS:</label>
            <textarea id="Address" name="Address" required></textarea><br>

            <label for="Height">HEIGHT (ft):</label>
            <input type="number" id="Height" name="Height" step="0.01"><br>

            <label for="Weight">WEIGHT (kg):</label>
            <input type="number" id="Weight" name="Weight" step="0.01"><br>

            <label for="FoodAllergies">FOOD ALLERGIES:</label>
            <input type="text" id="FoodAllergies" name="FoodAllergies"><br>

            <label for="ContactNumber">CONTACT NUMBER:</label>
            <input type="text" id="ContactNumber" name="ContactNumber" required><br>

            <label for="EmergencyContactPerson">EMERGENCY CONTACT PERSON:</label>
            <input type="text" id="EmergencyContactPerson" name="EmergencyContactPerson" required><br>

            <label for="EmergencyContactRelationship">RELATIONSHIP:</label>
            <input type="text" id="EmergencyContactRelationship" name="EmergencyContactRelationship" required><br>

            <label for="EmergencyContactNumber">CONTACT NUMBER:</label>
            <input type="text" id="EmergencyContactNumber" name="EmergencyContactNumber" required><br>

            <label for="ProfileImage">PROFILE IMAGE:</label>
            <input type="file" id="ProfileImage" name="ProfileImage" accept="image/*"><br>

            <h2>HEALTH PROFILE</h2>
            <label for="WithComorbidities">WITH COMORBIDITIES (HEALTH PROBLEM):</label>
            <select id="WithComorbidities" name="WithComorbidities" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select><br>

            <div id="ComorbiditiesSection">
                <h4>IF WITH COMORBIDITIES PLEASE FILL OUT BELOW (EX.HYPERTENSION/DIABETES)</h4>
                <button type="button" id="AddComorbidity">Add Comorbidity</button>
                <div id="ComorbiditiesContainer" style="display: none;"></div>
            </div>
            <label for="UnderwentSurgery">HAVE YOU UNDERGONE ANY SURGICAL PROCEDURE (EX. CESAREAN SECTION/TUMOR REMOVAL, ETC):</label>
            <select id="UnderwentSurgery" name="UnderwentSurgery" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select><br>

            <div id="SurgerySection">
                <h3>OPERATIONS</h3>
                <button type="button" id="AddSurgery">Add Operation</button>
                <div id="SurgeryContainer" style="display: none;"></div>
            </div>

            <h2>SCHOOL CLINIC RECORD</h2>
            <button type="button" id="AddClinicRecord">Add Clinic Record</button>
            <div id="ClinicRecordContainer" style="display: none;"></div>

            <button type="submit" name="submit">Submit</button>
        </form>

        <!-- Back button -->
        <a href="index.php" class="back-button">Back to Main Menu</a>
    </div>

    <script src="scripts/add_employee.js"></script>
</body>
</html>

