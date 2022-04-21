
<div id="layoutSidenav">
<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="<?php echo url(''); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            
                            <?php
                            if($_SESSION['user']['role'] == 'manager'){
                            $modules = ["Role" ,"User" , "Coach_details" , "Member_details" , "Feedback" ,"Subscribe"];
                            }elseif($_SESSION['user']['role'] == 'reception'){
                            $modules = [ "User" , "Coach_details","Member_details" ];
                            }

                            foreach($modules as $key => $value){
                            
                            ?>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts<?php echo $key?>" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Manage <?php echo $value ; ?>
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts<?php echo $key?>" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo url($value."/create.php"); ?>">Create <?php echo $value ?></a>
                                    <a class="nav-link" href="<?php echo url($value."/"); ?>">Display <?php echo $value ?></a>
                    
                                </nav>
                            </div>

                            <?php } ?>
                            
                        </div>
                    </div>


                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['user']['name']; ?>
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
