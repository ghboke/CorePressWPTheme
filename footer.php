<?php
global $set;
echo '<script>console.log("\n %c CorePress主题v ' . THEME_VERSIONNAME . ' %c by applek | www.lovestu.com", "color:#fff;background:#409EFF;padding:5px 0;", "color:#eee;background:#444;padding:5px 10px;");
</script>';
/*吃水不忘挖井人，请勿删除版权，让更多人使用，作者才有动力更新下去
删版权可能会影响SEO哦，good luck
*/

if ($set['code']['footcode'] != null) {
    echo base64_decode($set['code']['footcode']);
}
if ($set['code']['alifront'] != null) {
    echo '<script src="' . $set['code']['alifront'] . '"></script>';
}
?>

<div class="go-top-plane" title="返回顶部">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</div>
<script>

    var copynotmsg = 0;
    var reprint = {
        open: 0,
        msg: '',
        copylenopen: 0,
        copylen: 10,
        addurl: 0
    }
    <?php
    if ($set['module']['reprint']['open'] == 1) {
        echo 'reprint.open=1;';
        echo 'reprint.msg="' . $set['module']['reprint']['msg'] . '";';
        if ($set['module']['reprint']['copylenopen'] == 1) {
            echo 'reprint.copylenopen=1;';
            echo 'reprint.copylen=' . $set['module']['reprint']['copylen'] . ';';
        }
        if ($set['module']['reprint']['addurl'] == 1) {
            echo 'reprint.addurl=1;';
        }
    }
    ?>
    document.body.oncopy = function () {
        var copytext = window.getSelection().toString();
        if (copynotmsg == 0) {
            if (reprint.open == 1) {
                if (reprint.copylenopen == 1) {
                    if (copytext.length > reprint.copylen) {
                        addarelt('复制内容太长，禁止复制', 'erro');
                        JScopyText(' ');
                        copynotmsg = 0;
                    } else {
                        copyaddurl(copytext);
                    }
                } else {
                    copyaddurl(copytext);
                }
            }
        }
        copynotmsg = 0;
    }

    function copyaddurl(content) {
        if (reprint.addurl == 0) {
            addarelt(reprint.msg, 'succ');
        } else {

            if (content.length > 100) {
                addarelt(reprint.msg, 'succ');
                JScopyText(content + '\n 【来源：<?php echo curPageURL()?>，转载请注明】');
            } else {
                addarelt(reprint.msg, 'succ');

            }
        }
    }

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



        $('.menu-header-list > .menu-item-has-children');
        <?php
        if ($set['module']['imglightbox'] == 1) {

        if (is_page() || is_single()) {
        ?>
        var imgarr = $('.post-content-content').find('img').not('.c-downbtn-icon').not('.post-end-tools');

        for (var i = 0; i < imgarr.length; i++) {
            <?php
            if ($set['module']['imglazyload'] == 1) {
            ?>
            var imgurl = $(imgarr[i]).attr('data-original');
            <?php
            }else {
            ?>
            var imgurl = $(imgarr[i]).attr('src');
            <?php
            }
            ?>
            var html = imgarr[i].outerHTML;
            if ($(imgarr[i]).parent()[0].tagName != 'A') {
                $(imgarr[i]).replaceWith('<a data-fancybox="gallery" data-type="image" href="' + imgurl + '">' + html + '</a>');
            }
        }
        $.fancybox.defaults.buttons = [
            "close"
        ];
        $('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"], a[href*=".bmp"]').fancybox({});
        <?php
        }
        }
        ?>

        var i = 0;
        //文章目录
        var html = '';
        $(".post-content h2,.post-content h3").each(function () {
            var tagName = $(this)[0].tagName.toLowerCase();
            console.log();
            if ($(this).parent().attr('class') == 'zd-plane-content') {
                return;
            }
            $(this).attr('catalog', 'catalog-' + tagName + '-' + i);
            var clickargs = "go_catalog('catalog-" + tagName + "-" + i + "','" + tagName + "')";
            html = html + '<p catalogtagName="' + tagName + '" catalog="' + 'catalog-' + tagName + '-' + i + '" class="catalog-item" onclick="' + clickargs + '">' + $(this).html() + '</p>';
            i++;
        });
        $('#post-catalog-list').html(html);
        set_catalog_position();
        $('#post-catalog').css('visibility', 'visible');
        $('#post-catalog').css('opacity', '1');
        if ($(".post-content h2").length == 0 && $(".post-content h3").length == 0) {
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
        if (is_page() || is_single()) {
        if ($set['theme']['sidebar_position'] == 1) {
        ?>
        if ($('.post-info').length == 0) {
            return;
        }
        var title_x = $('.post-info').offset().left;

        $('#post-catalog').css('left', title_x - 200 + 'px');
        <?php
        }else {
        ?>
        var title_x = $('.post-info').offset().left;
        title_x = title_x + $('.post-info')[0].getBoundingClientRect().width
        $('#post-catalog').css('left', title_x + 40 + 'px');
        <?php
        }
        }
        ?>
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
    <?php
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
        <div class="footer-left">
            <div>
                <?php dynamic_sidebar('footer_widget'); ?>
                <?php
                get_template_part('component/nav-footer');
                //吃水不忘挖井人，请勿主题信息，让更多人使用，作者才有动力更新下去
                //删版权可能会影响SEO哦，good luck
                ?>
                <div class="footer-info">
                    Copyright © 2020 <?php bloginfo('name'); ?>
                    <span class="theme-copyright">
                     <a
                             href="https://www.lovestu.com/corepress.html">CorePress Theme</a>
                </span>
                    Powered by WordPress
                </div>
                <div class="footer-info">
                    <?php
                    if ($set['routine']['icp'] != null) {
                        echo '<span class="footer-icp"><img class="ipc-icon" src="' . file_get_img_url('icp.svg') . '" alt=""><a href="https://beian.miit.gov.cn/" target="_blank">' . $set['routine']['icp'] . '</a></span>';
                    }
                    if ($set['routine']['police'] != null) {
                        echo '<span class="footer-icp"><img class="ipc-icon" src="' . file_get_img_url('police.svg') . '" alt=""><a href="http://www.beian.gov.cn/portal/registerSystemInfo/" target="_blank">' . $set['routine']['police'] . '</a></span>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="footer-details footer-right">
            <div>
                <?php
                dynamic_sidebar('footer_widget_right');
                ?>
            </div>

        </div>
        <div>
            <?php wp_footer(); ?>
        </div>
    </div>
</div>

