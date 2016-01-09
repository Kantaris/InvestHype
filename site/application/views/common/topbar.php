<?php ?>  

<div class="header">
    <nav class="navbar navbar-fixed-top">
        <div class="line">
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-5 col-xs-6" style="padding-left: 0;">
                    <a href="http://investhype.com"><img class="logo" src="<?php echo $imagePath;?>logo.png"></a>
                </div>
                <div class="col-md-8 col-sm-7 col-xs-6" style="padding-right: 5px;">
                    <span class="visible-xs" style="text-align: right;">
                        <a class="toggle-menu" href="javascript:toogle_menu()"><img src="<?php echo $imagePath;?>menu.png"></a>
                    </span>
                    
                    <span class="topmarkets">
						<div class="tmchange">
							<i class="updown-icon icon-down-big colorred">&#xe800;</i> -0,00%
						</div>
						<div class="tmname">
							16.31, Dow Jones, <span class="SPAN_6">i år +0,00%</span>
						</div>
					</span>
									
					<span class="topmarkets">
						<div class="tmchange">
							<i class="updown-icon icon-down-big colorred">&#xe800;</i> -0,00%
						</div>
						<div class="tmname">
							16.31, OMX-S, <span class="SPAN_6">i år +0,00%</span>
						</div>
					</span>
                    
                    <div class="visible-lg visible-md visible-sm">
                        <img class="title" src="<?php echo $imagePath;?>title.png">
                    </div>
                </div>
            </div>
            <div class="row visible-xs" style="width:98%;left:0px;padding-left:15px;">

                        <img class="title-xs" src="<?php echo $imagePath;?>title.png">

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
				<div class="col-md-6 col-sm-6 col-xs-12 menu-item background-mest_hypeat">
                    <a href="<?php echo $basePath;?>nyheter">hetaste nyheter</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 menu-item background-emission">
                    <a href="#">aktuella emissioner</a>
                </div>
                
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
            </div>
            
            <div class="row margin-top-25 menu toggle opened" style="padding-left: 5px; padding-right: 5px; display: none;">
<!--
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-startup_news">
                    <a href="<?php echo $basePath;?>news/startup.html">startup news</a>
                </div>
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
                
                <div class="col-md-3 col-sm-6 col-xs-12 menu-item background-finansnytt">
                    <a href="<?php echo $basePath;?>news/finansnytt.html">finansnytt</a>
                </div>
				
-->
				
				<div class="col-md-6 col-sm-6 col-xs-12 menu-item background-mest_hypeat">
                    <a href="<?php echo $basePath;?>nyheter">hetaste nyheterna</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 menu-item background-emission">
                    <a href="#">aktuella emissioner</a>
                </div>
                
                
                <div class="clearfix visible-sm-block visible-xs-block"></div>
            </div>
        </div>
    </nav>    
</div>

