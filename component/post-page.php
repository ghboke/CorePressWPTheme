<?php
global $corepress_post_meta;
if ($corepress_post_meta['postrighttag']['open'] == 1) {
    ?>
    <style>
        .post-content:before {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            color: #fff;
            width: 0;
            height: 0;
            border-top: 80px solid<?php echo $corepress_post_meta['postrighttag']['color']?>;
            border-left: 80px solid transparent;
        }

        .post-content:after {
            content: "<?php echo $corepress_post_meta['postrighttag']['text']?>";
            color: #fff;
            position: absolute;
            right: 10px;
            top: 14px;
            z-index: 9;
            transform: rotate(45deg);
        }
    </style>
    <?php
}
?>
    <style>
        .post-content{
            box-shadow: 0 0 2px 0 rgba(98, 124, 153, .1);
            margin-bottom: 10px;
            background: #fff;
            overflow: hidden;
        }
    </style>
    <div class="post-content">
        <h1 class="post-title">
            <?php the_title();
            global $set;
            ?>
        </h1>
        <div class="post-info">
            <div class="post-info-left">
                <?php
                $author = get_the_author_meta('ID');
                $author_url = get_author_posts_url($author);
                $author_name = get_the_author();
                ?>
                <a class="nickname url fn j-user-card" data-user="<?php echo $author; ?>"
                   href="<?php echo $author_url; ?>"><i class="fa fa-user"
                                                        aria-hidden="true"></i><?php echo $author_name; ?>
                </a>
                <span class="dot">•</span>
                <time class="entry-date published"
                      datetime="<?php echo get_post_time('c', false, $post); ?>>" pubdate><i class="far fa-clock"></i>
                    <?php echo format_date(get_post_time('U', false, $post)); ?>
                </time>
                <?php if (function_exists('the_views')) {
                    $views = intval(get_post_meta($post->ID, 'views', true));
                    ?>
                    <span class="dot">•</span>
                    <span><i class="fa fa-eye"
                             aria-hidden="true"></i><?php echo sprintf('%s 阅读', $views); ?></span>
                <?php }
                if (get_edit_post_link() != null) {
                    ?>
                    <span class="dot">•</span>
                    <a href="<?php echo get_edit_post_link(); ?>"><i class="fas fa-edit"></i> 编辑</a>
                    <?php
                }
                ?>
            </div>
            <div class="post-info-right">
            <span title="关闭或显示侧边栏" class="post-info-switch-sidebar post-info-switch-sidebar-show"><i
                        class="fas fa-toggle-on"></i></span>
            </div>
        </div>
        <div class="post-content-post">
            <div class="post-content-content">
                <?php
                the_content();
                ?>
            </div>

            <div class="post-end-tools">
                <script>
                    $(document).click(function (e) {
                        $('#share-plane').removeClass("share-plane-show");
                        $('#qrcode-plane').removeClass("share-plane-show");
                        e.stopPropagation();
                    });
                    $('.post-info-switch-sidebar').click(function () {
                        $('.sidebar').toggleClass('sidebar-display');
                        $('.post-main').toggleClass('post-main-full');
                        $(this).toggleClass('post-info-switch-sidebar-show');

                    })
                    $('.clickshow').click(function () {
                        $('#share-plane').removeClass("share-plane-show");
                        $('#qrcode-plane').removeClass("share-plane-show");
                        $(this).toggleClass('clickshow-show');
                    });
                    $('.post-share-btn').click((e) => {
                        $('#share-plane').removeClass("share-plane-show");
                        $('#qrcode-plane').removeClass("share-plane-show");
                        $('#share-plane').addClass("share-plane-show");
                        e.stopPropagation();
                    });
                    $('.post-qrcode-btn').click((e) => {
                        $('#qrcode-plane').addClass("share-plane-show");
                        e.stopPropagation();
                    });


                    $(this).next().animate({height: '100%'}, 500);
                    $('.zd-plane-title').click(function (e) {
                        if (!$(this).hasClass('zd-plane-title-zk')) {
                            $(this).addClass('zd-plane-title-zk');
                            $(this).next().slideDown();
                        } else {
                            $(this).removeClass('zd-plane-title-zk')
                            $(this).next().slideUp();
                        }
                    })
                    var clipboard = new ClipboardJS('.code-bar-btn-copy-fonticon', {
                        text: function (trigger) {
                            return $(trigger).parent().prev().text();
                        }
                    });

                    var copy_pwd = new ClipboardJS('.btn-copy-pwd', {
                        text: function (trigger) {
                            return $(trigger).parent().find('.c-downbtn-pwd-key').text();
                        }
                    });
                    copy_pwd.on('success', function (e) {
                        $(e.trigger).toggleClass('fal fa-clone')
                        $(e.trigger).toggleClass('fal fa-check')
                        setTimeout(function () {
                            $(e.trigger).toggleClass('fal fa-clone')
                            $(e.trigger).toggleClass('fal fa-check')
                        }, 2000);
                    });


                    clipboard.on('success', function (e) {
                        $(e.trigger).toggleClass('fal fa-clone')
                        $(e.trigger).toggleClass('fal fa-check')
                        setTimeout(function () {
                            //$(e.trigger).text('复制')
                            $(e.trigger).toggleClass('fal fa-clone')
                            $(e.trigger).toggleClass('fal fa-check')
                        }, 2000);
                    });
                    clipboard.on('error', function (e) {
                        $(e.trigger).toggleClass('fal fa-clone')
                        $(e.trigger).toggleClass('fal times')
                        setTimeout(function () {
                            $(e.trigger).toggleClass('fal fa-clone')
                            $(e.trigger).toggleClass('fal times')
                        }, 2000);
                    });
                </script>
            </div>
            <div class="post-tool-plane">
                <?php
                if ($corepress_post_meta['catalog'] == 1) {
                    ?>
                    <div id="post-catalog">
                        <div class="catalog-title">文章目录</div>
                        <div id="post-catalog-list">
                        </div>
                        <div class="catalog-close" onclick="close_show(0)">关闭</div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
if (comments_open() != 0) {
    comments_template();
}
?>