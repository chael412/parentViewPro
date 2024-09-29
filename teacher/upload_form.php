<?php include('./includes/header.php') ?>
<?php

// Get teacher ID from the session
$teacher_id = $_SESSION['user_id'];

// Fetch only the section and subject assigned to the teacher
$assignmentQuery = "
    SELECT teacher_assignments.section_id, sections.section_name, teacher_assignments.subject_id, subjects.subject_name
    FROM teacher_assignments
    JOIN sections ON teacher_assignments.section_id = sections.id
    JOIN subjects ON teacher_assignments.subject_id = subjects.id
    WHERE teacher_assignments.teacher_id = ?
";
$stmt = $conn->prepare($assignmentQuery);
$stmt->bind_param('i', $teacher_id);
$stmt->execute();
$assignmentResult = $stmt->get_result();

$assignments = [];
while ($row = $assignmentResult->fetch_assoc()) {
    $assignments[] = $row;
}

// If there's only one assignment, set the default selected section and subject
$default_section_id = count($assignments) == 1 ? $assignments[0]['section_id'] : '';
$default_subject_id = count($assignments) == 1 ? $assignments[0]['subject_id'] : '';
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
                                <h2>Upload Student List</h2>
                                
                                <form action="upload_form.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col">
                                            <!-- Section Selection -->
                                            <label for="section">Select Section:</label>
                                            <select class="form-select" name="section_id" required>
                                                <?php foreach ($assignments as $assignment): ?>
                                                    <option value="<?php echo $assignment['section_id']; ?>" 
                                                        <?php echo ($assignment['section_id'] == $default_section_id) ? 'selected' : ''; ?>>
                                                        <?php echo $assignment['section_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <!-- Subject Selection -->
                                            <label for="subject">Select Subject:</label>
                                            <select  class="form-select" name="subject_id" required>
                                                <?php foreach ($assignments as $assignment): ?>
                                                    <option value="<?php echo $assignment['subject_id']; ?>"
                                                        <?php echo ($assignment['subject_id'] == $default_subject_id) ? 'selected' : ''; ?>>
                                                        <?php echo $assignment['subject_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <!-- CSV File Upload -->
                                            <label for="csv_file">Upload Student List (CSV):</label>
                                            <input class="form-control" type="file" name="csv_file" accept=".csv" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                    

                                    

                                    
                                </form>
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
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $section_id = $_POST['section_id'];
    $subject_id = $_POST['subject_id'];

    // Check if a file was uploaded without error
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');

        // Skip the first row if it contains headers
        fgetcsv($csvFile);

        // Prepare the query to insert student data
        $query = "INSERT INTO students (first_name, middle_name, last_name, section_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Process each row in the CSV file
        while (($row = fgetcsv($csvFile)) !== FALSE) {
            $first_name = $row[1];
            $middle_name = $row[2];
            $last_name = $row[3];

            // Bind the parameters and execute the query
            $stmt->bind_param('sssi', $first_name, $middle_name, $last_name, $section_id);
            $stmt->execute();
        }

        fclose($csvFile);

        // Update all students in the selected section
        $updateQuery = "UPDATE students SET section_id = ? WHERE section_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('ii', $section_id, $default_section_id);
        $updateStmt->execute();

        echo "<script>alert('Importing Successful');</script>";
    } else {
        echo "Error uploading file.";
    }
}
?>
<?php include('./includes/footer.php') ?>