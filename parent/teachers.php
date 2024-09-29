<?php include('./includes/header.php') ?>
<?php


// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}


// Handle form submission for assigning teachers
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_POST['teacher_id'];
    $section_id = $_POST['section_id'];
    $subject_id = $_POST['subject_id'];

    // Insert into the database
    $sql = "INSERT INTO teacher_assignments (teacher_id, section_id, subject_id) VALUES ('$teacher_id', '$section_id', '$subject_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher assigned successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch teachers, sections, and subjects from the database
$teachers_result = $conn->query("SELECT id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS teacher_name FROM users WHERE role='teacher'");
$teachers = [];
while ($row = $teachers_result->fetch_assoc()) {
    $teachers[] = $row;
}

$sections_result = $conn->query("SELECT id, section_name FROM sections");
$sections = [];
while ($row = $sections_result->fetch_assoc()) {
    $sections[] = $row;
}

$subjects_result = $conn->query("SELECT id, subject_name FROM subjects");
$subjects = [];
while ($row = $subjects_result->fetch_assoc()) {
    $subjects[] = $row;
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

                <div class="mb-3">
                    <h2>Assign Teacher to Section and Subject</h2>
                    <!-- <button type="button" id="admin_add" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#adminADD">
                        <i class="align-middle fas fa-fw fa-plus"></i> Add
                    </button> -->


                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-body">
                                <form method="POST" action="teachers.php">
                                    <div class="mb-3">
                                        <label for="teacher_id" class="form-label">Teacher</label>
                                        <select name="teacher_id" class="form-select" required>
                                            <option value="">-- Select Teacher --</option>
                                            <?php foreach ($teachers as $teacher) {
                                                echo "<option value='" . $teacher['id'] . "'>" . $teacher['teacher_name'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="section_id" class="form-label">Section</label>
                                        <select name="section_id" class="form-select" required>
                                            <option value="">-- Select Section --</option>
                                            <?php foreach ($sections as $section) {
                                                echo "<option value='" . $section['id'] . "'>" . $section['section_name'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">Subject</label>
                                        <select name="subject_id" class="form-select" required>
                                            <option value="">-- Select Subject --</option>
                                            <?php foreach ($subjects as $subject) {
                                                echo "<option value='" . $subject['id'] . "'>" . $subject['subject_name'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Assign</button>
                                </form>
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