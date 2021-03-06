<!doctype html>
<html lang="zh">
<head>
    <?php get_header(); ?>
</head>
<body>

<div id="app">
    <header>
        <div class="header-main-plane">
            <div class="header-main container">
                <?php
                get_template_part('component/nav-header');
                ?>
            </div>
        </div>
    </header>
    <div class="top-divider"></div>
    <main class="container">
        <div class="html-main">
            <?php
            global $set;
            if ($set['theme']['sidebar']['other']) {
                ?>
                <style>
                    body .post-info-right {
                        display: none;
                    }

                    .post-item-thumbnail img {
                        max-width: 336px;
                    }
                    .post-item-content,.post-item-info  {
                        font-size: 16px;
                    }
                    .post-item h2 {
                        font-size: 22px;

                    }
                </style>
                <div class="post-main post-main-closesidebar" style="flex-basis: 100%;">
                    <?php
                    get_template_part('component/post-main-index');
                    ?>
                </div>
                <?php
            } else
                if ($set['theme']['sidebar_position'] == 1) {
                    ?>
                    <div class="post-main">
                        <?php get_template_part('component/post-main-index'); ?>
                    </div>
                    <div class="sidebar">
                        <?php dynamic_sidebar('index_sidebar'); ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="sidebar">
                        <?php dynamic_sidebar('index_sidebar'); ?>
                    </div>
                    <div class="post-main">
                        <?php get_template_part('component/post-main-index'); ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </main>
    <footer>
        <?php
        wp_footer();
        get_footer(); ?>
    </footer>
</div>
</body>
</html>
<?php
