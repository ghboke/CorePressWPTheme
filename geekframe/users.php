<?php
add_filter('pre_get_users', 'corepress_filter_users');

function corepress_filter_users($query)
{
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow) {
        global $wpdb;
        if (!isset($_GET['orderby'])) {
            $query->set('orderby', 'registered');
            $query->set('order', 'desc');
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'unapproved') {
            $query->set('meta_query', array(
                array(
                    'key' => 'corepress_approve',
                    'value' => '1',
                    'compare' => '='
                )
            ));
        }
    }
    return $query;
}

function filter_users_by_groups($query)
{
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow && (isset($_REQUEST['filter_btn']) || isset($_REQUEST['filter_btn2']))) {
        $filter_group = isset($_REQUEST['filter_btn']) ? $_REQUEST['filter_group'] : $_REQUEST['filter_group2'];
        $group = get_term_by('slug', $filter_group, 'user-groups');
        $users = get_objects_in_term($group->term_id, 'user-groups');
        $query->set('include', $users);
    }
}

function corepress_views_users($views)
{
    global $wpdb;
    if (!current_user_can('edit_users')) return $views;
    $current = '';
    if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'unapproved') $current = 'class="current"';
    $meta_key = 'corepress_approve';
    $users = get_users(array(
        'meta_query' => array(
            array(
                'key' => $meta_key,
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    $count = count($users);
    $views['unapproved'] = '<a href="' . admin_url('users.php') . '?status=unapproved" ' . $current . '>' . '待审核' . ' <span class="count">（' . $count . '）</span></a>';
    return $views;
}


add_filter('bulk_actions-users', 'corepress_add_userlist_approve');
function corepress_add_userlist_approve($actions)
{
    if (current_user_can('edit_users')) {
        $actions['approve'] = '审核用户';
        $actions['disapprove'] = '设置为未审核';
    }
    return $actions;
}

add_filter('handle_bulk_actions-users', 'corepress_handle_users', 10, 3);
function corepress_handle_users($redirect_to, $doaction, $ids)
{
    if (!$ids || !current_user_can('edit_users')) return $redirect_to;
    if ($doaction == 'approve') {
        foreach ($ids as $id) {
            update_user_meta($id, 'corepress_approve', 0);
        }
    } else if ($doaction == 'disapprove') {

        foreach ($ids as $id) {
            if (user_can($id, 'edit_users')) {
                continue;
            }
            update_user_meta($id, 'corepress_approve', 1);
        }
    }
    return $redirect_to;
}


function corepress_user_row_action($actions, $user)
{
    if (isset($_GET['status']) && $_GET['status'] == 'unapproved') {
        if (current_user_can('edit_users')) {
            $actions['approveone'] = '<a title="审核用户" href="' . admin_url("users.php?&action=approve&amp;users[]=$user->ID") . '">审核用户</a>';
        }
    }
    return $actions;
}

add_filter('user_row_actions', 'corepress_user_row_action', 10, 2);
add_action('user_register', 'corepress_user_register');
function corepress_user_register($id)
{
    global $set;
    if ($set['user']['regapproved'] == 'manualapprov') {
        update_user_meta($id, 'corepress_approve', 1);
    }
}

add_action('wp_login', 'corepress_action_login', 10, 2);
function corepress_action_login($user_login, $user)
{
    global $set;
    if (get_user_meta($user->ID, 'corepress_approve', true) == 1) {
        $json['code'] = 0;
        $json['msg'] = '登录失败，账号未通过审核';
        wp_logout();
        wp_die(json_encode($json));
    }
}


