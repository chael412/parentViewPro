<?php include('./includes/header.php') ?>
<?php

$sql = "SELECT students.id, students.first_name, students.last_name, students.middle_name, 
               CONCAT(users.first_name, ' ', users.middle_name, ' ', users.last_name) AS parent_name 
        FROM students 
        LEFT JOIN users ON students.parent_id = users.id
        GROUP BY students.first_name, students.last_name, students.middle_name";

$result = $conn->query($sql);
?>



<div class="wrapper">
    <!-- ================= Sidbar Section ================= -->
    <?php include('./includes/sidebar.php') ?>
    <!-- ================= Sidebar Section ================= -->

    <div class="main">
        <!-- ================= Navbar Section ================= -->
        <?php include('./includes/nav.php') ?>
        <!-- ================= Navbar Section ================= -->

        <!-- Add Student Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_student.php" method="POST">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name">
                            </div>
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent ID</label>
                                <input type="text" class="form-control" name="parent_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="update_student.php" method="POST">
                            <input type="hidden" name="student_id" id="edit_student_id">
                            <div class="mb-3">
                                <label for="edit_first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="edit_middle_name" name="middle_name">
                            </div>
                            <div class="mb-3">
                                <label for="edit_parent_id" class="form-label">Parent ID</label>
                                <input type="text" class="form-control" id="edit_parent_id" name="parent_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Students Tables</h1>
                    <!-- <button type="button" id="admin_add" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#adminADD">
                        <i class="align-middle fas fa-fw fa-plus"></i> Add
                    </button> -->


                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Middle Name</th>
                                            <th>Parent</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['first_name']; ?></td>
                                                <td><?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['middle_name']; ?></td>
                                                <td><?php echo $row['parent_name']; ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editStudentModal"
                                                        data-id="<?php echo $row['id']; ?>"
                                                        data-firstname="<?php echo $row['first_name']; ?>"
                                                        data-lastname="<?php echo $row['last_name']; ?>"
                                                        data-middlename="<?php echo $row['middle_name']; ?>">
                                                        Edit
                                                    </button>
                                                    <a href="delete_student.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<script>
    // Script to populate the edit modal
    const editStudentModal = document.getElementById('editStudentModal');
    editStudentModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const firstName = button.getAttribute('data-firstname');
        const lastName = button.getAttribute('data-lastname');
        const middleName = button.getAttribute('data-middlename');

        // Update the modal's content
        const modalTitle = editStudentModal.querySelector('.modal-title');
        const modalBodyInputFirstName = editStudentModal.querySelector('#edit_first_name');
        const modalBodyInputLastName = editStudentModal.querySelector('#edit_last_name');
        const modalBodyInputMiddleName = editStudentModal.querySelector('#edit_middle_name');
        const modalBodyInputId = editStudentModal.querySelector('#edit_student_id');
        const modalBodyInputParentId = editStudentModal.querySelector('#edit_parent_id');

        modalTitle.textContent = 'Edit Student: ' + firstName + ' ' + lastName;
        modalBodyInputFirstName.value = firstName;
        modalBodyInputLastName.value = lastName;
        modalBodyInputMiddleName.value = middleName;
        modalBodyInputId.value = id;
        // Assuming you would also like to edit the parent's ID
    });
</script>
<?php include('./includes/footer.php') ?>