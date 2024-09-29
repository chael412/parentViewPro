<?php
require('config/dbcon.php');

$fetch_query = "SELECT *FROM admins";
$result = mysqli_query($conn, $fetch_query);

$i = 1;

if (mysqli_num_rows($result) > 0) {
    foreach ($result as $row) {
        ?>
        <tr>
            <td class="hidden admin_id">
                <?= $row['id'] ?>
            </td>
            <td class="ps-3">
                <?= $i++ ?>
            </td>
            <td class=" ">
                <?= $row['lastname'] ?>
            </td>
            <td class=" ">
                <?= $row['firstname'] ?>
            </td>
            <td class="">
                <?= $row['middlename'] ?>
            </td>
            <td class="">
                <?= $row['username'] ?>
            </td>
            <td class="">
                <button type="button" class="btn btn-primary">
                    Button
                </button>

            </td>
        </tr>
        <?php
    }

} else {
    ?>
    <tr>
        <td colspan="6" class="text-center text-danger">
            <p class="fs-4">No records found!</p>
        </td>
    </tr>

    <?php
}

?>

<style>
    td.hidden {
        display: none;
    }
</style>