<!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="active"><a href="<?php echo base_url('front'); ?>">Home</a></li>
                <?php if($this->session->userdata('id_user')){ ?>
                <li><a href="<?php echo base_url('history'); ?>">History</a></li>
                <li><a href="<?php echo base_url('complaint'); ?>">Complaint</a></li>
                <?php } ?>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->