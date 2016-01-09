function submit_comment(){
    var v = $("#txt_comment").val();
    if (v=="") {
        alert("Please input comment!");
        return false;
    }
    
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/submit_comment',
        data: {
            comment: v, news_id: $("#news_id").val()
        },
        dataType: 'json',
        success: function (data) {
            window.location.reload();
        },
        error: function () {
        }
    });
}

function onRefresh(){
    if ($(".news-detail").height()>$(".news-comment").height()) {
        $(".news-comment").css('height', ($(".news-detail").height()-12)+'px');
    }
}

function load(){
    $(".loading").fadeIn(300);
    
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/load_comment/' + $("#news_id").val(),
        data: {
        },
        dataType: 'json',
        success: function (data) {
            if (data.errCode==0) {
                $.each(data.list, function(index, row){
                   var html = "";
                   
                    html += '<div class="row">' +
                                '<div class="info">'+
                                    '<a href="#" class="author">'+ row.author + 
                                        '<span class="symbol">@</span><span class="source">'+row.screen+'</span>'+
                                    '</a>'+
                                    '<span class="time">'+row.time+'</span>'+
                                '</div>'+
                                '<div class="desc">'+row.content+
                                '';
                    
                    if (row.link.url!="" && row.link.name!="") {
                        html += '<br><a href="'+row.link.url+'">'+row.link.name+'</a>';
                    }
                    
                    if (row.media.url!="" && row.media.type=="photo") {
                        html += '<img src="'+row.media.url+'" alt="">';
                    }
                    
                    html += "</div></div>";
                    
                    $("#news_list").append(html);
                });
            }
            
            $(".loading").fadeOut(500);
        },
        error: function () {
            $(".loading").fadeOut(500);
        }
    });
}

jQuery(document).ready(function () {
    $(".footer .content").on('click', 'img.close', function(e){
        e.preventDefault();
        remove_subscribe();
    });
    
    if ($("#old_comment").val()!=""){
        $("#txt_comment").val($("#old_comment").val());
    }
    
    $(".news-comment").on('click', 'button.comment', function(e){
        e.preventDefault();
        submit_comment();
    });
    $(".headx").click(function () {

    $header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            return $content.is(":visible") ? "Mindre Information" : "Mer Information";
        });
    });
 });
    
    $(".bolaget").click(function () {

    $header = $(this);
    //getting the next element
    $content = $("#moreinfo")
    
    if(!$content.is(":visible")){
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
       
    });
    }
    $('body, html').animate({scrollTop: ($content.offset().top - 250) });

});
    
//    if ($(".news-comment>div.row").length==0){
//        $(".news-comment").html('No comments<br><br><br><br><br>');
//    }
    
    $(window).on('resize', function(){
//        onRefresh();
    });
    
//    onRefresh();

    load();
});
