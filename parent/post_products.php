<?php include('./includes/header.php') ?>
<?php

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    $insert_sql = "INSERT INTO products (product_name, price) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sd", $product_name, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully');</script>";
    } else {
        echo "<script>alert('Error adding product: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Fetch all products
$select_sql = "SELECT * FROM products";
$result = $conn->query($select_sql);
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






        <!-- ================= Modal Section ================= -->


        <div class="container-fluid ">
            <div class="row">
                <!-- Sidebar will automatically be included from header.php -->

                <!-- Main content -->
                <div class="col-12 mt-4">
                    <h2>Manage Products</h2>

                    <!-- Button to trigger "Add New Product" modal -->
                    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                        Add New Product
                    </button>

                    <!-- Modal for Adding Product -->
                    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="products.php">
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name:</label>
                                            <input type="text" id="product_name" name="product_name"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price:</label>
                                            <input type="number" step="0.01" id="price" name="price"
                                                class="form-control" required>
                                        </div>
                                        <button type="submit" name="add_product" class="btn btn-primary">Add
                                            Product</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product List Table -->
                    <h3>Product List</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td>
                                            <!-- Button to trigger "Edit Product" modal -->
                                            <button class="btn btn-sm btn-warning edit-product-btn" data-bs-toggle="modal"
                                                data-bs-target="#editProductModal" data-id="<?php echo $row['id']; ?>"
                                                data-name="<?php echo $row['product_name']; ?>"
                                                data-price="<?php echo $row['price']; ?>">
                                                Edit
                                            </button>
                                            <a href="products.php?delete_id=<?php echo $row['id']; ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal for Editing Product -->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="edit_product.php">
                                <input type="hidden" id="edit_product_id" name="product_id">
                                <div class="mb-3">
                                    <label for="edit_product_name" class="form-label">Product Name:</label>
                                    <input type="text" id="edit_product_name" name="product_name" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Price:</label>
                                    <input type="number" step="0.01" id="edit_price" name="price" class="form-control"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include("./includes/copy.php") ?>
        </div>
    </div>
    <script>
        // JavaScript to populate the Edit Product modal with product data
        document.querySelectorAll('.edit-product-btn').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = this.getAttribute('data-price');

                document.getElementById('edit_product_id').value = productId;
                document.getElementById('edit_product_name').value = productName;
                document.getElementById('edit_price').value = productPrice;
            });
        });
    </script>

    <?php include('./includes/footer.php') ?>