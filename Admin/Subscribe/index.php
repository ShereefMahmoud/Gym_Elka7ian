<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

///////// Check Privilage If Admin
require '../partials/checkManager.php';
########################################################################

$sql  = "select * From subscribe";
$show = doQuery($sql);



############################################################
//////// call header and navbar
require '../layouts/header.php';
require '../layouts/navbar.php';
require '../layouts/sidebar.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <?php
            # Print Messages .... 
            Messages('Dashboard / Subscribe / Index');
            ?>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Subscribes Data

                <div style="margin-left: 70%; display:inline"><a href="create.php">+ Add New Subscribe</a> </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_assoc($show)) {
                            ?>
                                <tr>
                                    <td><?php echo  ++$i; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td>
                                        <a href='delete.php?id=<?php echo $row['id']; ?>' class='btn btn-danger m-r-1em'>Delete</a>
                                        <a href='edit.php?id=<?php echo $row['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>









<?php
require '../layouts/footer.php';
?>