<?php
/**
 * Created by PhpStorm.
 * User: indro
 * Date: 30.10.2017
 * Time: 12:07
 */

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="header">
    Feed
</div>
<div class="container">
    <div class="row main-post">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="popUp" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script>

    $(document).ready(function () {

        //feed to parse
        var feed = "feed.xml";
        $.ajax(feed, {
            accepts: {
                xml: "application/rss+xml"
            },
            dataType: "xml",
            success: function (data) {
                $(data).find("item").each(function () { // or "item" or whatever suits your feed
                    var el = $(this);
                    var media = el.find('media\\:content,content').attr('url');
                    if (!media) {
                        media = 'img/placeholder.png'
                    }
                    $(".main-post").append(
                        "<div class='col-md-4 post'>" +
                        "<div class='category'>" + el.find("category").text() + "</div>" +
                        "<div class='contain col-md-12'>" +
                        "<div class='floated col-md-6'>" +
                        "<img class='img' src=" + media + ">" +
                        "</div>" +
                        "<div data-type_url="+ el.find("link").text() + " class='title'>" + el.find('title').text() + "</a></div>" +
                        "<br>" +
                        "<div class='desc'>" + el.find("description").text() + "</div>" +
                        "<div class='author'>" + el.find("pubDate").text() + "</div>" +
                        "</div>" +
                        "</div>");
                });
            }
        });



        setTimeout(function(){
            $(document).on('click','.title',function(){
                var url = "https://mercury.postlight.com/parser?url="+$(this).data('type_url');
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    headers: {"x-api-key": "VD6HvExyQqoNtWFCKA8VlNDaxjTA2UOv10Fz78FW"},
                    success: function (data) {
                        $(".modal-title").empty();
                        $(".modal-body").empty();
                        $(".modal-title").append(data.title);
                        $(".modal-body").append(data.content);
                        $('#popUp').modal('show');
                    }
                });
            });
        },1000);


    });


</script>