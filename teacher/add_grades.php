<?php include('./includes/header.php') ?>
<style>
    #classSelectionForm {
        display:
            <?php echo ($section_id && $subject_id && $quarter) ? 'none' : 'block'; ?>
        ;
    }

    #selectNewClassButton {
        display:
            <?php echo ($section_id && $subject_id && $quarter) ? 'block' : 'none'; ?>
        ;
    }
</style>

<?php
$teacher_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grades'])) {
    foreach ($_POST['grades'] as $student_id => $grade_data) {
        $grade = $grade_data['grade'];
        $section_id = $_POST['section_id'];
        $subject_id = $_POST['subject_id'];
        $quarter = $_POST['quarter'];

        // Check if the grade already exists in the database
        $check_sql = "SELECT * FROM grades WHERE student_id = '$student_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND quarter = '$quarter'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Update the grade if it exists
            $sql = "UPDATE grades SET grade = '$grade' WHERE student_id = '$student_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND quarter = '$quarter'";
        } else {
            // Insert a new grade if it doesn't exist
            $sql = "INSERT INTO grades (student_id, section_id, subject_id, quarter, grade) VALUES ('$student_id', '$section_id', '$subject_id', '$quarter', '$grade')";
        }

        $conn->query($sql);
    }

    echo "<script>alert('Grades updated successfully');</script>";
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
$students = [];

if ($section_id && $subject_id && $quarter) {
    $students_result = $conn->query("
        SELECT students.id, CONCAT(students.first_name, ' ', students.middle_name, ' ', students.last_name) AS student_name, grades.grade 
        FROM students
        LEFT JOIN grades ON students.id = grades.student_id AND grades.section_id = '$section_id' AND grades.subject_id = '$subject_id' AND grades.quarter = '$quarter'
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
<script>
    function toggleClassSelection() {
        const form = document.getElementById('classSelectionForm');
        const button = document.getElementById('selectNewClassButton');

        if (form.style.display === 'none') {
            form.style.display = 'block';
            button.style.display = 'none';
        } else {
            form.style.display = 'none';
            button.style.display = 'block';
        }
    }
</script>

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
                                <h2>Add Grades</h2>
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Class selection form -->
                                        <div id="classSelectionForm">
                                            <form method="GET" action="add_grades.php">
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
                                                <select class="form-select" name="quarter" id="quarter"
                                                    onchange="this.form.submit()">
                                                    <option value="">--Select Quarter--</option>
                                                    <option value="1" <?php echo ($quarter == '1' ? 'selected' : ''); ?>>
                                                        1st
                                                        Quarter</option>
                                                    <option value="2" <?php echo ($quarter == '2' ? 'selected' : ''); ?>>
                                                        2nd
                                                        Quarter</option>
                                                    <option value="3" <?php echo ($quarter == '3' ? 'selected' : ''); ?>>
                                                        3rd
                                                        Quarter</option>
                                                    <option value="4" <?php echo ($quarter == '4' ? 'selected' : ''); ?>>
                                                        4th
                                                        Quarter</option>
                                                </select>
                                                    </div>
                                                </div>




                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <!-- Select New Class Button -->
                                <!-- <div id="selectNewClassButton">
                                    <button onclick="toggleClassSelection()">Select New Class</button>
                                </div> -->

                                <?php if ($section_id && $subject_id && $quarter) { ?>
                                    <!-- Grade input form -->
                                    <form method="POST"
                                        action="add_grades.php?section_id=<?php echo htmlspecialchars($section_id); ?>&subject_id=<?php echo htmlspecialchars($subject_id); ?>&quarter=<?php echo htmlspecialchars($quarter); ?>">
                                        <input type="hidden" name="section_id"
                                            value="<?php echo htmlspecialchars($section_id); ?>">
                                        <input type="hidden" name="subject_id"
                                            value="<?php echo htmlspecialchars($subject_id); ?>">
                                        <input type="hidden" name="quarter"
                                            value="<?php echo htmlspecialchars($quarter); ?>">

                                        <div style="height: 650px; overflow-x: auto">
                                            <table class="table table-striped table-hover table-bordered">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th style="position:  sticky; top:0; z-index: 1;">Student Name</th>
                                                        <th style="position: sticky; top:0; z-index: 1;">Grade</th>
                                                        <th style="position: sticky; top:0 ; z-index: 1;">Grade Rate</th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php foreach ($students as $student) {
                                                        // If the form is submitted, keep the grade value entered by the user
                                                        $grade_value = isset($_POST['grades'][$student['id']]['grade']) ? $_POST['grades'][$student['id']]['grade'] : $student['grade'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                                            <td>
                                                                <input class="gradeInput" type="text"
                                                                    name="grades[<?php echo htmlspecialchars($student['id']); ?>][grade]"
                                                                    value="<?php echo htmlspecialchars($grade_value); ?>"
                                                                    required onchange="checkGrades()">
                                                            </td>
                                                            <td class="result"></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>

                                        <input type="submit" value="Save All Grades" class="btn btn-primary mt-4">
                                    </form>
                                <?php } else { ?>
                                    <p>Please select a section, subject, and quarter to view and edit grades.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <script>
            function checkGrades() {
                // Get all input elements with class 'gradeInput'
                let gradeInputs = document.getElementsByClassName('gradeInput');

                // Loop through each input element
                for (let i = 0; i < gradeInputs.length; i++) {
                    // Get the grade value from the current input element
                    let grade = gradeInputs[i].value;

                    // Parse the grade as an integer
                    grade = parseInt(grade);

                    // Find the corresponding result cell (assuming it's in the next column or has a class 'result')
                    let resultElement = document.getElementsByClassName('result')[i];

                    // Check if grade is a number and determine pass/fail
                    if (!isNaN(grade)) {
                        if (grade >= 75) {
                            resultElement.textContent = 'Passed';
                        } else {
                            resultElement.textContent = 'Failed';
                        }
                    } else {
                        resultElement.textContent = 'Invalid input';
                    }
                }
            }
        </script>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>