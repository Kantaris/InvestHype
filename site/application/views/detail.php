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
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="news-cover">
<?php 
$image_logo = $news['localimage'];
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
                                    <p><?php echo $news['summary'];?></p>
                                    <a class="read-more" target="_blank"  href="<?php echo $news['link'];?>">Läs hela artikeln</a>
                                </div>
								<ul class="share-buttons">
  <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Finvesthype.com&t=" title="Dela på Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/Facebook.png"></a></li>
  <li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Finvesthype.com&text=:%20http%3A%2F%2Finvesthype.com" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/Twitter.png"></a></li>
  <li><a href="https://plus.google.com/share?url=http%3A%2F%2Finvesthype.com" target="_blank" title="Dela på Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/Google.png"></a></li>
  <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Finvesthype.com&title=&summary=&source=http%3A%2F%2Finvesthype.com" target="_blank" title="Dela på LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="http://investhype.com/images/flat_web_icon_set/color/LinkedIn.png"></a></li>
</ul>
								<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'invest-hype';
    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
                            </div>
                            
                            <div class="col-md-4 col-sm-12 col-xs-12" style="padding-left: 5px; padding-right: 5px;">
                                <div class="news-extra">
                                    <div class="row bolagsfakta">
                                       <li class="LI_1">
										<div class="DIV_3">Sverige
										</div>
										<div class="DIV_5">
											OMX Stockholm och FirstNorth
										</div>
										</li>
                                       
										<li class="LI_1">
										<div class="DIV_3">
											<i class="updown-icon icon-down-big colorred">&#xe800;</i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, OMX-S, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="updown-icon icon-down-big colorgreen">&#xe801;</i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, FirstNorth, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">USA
										</div>
										<div class="DIV_5">
											Dow Jones, Nasdaq och S&P
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, Dow Jones, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, Nasdaq, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, S&P 500, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">Asien
										</div>
										<div class="DIV_5">
											Nikkei, Shanghai och Hong Kong
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, Nikkei, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, Shanghai, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, Hong Kong, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">Europa
										</div>
										<div class="DIV_5">
											DAX, FTSE och CAC
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, DAX, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, FTSE, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> -0,71%
										</div>
										<div class="DIV_5">
											16.31, CAC 40, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">Råvaror
										</div>
										<div class="DIV_5">
											Dagspriser på viktiga råvaror
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 1 023,56 USD per oz -0,71%
										</div>
										<div class="DIV_5">
											16.31, Guld, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 1 023,56 USD per oz -0,71%
										</div>
										<div class="DIV_5">
											16.31, Silver, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 1 023,56 USD per oz -0,71%
										</div>
										<div class="DIV_5">
											16.31, Koppar, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 1 023,56 USD per oz -0,71%
										</div>
										<div class="DIV_5">
											16.31, Stål, <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 1 023,56 USD per oz -0,71%
										</div>
										<div class="DIV_5">
											16.31, Olja (Brent), <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 1 023,56 USD per oz -0,71%
										</div>
										<div class="DIV_5">
											16.31, Olja (VTI), <span class="SPAN_6">i år +12,58%</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> $1 023,56  -0,71%
										</div>
										<div class="DIV_5">
											16.31, Naturgas, USD per m&#179;, <div class="SPAN_6">i år +12,58%</div>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">Valutor
										</div>
										<div class="DIV_5">
											Värdet av viktiga valutor i svenska kronor.
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, EUR, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, USD, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, GBP, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, DKK, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, NOK, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, CHF, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, JPY, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
										<li class="LI_1">
										<div class="DIV_3">
											<i class="I_4"></i> 8,51 kr -12 öre
										</div>
										<div class="DIV_5">
											16.31, CNY, <span class="SPAN_6">i år +1,34 kr</span>
										</div>
										</li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding-left: 5px; padding-right: 5px;">
                        <div class="news-comment" id="news_list">
                            
<?php if ($front_userid!="") { ?>                            
                            <div class="row">
                                <div class="info">
                                    <a href="#" class="author"><?php echo $user['name'];?><?php if (isset($comment)){ ?><span class="symbol">@</span><span class="source"><?php echo $comment['screen'];?></span><?php } ?>                                    </a>
                                    <span class="time"><?php echo isset($comment) ? $comment['time'] : "Now";?></span>
                                </div>
                                
                                <textarea id="txt_comment" class="form-control" style="height: 150px;"></textarea>
                                <button type="button" class="btn btn-warning comment"><?php echo isset($comment) ? "Update Comment" : "Submit Comment"; ?></button>
                            </div>
<?php } ?>                            

                        </div>
                    </div>
                </div>
                
            </div>
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

