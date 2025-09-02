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

$sql = "SELECT id, name, email, phone, sport, dob, emergency_contact, emergency_phone FROM form";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if there are any results
if (mysqli_num_rows($result) == 0) {
    echo "No results found.";
} else {
    ?>
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Student List</h5>

              <!-- Dark Table -->
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th>ID</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Select Sport</th>
                <th>Date of Birth</th>
                <th>Emergency Contact Name</th>
                <th>Emergency Contact Number</th>               
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']?></td> 
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['sport']?></td>
                <td><?php echo $row['dob']?></td>
                <td><?php echo $row['emergency_contact']?></td>
                <td><?php echo $row['emergency_phone']?></td>
            </tr>
            <?php } ?>
                </tbody>
              </table>
              <!-- End Dark Table -->

            </div>
          </div>
    
<?php } ?>