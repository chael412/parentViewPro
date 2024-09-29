<?php include('./includes/header.php') ?>
<?php
// Fetching account requests along with the child's name
$sql = "SELECT ar.id, ar.firstname, ar.lastname, ar.middlename, ar.email, s.first_name, s.last_name AS child_name
        FROM account_requests ar
        LEFT JOIN students s ON ar.child_id = s.id
        WHERE ar.status = 'Pending'"; // Add condition for status

$stmt = $conn->prepare($sql);

if (!$stmt) {
    // If prepare fails, output error
    die("SQL Error: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();
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


        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Account Request</h1>
                    <!-- <button type="button" id="admin_add" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#adminADD">
                        <i class="align-middle fas fa-fw fa-plus"></i> Add
                    </button> -->


                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Middle Name</th>
                                            <th>Email</th>
                                            <th>Child's Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            $firstname = $row['first_name'];
                                            $lastname = $row['child_name']; // Ensure child_name is correct
                                            $childname = $lastname . ' ' . $firstname; // Concatenate child's name
                                        
                                            echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['firstname'] . "</td>";
                                            echo "<td>" . $row['lastname'] . "</td>";
                                            echo "<td>" . $row['middlename'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "<td>" . (isset($childname) ? $childname : 'N/A') . "</td>";
                                            echo "<td>
                                <a href='approve.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><i class='fas fa-check'></i> Approve</a> 
                                <a href='reject.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-times'></i> Reject</a>
                              </td>";
                                            echo "</tr>";
                                        }
                                        ?>
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

<?php include('./includes/footer.php') ?>