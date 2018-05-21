$(document).ready(function () {
    //scrollTo top function
    // hide #back-top first
    $(".scrollToTop").hide();

    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('.scrollToTop').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

    $("#myCarousel .left").click(function(){
        console.log("Here");
        $("#myCarousel").carousel("prev");
    });

    $("#myCarousel .right").click(function(){
        console.log("There");
        $("#myCarousel").carousel("next");
    });

    // offcanvas

    $(".close").click(function () {
        $("#wrapper").removeClass('toggled');
        $("#menu-toggle").show();
    });
    $("#menu-toggle").click(function () {
        $("#menu-toggle").hide();
        $("#wrapper").addClass('toggled');
    });

    //add class on image
    $("img").addClass("img-responsive");

    //owl-carousel
    $('#owl-demo').owlCarousel({
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        rtl: false,
        loop: true,
        margin: 30,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            700: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    $(".view").click(function(event){
            event.preventDefault();
            var viewUrl = $(this).attr('href');
            //console.log(viewUrl);
            $.ajax({
                type: "GET",
                url: viewUrl,
                success: function( quote ) {
                    var quoteInfo="";
                    quoteInfo = "<p>Item name: "+quote['item_name']+"</p>"+
                                "<p>Url: "+quote['url']+"</p>"+
                                "<p>Buy url: "+quote['buy_url']+"</p>"+
                                "<p>Quantity: "+quote['quantity']+"</p>"+
                                "<p>Status: "+quote['quote_status']+"</p>"+
                                "<p>Category: "+quote['category']+"("+quote['tariff']+"%)</p>"+
                                "<p>Dimention: "+quote['length']+"x"+quote['width']+"x"+quote['height']+"</p>"+
                                "<p>Weight: "+quote['weightlbs']+"</p>"+
                                "<p>Buy price: "+quote['buy_price']+"</p>"+
                                "<p>Sales tax: "+quote['sales_tax']+"</p>"+
                                "<p>Domestic shipping: "+quote['dom_shipping']+"</p>"+
                                "<p>International shipping: "+quote['intlShip']+"</p>"+
                                "<p>Customs: $ "+quote['customeval']+"</p>"+
                                "<p>Discount: $ "+quote['discount']+"</p>"+
                                "<p>Subtotal: $ "+quote['subtotal']+"</p>"+
                                "<p>Vat: "+quote['vat']+"</p>"+
                                "<p>Total: $"+quote['finalcost']+"</p>";
                    $("#quoteInfo").html(quoteInfo);
                    console.log(quote['quote_status']);
                }
            });
        });

        $(".addCmt").click(function(event){
            event.preventDefault();
            var data = $('.form-comment').serialize();
            var viewUrl = $(this).attr('href');

            $.ajax({
                type: "POST",
                url: viewUrl,
                data: data,
                success: function( data ) {
                    var cmtStr = '';
                    console.log(data['quote']);
                    quote = data['quote'];
                    cmtStr += '<div class="comment" id="cmtBottom"><div class="row"><div class="col-md-12 cmt-txt">'+quote['comment']+'</div><div class="col-md-12 cmt-auther"><b>'+quote['author']+'</b><br><span class="cmt-time">'+quote['formatted']+'</span></div></div></div>';
                    cmt = data['comments'];
                    for(var i=0;i<cmt.length;i++)
                    {
                        if(i==cmt.length-1)
                            cmtStr += '<div class="comment" id="cmtBottom"><div class="row"><div class="col-md-12 cmt-txt">'+cmt[i]['comment']+'</div><div class="col-md-12 cmt-auther"><b>'+cmt[i]['author']+'</b><br><span class="cmt-time">'+cmt[i]['formatted']+'</span></div></div></div>';
                        else
                            cmtStr += '<div class="comment"><div class="row"><div class="col-md-12 cmt-txt">'+cmt[i]['comment']+'</div><div class="col-md-12 cmt-auther"><b>'+cmt[i]['author']+'</b><br><span class="cmt-time">'+cmt[i]['formatted']+'</span></div></div></div>';
                        $("#cmt").val('');
                        //$("#comments").scrollTop($("#comments")[0].scrollHeight+20);
                    }
                    $("#comments").html(cmtStr);
                }
            });
        });

        $('[data-toggle="tooltip"]').tooltip('show');

    /*$("a.btn-forget").click(function(event){
        $(".frm-login").slideUp();
        $(".frm-forgot").slideDown();
    });*/
    /*$('#reqote').click(function(event){
        //event.preventDefault();
        if($('.qlist').is(':checked'))
            return true;
        else
        {
            $("#jmsg").html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> Select atleast one quote.');
            $("#jmsg").show();
            return false;
        }
    });*/




});


$(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();




    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = (sampwidth / incno);
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});
