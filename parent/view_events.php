<?php include('./includes/header.php') ?>
<?php

$sql = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC";
$result = $conn->query($sql);
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
                        <h2>Upcoming Events</h2>
                        <?php if ($result->num_rows > 0): ?>
                            <ul>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <li>
                                        <h3><?php echo $row['title']; ?></h3>
                                        <p><?php echo $row['description']; ?></p>
                                        <p>Date: <?php echo $row['event_date']; ?></p>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>No upcoming events</p>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </main>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>