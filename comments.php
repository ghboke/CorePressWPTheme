<?php
if (post_password_required()) {
    return;
}
global $set;
?>
<?php
if (is_single()) {
    if (wp_is_mobile()) {
        if ($set['ad']['post_4_phone'] != null) {
            ?>
            <div class="ad-plane-post-comment">
                <?php echo base64_decode($set['ad']['post_4_phone']); ?>
            </div>
            <?php
        }
    } else {
        if ($set['ad']['post_4'] != null) {
            ?>
            <div class="ad-plane-post-comment">
                <?php echo base64_decode($set['ad']['post_4']); ?>
            </div>
            <?php
        }
    }
}
?>

<div id="comments" class="responsesWrapper">
    <?php if (comments_open()) {
        ?>
        <div class="reply-title">
            发表评论
        </div>
        <?php
    }
    ?>
    <?php

    $comment_face = '';
    if ($set['comment']['face'] == 1) {
        $comment_face = '<button class="popover-btn popover-btn-face" type="button"><i class="far fa-smile-wink"></i> 添加表情</button>
            <div class="conment-face-plane">
               ' . file_load_face() . '
            </div>
            ';
    }
    $title_reply = '';
    ?>
    <?php
    global $current_user;
    $regbtn = null;
    if (get_option('users_can_register')) {
        $regbtn = '<a href="' . wp_registration_url() . '"><button class="login-btn-header" style="margin-left: 20px">注册</button></a>';
    }
    if (!is_user_logged_in()) {
        $user_avatar = '<div class="comment-user-plane"><div class="logged-in-as"><img class="comment-user-avatar" src="' . get_avatar_url(esc_attr($commenter['comment_author_email']), array('size' => 48)) . '" alt=""></div>';
    } else {
        $user_avatar = '<div class="comment-user-plane"><div class="logged-in-as"><img class="comment-user-avatar" src="' . corepress_get_avatar_url($current_user->user_email, 48) . '" alt=""><a href="' . admin_url('profile.php') . '">' . $user_identity . '</a></div>';
    }
    if (comments_open()) {
        $comment_form_args = array(
            'submit_button' => '<div style="text-align: right">
            <input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" /></div>',
            'comment_notes_before' => '',
            'title_reply' => $title_reply,
            'class_submit' => 'button primary-btn',
            'comment_notes_after' => '',
            'id_form' => 'form_comment',
            'cancel_reply_link' => __('取消回复', 'corePress'),
            'comment_field' => $user_avatar . '<div class="comment_form_textarea_box"><textarea class="comment_form_textarea" name="comment" id="comment" placeholder="发表你的看法" rows="5"></textarea><div id="comment_addplane">' . $comment_face . '</div></div></div>',
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' => '<div class="comment_userinput"><div class="comment-form-author"><input id="author" name="author" placeholder="昵称(*)" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . ($req ? ' class="required"' : '') . '></div>',
                'email' => '<div class="comment-form-email"><input id="email" name="email" type="text" placeholder="邮箱(*)" value="' . esc_attr($commenter['comment_author_email']) . '"' . ($req ? ' class="required"' : '') . '></div>',
                'url' => '<div class="comment-form-url"><input id="url" placeholder="网址"name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30"></div></div>',
                'cookies' => '<div class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . (empty($commenter['comment_author_email']) ? '' : ' checked="checked"') . '> 记住用户信息</div>'
            )),
            'logged_in_as' => '',
            'comment_notes_before' => '',
            'must_log_in' => '<div class="comment_form_must_login"><p>登录后才能发表评论</p><div><a href="' . loginAndBack() . '"><button class="login-btn-header">登录</button></a>' . $regbtn . '</div></div>',
            'submit_field' => '<div class="form-submit">' . '%1$s %2$s</div>',

        );
        comment_form($comment_form_args);

    } ?>

    <meta content="UserComments:<?php echo number_format_i18n(get_comments_number()); ?>" itemprop="interactionCount">
    <h3 class="comments-title">共有 <span
                class="commentCount"><?php echo number_format_i18n(get_comments_number()); ?></span> 条评论</h3>

    <?php
    if (get_comments_number() == 0) {
        ?>
        <div class="comment-sofa">
            <i class="fas fa-couch"></i> 沙发空余
        </div>
        <?php
    } else {
        ?>
        <ol class="commentlist">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
                'type' => 'comment',
                'callback' => 'my_comment',
            ));
            ?>
        </ol>
        <?php
    }

    ?>

    <script type='text/javascript'
            src='<?php echo get_bloginfo('url') ?>/wp-includes/js/comment-reply.min.js?ver=5.1.1'></script>
    <script type='text/javascript'>

        $('body').on('click', '.comment-reply-link', function (e) {
            addComment.moveForm("li-comment-" + $(this).attr('data-commentid'), $(this).attr('data-commentid'), "respond", $(this).attr('data-postid'));
            console.log("li-comment-" + $(this).attr('data-commentid'), $(this).attr('data-commentid'), "respond", $(this).attr('data-postid'));
            e.stopPropagation();
            return false;
        });
        <?php
        if ($set['comment']['face'] == 1) {
        ?>
        $(document).click(function (e) {
            $('.conment-face-plane').css("opacity", "0");
            $('.conment-face-plane').css("visibility", "hidden");
            e.stopPropagation();
        });
        $('body').on('click', '.img-pace', function (e) {
            $('.comment_form_textarea').val($('.comment_form_textarea').val() + '[f=' + $(this).attr('facename') + ']')
        });
        $('body').on('click', '.popover-btn-face', function (e) {
            if ($('.conment-face-plane').css("visibility") == 'visible') {
                $('.conment-face-plane').css("opacity", "0");
                $('.conment-face-plane').css("visibility", "hidden");
            } else {
                $('.conment-face-plane').css("opacity", "1");
                $('.conment-face-plane').css("visibility", "visible");
            }
            e.stopPropagation();
        });
        <?php
        }
        ?>
    </script>
    <nav class="comment-navigation pages">
        <?php paginate_comments_links(array('prev_next' => true)); ?>
    </nav>
</div>