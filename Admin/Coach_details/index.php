<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';


$sql  = "select coach.* , user.name as user_name From coach inner join user on coach.user_id = user.id";
$show_coach_details = doQuery($sql);



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

            Messages('Dashboard / Coach Details / Index');

            ?>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Coach Data

                <div style="margin-left: 74%; display:inline"><a href="create.php">+ Add New Coach</a> </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($raw = mysqli_fetch_assoc($show_coach_details)) {
                            ?>
                                <tr>
                                    <td><?php echo  ++$i; ?></td>
                                    <td><?php echo $raw['user_name']; ?></td>
                                    <td><?php echo $raw['address']; ?></td>
                                    <td><?php echo $raw['gender']; ?></td>
                                    <td><?php echo $raw['salary']; ?></td>
                                    <td>
                                        <a href='delete.php?id=<?php echo $raw['id']; ?>' class='btn btn-danger m-r-1em'>Delete</a>
                                        <a href='edit.php?id=<?php echo $raw['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
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