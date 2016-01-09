function get_news(section, start){
	var end = start + 49;
    $.ajax({
        type: "POST",
        url: 'http://api.chrispersson.com/nyheter.ashx?from=' + start + '&to=' + end,
        data: {},
        dataType: 'json',
        success: function (data) {
            var l = data.length;
            var html_large='', html_medium='', html_small='', html='';
            
            if (l>0) {
                var l_s = parseInt(l/3);
                var l_medium = l_s - (l_s%6);
                var l_large = l_s - (l_s%2);
                var l_small = l - l_medium-l_large;
                
//                console.log(l_large+"---"+l_medium+"---"+l_small);
                $.each(data, function(index, row){
                    var img = $("#resPath").val()+"images/blank-small.jpg";
					img = row.localimage;
					if(img.length < 1){
						img = 'logos/' + row.source_id + '.jpg';
					}
					else if(img.indexOf('Not Found') >= 0){
						img = 'logos/' + row.source_id + '.jpg';
					}
                    
                    var desc = "";
                    if (row.description!=null) {
                        desc = row.description;
                    }
                    
                    var news_id = row.id;
					var news_url = row.url;
                   if (index%7==0 || index%7==6) {
                        html += ''+
                                '<div class="col-md-6 col-sm-12 col-xs-12 news-container" data-id="http://investhype.com/nyheter'+news_url+'">'+
                                    '<div class="news news-large">'+
                                        '<img class="background" src="'+$("#resPath").val()+'images/blank-large.jpg" alt="">'+
                                        '<a href="http://investhype.com/nyheter' + news_url + '"><img class="logo" src="" alt="" style="background: url(\''+img+'\') no-repeat center center; background-size: cover;"></a>'+
                                        '<div class="section '+row.title_background+'">'+
                                            '<span>'+row.category_name+'</span>'+
                                        '</div>'+
//                                        '<div class="feature">'+
//                                            '<img src="" alt="">'+
//                                        '</div>'+
                                        '<div class="title">'+
                                            '<div class="content">'+
                                                '<span>'+row.title+'</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="info">'+
                                            '<div class="social">HYPE '+row.hyped+'</div>'+
                                            '<div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/nyheter' + news_url +'">0 </span><i class="updown-icon icon-down-big">&#xe802;</i></div>'+
                                            '<div class="source">'+row.source_name+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '';
                    }
                    else if (index%7==1 || index%7==4 || index%7==5) {
                        html += ''+
                                '<div class="col-md-3 col-sm-6 col-xs-12 news-container" data-id="http://investhype.com/nyheter'+news_url+'">'+
                                    '<div class="news news-medium">'+
                                        '<img class="background" src="'+$("#resPath").val()+'images/blank-medium.jpg" alt="">'+	
                                        '<img class="background2" src="'+$("#resPath").val()+'images/blank-small.jpg" alt="">'+
                                        '<a href="http://investhype.com/nyheter' + news_url + '"><img class="logo" src="" alt="" style="background: url(\''+img+'\') no-repeat center center; background-size: cover;"></a>'+
                                        '<div class="section '+row.title_background+'">'+
                                            '<span>'+row.category_name+'</span>'+
                                        '</div>'+
//                                        '<div class="feature">'+
//                                            '<img src="" alt="">'+
//                                        '</div>'+
                                        '<div class="title">'+
                                            '<div class="content">'+
                                                '<span>'+row.title+'</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="desc">'+
                                            '<div class="content">'+
                                                '<div>'+desc+'</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="info">'+
                                            '<div class="social">HYPE '+row.hyped+'</div>'+
                                           '<div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/nyheter' + news_url +'">0 </span><i class="updown-icon icon-down-big">&#xe802;</i></div>'+
                                           '<div class="source">'+row.source_name+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '';
                    } 
                    else {
                        html += ''+
                                '<div class="col-md-3 col-sm-6 col-xs-12 news-container" data-id="http://investhype.com/nyheter'+news_url+'">'+
                                    '<div class="news news-small">'+
                                        '<img class="background" src="'+$("#resPath").val()+'images/blank-small.jpg" alt="">'+
                                        '<a href="http://investhype.com/nyheter' + news_url + '"><img class="logo" src="" alt="" style="background: url(\''+img+'\') no-repeat center center; background-size: cover;"></a>'+
                                        '<div class="section '+row.title_background+'">'+
                                            '<span>'+row.category_name+'</span>'+
                                        '</div>'+
//                                        '<div class="feature">'+
//                                            '<img src="" alt="">'+
//                                        '</div>'+
                                        '<div class="title">'+
                                            '<div class="content">'+
                                                '<span>'+row.title+'</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="info">'+
                                            '<div class="social">HYPE '+row.hyped+'</div>'+
                                            '<div class="comment"><span class="disqus-comment-count" data-disqus-url="http://investhype.com/nyheter' + news_url +'">0 </span><i class="updown-icon icon-down-big">&#xe802;</i></div>'+
                                            '<div class="source">'+row.source_name+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '';
                    }
                });
            }
            
//            $(".news-list-large").html(html_large);
//            $(".news-list-medium").html(html_medium);
//            $(".news-list-small").html(html_small);
			var dom_target = document.getElementById("mainlist");
			dom_target.innerHTML += html;
            
            $(".loading").fadeOut(300);
			var s = document.createElement('script'); s.async = true;
			s.type = 'text/javascript';
			s.src = '//' + disqus_shortname + '.disqus.com/count.js';
			(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        },
        error: function () {
            $(".loading").fadeOut(300);
        }
    });
}


jQuery(document).ready(function () {
	var cIndex = 14;
    $(".footer .content").on('click', 'img.close', function(e){
        e.preventDefault();
        remove_subscribe();
    });
    
    $(".news-list").on('click', '.news-container', function(e){
        e.preventDefault();
        var news_url = $(this).attr('data-id');
        window.open(news_url ,"_self")
    });
	$(".container").on('click', '.more-button', function(e){
        e.preventDefault();
        get_news($("#section").val(), cIndex);
		cIndex = cIndex + 49;
    });
    
    //$(".news-list").html('');
    //$(".loading").fadeIn(500);
    get_news($("#section").val(), cIndex);
	cIndex = cIndex + 49;
});

