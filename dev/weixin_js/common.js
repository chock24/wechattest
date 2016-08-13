/**
 * Created by zhuimin on 15-2-2.
 * 共用js插件
 */
$(function () {
    /*ie7浏览器下报浏览器更新*/
    var b_v = navigator.appVersion;
    if(b_v.search(/MSIE 6/i) != -1 || b_v.search(/MSIE 7/i) != -1){
        if($.cookie("isClose") != 'yes'){
            var html;
            html+='<div class="ie-version"><h2>系统提示</h2><div class="ie-version-cont"><p>系统检测到你所使用的IE浏览器版本过低，为了更好的界面体验，系统建议你更换浏览器访问。</p>'
                +'<label class="color-red"><input type="checkbox" class="margin-right-5" id="ie-version-ch">不再提示</label></div><div class="ie-version-footer">'
                +'<a href="javascript:;" class="button button-green">确定</a></div></div>';
            $('body').append(html);
            $('.ie-version-footer').find('.button').live('click',function(){
                if($('.ie-version-cont').find('input:checkbox').attr('checked')=='checked'){
                    $.cookie("isClose",'yes');
                }
                $('.ie-version').remove();
            });
        }
    }
    (function ($) {
        /*选显卡*/
        $.fn.tabhost = function (number) {
            /*备注:此方法只适用于$('.tabhost')，拥有固定样式写法的tabhpst类来调用*/
            $(this).find('.tabhost-title ul').find('li').live('click', function () {
                var ind = $(this).index();
                $('.tabhost').find('.tabhost-title ul').find('li').removeClass('active');
                $(this).addClass('active');
                $('.tabhost-center').children('.tabhost-center').hide();
                $('.tabhost-center').children('.tabhost-center').eq(ind).show();
            });
        };

        /*控制表单字符数(递减)*/
        /*备注:调用的类中必须有文本输入框及<em>标签用来计数才可调用有效*/
        $.fn.form_count = function (number) {
            var obj1 = $(this).find('input,textarea');
            var obj2 = $(this).find('em');
            preview_title();
            obj1.live('keyup',function () {
                preview_title();
            });
            obj1.live('mouseenter',function () {
                preview_title();
            });
            function preview_title() {
                var wz = obj1.val();
                obj2.html(wz.length);
                if (wz.length > number) {
                    var wz2 = wz.slice(0, number);
                    obj1.val(wz2);
                    obj2.html(number);
                }
            }
        };
        /*计数(递减)*/
        $.fn.text_count = function (obj1, obj2) {
            var sl = obj2.html();
            count(sl);
            obj1.keyup(function () {
                count(sl);
            });
            obj1.mouseenter(function () {
                count(sl);
            });
            function count(number) {
                var wz = obj1.val();
                obj2.html(sl - wz.length);
                if (wz.length > sl) {
                    var wz2 = wz.slice(0, number);
                    obj1.val(wz2);
                }
            }
        }

        /*不同内容切换*/
        /*备注:需要传入两个对象，第一个为显示的对象，第二个为显示中要返回原先位置的对象。还需传入$(this)*/
        $.fn.show_hide = function (obj1, obj2) {
            var This = $(this);
            This.click(function () {
                This.parent().hide();
                obj1.show();
                obj2.click(function () {
                    This.parent().show();
                    obj1.hide();
                });
            });
        };
        /*判断浏览器是否兼容placeholder*/
        if('placeholder' in document.createElement('input')==false){
            $('input').each(function(){
                if($(this).attr('placeholder')!=''||$(this).attr('placeholder')!=undefined){
                    $(this).val($(this).attr('placeholder'));
                    $(this).blur(function(){
                        if($(this).val()==''){
                            $(this).val($(this).attr('placeholder'));
                        }
                    });
                    $(this).focus(function(){
                        if($(this).val()==$(this).attr('placeholder')){
                            $(this).val('');
                        }
                    });
                }
            });
        }
        /*控制全选反选多选框*/
        checkboxSelect = function (selector, options, operations) {
            if(operations) operations.attr('disabled', true);
            selector.click(function () {

                var state = selector.attr('checked') == 'checked';
                options.each(function () {
                    $(this).attr("checked", state);
                    if (state) {
                        operations.attr('disabled', false).removeClass('button-gray').addClass('button-white');
                    } else {
                        operations.attr('disabled', true).addClass('button-gray').removeClass('button-white');
                    }
                });
            })
            options.click(function () {
                var state = false;
                var operation = false;
                options.each(function () {
                    if ($(this).attr('checked') != 'checked') {
                        state = true;
                    } else {
                        operation = true;
                    }
                })
                if (state) {
                    selector.attr('checked', false);
                } else {
                    selector.attr('checked', true);
                }
                if (operation) {
                    operations.attr('disabled', false).removeClass('button-gray').addClass('button-white');
                } else {
                    operations.attr('disabled', true).addClass('button-gray').removeClass('button-white');
                }
            })
        };

        /*fixed*/
        $.fn.Header = function(){
            $(this).css({
                position:'absolute'
            });
            var ZHdiv = $(this).offset().top ;
            var _div = $(this);
            $(window).scroll( function(){
                var Hdiv = $(document).scrollTop();
                if(ZHdiv <= $(document).scrollTop()){
                    _div.css({
                        position: 'fixed',
                        top: '0'
                    });
                }else if($(document).scrollTop() < ZHdiv){
                    _div.css({
                        position:'absolute',
                        top : ZHdiv
                    });
                    //alert(ZHdiv);
                }
            });
        };
    })(jQuery);
})

/*点击获取选中的data-id*/
function select_data_id(obj1, obj2) {
    if(obj1.val()=='删除'){
        if (window.confirm('你确定要删除吗？？')) {
            select_data_fu ();
        }
    }else {
        select_data_fu ();
    }
    function select_data_fu (){
        var url = obj1.attr('data-href');
        var Select_array = [];
        obj2.each(function () {
            if ($(this).find('input:checkbox').attr('checked') == 'checked') {
                var data_id = $(this).attr('data-id');
                Select_array.push(data_id);
            }
        });
        if (url == ''||url==null) {//移动分组
            var url = obj1.attr('base_url');
            //var ids = Select_array;
            var Select_array_2 = [];
            Select_array_2.push('gather_id',obj1.attr('gather_id'));
            Select_array_2.push('type',obj1.attr('type1'));
            Select_array_2.push('multi',obj1.attr('multi'));
            var text1 = '/ids/'+Select_array;
            var text2 = Select_array_2.join("/");
            var text=text1+'/'+text2+'.html';
            url=url.replace('.html',text);
            obj1.attr('href', url);
            popup(obj1, '移动单图文分组', 390, 190);
        } else {//删除
            autoaction(url, Select_array);
        }
    }

}
//ajax 提交
function autoaction(url, ids) {
    var url = url;
    $.post(url, {queryString: "" + ids + ""},
    function (data) {

        location.reload();
        // var dd = JSON.parse(data); 
        //  $('#txt1').html(dd.countMoney);
    });
}
/**
 * 弹出框的显隐
 * @param {obecjt} object
 * @param {string} title
 * @param {int} width
 * @param {int} height
 * @returns {Boolean}
 */
function popup(object, title, width, height) {
    var url = object.attr('href');
    $('.popup-data').html('');
    $.get(url, '', function (data) {
        $('.popup-data').html(data);
    });
    var wd_height=$(window).height();
    var wd_width=$(window).width();
    title = title ? title : '操作界面';
    height = height ? height : 600;
    width = width ? width : 700;
    if(height>wd_height){ height = wd_height-100}
    if(width>wd_width){ width = wd_width-100}
    $('.popup .popup-title h3').text(title);
    $('.popup .popup-content').css({width: width, height: height, marginLeft: -width / 2, marginTop: -(height / 2 + 37)});
    $('.popup .popup-data').css({height: height - 54});
    $('.popup').show();
    $('.popup').find('.closed').live('click', function () {
        $('.popup').hide();
    });
    return false;
}

/*微信素材标题文字跟随输入框修改*/
function wechat_icovw(obj1, obj2, bt) {
    icovw_title();
    obj1.keyup(function () {
        icovw_title();
    });
    obj1.mouseenter(function () {
        icovw_title();
    });
    function icovw_title() {
        var wz = obj1.val();
        if (obj1.val() == '') {
            obj2.html(bt);
        } else {
            obj2.html(wz);
        }
    }
}

function notifyHide() {
    setTimeout(function () {
        $('.flash-success,.flash-error').fadeOut(100);
    }, 2000);
}

/*关闭（刷新）页面提示是否关闭*/
function web_release(obj) {
    $(window).bind('beforeunload', function () {
        return '本页面要求您确认您要离开 - 您输入的数据可能不会被保存？';
    });
    if (obj != '') {
        obj.on('click', function () {
            $(window).unbind('beforeunload');
            if (window.confirm('你确定要提交吗？')) {
                return true;
            } else {
                return false;
            }
        });
    }
}
/*删除提示*/
function element_del(obj, text) {
    obj.live('click', function () {
        if (window.confirm(text)) {
            return true;
        } else {
            return false;
        }
    });
}

/*查询省市区*/
function province_seek(obj) {
    var obj_one = obj.find('.city-one');
    var obj_tow = obj.find('.city-two');
    var obj_three = obj.find('.city-three');
    var html = "<option value=''>广州</option><option value=''>广州</option><option value=''>广州</option><option value=''>广州</option>";

    $.get("/site/index", function (xml) {
        var docXml = xml;
        var $provinceElements = $(docXml).find("province");

        //给省添加click事件，获得选中的值，并显示在
        obj_one.live('change', function () {
            var $clickPro = $(this).val();//获得点击修改后的省的id可省略在调用函数的时候传入id.
            //alert($clickPro);
            // 遍历省，找到与选中值相同的，得到所有的市
            var $flag = true;//作为判断条件
            $provinceElements.each(function (index, domEle) {
                var $provinceId = $(domEle).attr('id');
                if ($flag) {
                    if ($clickPro == $provinceId) {
                        $flag = false;//匹配成功，停止匹配。执行如下：
                        var $cityElements = $(domEle).find("city");//假设城市的属性为city
                        //遍历市并输入到相应class属性中
                        $cityElements.each(function (index, domEle) {
                            var $cityValue = $(domEle).attr("name");
                            obj_three.prepend(html);//将市放入（html为上面设置）
                        });
                    }
                }
            });
        });
        //区的遍历方式与省相似
    });

}

/**
 * 弹出框选择素材
 * @param {object} object
 * @param {object} vessel
 */
function popupSelect(object, vessel) {
    var id = object.attr('data-id');//得到选中的id
    var multi = object.attr('data-multi');//得到选中的是单图文还是多图文
    var type = object.attr('data-type');//得到选中的素材类型
    $('*').removeClass('selected');
    object.addClass('selected');
    vessel.attr('data-id', id).attr('data-multi', multi).attr('data-type', type);
}

function popupConfirm(object, source_file_id, source_file_multi, source_file_type, section) {
    var id = object.attr('data-id');//得到选中的id
    var multi = object.attr('data-multi');//得到选中的id
    var type = object.attr('data-type');//得到选中的id
    if(type){
        source_file_id.val(id);
        source_file_multi.val(multi);
        source_file_type.val(type);
        if (!section) {
            $('#news-section').html('').show();
            $('#news-section').html($('.selected').html());
            $('#text-section').hide();
            $('.popup').hide();
        }
    }else {
        alert('亲，你还未选择素材。');
    }
}

/*
* 音频点击播放方法
* clasa为视频点击的父元素对象$('对象名')
* clasb为音频标签（audio/embed）
*/
function voice(clasa,clasb){
    clasa.live('click',function(){
        if($(this).find(clasb).attr('name') == 'voi' ){
            $(clasb).each(function(){
                $(this)[0].pause();
                $(this).attr('name','voi');
            });
            clasa.removeClass('gif_icon');
            $(this).addClass('gif_icon');
            var audioEle = $(this).find(clasb)[0];
            audioEle.play();
            $(this).find(clasb).attr('name','');
            audioEle.loop = false;//音频播放完毕执行
            audioEle.addEventListener('ended', function () {
                clasa.removeClass('gif_icon');
            }, false);
        }else {
            clasa.removeClass('gif_icon');
            var audioEle = $(this).find(clasb)[0];
            audioEle.pause();
            $(this).find(clasb).attr('name','voi');
        }
    });
}

//处理单图文添加中计数bug问题
function ie7_text_count(obj,number) {
    var obj1 = obj.find('input,textarea');
    var obj2 = obj.find('em');
    preview_title();
    obj1.live('keyup',function () {
        preview_title();
    });
    obj1.live('mouseenter',function () {
        preview_title();
    });
    function preview_title() {
        var wz = obj1.val();
        obj2.html(wz.length);
        if (wz.length > number) {
            var wz2 = wz.slice(0, number);
            obj1.val(wz2);
            obj2.html(number);
        }
    }
};

/*
 *时间选择器
 * time_sorter == 开始结束时间
 * time_data == 显示的时间方式是否包含秒 传时间方式分三种 'YYYY-MM-DD hh:mm:ss' 'YYYY-MM-DD’'YYYY-MM'
 */
function time_sorter(start_id,finish_id,time_data){
    var start = {
        elem: start_id,
        format: time_data,
        //min: laydate.now(), //设定最小日期为当前日期
        //max: '2099-06-16 23:59:59', //最大日期
        //istime: true, //显示时间的
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: finish_id,
        format: time_data,
        //min: laydate.now(),
        //max: '2099-06-16 23:59:59',
        //istime: true, //是否显示时间
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
}
