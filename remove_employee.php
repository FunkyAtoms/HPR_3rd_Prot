<?php
// filepath: c:\xampp\htdocs\HPR_3\remove_employee.php
include 'connector.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EmployeeID'])) {
    $employeeID = $_POST['EmployeeID'];

    // Delete employee from the database
    $stmt = $conn->prepare("DELETE FROM BasicInformation WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    if ($stmt->execute()) {
        echo "<script>alert('Employee removed successfully.');</script>";
    } else {
        echo "<script>alert('Error removing employee.');</script>";
    }
    $stmt->close();
}

// Fetch all employees
$result = $conn->query("SELECT EmployeeID, FirstName, LastName, Position FROM BasicInformation");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Employee</title>
    <link rel="stylesheet" href="styles/remove_employee.css"> <!-- Use existing styles -->
</head>
<body>
    <div class="container">
        <h1>Remove Employee</h1>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['EmployeeID']; ?></td>
                            <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                            <td><?php echo $row['Position']; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to remove this employee?');">
                                    <input type="hidden" name="EmployeeID" value="<?php echo $row['EmployeeID']; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No employees found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Back Button -->
        <a href="index.php" class="back-button">Back to Main Menu</a>
    </div>
</body>
</html>