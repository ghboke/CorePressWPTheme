<?php


class CorePress_comments_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'corepress_comments_widget',
            'CorePress最新评论',
            array(
                'description' => '显示最新评论'
            )
        );
    }

    function form($instance)
    {
        $num = isset($instance['number']) ? absint($instance['number']) : 5;
        $title = isset($instance['title']) ? $instance['title'] : '最新评论';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1"
                   value="<?php echo $num; ?>" size="3"/></p>
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
        $instance['num'] = absint($new_instance['num']);
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }

    function widget($args, $instance)
    {

        $this->widget_start($args, $instance);
        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        $comments = get_comments(
        /**
         * Filters the arguments for the Recent Comments widget.
         *
         * @param array $comment_args An array of arguments used to retrieve the recent comments.
         * @param array $instance Array of settings for the current widget.
         * @see WP_Comment_Query::query() for information on accepted arguments.
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         */
            apply_filters(
                'widget_comments_args',
                array(
                    'number' => $number,
                    'status' => 'approve',
                    'post_status' => 'publish',

                ),
                $instance
            )
        );
        foreach ($comments as $comment) {
            if ($comment->user_id) {
                $author_url = get_author_posts_url($comment->user_id);
                $userdata = get_userdata($comment->user_id);
                $display_name = $userdata->display_name;
            } else {
                $author_url = 'javascript:;';
                $display_name = $comment->comment_author;
            }
            $post_title = get_the_title($comment->comment_post_ID);
            $post_link = get_permalink($comment->comment_post_ID);
            ?>
            <li>
                <div class="widger-comment-plane">
                    <div class="widger-comment-info">
                        <div class="widger-comment-user">
                            <div class="widger-avatar">
                                <?php echo get_avatar($comment, 30, '', $display_name ? $display_name : '匿名'); ?>
                            </div>
                            <div class="widger-comment-name">
                                <?php echo $display_name; ?>
                            </div>
                        </div>
                        <div class="widger-comment-time">
                            <span><?php echo date('n月j日',strtotime($comment->comment_date)); ?></span>
                        </div>
                    </div>
                    <div class="widger-comment-excerpt">
                        <p><?php echo corepress_comment_face((utf8_excerpt($comment->comment_content, 55))); ?></p>
                    </div>
                    <p class="widger-comment-postlink">
                        评论于 <a href="<?php echo get_permalink($comment->comment_post_ID); ?>" target="_blank"><?php echo get_the_title($comment->comment_post_ID);?></a>
                    </p>
                </div>

            </li>

            <?php
        }
        //print_r(json_encode($comments));
        $this->widget_end($args, $instance);
    }
}

// register widget
function register_corepress_comments_widget()
{
    register_widget('CorePress_comments_widget');
}

add_action('widgets_init', 'register_corepress_comments_widget');