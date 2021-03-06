<?php


class CorePress_hot_post_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'corepress_hot_post_widget',
            'CorePress热门文章',
            array(
                'description' => '热门文章排行'
            )
        );
    }

    function form($instance)
    {
        $num = isset($instance['number']) ? absint($instance['number']) : 5;
        $title = isset($instance['title']) ? $instance['title'] : '热门文章';
        $type = isset($instance['type']) ? $instance['type'] : 'comment';

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>">文章数量</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1"
                   value="<?php echo $num; ?>" size="3"/></p>


        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>">文章数量</label>
            <select name="<?php echo $this->get_field_name('type'); ?>">
                <option value="view" <?php if ($type == 'view') echo 'selected' ?>>阅读量</option>
                <option value="comment"<?php if ($type == 'comment') echo 'selected' ?>>评论</option>
            </select>
        </p>
        <?php
    }

    public function widget_start($args, $instance)
    {
        echo $args['before_widget'];
        if ($title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
    }

    public function widget_end($args)
    {
        echo $args['after_widget'];
    }


    function update($new_instance, $old_instance)
    {
        /*  $instance = $old_instance;
          $instance['num'] = absint($new_instance['num']);
          $instance['title'] = sanitize_text_field($new_instance['title']);*/
        return $new_instance;
    }

    function widget($args, $instance)
    {

        $this->widget_start($args, $instance);
        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        $type = (!empty($instance['type'])) ? $instance['type'] : 'comment';
        if ($type == 'comment') {
            $the_query = new WP_Query(array('order' => 'DESC', 'orderby' => 'comment_count', 'posts_per_page' => $number));

        } elseif ($type == 'view') {
            $the_query = new WP_Query(array('order' => 'DESC', 'orderby' => 'meta_value_num', 'meta_key'=>'views','posts_per_page' => $number));
        }

        if ($the_query->have_posts()) {
            $postitem = array();
            $i = 0;
            while ($the_query->have_posts()) {
                $i++;
                $the_query->the_post();
                $postitem['title'] = get_the_title();
                $postitem['time'] = get_the_time('Y-m-d');
                $postitem['category'] = get_the_category();
                $postitem['url'] = get_the_permalink();
                ?>
                <div class="hot-post-widget-item">
                    <div>
                            <span class="hot-post-widget-item-num">
                                    <?php echo $i; ?>
                            </span>
                        <span class="hot-post-widget-item-title">
                                <a href="<?php echo $postitem['url']; ?>"> <?php echo $postitem['title'] ?></a>
                            </span>
                    </div>
                    <div class="hot-post-widget-item-meta">
                        <div>
                            <?php echo $postitem['time']; ?>
                        </div>
                        <div>
                            <a href="<?php echo get_category_link($postitem['category'][0]->cat_ID) ?>"> <?php echo $postitem['category'][0]->name ?></a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <?php


        ?>

        <?php

        $this->widget_end($args, $instance);
    }
}

// register widget
function register_corepress_hot_post_widget()
{
    register_widget('CorePress_hot_post_widget');
}

add_action('widgets_init', 'register_corepress_hot_post_widget');