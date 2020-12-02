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
    <div style="min-height: 80px;width: 100%;"></div>
    <main class="container">
        <div class="html-main">
            <?php
            global $set;
            if ($set['theme']['sidebar_position'] == 1) {
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
                    <p>友情链接</p>
                    <?php
                    if ($set['index']['applylink'] != null) {
                        ?>
                        <a href="<?php echo $set['index']['applylink'] ?>" class="frinds-links-apply">申请友链</a>
                        <?
                    }
                    ?>
                </div>
                <div class="frinds-links-list">
                    <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
                </div>
            </div>
            <?
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
