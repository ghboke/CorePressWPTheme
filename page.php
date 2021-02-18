<?php
the_post();
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
            <div class="html-main">
                <?php
                global $set;
                global $corepress_post_meta;
                if ($corepress_post_meta['closesidebar'] == 1) {
                    ?>
                    <style>
                        body .post-info-right {
                            display: none;
                        }
                    </style>
                    <div class="post-main post-main-closesidebar" style="flex-basis: 100%;">
                        <?php
                        get_template_part('component/post-page');
                        ?>
                    </div>
                    <?php
                } else {
                    if ($set['theme']['sidebar_position'] == 1) {
                        ?>
                        <div class="post-main">
                            <?php get_template_part('component/post-page'); ?>
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
                            <?php get_template_part('component/post-page'); ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </main>
        <footer>
            <?php get_footer(); ?>
        </footer>
    </div>
    </body>
    </html>
<?php
