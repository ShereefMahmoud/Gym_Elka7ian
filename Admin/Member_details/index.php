<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

/////////////Check Privilage Admin Or Receptionist
require '../partials/checkManagerOrReceptionOrCoach.php'; 

############################################################


$sql  = "select member.* , user.name as user_name , subscribe.type as sub_type From member inner join user on member.user_id = user.id  inner join subscribe on member.subscribe_id = subscribe.id";
$show_member_details = doQuery($sql);



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

            Messages('Dashboard / Member Details / Index');

            ?>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Member Data
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
                                <th>Type Of Subscribe </th>
                                <th>Start Subscribe </th>
                                <th>End Subscribe </th>
                                <th>Active </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Type Of Subscribe </th>
                                <th>Start Subscribe </th>
                                <th>End Subscribe </th>
                                <th>Active </th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($raw = mysqli_fetch_assoc($show_member_details)) {
                            ?>
                                <tr>
                                    <td><?php echo  ++$i; ?></td>
                                    <td><?php echo $raw['user_name']; ?></td>
                                    <td><?php echo $raw['address']; ?></td>
                                    <td><?php echo $raw['gender']; ?></td>
                                    <td><?php echo $raw['sub_type']; ?></td>
                                    <td><?php echo $raw['start_subscribe']; ?></td>
                                    <td><?php echo $raw['end_subscribe']; ?></td>
                                    <td><?php echo $raw['active']; ?></td>
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