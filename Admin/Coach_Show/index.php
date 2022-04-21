<?php 

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

/////////////Check Privilage Admin Or Receptionist
require '../partials/checkCoach.php'; 

#############################################################
$coach_id = $_SESSION['user']['id'];

$sql  = "select member.* , user.name as user_name  From member inner join user on member.user_id = user.id where member.coach_id = $coach_id ";
$show_member_details = doQuery($sql);

############################################################
//////// call header and navbar
require '../layouts/header.php';
require '../layouts/navbar.php';
?>
<div id="layoutSidenav_content" >

<main>
    <div class="container-fluid">
        <h1 class="mt-4" >  d</h1>
        <ol class="breadcrumb mb-4">
            <?php

            Messages('Data For Coach');

            ?>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Member Data
                <a href="sendFeedback.php" style="margin-left: 80%;font-size:20px;">Send Feedback </a>
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
                                <th>End Subscribe </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>End Subscribe </th>
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
                                    <td><?php echo date('d M Y',$raw['end_subscribe']); ?></td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

</div>

<?php
require '../layouts/footer.php';
?>