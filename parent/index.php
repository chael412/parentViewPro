<?php include('./includes/header.php') ?>
<?php

$parent_id = $_SESSION['user_id'];
$sql = "SELECT s.id, s.first_name, s.last_name, s.middle_name
        FROM students s
        JOIN users u ON s.parent_id = u.id
        WHERE u.id = '$parent_id'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();
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
                        <h1>Welcome, Parent of
                            <?php echo $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']; ?>
                        </h1>
                    </div>
                </div>


            </div>
        </main>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>