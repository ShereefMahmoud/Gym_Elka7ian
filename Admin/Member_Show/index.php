<?php 

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

/////////////Check Privilage Admin Or Receptionist
require '../partials/checkMember.php'; 

#############################################################
$member_id = $_SESSION['user']['id'];

$sql  = "select member.* , user.name as user_name  From member inner join user on member.user_id = user.id where user.id = $member_id ";
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

            Messages('Data For Member');

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
                                <th>Your Name</th>
                                <th>Start Subscribe</th>
                                <th>End Subscribe </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($raw = mysqli_fetch_assoc($show_member_details)) {
                            ?>
                                <tr>
                                    <td><?php echo $raw['user_name']; ?></td>
                                    <td><?php echo date('d M Y',$raw['start_subscribe']); ?></td>
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