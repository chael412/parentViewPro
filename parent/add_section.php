<?php include('./includes/header.php') ?>
<?php

$section_name = "";
$id = 0;
$update = false;

if (isset($_POST['save'])) {
    $section_name = $_POST['section_name'];
    $stmt = $conn->prepare("INSERT INTO sections (section_name) VALUES (?)");
    $stmt->bind_param("s", $section_name);
    $stmt->execute();
    $stmt->close();
    header('location: section.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM sections WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('location: section.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM sections WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $section_name = $row['section_name'];
        $update = true;
    }
    $stmt->close();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $section_name = $_POST['section_name'];
    $stmt = $conn->prepare("UPDATE sections SET section_name=? WHERE id=?");
    $stmt->bind_param("si", $section_name, $id);
    $stmt->execute();
    $stmt->close();
    header('location: section.php');
}

$result = $conn->query("SELECT * FROM sections") or die($conn->error);
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
                <h1 class="text-center">Manage Sections</h1>
                <div class="row justify-content-center">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <form action="section.php" method="POST">

                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <div>
                                        <label>Section Name</label>
                                        <input class="form-control" type="text" name="section_name" value="<?php echo $section_name; ?>"
                                            required>
                                    </div>
                                    <div class="mt-3">
                                        <?php if ($update): ?>
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        <?php else: ?>
                                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                                        <?php endif; ?>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Account Request</h1>
                    <!-- <button type="button" id="admin_add" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
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
                                            <th>Section Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['section_name']; ?></td>
                                                <td>
                                                    <a href="section.php?edit=<?php echo $row['id']; ?>">Edit</a>
                                                    <a href="section.php?delete=<?php echo $row['id']; ?>"
                                                        onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
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