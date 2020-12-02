<?php
if (is_home()) {
    global $set;
    if ($set['index']['swiperlist'] != null || count($set['index']['swiperlist']) > 0) {
        ?>
        <?php if ($set['index']['swiperlist'] !== null && count($set['index']['swiperlist'])) {
            ?>
            <div>
                <div class="swiper-container carousel">
                    <div class="swiper-wrapper">
                        <?php
                        //print_r($set['index']['swiperlist']);
                        foreach ($set['index']['swiperlist'] as $item) {
                            $target = '_blank';
                            if ($item['url'] == null) {
                                $item['url'] = 'javascript:void(0);';
                                $target = '';
                            }
                            echo '<div class="swiper-slide"><a href="' . $item['url'] . '" target="' . $target . '"><img src="' . $item['imgurl'] . '" alt=""></a>';
                            if ($item['title'] != null) {
                                echo '<h3 class="slide-title">' . $item['title'] . '</h3>';
                            }
                            echo '</div>'
                            ?>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="corepress-swiper-button-next corepress-swiper-button"><i class="fas fa-chevron-right"></i></div>
                    <div class="corepress-swiper-button-prev corepress-swiper-button"><i class="fas fa-chevron-left"></i></div>
                </div>
            </div>
        <?php } ?>
        <script>
            window.onload = function () {
                var mySwiper = new Swiper('.carousel', {
                    loop: true,
                    autoplay: true,
                    delay: 3000,
                    pagination: {
                        el: '.swiper-pagination',
                    },
                    // 如果需要前进后退按钮
                    navigation: {
                        nextEl: '.corepress-swiper-button-next',
                        prevEl: '.corepress-swiper-button-prev',
                    },
                })
            }
        </script>
        <?php
    }
}
?>
<div class="post-list-page-plane">
    <div class="list-plane-title">
        <?php
        if (is_category()) {
            echo ' <p>'.single_cat_title('', false).'</p>';
        } elseif (is_home()) {
            echo ' <p>最新文章</p>';
        } else {
            echo ' <p>最新文章</p>';
        }
        ?>
    </div>
    <ul class="post-list">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('component/post-list-item');
            }
        }
        ?>
    </ul>
    <div class="pages">
        <?php
        get_template_part('component/pageobj');
        ?>
    </div>
</div>
