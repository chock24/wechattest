/* -- 全局 -- */

/* -- 截取字符 -- */
function capture_c (obj,i){
    obj.each(function(){
        if(($(this).html().length)>i){
            $(this).html(obj.html().substr(0, i)+'...');
        }
    });
}

$(function(){
    //点击关闭提示信息
    $('.popup_x').click(function(){
        $('.popup_bj').hide().find('.popup_con').hide();
    });

    //banner图片轮播方法
    function banner_carousel (){
        if($('.banner_com li').length>=2){
            var $bannerHtml = '';
            for(var banner_li=0;banner_li<$('.banner_com li').length;banner_li++){
                $bannerHtml+='<span></span>';
            }
            $('.banner_li').html($bannerHtml);
            $('.banner_li span').eq(0).addClass('on');
            $('.banner_com ul').append('<li><a href="javascript:;"><img src='+ $('.banner_com li').eq(0).find('img').attr('src') +'></a></li>');
            var wwidth=$('.banner').width();
            var $wrap=$(".banner li");
            var $bannerLi = $('.banner_com li').length;
            $('.banner,.banner_com li').width(wwidth);
            $('.banner_com').width($bannerLi*wwidth);
            var bannerI=-1;//页数
            $wrap.swipeLeft(function(){
                window.clearInterval($setInt);
                moveLeft();
                $setInt = setInterval(function(){moveLeft();},4000);
            });
            $wrap.swipeRight(function(){
                window.clearInterval($setInt);
                moveRight();
                $setInt = setInterval(function(){moveLeft();},4000);
            });
            var $setInt = setInterval(function(){ //设置自动轮播
                moveLeft();
            },2000);
            function transMove(num){ //切换方法
                var dis=wwidth*num;
                $wrap.css({"-webkit-transform":"translateX("+dis+"px)",'-webkit-transition':'450ms ease-out'});
                $('.banner_li span').eq((-num)-1).addClass('on').siblings().removeClass('on');
            }
            function moveRight(){
                bannerI++;
                if (bannerI<=0){
                    transMove(bannerI);
                }else {
                    bannerI = -($bannerLi-1);
                    $wrap.css({"-webkit-transform":"translateX("+-($bannerLi-1)*wwidth +"px)",'-webkit-transition':'0ms ease-out'});
                    setTimeout(function(){moveRight();},100);
                }
            }
            function moveLeft(){
                bannerI--;
                if((-bannerI)<$bannerLi){
                    transMove(bannerI);
                }else {
                    bannerI=0;
                    $wrap.css({"-webkit-transform":"translateX(0px)",'-webkit-transition':'0ms ease-out'});
                    setTimeout(function(){moveLeft();},100);
                }
            }
        }
    }
    banner_carousel();//调用轮播方法

    //商品详情页的商品图片切换
    function goods_carousel (){
        var $wwidth=$(window).width();
        var $wrap = $('.goods_top_img_com li');
        $('.goods_top_img_com').width($('.goods_top_img_com li').length*$wwidth);
        $('.goods_top_img_com li').width($wwidth);
        if($('.goods_top_img_com li').length>1){
            $wrap.eq(1).addClass('on');
            $wrap.eq(1).next().find('img').css({left: '-2.85rem',right: 'auto'});
            $wrap.eq(1).prev().find('img').css({left: 'auto',right: '-2.85rem'});
            $wrap.css({"-webkit-transform":"translateX("+ -$wwidth +"px)",'-webkit-transition':'0ms ease-out',"transform":"translateX("+ -$wwidth +"px)",'transition':'0ms ease-out'});
            $wrap.swipeLeft(function(){
                var ind = $(this).index()+1;
                if(ind<$wrap.length){
                    transMove(-ind,ind);
                }
            });
            $wrap.swipeRight(function(){
                var ind = $(this).index()-1;
                if(ind>=0){
                    transMove(-ind,ind);
                }
            });
            function transMove(num,ind){ //切换方法
                var dis=$wwidth*num;
                $wrap.css({"-webkit-transform":"translateX("+dis+"px)",'-webkit-transition':'450ms ease-out'});
                $wrap.siblings().removeClass('on').find('img').removeClass('imgOn2').addClass('imgOn');
                $wrap.eq(ind).addClass('on').find('img').css({left: '50%',right: 'auto'}).removeClass('imgOn').addClass('imgOn2');
                $wrap.eq(ind).next().find('img').css({left: '-2.85rem',right: 'auto'});
                $wrap.eq(ind).prev().find('img').css({left: 'auto',right: '-2.85rem'});
            }
        }else {
            $wrap.addClass('on');
        }
    }
    goods_carousel ();//调用商品切换方法



});

/*
 * 提交表单验证
 * tagName为提示的表单的父元素的标签名，做红边框颜色高亮提醒
 * 表单添加data-null(data-select选择框)为non-null来做表单非空验证
 * 表单添加data-tel为non-null来做手机号码验证
 * 每个验证表单同级目录下需要增加验证提示类为errorMessage的对象
 */
function crmValidator(tagName){
    var property = true;
    var data_html = '验证不通过';
    $('*').each(function(){
        var data_null = $(this).attr('data-null');//非空
        var data_tel = $(this).attr('data-tel');//手机
        if($(this).prop("tagName")=='INPUT'){
            var obj_null = $(this).val();
        }else {
            var obj_null = $(this).html();
        }
        if(data_null == 'non-null'){
            if(obj_null==''){
                data_html = $(this).attr('data-name')+'不能为空！';
                border_red ($(this),tagName);
                return property = false;
            }
            if($(this)){}
        }
        if(data_tel == 'non-null'){
            var reg=/(^((\+?86)|(\(\+86\)))?\d{3,4}-{1}\d{7,8}(-{0,1}\d{3,4})?$)|(^((\+?86)|(\(\+86\)))?1\d{10}$)/;
            if(!reg.test(obj_null)){
                data_html = '手机号码有误,请正确填写！';
                border_red ($(this),tagName);
                return property = false;
            }
        }
        function border_red (obj,tagName){
            obj.parents(tagName).eq(0).addClass('crmValidator_border').click(function(){
                obj.parents(tagName).removeClass('crmValidator_border');
            });
        }
    });
    var html = '<div class="popup_bj crmValidator" style="display: block;"><div class="popup"><div class="popup_con popup_bu_int" style="display: block;">'
        +'<a href="javascript:;" class="popup_x crmValidator_x"></a><h5>'+ data_html +'</h5>'
        +'<div class="popup_site_fill_but"><a class="pop_but crmValidator_but" href="javascript:;">确定</a></div></div></div></div>';
    if(property==false){
        $('section').append(html);
        $('.crmValidator_but,.crmValidator_x').live('click',function(){
            $('.crmValidator').detach();
        });
    }
    return property;
}