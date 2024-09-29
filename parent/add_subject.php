<?php include('./includes/header.php') ?>
<?php

function fetchSubjects($conn) {
    $sql = "SELECT * FROM subjects";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function addSubject($conn, $subject_name) {
    $subject_name = mysqli_real_escape_string($conn, $subject_name);
    $sql = "INSERT INTO subjects (subject_name) VALUES ('$subject_name')";
    return mysqli_query($conn, $sql);
}

function updateSubject($conn, $id, $subject_name) {
    $id = intval($id);
    $subject_name = mysqli_real_escape_string($conn, $subject_name);
    $sql = "UPDATE subjects SET subject_name='$subject_name' WHERE id=$id";
    return mysqli_query($conn, $sql);
}

function deleteSubject($conn, $id) {
    $id = intval($id);
    $sql = "DELETE FROM subjects WHERE id=$id";
    return mysqli_query($conn, $sql);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        addSubject($conn, $_POST['subject_name']);
        header('Location: add_subject.php'); // Redirect to prevent resubmission
        exit;
    } elseif (isset($_POST['update'])) {
        updateSubject($conn, $_POST['id'], $_POST['subject_name']);
        header('Location: add_subject.php'); // Redirect to prevent resubmission
        exit;
    } elseif (isset($_POST['delete'])) {
        deleteSubject($conn, $_POST['id']);
        header('Location: add_subject.php'); // Redirect to prevent resubmission
        exit;
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

        <!-- ================= Modal Section ================= -->

        <div class="modal fade" id="adminADD" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="adminFormAdd">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="fname">First Name</label>
                                <input class="form-control form-control-sm fname" id="fname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mname">Middle Name</label>
                                <input class="form-control form-control-sm mname" id="mname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="lname">Last Name</label>
                                <input class="form-control form-control-sm lname" id="lname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">UserName</label>
                                <input class="form-control form-control-sm username" id="username" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control form-control-sm password" id="password" type="text" />
                            </div>
                            <div class="mb-5 float-end">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="admin_add" class="btn btn-primary">
                                    <i class="align-middle me-2 fas fa-fw fa-save"></i>Save
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adminVIEW" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="staticBackdropLabel">Admin View</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="adminFormAdd">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="fname">First Name</label>
                                <input class="form-control form-control-sm fname" id="fname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mname">Middle Name</label>
                                <input class="form-control form-control-sm mname" id="mname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="lname">Last Name</label>
                                <input class="form-control form-control-sm lname" id="lname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">UserName</label>
                                <input class="form-control form-control-sm username" id="username" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control form-control-sm password" id="password" type="text" />
                            </div>
                            <div class="mb-5 float-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adminEDIT" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="staticBackdropLabel">Admin Edit</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="adminFormAdd">
                        <div class="modal-body">
                            <input class="form-control form-control-sm fname" id="aID" type="text" />
                            <div class="mb-3">
                                <label class="form-label" for="fname">First Name</label>
                                <input class="form-control form-control-sm fname" id="fname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mname">Middle Name</label>
                                <input class="form-control form-control-sm mname" id="mname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="lname">Last Name</label>
                                <input class="form-control form-control-sm lname" id="lname" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">UserName</label>
                                <input class="form-control form-control-sm username" id="username" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control form-control-sm password" id="password" type="text" />
                            </div>
                            <div class="mb-5 float-end">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="admin_update" class="btn btn-primary">
                                    <i class="align-middle me-2 fas fa-fw fa-save"></i>Update
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adminDELETE" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-3 text-light" id="staticBackdropLabel">Admin Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="adminFormDel">
                        <div class="modal-body">
                            <input class="form-control form-control-sm admin-id" id="aID" type="hidden" />
                            <div class="mb-3">
                                <h4>Are you sure you want to delete?</h4>

                                <!-- <div id="adminDetails">
                                    
                                </div> -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="admin_delete" class="btn btn-primary">
                                <i class="align-middle me-2 fas fa-fw fa-trash-alt"></i>Remove
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <!-- ================= Modal Section ================= -->


        <div class="main-content">
    <h2>Add New Subject</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#subjectModal">
        Add New Subject
    </button>

    <!-- Subjects Table -->
    <h2>Subjects List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subject Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = fetchSubjects($conn);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['subject_name']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#subjectModal' 
                                onclick='editSubject({$row['id']}, \"{$row['subject_name']}\")'>Edit</button>
                                <form method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' name='delete' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this subject? Note: This will fail if there are related records in the attendance table.')\">Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No subjects found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for adding/editing subjects -->
<div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subjectModalLabel">Add New Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subjectForm" method="POST">
                    <input type="hidden" name="id" id="subjectId">
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" name="subject_name" id="subjectName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="add" class="btn btn-primary">Add Subject</button>
                        <button type="submit" name="update" class="btn btn-warning" style="display:none;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


        <?php include("./includes/copy.php") ?>
    </div>
</div>
<script>
    function editSubject(id, name) {
        // Set the values in the modal
        document.getElementById('subjectId').value = id;
        document.getElementById('subjectName').value = name;

        // Change the button to "Update"
        const updateButton = document.querySelector('button[name="update"]');
        updateButton.style.display = 'inline-block';

        // Change the button to "Add Subject"
        const addButton = document.querySelector('button[name="add"]');
        addButton.style.display = 'none';

        // Set modal title
        document.getElementById('subjectModalLabel').innerText = "Edit Subject";
    }

    // Reset the modal when closed
    document.getElementById('subjectModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('subjectForm').reset();
        document.querySelector('button[name="add"]').style.display = 'inline-block';
        document.querySelector('button[name="update"]').style.display = 'none';
        document.getElementById('subjectModalLabel').innerText = "Add New Subject";
    });
</script>

<?php include('./includes/footer.php') ?>