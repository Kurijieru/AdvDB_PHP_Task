<?php
// Database credentials
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "form"; // Make sure this matches the database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sport = $_POST['sport'];
    $dob = $_POST['dob'];
    $emergency_contact = $_POST['emergency_contact'];
    $emergency_phone = $_POST['emergency_phone'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO form (name, email, phone, sport, dob, emergency_contact, emergency_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $name, $email, $phone, $sport, $dob, $emergency_contact, $emergency_phone);

    // Execute
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success' role='alert'>Registration successful!</div>";
    } else {
        $message = "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sports Registration</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <!-- Display message if any -->
  <?php if (isset($message)) echo $message; ?>

  <main>
    <div class="container">
      <h2>Sports Registration Form</h2>
      <form action="" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
          <label for="sport" class="form-label">Select Sport</label>
          <select class="form-control" id="sport" name="sport" required>
            <option value="">Select a sport</option>
            <option value="Badminton">Badminton</option>
            <option value="Basketball">Basketball</option>
            <option value="SepakTakraw">SepakTakraw</option>
            <option value="Volleyball">Volleyball</option>
            <!-- Add more sports as needed -->
          </select>
        </div>
        <div class="mb-3">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="mb-3">
          <label for="emergency_contact" class="form-label">Emergency Contact Name</label>
          <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required>
        </div>
        <div class="mb-3">
          <label for="emergency_phone" class="form-label">Emergency Contact Phone</label>
          <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
