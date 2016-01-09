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

    <body class="investhype">

        <?php require 'common/topbar.php'; ?>
        
        <div class="content">
            <div class="container">
		
                 <div id="mainlist" class="row news-list news-list-large">
				 <?php
					$json = file_get_contents('http://api.chrispersson.com/nyheter.ashx?from=0&to=14');
					$obj = json_decode($json);
					$index = 0;
					
                    
					foreach($obj as $mydata)
					{
						$desc = $mydata->description;
						$img = $mydata->localimage;
						if(strlen($img) < 1){
							$img = 'logos/' . $mydata->source_id . '.jpg';
						}
						else if(strrpos($img,'ot Found') > 0){
							$img = 'logos/' . $mydata->source_id . '.jpg';
						}
						$html = '';
						if ($index%7==0 || $index%7==6) {
							
							if($mydata->category_id > 1){
								$html = $html . '<div class="col-md-6 col-sm-12 col-xs-12 news-container" data-id="http://investhype.com' . $mydata->url . '">';
							$html = $html . '<div class="news news-large">';
							$html = $html . '<img class="background" src="' . $imagePath . 'blank-large.jpg" alt="">';
							$html = $html . '<a href="http://investhype.com' . $mydata->url . '"><img class="logo" src="" alt="" style="background: url(\'' . $img . '\') no-repeat center center; background-size: cover;"></a>';
                            $html = $html . '<div class="section ' . $mydata->title_background . '">';
                            $html = $html . '<span>' . $mydata->category_name . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="title">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<span>' . $mydata->title . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="info">';
                            $html = $html . '<div class="source">' . $mydata->source_name . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
							}
							else{
							$html = $html . '<div class="col-md-6 col-sm-12 col-xs-12 news-container" data-id="http://investhype.com/nyheter' . $mydata->url . '">';
							$html = $html . '<div class="news news-large">';
							$html = $html . '<img class="background" src="' . $imagePath . 'blank-large.jpg" alt="">';
							$html = $html . '<a href="http://investhype.com/nyheter' . $mydata->url . '"><img class="logo" src="" alt="" style="background: url(\'' . $img . '\') no-repeat center center; background-size: cover;"></a>';
                            $html = $html . '<div class="section ' . $mydata->title_background . '">';
                            $html = $html . '<span>' . $mydata->category_name . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="title">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<span>' . $mydata->title . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="info">';
                            $html = $html . '<div class="social">HYPE ' . $mydata->hyped . '</div>';
                            $html = $html . '<div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/nyheter' . $mydata->url . '">0 </span><i class="updown-icon icon-down-big">&#xe802;</i></div>';
                            $html = $html . '<div class="source">' . $mydata->source_name . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
							}
							
						}
						else if ($index%7==1 || $index%7==4 || $index%7==5) {
							if($mydata->category_id > 1){
							$html = $html . '<div class="col-md-3 col-sm-6 col-xs-12 news-container" data-id="http://investhype.com' . $mydata->url . '">';
                            $html = $html . '<div class="news news-medium">';
                            $html = $html . '<img class="background" src="' . $imagePath . 'blank-medium.jpg" alt="">';	
                            $html = $html . '<img class="background2" src="' . $imagePath . 'blank-small.jpg" alt="">';
                            $html = $html . '<a href="http://investhype.com' . $mydata->url . '"><img class="logo" src="" alt="" style="background: url(\'' . $img . '\') no-repeat center center; background-size: cover;"></a>';
                            $html = $html . '<div class="section ' . $mydata->title_background . '">';
                            $html = $html . '<span>' . $mydata->category_name . '</span>';
                            $html = $html . '</div>';
							$html = $html . '<div class="title">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<span>' . $mydata->title . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="desc">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<div>'. $desc . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="info">';
                            $html = $html . '<div class="source">' . $mydata->source_name . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
							}
							else{
							$html = $html . '<div class="col-md-3 col-sm-6 col-xs-12 news-container" data-id="http://investhype.com/nyheter' . $mydata->url . '">';
                            $html = $html . '<div class="news news-medium">';
                            $html = $html . '<img class="background" src="' . $imagePath . 'blank-medium.jpg" alt="">';	
                            $html = $html . '<img class="background2" src="' . $imagePath . 'blank-small.jpg" alt="">';
                            $html = $html . '<a href="http://investhype.com/nyheter' . $mydata->url . '"><img class="logo" src="" alt="" style="background: url(\'' . $img . '\') no-repeat center center; background-size: cover;"></a>';
                            $html = $html . '<div class="section ' . $mydata->title_background . '">';
                            $html = $html . '<span>' . $mydata->category_name . '</span>';
                            $html = $html . '</div>';
							$html = $html . '<div class="title">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<span>' . $mydata->title . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="desc">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<div>'. $desc . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="info">';
                            $html = $html . '<div class="social">HYPE '. $mydata->hyped . '</div>';
                            $html = $html . '<div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/nyheter' . $mydata->url . '">0 </span><i class="updown-icon icon-down-big">&#xe802;</i></div>';
                            $html = $html . '<div class="source">' . $mydata->source_name . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
							}
						} 
						else {
							$html = $html . '<div class="col-md-3 col-sm-6 col-xs-12 news-container" data-id="http://investhype.com/nyheter' . $mydata->url .'">';
                            $html = $html . '<div class="news news-small">';
                            $html = $html . '<img class="background" src="' . $imagePath . 'blank-small.jpg" alt="">';
                            $html = $html . '<a href="http://investhype.com/nyheter' . $mydata->url . '"><img class="logo" src="" alt="" style="background: url(\'' . $img . '\') no-repeat center center; background-size: cover;"></a>';
                            $html = $html . '<div class="section ' . $mydata->title_background . '">';
                            $html = $html . '<span>' . $mydata->category_name . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="title">';
                            $html = $html . '<div class="content">';
                            $html = $html . '<span>' . $mydata->title . '</span>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '<div class="info">';
                            $html = $html . '<div class="social">HYPE ' . $mydata->hyped . '</div>';
                            $html = $html . '<div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/nyheter' . $mydata->url . '">0 </span><i class="updown-icon icon-down-big">&#xe802;</i></div>';
                            $html = $html . '<div class="source">' . $mydata->source_name . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
                            $html = $html . '</div>';
						}
						echo $html;
						$index = $index + 1;
					}
				 ?>
               <!--     <div class="col-md-6 col-sm-12 col-xs-12 news-container">
                        <div class="news news-large">
                            <img class="background" src="<?php echo $imagePath;?>blank-large.jpg" alt="">
                            <img class="logo" src="" alt="" style="background: url('<?php echo $imagePath;?>test/1.png') no-repeat center top; background-size: contain;">
                            <div class="section background-emission">
                                <span>emissionserbjudanden</span>
                            </div>
                            <div class="feature">
                                <img src="<?php echo $imagePath;?>feature.png">
                            </div>
                            <div class="title">
                                <div class="content">
                                    <span>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</span>
                                </div>
                            </div>
                            <div class="info">
                                <div class="social">HYPED 35</div>
                                <div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/news?news_id=11157"></span>COMMENTS 15</div>
                                <div class="source">DI.SE</div>
                            </div>
                        </div>
                    </div>
          <!--          <div class="col-md-3 col-sm-6 col-xs-12 news-container">
                        <div class="news news-medium">
                            <img class="background" src="<?php echo $imagePath;?>blank-medium.jpg" alt="">
                            <img class="logo" src="" alt="" style="background: url('<?php echo $imagePath;?>test/3.png') no-repeat center top; background-size: contain;">
                            <div class="section background-startup_news">
                                <span>Startup News</span>
                            </div>
                            <div class="feature">
                                <img src="<?php echo $imagePath;?>feature.png">
                            </div>
                            <div class="title">
                                <div class="content">
                                    <span>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</span>
                                </div>
                            </div>
                            <div class="desc">
                                <div class="content">
                                    <p>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</p>
                                </div>
                            </div>
                            <div class="info">
                                <div class="social">HYPED 35</div>
                                <div class="comment">COMMENTS 15</div>
                                <div class="source">DI.SE</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 news-container">
                        <div class="news news-small">
                            <img class="background" src="<?php echo $imagePath;?>blank-small.jpg" alt="">
                            <img class="logo" src="" alt="" style="background: url('<?php echo $imagePath;?>test/2.png') no-repeat center top; background-size: contain;">
                            <div class="section background-startup_news">
                                <span>Startup News</span>
                            </div>
                            <div class="feature">
                                <img src="<?php echo $imagePath;?>feature.png">
                            </div>
                            <div class="title">
                                <div class="content">
                                    <span>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</span>
                                </div>
                            </div>
                            <div class="info">
                                <div class="social">HYPED 35</div>
                                <div class="comment">COMMENTS 15</div>
                                <div class="source">DI.SE</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 news-container">
                        <div class="news news-small">
                            <img class="background" src="<?php echo $imagePath;?>blank-small.jpg" alt="">
                            <img class="logo" src="" alt="" style="background: url('<?php echo $imagePath;?>test/2.png') no-repeat center top; background-size: contain;">
                            <div class="section background-startup_news">
                                <span>Startup News</span>
                            </div>
                            <div class="feature">
                                <img src="<?php echo $imagePath;?>feature.png">
                            </div>
                            <div class="title">
                                <div class="content">
                                    <span>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</span>
                                </div>
                            </div>
                            <div class="info">
                                <div class="social">HYPED 35</div>
                                <div class="comment">COMMENTS 15</div>
                                <div class="source">DI.SE</div>
                            </div>
                        </div>
                    </div>-->
                </div>
                
<!--                <div class="row news-list news-list-medium">
                    <div class="col-md-3 col-sm-6 col-xs-12 news-container">
                        <div class="news news-medium">
                            <img class="background" src="<?php echo $imagePath;?>blank-medium.jpg" alt="">
                            <img class="logo" src="" alt="" style="background: url('<?php echo $imagePath;?>test/3.png') no-repeat center top; background-size: contain;">
                            <div class="section background-startup_news">
                                <span>Startup News</span>
                            </div>
                            <div class="feature">
                                <img src="<?php echo $imagePath;?>feature.png">
                            </div>
                            <div class="title">
                                <div class="content">
                                    <span>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</span>
                                </div>
                            </div>
                            <div class="desc">
                                <div class="content">
                                    <p>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</p>
                                </div>
                            </div>
                            <div class="info">
                                <div class="social">HYPED 35</div>
                                <div class="comment">COMMENTS 15</div>
                                <div class="source">DI.SE</div>
                            </div>
                        </div>
                    </div>
                </div>
  
                <div class="row news-list news-list-small">
                    <div class="col-md-3 col-sm-6 col-xs-12 news-container">
                        <div class="news news-small">
                            <img class="background" src="<?php echo $imagePath;?>blank-small.jpg" alt="">
                            <img class="logo" src="" alt="" style="background: url('<?php echo $imagePath;?>test/2.png') no-repeat center top; background-size: contain;">
                            <div class="section background-startup_news">
                                <span>Startup News</span>
                            </div>
                            <div class="feature">
                                <img src="<?php echo $imagePath;?>feature.png">
                            </div>
                            <div class="title">
                                <div class="content">
                                    <span>The example padfas dfdsaj vcvzxnm cxvzxv ggdfklgd gdfgkdfslgksdflg gkdfslgk dsfgkdgldfsgkldsfgksd;ldg gdfs</span>
                                </div>
                            </div>
                            <div class="info">
                                <div class="social">HYPED 35</div>
                                <div class="comment">COMMENTS 15</div>
                                <div class="source">DI.SE</div>
                            </div>
                        </div>
                    </div>
                </div>-->
            
            </div>
        </div>
        
        <div class="loading">
            <img src="<?php echo $imagePath;?>loader8.gif">
        </div>
        
        <input type="hidden" id="section" value="<?php echo $section;?>">
        
        
        
        <?php require 'common/footer.php'; ?>
        
        <script>
			var disqus_shortname = 'invest-hype';
            jQuery(document).ready(function () {
                iDragonIT.init();
				getMarkets();
				setInterval(getMarkets, 30000);
            });
			
        </script>
        
        <script src="<?php echo $scriptPath; ?>home.js?v=5" type="text/javascript"></script>
    </body>

    <!-- END BODY -->
</html>

