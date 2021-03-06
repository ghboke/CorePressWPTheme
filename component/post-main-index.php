<?php
global $paged;
if (!$paged) {
    $paged = 1;
}

if (is_home() && $paged == 1) {
    global $set;

    if (wp_is_mobile()) {
        if ($set['ad']['index_1_phone'] != null) {
            ?>
            <div class="swiper-container carousel">
                <?php echo base64_decode($set['ad']['index_1_phone']); ?>
            </div>
            <?php
        }
    } else {
        if ($set['ad']['index_1'] != null) {
            ?>
            <div class="swiper-container carousel">
                <?php echo base64_decode($set['ad']['index_1']); ?>
            </div>
            <?php
        }
    }

    if ($set['index']['swiperlist'] != null || count($set['index']['swiperlist']) > 0) {
        ?>
        <?php if ($set['index']['swiperlist'] !== null && count($set['index']['swiperlist'])) {
            ?>
            <div>
                <div class="swiper-container carousel">
                    <div class="swiper-wrapper">
                        <?php
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
                    <div class="swiper-button-prev "></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        <?php } ?>
        <script>
            window.onload = function () {
                var mySwiper = new Swiper('.swiper-container', {
                    loop: true,
                    autoplay: true,
                    delay: 3000,
                    pagination: {
                        el: '.swiper-pagination',
                    },
                    // 如果需要前进后退按钮
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                })
            }
        </script>
        <?php
    }
    if ($set['index']['postcard'] != null || count($set['index']['postcard']) > 0) {
        $item_percent = 100 / $set['index']['postcardlinenumber'] - 1;
        ?>
        <style>
            .index-top-postcard-item {
                flex-basis: <?php echo $item_percent.'%';?>;
            }
        </style>
        <div class="index-top-postcard-plane">
            <div class="index-top-postcard-body">
                <?php
                foreach ($set['index']['postcard'] as $item) {
                    ?>
                    <div class="index-top-postcard-item">
                        <div class="index-top-postcard-main">
                            <div class="post-item-thumbnail">
                                <a href="<?php echo $item['url'] ?>"><img src="<?php echo $item['imgurl'] ?>"
                                                                          alt=""></a>
                            </div>
                            <?php if ($item['url'] != null) {
                                ?>
                                <div class="index-top-postcard-title">
                                    <a href="<?php echo $item['url'] ?>"><?php echo $item['title'] ?></a>
                                </div>
                                <?php
                            } ?>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

}

if (wp_is_mobile()) {
    if ($set['ad']['index_2_phone'] != null) {
        ?>
        <div class="swiper-container carousel">
            <?php echo base64_decode($set['ad']['index_2_phone']); ?>
        </div>
        <?php
    }
} else {
    if ($set['ad']['index_2'] != null) {
        ?>
        <div class="swiper-container carousel">
            <?php echo base64_decode($set['ad']['index_2']); ?>
        </div>
        <?php
    }
}
?>

<div class="post-list-page-plane">
    <div class="list-plane-title">
        <?php
        if (is_category()) {
            echo ' <p>' . single_cat_title('', false) . '</p>';
        } elseif (is_home()) {
            echo ' <p>最新文章</p>';
        } elseif (is_author()) {
            echo '<p>' . get_the_author() . ' 的文章</p>';
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
