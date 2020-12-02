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
    <main class="container">
        你找的内容丢了
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
