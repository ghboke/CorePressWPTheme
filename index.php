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
            if ($set['theme']['sidebar']['index']) {
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
            } else if ($set['theme']['sidebar_position'] == 1) {
                ?>
                <div class="post-main">
                    <?php get_template_part('component/post-main-index'); ?>
                </div>
                <div class="sidebar">
                    <div class="sidebar-box-list">
                        <?php dynamic_sidebar('index_sidebar'); ?>
                    </div>
                </div>

                <?php
            } else {
                ?>
                <div class="sidebar">
                    <div class="sidebar-box-list">
                        <?php dynamic_sidebar('index_sidebar'); ?>
                    </div>
                </div>
                <div class="post-main">
                    <?php get_template_part('component/post-main-index'); ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if ($set['index']['links'] == 1) {
            ?>
            <div class="frinds-links">
                <div class="list-plane-title">
                    <div>友情链接 <span
                                class="list-plane-linksdescribe"><?php echo $set['index']['linksdescribe']; ?></span>
                    </div>
                    <?php
                    if ($set['index']['applylink'] != null) {
                        ?>
                        <a href="<?php echo $set['index']['applylink'] ?>" class="frinds-links-apply">申请友链</a>
                        <?php
                    }
                    ?>
                </div>
                <div class="frinds-links-list">
                    <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
                </div>
            </div>
            <?php
        }
        if (wp_is_mobile()) {
            if ($set['ad']['index_3_phone'] != null) {
                ?>
                <div class="ad-plane">
                    <?php echo base64_decode($set['ad']['index_3_phone']); ?>
                </div>
                <?php
            }
        } else {
            if ($set['ad']['index_3'] != null) {
                ?>
                <div class="ad-plane">
                    <?php echo base64_decode($set['ad']['index_3']); ?>
                </div>
                <?php
            }
        }
        ?>

    </main>
    <footer>
        <?php
        wp_footer();
        get_footer(); ?>
    </footer>
</div>
</body>
</html>
