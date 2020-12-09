<?php
global $set;

echo '<script>console.log("\n %c CorePress主题v ' . THEME_VERSIONNAME . ' %c by applek | www.lovestu.com", "color:#fff;background:#409EFF;padding:5px 0;", "color:#eee;background:#444;padding:5px 10px;");
</script>';
/*吃水不忘挖井人，请勿删除版权，让更多人使用，作者才有动力更新下去*/
if ($set['code']['footcode'] != null) {
    echo base64_decode($set['code']['footcode']);
}
?>
<div class="go-top-plane" title="返回顶部">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</div>
<script>
    $('.go-top-plane').click(function () {
        $('html,body').animate({scrollTop: '0px'}, 500);
    });
    $(document).scroll(function () {
        var scroH = $(document).scrollTop();  //滚动高度
        var viewH = $(window).height();  //可见高度
        var contentH = $(document).height();  //内容高度
        if (scroH > 100) {  //距离顶部大于100px时
            $('.go-top-plane').addClass('go-top-plane-show')
        } else {
            $('.go-top-plane').removeClass('go-top-plane-show')
        }
        if (contentH - (scroH + viewH) <= 100) {  //距离底部高度小于100px
        }
        if (contentH == (scroH + viewH)) {  //滚动条滑到底部啦
        }
    });

    $(document).ready(function () {
        <?php
        if ($set['module']['imglightbox'] == 1) {
        ?>
        var imgarr = $('.post-content-content').find('img');
        for (var i = 0; i < imgarr.length; i++) {
            var imgurl = $(imgarr[i])[0].src;
            var html = imgarr[i].outerHTML;
            if ($(imgarr[i]).parent()[0].tagName != 'A') {
                $(imgarr[i]).replaceWith('<a data-fancybox="gallery" data-type="image" href="' + imgurl + '">' + html + '</a>');
            }
        }
        $.fancybox.defaults.buttons = [
            "close"
        ];
        $('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"], a[href*=".bmp"]').fancybox({});
        <?
        }
        ?>

        var i = 0;
        //文章目录
        var html = '';
        $(".post-content h2,.post-content h3").each(function () {
            var tagName = $(this)[0].tagName.toLowerCase();
            $(this).attr('catalog', 'catalog-' + tagName + '-' + i);
            var clickargs = "go_catalog('catalog-" + tagName + "-" + i + "','" + tagName + "')";
            html = html + '<p catalogtagName="' + tagName + '" catalog="' + 'catalog-' + tagName + '-' + i + '" class="catalog-item" onclick="' + clickargs + '">' + $(this).html() + '</p>';
            i++;
        });
        $('#post-catalog-list').html(html);
        set_catalog_position();
        $('#post-catalog').css('visibility', 'visible');
        $('#post-catalog').css('opacity', '1');
        if ($(".post-content h2").length == 0) {
            $('#post-catalog').css('visibility', 'hidden');
        }

        $('.corepress-code-pre>code').each(function () {
            $(this).html(replaceTag($(this).html()));
        });
    });

    $(window).resize(function () {
        set_catalog_position();
    });
    $(document).scroll(function () {
        if ($('#post-catalog').css('visibility') != 'visible') {
            return;
        }
        $(".post-content h2[catalog],.post-content h3[catalog]").each(function () {
            var el_y = this.getBoundingClientRect().y;
            if (el_y < 100 && el_y > 0) {
                var name = $(this).attr('catalog');
                set_catalog_css();
                $('p[catalog=' + name + ']').addClass('catalog-hover');

                return;
            }

        });
    });

    function close_show(type) {
        if (type == 1) {
            $('.post-catalog-main').removeClass('post-catalog-main-hide')
        } else {
            $('#post-catalog').addClass('post-catalog-hide')
        }
    }

    function set_catalog_css() {
        $('p[catalog]').removeClass('catalog-hover');
    }

    function set_catalog_position() {

        <?php
        global $corepress_post_meta;
        if ($corepress_post_meta['catalog'] != 1) {

        }
        if ($set['theme']['sidebar_position'] == 1) {
        ?>
        var title_x = $('.post-info').offset().left;
        $('#post-catalog').css('left', title_x - 200 + 'px');
        <?php
        }else {
        ?>
        var title_x = $('.post-info').offset().left;
        title_x = title_x + $('.post-info')[0].getBoundingClientRect().width
        $('#post-catalog').css('left', title_x + 40 + 'px');
        <?php
        }?>
    }

    function go_catalog(catalogname, tagName) {
        var _scrolltop = $(tagName + '[catalog=' + catalogname + ']').offset().top;
        $('html, body').animate({
                scrollTop: _scrolltop - 60
            }, 500
        );
    }

    <?php
    global $set;
    if ($set['module']['imglazyload'] == 1) {
    ?>
    $(document).ready(
        function () {
            $("img").lazyload({effect: "fadeIn"});
        }
    )
    <?
    }
    ?>
</script>
<?php
if ($set['module']['highlight'] == 1) {
    if (is_single() || is_page()) {
        file_load_lib('highlight/init.js', 'js');
    }
}
?>

<div class="footer-plane">
    <div class="footer-container">
        <div>
            <?php dynamic_sidebar('footer_widget'); ?>
        </div>
        <div>
            <?php
            get_template_part('component/nav-footer');
            ?>
            <!--吃水不忘挖井人，请勿删除版权，让更多人使用，作者才有动力更新下去-->
            <div class="footer-info">
                Copyright © 2020 <?php bloginfo('name'); ?> · <a
                        href="https://www.lovestu.com/corepress.html">CorePress主题</a><?php
                if ($set['routine']['icp'] != null) {
                    echo '·' . '<a href="https://beian.miit.gov.cn/" target="_blank">' . $set['routine']['icp'] . '</a>';
                }
                ?>
            </div>
        </div>
        <div class="footer-details">
            <div><?php
                if ($set['routine']['footer_1_imgurl'] != null) {
                    ?>
                    <img src="<?php echo $set['routine']['footer_1_imgurl'] ?>" alt="">
                    <?
                }
                ?>
                <p><?php echo $set['routine']['footer_1_imgname'] ?></p>
            </div>
            <div>
                <?php
                if ($set['routine']['footer_2_imgurl'] != null) {
                    ?>
                    <img src="<?php echo $set['routine']['footer_2_imgurl'] ?>" alt="">
                    <?
                }
                ?>
                <p><?php echo $set['routine']['footer_2_imgname'] ?></p>
            </div>
        </div>
    </div>
</div>

