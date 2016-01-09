<?php require 'common/variable.php'; ?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <?php require 'common/header2.php'; ?>
    </head>

    <body class="investhype">

        <?php require 'common/topbar.php'; ?>
        
        <div class="content">
            <div class="container">
                
                <div class="row news-detail">
                    <div class="col-md-12 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="news-cover">
<?php 
$image_logo = $news['image'];
if (isset($images) && is_array($images)) { 
     foreach ($images as $row) {
         $image_logo = $row['link'];
         break;
     }
}     
if(strlen($image_logo) < 1){
							$image_logo = 'http://investhype.com/logos/' . $news['sourceId'] . '.jpg';
						}
						else if(strrpos($image_logo,'ot Found') > 0){
							$image_logo = 'http://investhype.com/logos/' . $news['sourceId'] . '.jpg';
						}
    ?>       
                                
<?php if ($image_logo!="") { ?>           
								
                                <img class="background" src="<?php echo $image_logo;?>" alt="">
<?php } ?>                                
                                
                                <div class="title <?php echo $image_logo!='' ? 'image' :  '';?>">
                                    <div class="content">
                                        <span><?php echo $news['title'];?></span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12" style="padding-right: 5px; padding-left: 7px;">
                                <div class="news-content">
                                    <?php echo $news['longText'];?>
                                    
                                    <div class="containx">
    <div class="headx"><span>mer information</span>

    </div>
    <div class="content">
        <?php echo $news['moreText'];?>
    </div>
</div>
                                    <div class="row bolaget">
                                    	<span>mer information om emissionen
                                    	</span>
                                    </div>
                                </div>
								<ul class="share-buttons">
  <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Finvesthype.com&t=" title="Dela på Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/Facebook.png"></a></li>
  <li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Finvesthype.com&text=:%20http%3A%2F%2Finvesthype.com" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/Twitter.png"></a></li>
  <li><a href="https://plus.google.com/share?url=http%3A%2F%2Finvesthype.com" target="_blank" title="Dela på Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/Google.png"></a></li>
  <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Finvesthype.com&title=&summary=&source=http%3A%2F%2Finvesthype.com" target="_blank" title="Dela på LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/LinkedIn.png"></a></li>
</ul>
								
                            </div>
                            
                            <div class="col-md-4 col-sm-12 col-xs-12" style="padding-left: 5px; padding-right: 5px;">
                                <div class="news-extra">
                                    <div class="row bolagsfakta">
                   
										<?php echo $news['sidebar'];?>
                                    </div>
                                    <div class="row bolaget">
                                    	<span>ANM&Auml;L INTRESSE</span>
                                    </div>
                                    <div id="moreinfo" class="row bolagsfakta2">
                                    	<p>Ange din mailadress s&aring; skickar vi mer information!</p>
										<div class="emailbar"><input type="email" id="add_email" name="subscribe_email" class="form-control" placeholder="e-postadress"></div>
            <div class="skicka"><a class="ok" href="javascript:submit_email()">Skicka</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                </div>
                
            </div>
        </div>
        
        <div class="loading">
            <img src="<?php echo $imagePath;?>loader8.gif">
        </div>
        
        <input type="hidden" id="news_id" value="<?php echo $news_id;?>">
        <input type="hidden" id="section" value="<?php echo $section;?>">
        <input type="hidden" id="old_comment" value="<?php echo isset($comment) ? $comment['content'] : ""; ?>">
        
        <form id="frm_detail" name="frm_detail" action="<?php echo $basePath . "nyheter/" . $section;?>">
            
        </form>
        
        <?php require 'common/footer.php'; ?>
        
        <script>
            jQuery(document).ready(function () {
                iDragonIT.init();
				getMarketsAll();
				setInterval(getMarketsAll, 30000);
            });
        </script>
        
        <script src="<?php echo $scriptPath; ?>detail.js" type="text/javascript"></script>
        
    </body>

    <!-- END BODY -->
</html>

