<?php
// TEMPLATE NAME: CorrPress全宽页面
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
    <div style="min-height: 80px;width: 100%;"></div>
    <main class="container">
        <div class="html-main">
            <?php
            global $set;
            if ($set['theme']['sidebar_position'] == 1) {
                ?>
                <div class="post-main post-main-full">
                    <?php get_template_part('component/post-content'); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="post-main post-main-full">
                    <?php get_template_part('component/post-content'); ?>
                </div>
                <?php
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
