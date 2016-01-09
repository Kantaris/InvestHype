<?php require 'common/variable.php'; ?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <?php require 'common/header.php'; ?>
    </head>

    <body class="">

        <div class="content">
            <div class="container">
                <div class="row register-box">
                    <form action="<?php echo $basePath;?>user/update_profile.html" method="post" role="form">
                        <div class="row margin-bottom-10" style="text-align: center;">
                            <img src="<?php echo $imagePath;?>logo.png">
                        </div>
                        <div class="row">
                            <h2 class="title">My Profile</h2>
                        </div>

                        <div class="row" style="text-align: center;">
                            <h4 id="msg_alert"><?php echo $message;?></h4>
                        </div>

                        <div class="row margin-bottom-10 form-group">
                            <input type="email" placeholder="Email Address" id="email" name="email" class="form-control" required maxlength="100" value="<?php echo $account['email'];?>">
                        </div>
                        <div class="row margin-bottom-10 form-group">
                            <input type="text" placeholder="Username" id="username" name="username" class="form-control" required maxlength="200" value="<?php echo $account['name'];?>">
                        </div>
                        <div class="row margin-bottom-10 form-group">
                            <input type="password" placeholder="Old Password" id="password1" name="password1" class="form-control" required maxlength="50">
                        </div>
                        <div class="row margin-bottom-10 form-group">
                            <input type="password" placeholder="New Password" id="password" name="password" class="form-control" required maxlength="50">
                        </div>
                        <div class="row margin-bottom-20 form-group">
                            <input type="password" placeholder="Confirm Password" id="password2" name="password2" class="form-control" required maxlength="50">
                        </div>
                        
<!--                        <div class="row margin-bottom-20 form-group subscribe" style="text-align: center; cursor: pointer;">
                            <i class="subscribe fa <?php echo $user_subscribe!="" ? "fa-check-square-o" : "fa-square-o"; ?>" id="subscribe" name="subscribe"></i>
                            <label for="subscribe" style="cursor: pointer;">Subscribe</label>
                        </div>-->

                        <div class="row margin-bottom-10" style="text-align: center;">
                            <button type="submit" style="width: 75%;" class="btn btn-success">Update Account</button>
                        </div>
                        
                        <div class="row form-group" style="padding: 10px 5px 10px 5px; line-height: 35px; text-align: center;">
                            <a href="<?php echo $basePath;?>welcome/index.html" class="menu-button">Back to Home</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <form id="frm_home" name="frm_home" action="<?php echo $basePath . "news/mest_hypeat";?>.html" method="get">
        </form>
        
        <?php $subscribe="subscribe";  ?>
        <?php require 'common/footer.php'; ?>
        
        <script>
            jQuery(document).ready(function () {
                iDragonIT.init();
            });
        </script>
        
        <script src="<?php echo $scriptPath; ?>profile.js" type="text/javascript"></script>
        
    </body>

    <!-- END BODY -->
</html>
