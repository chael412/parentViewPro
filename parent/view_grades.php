<?php include('./includes/header.php') ?>
<?php

$parent_id = $_SESSION['user_id'];

$children_result = $conn->query("SELECT id, first_name, middle_name, last_name FROM students WHERE parent_id='$parent_id'");
$children = [];
while ($row = $children_result->fetch_assoc()) {
    $children[] = $row;
}

$grades = [];
$attendance = [];

foreach ($children as $child) {
    $student_id = $child['id'];

    $grades_result = $conn->query("SELECT subjects.subject_name, grades.grade, grades.quarter FROM grades JOIN subjects ON grades.subject_id = subjects.id WHERE grades.student_id='$student_id'");
    while ($row = $grades_result->fetch_assoc()) {
        $grades[$student_id][] = $row;
    }

    $attendance_result = $conn->query("SELECT subjects.subject_name, attendance.date, attendance.status FROM attendance JOIN subjects ON attendance.subject_id = subjects.id WHERE attendance.student_id='$student_id'");
    while ($row = $attendance_result->fetch_assoc()) {
        $attendance[$student_id][] = $row;
    }
}
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
                <div class="row">
                    <div class="col">
                        <h2>Parent Dashboard</h2>

                        <?php foreach ($children as $child) { ?>
                            <h3><?php echo htmlspecialchars($child['first_name'] . ' ' . $child['middle_name'] . ' ' . $child['last_name']); ?>
                            </h3>

                            <h4>Grades</h4>
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Subject</th>
                                        <th>Quarter</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($grades[$child['id']])) {
                                        foreach ($grades[$child['id']] as $grade) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                                <td><?php echo htmlspecialchars($grade['quarter']); ?></td>
                                                <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="3">No grades available</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <h4>Attendance</h4>
                            <table class="table table-striped table-hover table-bordered ">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($attendance[$child['id']])) {
                                        foreach ($attendance[$child['id']] as $record) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($record['subject_name']); ?></td>
                                                <td><?php echo htmlspecialchars($record['date']); ?></td>
                                                <td><?php echo htmlspecialchars($record['status']); ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="3">No attendance records available</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>


            </div>
        </main>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>