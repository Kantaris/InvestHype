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
                    <form action="<?php echo $basePath;?>user/signin.html" method="post" role="form">
                        <div class="row margin-bottom-10" style="text-align: center;">
                            <img src="<?php echo $imagePath;?>logo.png">
                        </div>
                        <div class="row">
                            <h2 class="title">Login</h2>
                        </div>

                        <div class="row" style="text-align: center;">
                            <h4 id="msg_alert"><?php echo $message;?></h4>
                        </div>

                        <div class="row margin-bottom-10 form-group">
                            <input type="email" placeholder="Email Address" id="email" name="email" class="form-control" required maxlength="100" value="<?php echo $login_email;?>">
                        </div>
                        <div class="row margin-bottom-20 form-group">
                            <input type="password" placeholder="Password" id="password" name="password" class="form-control" required maxlength="50">
                        </div>

                        <div class="row margin-bottom-10" style="text-align: center;">
                            <button type="submit" style="width: 60%;" class="btn btn-success">Login</button>
                        </div>
                        
                        <div class="row form-group" style="padding: 10px 5px 10px 5px; line-height: 35px; text-align: center;">
<!--                            <a href="javascript:forget_password()" class="menu-button">Forgot Password?</a>
                            <br>-->
                            <a href="<?php echo $basePath;?>user/register.html" class="menu-button">Register</a>
                            <br>
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
        
        <script src="<?php echo $scriptPath; ?>login.js" type="text/javascript"></script>
        
    </body>

    <!-- END BODY -->
</html>
