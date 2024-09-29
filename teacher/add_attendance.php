<?php include('./includes/header.php') ?>
<?php


$teacher_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section_id = $_POST['section_id'];
    $subject_id = $_POST['subject_id'];
    $date = $_POST['date'];
    $quarter = $_POST['quarter'];
    $student_ids = $_POST['student_ids'];
    $statuses = $_POST['statuses'];

    foreach ($student_ids as $index => $student_id) {
        $status = $statuses[$index];

        $check_sql = "SELECT * FROM attendance WHERE student_id = '$student_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND date = '$date' AND quarter = '$quarter'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $sql = "UPDATE attendance SET status = '$status' WHERE student_id = '$student_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND date = '$date' AND quarter = '$quarter'";
        } else {
            $sql = "INSERT INTO attendance (student_id, section_id, subject_id, date, quarter, status) VALUES ('$student_id', '$section_id', '$subject_id', '$date', '$quarter', '$status')";
        }

        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo "<script>alert('Attendance Saved Successfully');</script>";
}

$assignments_result = $conn->query("
    SELECT teacher_assignments.section_id, sections.section_name, teacher_assignments.subject_id, subjects.subject_name
    FROM teacher_assignments
    JOIN sections ON teacher_assignments.section_id = sections.id
    JOIN subjects ON teacher_assignments.subject_id = subjects.id
    WHERE teacher_assignments.teacher_id = '$teacher_id'
");
if (!$assignments_result) {
    die("Error fetching assignments: " . $conn->error);
}

$assignments = [];
while ($row = $assignments_result->fetch_assoc()) {
    $assignments[] = $row;
}

$section_id = isset($_GET['section_id']) ? $_GET['section_id'] : (isset($_POST['section_id']) ? $_POST['section_id'] : '');
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : (isset($_POST['subject_id']) ? $_POST['subject_id'] : '');
$quarter = isset($_GET['quarter']) ? $_GET['quarter'] : (isset($_POST['quarter']) ? $_POST['quarter'] : '');
$date = isset($_GET['date']) ? $_GET['date'] : (isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'));
$students = [];

if ($section_id && $subject_id && $quarter) {
    $students_result = $conn->query("
        SELECT students.id, CONCAT(students.first_name, ' ', students.middle_name, ' ', students.last_name) AS student_name, attendance.status 
        FROM students
        LEFT JOIN attendance ON students.id = attendance.student_id AND attendance.section_id = '$section_id' AND attendance.subject_id = '$subject_id' AND attendance.date = '$date' AND attendance.quarter = '$quarter'
        WHERE students.section_id = '$section_id'
    ");
    if (!$students_result) {
        die("Error fetching students: " . $conn->error);
    }

    while ($row = $students_result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>



<div class="wrapper">
    <!-- ================= Sidbar Section ================= -->
    <?php include('./includes/sidebar.php') ?>
    <!-- ================= Sidebar Section ================= -->

    <div class="main">
        <!-- ================= Navbar Section ================= -->
        <?php include('./includes/nav.php') ?>
        <!-- ================= Navbar Section ================= -->



        <main class="content">
            <div class="container-fluid p-0">

                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <h2>Add Attendance</h2>

                                <!-- Class Selection Form -->
                                <div id="classSelectionForm">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card">
                                                <form method="GET" action="add_attendance.php">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="section_id">Select Section:</label>
                                                            <select class="form-select" name="section_id" id="section_id"
                                                                onchange="this.form.submit()">
                                                                <option value="">--Select Section--</option>
                                                                <?php foreach ($assignments as $assignment) {
                                                                    echo "<option value='" . $assignment['section_id'] . "'" . ($assignment['section_id'] == $section_id ? ' selected' : '') . ">" . $assignment['section_name'] . "</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <label for="subject_id">Select Subject:</label>
                                                            <select class="form-select" name="subject_id" id="subject_id"
                                                                onchange="this.form.submit()">
                                                                <option value="">--Select Subject--</option>
                                                                <?php foreach ($assignments as $assignment) {
                                                                    echo "<option value='" . $assignment['subject_id'] . "'" . ($assignment['subject_id'] == $subject_id ? ' selected' : '') . ">" . $assignment['subject_name'] . "</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <label for="quarter">Select Quarter:</label>
                                                            <select class="form-select" name="quarter" id="quarter" onchange="this.form.submit()">
                                                                <option value="">--Select Quarter--</option>
                                                                <option value="1" <?php echo ($quarter == '1') ? 'selected' : ''; ?>>
                                                                    Quarter 1</option>
                                                                <option value="2" <?php echo ($quarter == '2') ? 'selected' : ''; ?>>
                                                                    Quarter 2</option>
                                                                <option value="3" <?php echo ($quarter == '3') ? 'selected' : ''; ?>>
                                                                    Quarter 3</option>
                                                                <option value="4" <?php echo ($quarter == '4') ? 'selected' : ''; ?>>
                                                                    Quarter 4</option>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                        <label for="date">Select Date:</label>
                                                    <input class="form-control" type="date" name="date" id="date"
                                                        value="<?php echo htmlspecialchars($date); ?>"
                                                        onchange="this.form.submit()">
                                                        </div>
                                                    </div>



                                                    

                                                    
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <!-- Select New Class Button -->
                                <!-- <button id="newClassButton" onclick="toggleForm()">Select New Class</button> -->

                                <script>
                                    function toggleForm() {
                                        document.getElementById('classSelectionForm').style.display = 'block';
                                        document.getElementById('newClassButton').style.display = 'none';
                                    }
                                </script>

                                <div>
                                    <?php if ($section_id && $subject_id && $quarter) { ?>
                                        <!-- Attendance Form -->
                                        <form method="POST" action="add_attendance.php">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="card">
                                                        <input type="hidden" name="section_id"
                                                            value="<?php echo htmlspecialchars($section_id); ?>">
                                                        <input type="hidden" name="subject_id"
                                                            value="<?php echo htmlspecialchars($subject_id); ?>">
                                                        <input type="hidden" name="date"
                                                            value="<?php echo htmlspecialchars($date); ?>">
                                                        <input type="hidden" name="quarter"
                                                            value="<?php echo htmlspecialchars($quarter); ?>">

                                                        <h3>
                                                            <span>Section:
                                                                <?php echo htmlspecialchars($assignments[array_search($section_id, array_column($assignments, 'section_id'))]['section_name']); ?></span>
                                                            <span>Subject:
                                                                <?php echo htmlspecialchars($assignments[array_search($subject_id, array_column($assignments, 'subject_id'))]['subject_name']); ?>

                                                                <span>Quarter:
                                                                    <?php echo htmlspecialchars($quarter); ?></span>
                                                                <span>Date: <?php echo htmlspecialchars($date); ?></span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col" style="height: 650px; overflow-x: auto">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="table-secondary">
                                                            <tr>
                                                                <th style="position:  sticky; top:0; z-index: 1; width: 80%">Student
                                                                    Name
                                                                </th>
                                                                <th style="position:  sticky; top:0; z-index: 1; width:20%">Status
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <?php foreach ($students as $index => $student) { ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($student['student_name']); ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="student_ids[]"
                                                                        value="<?php echo htmlspecialchars($student['id']); ?>">
                                                                    <select class="form-select" name="statuses[]">
                                                                        <option value="present" <?php echo ($student['status'] == 'present') ? 'selected' : ''; ?>>Present</option>
                                                                        <option value="absent" <?php echo ($student['status'] == 'absent') ? 'selected' : ''; ?>>Absent</option>
                                                                        <option value="late" <?php echo ($student['status'] == 'late') ? 'selected' : ''; ?>>
                                                                            Late</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>

                                            </div>


                                            <button type="submit" class="btn btn-primary mt-3">
                                            <i class="fa-solid fa-plus"></i> Save All Attendance
                                            </button>
                                        </form>
                                    <?php } else { ?>
                                        <p>Please select a section, subject, quarter, and date to view and edit
                                            attendance.</p>
                                    <?php } ?>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>



        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>