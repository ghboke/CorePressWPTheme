<script>
    function openMenu() {
        $('body').css('overflow', 'hidden');
        $(".drawer-menu-plane").addClass("drawer-menu-plane-show");
        $(".menu-plane").appendTo($(".drawer-menu-list"));
        $(".user-menu-plane").appendTo($(".drawer-menu-list"));
        $(".menu-item-has-children").append('<div class="m-dropdown"><i class="fa fa-angle-down"></i></div>')
        $(".user-menu-main").append('<div class="m-dropdown"><i class="fa fa-angle-down"></i></div>')

    }

    function closeMenu() {
        $('body').css('overflow', 'auto');
        $(".drawer-menu-plane").removeClass("drawer-menu-plane-show");
        $(".user-menu-plane").prependTo($(".header-menu"));
        $(".menu-plane").prependTo($(".header-menu"));

        $(".m-dropdown").remove();
    }

    function openSearch() {
        //$('body').css('overflow', 'hidden');
        $(".dialog-search-plane").addClass("dialog-search-plane-show");
    }

    function closeSearch() {
        //$('body').css('overflow', 'auto');
        $(".dialog-search-plane").removeClass("dialog-search-plane-show");
    }
</script>
<div class="mobile-menu-btn" onclick="openMenu()">
    <i class="fa fa-bars" aria-hidden="true"></i>
</div>
<div class="drawer-menu-plane">
    <div class="drawer-menu-list">
    </div>
    <div class="drawer-menu-write" onclick="closeMenu()">
    </div>
</div>
<div class="header-logo-plane">
    <div class="header-logo">
        <?php
        global $set;
        $logourl = $set['routine']['logo'];
        if ($logourl == '') {
            echo '<a href="' . get_bloginfo('url') . '"><h2>CorePress</h2></a>';
        } else {
            echo '<a href="/"><img src="' . $logourl . '" alt=""></a>';
        }
        ?>
    </div>
</div>
<div class="mobile-search-btn" onclick="openSearch()">
    <i class="fa fa-search"></i>
</div>
<div class="dialog-search-plane">
    <div class="dialog-mask" onclick="closeSearch()"></div>
    <div class="dialog-plane">
        <h2>搜索内容</h2>
        <form class="search-form" action="<?php echo get_bloginfo('url'); ?>" method="get" role="search">
            <div class="search-form-input-plane">
                <input type="text" class="search-keyword" name="s" placeholder="搜索内容"
                       value="<?php echo get_search_query(); ?>">
            </div>
            <div>
                <button type="submit" class="search-submit" value="&#xf002;">搜索</button>
            </div>
        </form>
    </div>
</div>


<div class="header-menu">
    <div class="menu-plane">
        <?php
        wp_nav_menu(array(
                'menu' => 'header_menu',
                'theme_location' => 'header_menu',
                'depth' => 3,
                'container' => 'nav',
                'container_class' => 'menu-header-plane',
                'menu_class' => 'menu-header-list',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
            )
        );
        ?>

    </div>
    <div class="user-menu-plane">
        <div class="user-menu-pc-search" onclick="openSearch()" title="搜索">
            <i class="fal fa-search"></i>
        </div>
        <?php
        if (islogin()) {
            ?>
            <ul class="user-menu">
                <li>
                    <a class="user-menu-main"><img class="user-avatar" width="30" height="30"
                                                   src="<?php echo corepress_get_avatar_url() ?>" alt=""><span
                                class="user-menu-name"><?php echo corepress_get_user_nickname() ?></span></a>
                    <ul class="user-sub-menu">
                        <?php
                        if ($set['user']['usercenter'] == 1 && $set['user']['usercenterurl'] != null) {
                            echo ' <li><a href="' . $set['user']['usercenterurl'] . '"><i class="fas fa-user-cog"></i> 账号设置</a></li>';
                        }
                        ?>

                        <?php
                        if (isadmin()) {
                            ?>
                            <li><a href="<?php echo admin_url(); ?>"><i class="fas fa-tachometer-alt"></i> 管理中心</a></li>
                            <li><a href="<?php echo admin_url() . 'post-new.php'; ?>"><i class="far fa-edit"></i>
                                    新建文章</a></li>
                            <?php
                        }

                        ?>
                        <li><a href="<?php echo wp_logout_url(get_bloginfo('url')) ?>"><i
                                        class="fas fa-sign-out-alt"></i> 退出登录</a></li>
                    </ul>
                </li>
            </ul>
            <?
        } else {
            if ($set['user']['hideloginbtn'] != 1) {
                ?>
                <span class="user-menu-main">
                 <a href="<?php echo loginAndBack(); ?>"><button class="login-btn-header">登录</button></a>

            <?php if (get_option('users_can_register')) {
                ?>
                <a href="<?php echo wp_registration_url(); ?>"><button
                            class="login-btn-header reg-btn-header">注册</button></a>
                <?
            } ?>
            </span>
                <?
            }

        }
        ?>
    </div>
</div>

