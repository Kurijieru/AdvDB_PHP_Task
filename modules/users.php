<?php
// DB connection
$host = "localhost";
$dbname = "user_db";
$db_user = "root";
$db_pass = "";

$conn = new mysqli($host, $db_user, $db_pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        // Redirect after deletion
        echo "<script>window.location.href='components-accordion.php?page=users';</script>";
        exit();
    } else {
        $message = "❌ Error deleting user: " . $stmt->error;
    }
    $stmt->close();
}

// Handle form submission (update)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
        $message = "❌ Invalid Gmail address.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $first, $last, $email, $id);

        if ($stmt->execute()) {
            echo "<script>window.location.href='components-accordion.php?page=users';</script>";
            exit();
        } else {
            $message = "❌ Error updating user: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Get all users
$result = $conn->query("SELECT * FROM users");

// Check if editing
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : null;
?>

<h2>Registered Users</h2>

<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<table border="1" cellpadding="10" style="width: 100%; max-width: 900px;">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <?php if ($edit_id === (int)$row['id']): ?>
            <!-- Inline Edit Form -->
            <form method="POST" action="components-accordion.php?page=users&edit=<?= $row['id']; ?>">
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']); ?>" required></td>
                    <td><input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']); ?>" required></td>
                    <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']); ?>" required></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="submit" name="update" value="Save">
                        <a href="components-accordion.php?page=users">Cancel</a>
                    </td>
                </tr>
            </form>
        <?php else: ?>
            <!-- Display Row -->
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['first_name']); ?></td>
                <td><?= htmlspecialchars($row['last_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="components-accordion.php?page=users&edit=<?= $row['id']; ?>">Edit</a> | 
                    <a href="components-accordion.php?page=users&delete=<?= $row['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this user?');"
                       style="color: red;">Delete</a>
                </td>
            </tr>
        <?php endif; ?>
    <?php endwhile; ?>
</table>

<?php $conn->close(); ?>
