<!-- BEGIN FOOTER -->
<?php if ($subscribe=="") { ?>
<div class="footer">
    <div class="content">
        <label for="subscribe_email">Prenumerera på de hetaste finansnyheterna!</label>
        <div class="subscribe">
            <input type="email" id="subscribe_email" name="subscribe_email" class="form-control" placeholder="e-postadress">
            <a class="ok" href="javascript:submit_subscribe()">OK</a>
        </div>
        <img src="<?php echo $imagePath;?>close.png" alt="" class="close">
    </div>
	
</div>
<?php } ?>
<div class="container">
<div id="more-container" class="row margin-top-25 menu visible-lg visible-md visible-sm"  style="padding-left: 5px; padding-right: 5px; display:none;">
<!--                
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-startup_news">
                    <a href="<?php echo $basePath;?>news/startup.html">startup news</a>
                </div>
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
                
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-finansnytt">
                    <a href="<?php echo $basePath;?>news/finansnytt.html">finansnytt</a>
                </div>
                -->
				<?php $lurl = $_SERVER['REQUEST_URI']; $spos = strrpos($lurl, '-'); $spos2 = strrpos($lurl, 'tranet'); if($spos <= 1 && $spos2 < 0){ ?>
				<div class="col-md-12 col-sm-6 col-xs-12 menu-item background-finansnytt">
                    <a class="more-button" href="#">fler nyheter</a>
                </div>
                <?php } ?>
                
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
            </div>
			<div class="row margin-top-25 menu visible-lg visible-md visible-sm" style="padding-left: 5px; padding-right: 5px;">
<!--                
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-startup_news">
                    <a href="<?php echo $basePath;?>news/startup.html">startup news</a>
                </div>
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
                
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-finansnytt">
                    <a href="<?php echo $basePath;?>news/finansnytt.html">finansnytt</a>
                </div>
                -->
				<div class="col-md-12 col-sm-6 col-xs-12 menu-item background-startup_news">
                    <a href="mailto:oliver@investhype.com">Synas pa investhype? Kontakta oss</a>
                </div>
                
                
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
            </div>
			<div class="row margin-top-25 menu toggle opened  visible-xs" style="padding-left: 5px; padding-right: 5px; display: none;">
<!--
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-startup_news">
                    <a href="<?php echo $basePath;?>news/startup.html">startup news</a>
                </div>
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
                
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-finansnytt">
                    <a href="<?php echo $basePath;?>news/finansnytt.html">finansnytt</a>
                </div>
-->
<?php $lurl = $_SERVER['REQUEST_URI']; $spos = strrpos($lurl, '-'); $spos2 = strrpos($lurl, 'tranet'); if($spos <= 1 && $spos2 < 0){ ?>
				<div class="col-md-6 col-sm-6 col-xs-12 menu-item background-mest_hypeat">
                    <a class="more-button" href="#">fler nyheter</a>
                </div>
				<?php } ?>
                <div class="col-md-6 col-sm-6 col-xs-12 menu-item background-emission">
                    <a href="mailto:oliver@investhype.com">Synas pa investhype? Kontakta oss</a>
                </div>
                
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
            </div>
			</div>
			
			<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60843482-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- END FOOTER -->

<input type="hidden" id="basePath" value="<?php echo $basePath; ?>">
<input type="hidden" id="resPath" value="<?php echo $resPath; ?>">
<input type="hidden" id="imagePath" value="<?php echo $imagePath; ?>">

<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo $pluginPath; ?>assets/plugins/respond.min.js"></script>
<script src="<?php echo $pluginPath; ?>assets/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="<?php echo $pluginPath; ?>jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo $pluginPath; ?>jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

<script src="<?php echo $pluginPath; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $pluginPath; ?>bootstrap-validator/js/bootstrapValidator.min.js" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo $scriptPath; ?>common.js?v=2" type="text/javascript"></script>
<script src="<?php echo $scriptPath; ?>layout.js" type="text/javascript"></script>
<script src="<?php echo $scriptPath; ?>back-to-top.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
