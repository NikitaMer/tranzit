var CompareControl = null;

function SetFavCounter (count)
{
    $('.catalog-line .icon.favorite').next().text(count);

    if(count > 0)
        $('.catalog-line .icon.favorite').parents('.link').addClass('active');
    else
        $('.catalog-line .icon.favorite').parents('.link').removeClass('active');
}

//обновление корзины
function UpdateCartMini(success, error) {

    $.ajax({
        type: "post",
        dataType: 'json',
        cache: false,
        data: '', //'AJAX_UPDATER=Y&CART_MINI=Y',
        url: "/local/ajax/cart_mini.php",
        success: function(data){

            var footer_cart = $('.catalog-line .cart'),
                top_cart = $('.icon-blocks .block.cart .desc'),
                product_more_cart = $('.product-more-cart');

            if(data.QUANTITY)
                footer_cart.find('.link').addClass('active');
            else
                footer_cart.find('.link').removeClass('active');

            footer_cart.find('.counter').text(data.QUANTITY);

            top_cart.find('span').text(data.QUANTITY + ' ' + data.TEXT + ' — ' + data.PRICE_FORMATED) + ' руб.';

            product_more_cart.find('.counter').text(data.QUANTITY + ' ' + data.TEXT + ' на сумму');
            product_more_cart.find('.price-block').html(data.PRICE_FORMATED_2);

            if(data.QUANTITY > 0)
            {
                product_more_cart.show();
                product_more_cart.find('a').removeClass('white');
                product_more_cart.find('a').unbind('click');
            }
            else
            {
                product_more_cart.hide();
                product_more_cart.find('a').addClass('white');
                product_more_cart.find('a').click(function(){
                    return false;
                    });
            }

            if(typeof success == 'function')
                success();

            },
        error: function(){

            if(typeof error == 'function')
                error();

        }
    });
}

function setCompareCount(count)
{
    if(typeof count != 'number')
        count = 0 ;

    var counter = $('.compare + .counter'),
        parent = counter.parents('.link');

    //console.log('setCompareCount', typeof count, count);

    counter.text(count);

    if(count <= 0)
        parent.removeClass('active');
    else
        parent.addClass('active');
}

$(document).ready(function () {

    var sudoSliderPartner = $("#partner-slider").sudoSlider({
        speed: 900,
        pause: 3000,
        slideCount: 6,
        auto:true,
        prevNext: false,
        numeric: false,
        touch: true,
        continuous:true,
        });

    $(".open_ajax").fancybox({
        type: 'ajax',
        autoSize    : true,
        minWidth    : 300,
        minHeight    : 120,
        fitToView    : false,
        closeClick    : false,
        openEffect    : 'none',
        closeEffect    : 'none',
        wrapCSS        : 'fancyapp-theme',
        margin: 0
        });

    $(".fancyapp").fancybox({
        autoSize    : true,
        minWidth    : 200,
        minHeight    : 200,
        fitToView    : false,
        closeClick    : false,
        openEffect    : 'none',
        closeEffect    : 'none',
        wrapCSS        : 'fancyapp-theme',
        margin: 0
        });

    var height_left = $('.columns .main_left').height(),
        height_right = $('.columns .main_right').height();

    if(height_left < height_right)
    {
        var column = $('.columns .main_left');

        if(!column.hasClass('product-more'))
            column.height(height_right);
    }

    var e = GetEmail('117114046116110101105108099050108108097099064116114111112112117115');
    $('.contact_email').html(e);
    $('.contact_email').attr('href', 'mailto:' + e);



    $(document).on('click', 'a[data-action=add2basket]', function(){

        $.ajax({
            type: "post",
            dataType: 'text',
            cache: false,
            url: $(this).attr('href')+ '&ajax_basket=Y&prop[]=CML2_ARTICLE',
            success: function(data){

                ShowNotice('cart');

                data = data.replace(/'/g,'"');
                data = JSON.parse(data);

                if(data['STATUS'] === 'OK'){
                    if(typeof recalcBasketAjax == 'function')
                        recalcBasketAjax();

                    if(typeof UpdateCartMini == 'function')
                        UpdateCartMini();
                    }

            },
            error: function(e){
                console.error(e);
            }
        });

        return false;
    });


    CompareControl = $('a[data-action=add2compare]').compareList({
        'list_name'     : 'CATALOG_COMPARE_LIST',
        'iblock_id'     : CATALOG_IBLOCK_ID,
        'started'         : function(obj){
            //console.log('started', obj);
            },
        'checkStatus'   : function(elements, count){

            //console.log('checkStatus', elements, count);

            for(id in elements){

                var el = $('a[data-action=add2compare]').filter('[data-id='+id+']');

                if(elements[id]){
                    el.addClass('active');
                    el.find('span').text('В сравнении');
                    }
                else{
                    el.find('span').text('К сравнению');
                    }

                }

                if(typeof  setCompareCount == 'function')
                    setCompareCount(count);

            },
        'success' : function(obj, data){

            //console.log('success', obj, data);

            if(data['IN_COMPARE']){

                if(typeof ShowNotice == 'function')
                    ShowNotice('compare');

                $(obj).addClass('active');
                $(obj).find('span').text('В сравнении');
                }
            else{

                if(typeof removeFromCompareComplate == 'function')
                    removeFromCompareComplate(data['ID']);

                if(typeof removeFromCompareList == 'function')
                    removeFromCompareList(data['ID']);

                $(obj).removeClass('active');
                $(obj).find('span').text('К сравнению');
                }

            if(typeof  setCompareCount == 'function')
                setCompareCount(data['COUNT']);

            },
        'errors' : function(err){
            console.warn(err);
            }
        });

    $('.catalog-line .link a').click(function(){
        if(!$(this).parent().hasClass('active'))
            return false;
        });


    $('.radio-block span').click(function(){
        $(this).next().click();
        });


    $("input[name='phone']").mask('+7(999)999-99-99');
            
    
});
$(document).mouseup(function (e) {
    if ($(".block").is(e.target) && $(".add_car_form").css("right") == "0px") {
        $(".add_car_form").animate({ right:'-560px' }, 200);        
    } else {
        if ($(".block").is(e.target) || $(".add_car_form").is(e.target) ||  $(".add_car_form").find('*').is(e.target)) {
            $(".add_car_form").animate({ right:'0' }, 400);    
        } else {
            $(".add_car_form").animate({ right:'-560px' }, 200);    
        }    
    }           
});

//*****************************************************************
// анимация при добавлении в корзину и т.п.
//*****************************************************************

var timeout = {};
function ShowNotice(id){

    clearTimeout(timeout[id]);

    var notice = null;
    if(id == 'favorite')
        notice = $('.ballon.favorite');
    else if(id == 'compare')
        notice = $('.ballon.compare');
    else if(id == 'cart')
        notice = $('.ballon.cart');

    notice.hide(0);
    notice.css('top', "-150px");
    $(notice).fadeIn('slow', function(){    });
    notice.animate({top: "-35px"}, 400, 'easeOutBounce');

    timeout[id] = setTimeout(function(){
        $(notice).fadeOut('normal', function(){
            notice.css('top', "-150px");
        });
    }, 3500);


}