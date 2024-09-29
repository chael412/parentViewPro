<?php include('./includes/header.php') ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    $sql = "INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $description, $event_date);

    if ($stmt->execute()) {
        echo "<script>alert('Event added successfully');</script>";
    } else {
        echo "<script>alert('Error adding event');</script>";
    }

    $stmt->close();
    $conn->close();
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


        <div class="d-flex flex-column min-vh-100">
        <div class="main-content flex-fill">
            <div class="container mt-5">
                <h2>Add Event</h2>
                <form method="POST" action="post_event.php">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Event</button>
                </form>
            </div>
        </div>
        
    </div>
        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>