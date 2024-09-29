<?php include('./includes/header.php') ?>
<?php

if (isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['new_status'];
    $admin_notes = $_POST['admin_notes'];

    $update_sql = "UPDATE requests SET request_status=?, admin_notes=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $new_status, $admin_notes, $request_id);

    if ($stmt->execute()) {
        echo "<script>alert('Update successfully');</script>";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

$sql = "SELECT r.id, s.first_name, s.last_name, r.request_type, r.request_status, r.request_date, r.admin_notes
        FROM requests r
        INNER JOIN students s ON r.student_id = s.id
        ORDER BY r.request_date DESC";
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


    <div class="container main-content">
        <h2 class="mt-4">Manage Requests</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Student Name</th>
                    <th>Request Type</th>
                    <th>Status</th>
                    <th>Request Date</th>
                    <th>Admin Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $row['request_type']))); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['request_status'])); ?></td>
                        <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['admin_notes']); ?></td>
                        <td>
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <select name="new_status" class="form-select mb-2">
                                    <option value="pending" <?php echo ($row['request_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo ($row['request_status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="declined" <?php echo ($row['request_status'] == 'declined') ? 'selected' : ''; ?>>Declined</option>
                                </select>
                                <textarea name="admin_notes" class="form-control mb-2" rows="2" placeholder="Admin Notes"><?php echo htmlspecialchars($row['admin_notes']); ?></textarea>
                                <input type="submit" name="update_status" class="btn btn-primary btn-sm" value="Update Status">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>