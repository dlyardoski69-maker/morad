<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student CRUD</title>
</head>
<body>

<?php
$con = mysqli_connect("127.0.0.1", "root", "", "final");
if (!$con) {
    die("Connection failed");
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS Student (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(30),
    LastName VARCHAR(30),
    age VARCHAR(30)
)";
mysqli_query($con, $sql);

// VARIABLES FOR EDIT
$edit_id = "";
$FirstName = "";
$LastName = "";
$age = "";

// FETCH DATA FOR EDIT
if (isset($_POST['edit'])) {
    $edit_id = $_POST['id'];
    $result = mysqli_query($con, "SELECT * FROM Student WHERE CustomerID=$edit_id");
    $row = mysqli_fetch_assoc($result);

    $FirstName = $row['FirstName'];
    $LastName  = $row['LastName'];
    $age       = $row['age'];
}

// INSERT
if (isset($_POST['submit'])) {
    $FirstName = mysqli_real_escape_string($con, $_POST['FirstName']);
    $LastName  = mysqli_real_escape_string($con, $_POST['LastName']);
    $age       = mysqli_real_escape_string($con, $_POST['age']);

    mysqli_query($con, "INSERT INTO Student (FirstName, LastName, age)
                        VALUES ('$FirstName', '$LastName', '$age')");
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $FirstName = mysqli_real_escape_string($con, $_POST['FirstName']);
    $LastName  = mysqli_real_escape_string($con, $_POST['LastName']);
    $age       = mysqli_real_escape_string($con, $_POST['age']);

    mysqli_query($con, "UPDATE Student 
                        SET FirstName='$FirstName', LastName='$LastName', age='$age'
                        WHERE CustomerID=$id");
}

// DELETE
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    mysqli_query($con, "DELETE FROM Student WHERE CustomerID=$id");
}
?>

<!-- FORM -->
<form method="post">
<table>
    <tr>
        <td>FirstName:</td>
        <td>
            <input type="text" name="FirstName" value="<?php echo $FirstName; ?>" required>
        </td>
    </tr>
    <tr>
        <td>LastName:</td>
        <td>
            <input type="text" name="LastName" value="<?php echo $LastName; ?>" required>
        </td>
    </tr>
    <tr>
        <td>Age:</td>
        <td>
            <input type="text" name="age" value="<?php echo $age; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <?php if ($edit_id == "") { ?>
                <input type="submit" name="submit" value="Submit">
            <?php } else { ?>
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                <input type="submit" name="update" value="Update">
            <?php } ?>
        </td>
    </tr>
</table>
</form>

<hr>

<?php
// DISPLAY DATA
$result = mysqli_query($con, "SELECT * FROM Student");

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['FirstName']}</td>
                <td>{$row['LastName']}</td>
                <td>{$row['age']}</td>

                <td>
                    <form method='post'>
                        <input type='hidden' name='id' value='{$row['CustomerID']}'>
                        <input type='submit' name='edit' value='Edit'>
                    </form>
                </td>

                <td>
                    <form method='post'>
                        <input type='hidden' name='id' value='{$row['CustomerID']}'>
                        <input type='submit' name='delete' value='Delete'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

mysqli_close($con);
?>

</body>
</html>
