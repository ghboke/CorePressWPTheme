<?php


class CorePress_author_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'corepress_author_widget',
            'CorePress作者模块',
            array(
                'description' => '显示作者的一些信息，建议放到文章页面侧边栏，否则无法获取到内容'
            )
        );
    }

    function form($instance)
    {
        $num = isset($instance['number']) ? absint($instance['number']) : 5;
        $title = isset($instance['title']) ? $instance['title'] : '作者信息';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/></p>
        <p>请放到文章侧边栏，否则无法获取到作者用户信息</p>
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
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }

    function widget($args, $instance)
    {

        $this->widget_start($args, $instance);
        $author_id = get_the_author_meta('ID');
        $author_description = get_the_author_meta('description');
        $author_url = get_author_posts_url($author_id);
        $author_name = get_the_author();
        $avatar = get_avatar($author_id, 50, '');

        ?>
        <div class="widget-author-plane">
            <div class="widget-author-main">
                <?php echo $avatar; ?>
                <div class="widget-author-name">
                    <?php echo $author_name ?>
                </div>
                <div class="widget-avatar-description">
                    <?php echo $author_description ?>
                </div>
                <div class="widget-avatar-meta">
                    <div class="widget-avatar-meta-box widget-avatar-meta-comments" title="评论数量">
                        <i class="far fa-comment"></i>
                        <?php echo get_comments('count=true&user_id=' . $author_id); ?>
                    </div>
                    <div class="widget-avatar-meta-box" title="文章数量">
                        <i class="far fa-newspaper"></i>
                        <?php
                        the_author_posts();
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="widget-avatar-post-list">
            <h2 class="widget-avatar-title">近期文章</h2>
            <ul>
                <?php
                $post_list = get_posts(array('numberposts' => 5, 'author' => $author_id));
                foreach ($post_list as $item) {
                    echo '<li><a href="' . get_the_permalink($item) . '">' . $item->post_title . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <?php
        //print_r(json_encode($comments));
        $this->widget_end($args, $instance);
    }
}

// register widget
function register_corepress_author_widget()
{
    register_widget('CorePress_author_widget');
}

add_action('widgets_init', 'register_corepress_author_widget');