<?php include('./includes/header.php') ?>
<?php
$user_id = $_SESSION['user_id'];

$sql_students = "SELECT id, first_name, last_name FROM students WHERE parent_id = ?";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("i", $user_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();
$stmt_students->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $request_type = $_POST['request_type'];

    $insert_sql = "INSERT INTO requests (student_id, request_type) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("is", $student_id, $request_type);

    if ($insert_stmt->execute()) {
        echo "<script>alert('Request successfully');</script>";
    } else {
        echo "Error submitting request: " . $conn->error;
    }

    $insert_stmt->close();
}

$sql_requests = "SELECT r.id, r.request_type, r.request_status, r.request_date, s.first_name, s.last_name
                FROM requests r
                INNER JOIN students s ON r.student_id = s.id
                WHERE s.parent_id = ?";
$stmt_requests = $conn->prepare($sql_requests);
$stmt_requests->bind_param("i", $user_id);
$stmt_requests->execute();
$result_requests = $stmt_requests->get_result();
$stmt_requests->close();
?>


<div class="wrapper">
    <!-- ================= Sidebar Section ================= -->
    <?php include('./includes/sidebar.php') ?>
    <!-- ================= Sidebar Section ================= -->

    <div class="main">
        <!-- ================= Navbar Section ================= -->
        <?php include('./includes/nav.php') ?>
        <!-- ================= Navbar Section ================= -->

        <main class="content">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-6">

                        <h2>Request Form</h2>
                        <form method="POST" action="request.php">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-12 mb-3">
                                            <label for="student_id">Select Student:</label>
                                            <select class="form-select" name="student_id" id="student_id" required>
                                                <?php while ($row = $result_students->fetch_assoc()): ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="request_type">Request Type:</label>
                                            <select class="form-select" name="request_type" id="request_type" required>
                                                <option value="good_moral">Good Moral</option>
                                                <option value="school_card">School Card</option>
                                                <option value="school_card_and_good_moral">School Card and Good Moral
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-12 ">
                                            <input type="submit" value="Submit Request" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>

                            </div>




                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h2>Parent's Requests</h2>
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Request Type</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_requests->num_rows > 0): ?>
                                    <?php while ($row = $result_requests->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                            <td><?php echo ucfirst($row['request_type']); ?></td>
                                            <td><?php echo ucfirst($row['request_status']); ?></td>
                                            <td><?php echo $row['request_date']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No records found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>


            </div>
        </main>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>