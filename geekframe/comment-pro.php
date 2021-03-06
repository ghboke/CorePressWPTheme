<?php
function my_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    $reply = '';
    if ($depth > 0 && $comment->comment_parent) {
        $reply = get_comment_author($comment->comment_parent);
        if ($reply) {
            $reply = '<span class="comment-from">@<a href="#comment-' . $comment->comment_parent . '">' . $reply . '</a></span>';
        } else {
            $reply = '';
        }
    }
    $user = get_userdata($comment->user_id);
    if (!empty($user->roles) && in_array('administrator', $user->roles)) {
        $user = '<span class="user-identity user-admin" title="管理员"><svg t="1600335403368" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2033" width="200" height="200"><path d="M26.284569 116.246723l431.047428 0 0 36.312877c-25.941382 3.518578-44.072532 9.081832-53.923827 16.957087-10.053595 7.842743-15.082199 20.074677-15.082199 36.833077 0 23.763042 16.689762 74.236929 50.105412 151.385536 33.415649 77.033006 80.302321 173.569915 140.865928 289.534862 63.189896-140.226515 106.659141-241.340464 130.017583-303.327397 23.32593-62.153108 34.990701-104.751739 34.990701-127.990969 0-19.388302-6.032879-34.033387-17.878276-43.639032-12.083821-9.80072-31.988711-16.238199-59.974769-19.236577L666.452551 116.246723l332.650081 0 0 36.833077c-32.628124 2.445664-59.776081 12.600409-81.711197 30.39921-21.718366 17.997488-46.886672 54.108065-75.053355 108.786905-37.840965 74.385042-79.915784 162.212206-126.603768 263.676568-46.464009 101.431849-93.975644 209.550441-142.253129 324.08845-22.607042 41.388443-94.192394 42.797319-113.931108 0-26.143682-53.591477-61.950808-127.304593-107.266041-221.583687C190.086277 321.610273 83.239286 153.0798 32.133211 153.0798L26.284569 153.0798 26.284569 116.246723z" p-id="2034"></path></svg></span>';
    } else {
        $user = '';
    }
    ?>
    <li class="comment">
    <div class="comment-item" id="comment-<?php comment_ID(); ?>">
        <div class="comment-media">
            <div class="avatar-img">
                <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                    echo get_avatar($comment, 48);
                } ?>
            </div>
        </div>
        <div class="comment-metadata">
            <div class="media-body">
                <?php echo __('<p class="author_name">') . get_comment_author_link() . $user . $reply . '</p>'; ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <b>你的评论审核中，审核通过方能显示...</b><br/>
                <?php endif; ?>
                <div class="comment-text">
                    <?php echo comment_text(); ?>
                </div>
            </div>
            <span class="comment-pub-time">
   				<?php echo get_comment_time('Y-m-d H:i'); ?>
   			</span>
            <span class="comment-btn-reply">
 				<i class="fa fa-reply"></i> <?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
   			</span>
        </div>
    </div>

    <?php
}