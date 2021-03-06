<?php
the_post();
global $set;
?>
    <!doctype html>
    <html lang="zh">
    <head>
        <?php get_header(); ?>
    </head>
    <body>
    <div id="app">
        <header>
            <div class="header-main container">
                <?php
                get_template_part('component/nav-header');
                ?>
            </div>
        </header>
        <div class="top-divider"></div>
        <main class="container">
            <?php
            if (wp_is_mobile()) {
                if ($set['ad']['post_1_phone'] != null) {
                    ?>
                    <div class="ad-plane-post">
                        <?php echo base64_decode($set['ad']['post_1_phone']); ?>
                    </div>
                    <?php
                }
            } else {
                if ($set['ad']['post_1'] != null) {
                    ?>
                    <div class="ad-plane-post">
                        <?php echo base64_decode($set['ad']['post_1']); ?>
                    </div>
                    <?php
                }
            }

            ?>

            <div class="html-main">
                <?php
                global $corepress_post_meta;
                if ($corepress_post_meta['closesidebar'] == 1 || $set['theme']['sidebar']['post']) {
                    ?>
                    <style>
                        body .post-info-right {
                            display: none;
                        }
                    </style>
                    <div class="post-main post-main-closesidebar" style="flex-basis: 100%;">
                        <?php
                        get_template_part('component/post-content');
                        ?>
                    </div>
                    <?php
                } else {
                    if ($set['theme']['sidebar_position'] == 1) {
                        ?>
                        <div class="post-main">
                            <?php get_template_part('component/post-content'); ?>
                        </div>
                        <div class="sidebar">
                            <div class="sidebar-box-list">
                                <?php dynamic_sidebar('post_sidebar'); ?>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="sidebar">
                            <div class="sidebar-box-list">
                                <?php dynamic_sidebar('post_sidebar'); ?>
                            </div>
                        </div>
                        <div class="post-main">
                            <?php get_template_part('component/post-content'); ?>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
            <?php
            if (wp_is_mobile()) {
                if ($set['ad']['post_5_phone'] != null) {
                    ?>
                    <div class="ad-plane-post-bottom">
                        <?php echo base64_decode($set['ad']['post_5_phone']); ?>
                    </div>
                    <?php
                }
            } else {
                if ($set['ad']['post_5'] != null) {
                    ?>
                    <div class="ad-plane-post-bottom">
                        <?php echo base64_decode($set['ad']['post_5']); ?>
                    </div>
                    <?php
                }
            }
            ?>
        </main>
        <footer>
            <?php get_footer(); ?>
        </footer>
    </div>
    </body>
    </html>
<?php
