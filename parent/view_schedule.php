<?php include('./includes/header.php') ?>


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
                        <?php
                        $parent_id = $_SESSION['user_id'];

                        // Prepare the query to fetch the section ID for the current parent
                        $section_id_stmt = $conn->prepare("SELECT section_id FROM students WHERE parent_id = ?");
                        if ($section_id_stmt) {
                            $section_id_stmt->bind_param('i', $parent_id);
                            $section_id_stmt->execute();
                            $section_id_result = $section_id_stmt->get_result();
                            $section_id_row = $section_id_result->fetch_assoc();

                            if ($section_id_row) {
                                $section_id = $section_id_row['section_id'];

                                if ($section_id) {
                                    // Check if image data exists
                                    $sql = "SELECT schedule_image FROM schedules WHERE section_id = ?";
                                    $stmt = $conn->prepare($sql);

                                    if ($stmt) {
                                        $stmt->bind_param('i', $section_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $image_data = $row['schedule_image'];

                                            // Check if image data is present
                                            if ($image_data) {
                                                // Detect MIME type based on the binary image data
                                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                $mime_type = $finfo->buffer($image_data);

                                                // Fallback if MIME type cannot be determined
                                                if (!$mime_type) {
                                                    $mime_type = 'image/jpeg'; // Common fallback for images
                                                }

                                                // Encode the image to base64
                                                $base64_image = base64_encode($image_data);

                                                // Display the image with the correct MIME type and responsive styling
                                                echo "<div style='text-align:center;'>
                                <img src='data:$mime_type;base64,$base64_image' alt='Class Schedule' style='width:80vw; height:auto;' />
                              </div>";
                                            } else {
                                                echo "No image data found for this section.";
                                            }
                                        } else {
                                            echo "No schedule found for this section.";
                                        }

                                        $stmt->close();
                                    } else {
                                        echo "Error preparing statement: " . $conn->error;
                                    }
                                } else {
                                    echo "No section ID found for this parent.";
                                }
                            } else {
                                echo "No section ID found for this parent.";
                            }

                            $section_id_stmt->close();
                        } else {
                            echo "Error preparing section ID statement: " . $conn->error;
                        }


                        ?>
                    </div>
                </div>


            </div>
        </main>

        <?php include("./includes/copy.php") ?>
    </div>
</div>

<?php include('./includes/footer.php') ?>