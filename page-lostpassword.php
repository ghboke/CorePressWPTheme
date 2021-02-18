<?php
// TEMPLATE NAME: CorrPress自定义忘记密码页面
if (islogin()) {
    header("Location: " . get_bloginfo('url'));
    exit();
}
global $set;
?>
<!doctype html>
<html lang="zh">
<head>
    <?php get_header(); ?>
</head>
<body>
<?php
file_load_css('login-plane.css');
?>
<div id="app" class="login-background">
    <header>
        <div class="header-main-plane">
            <div class="header-main container">
                <?php
                get_template_part('component/nav-header');
                ?>
            </div>
        </div>
    </header>
    <div class="header-zhanwei" style="min-height: 80px;width: 100%;"></div>

    <style>
        <?php
if ($set['user']['repasswordimg'] != null) {
    echo '#app{background-image:url('.$set['user']['repasswordimg'].');}';
}
?>
    </style>
    <main class="container">
        <?php
        if (isset($_GET['action']) && isset($_GET['key']) && isset($_GET['id']) && $_GET['action'] == 'resetpwd') {
            $userid = $_GET['id'];
            $key = $_GET['key'];
            $userObj = get_user_by('ID', $userid);
            $activation_key = $userObj->user_activation_key;
            if ($activation_key != null && strpos($activation_key, ":") == true) {
                $arr = explode(":", $activation_key);
                $time = $arr[0];
                $activation_key = $arr[1];
                $nowtime = time();
                if ($nowtime - $time > 86400 || $nowtime - $time < -86400) {
                    $msg = '验证过期';
                    showlostpasshtml(0, $msg);

                } else {
                    if ($key == $activation_key) {
                        $msg = '验证成功';
                        showlostpasshtml(1, $msg);

                    } else {
                        $msg = '验证失败';
                        showlostpasshtml(0, $msg);
                    }
                }
            } else {
                showresetpwdhtml();
            }

        } else {
            showresetpwdhtml();
        }
        ?>
    </main>
    <script>

        $('#btn-getlostpass').click(() => {
            getlostpass();
        })

        $('#btn-resetpwd').click(() => {
            var pwd = $('input[name="pwd"]').val();
            var repwd = $('input[name="repwd"]').val();
            if (pwd == '' || repwd == '') {
                addarelt('请输入完整内容', 'erro');
                return;
            }
            if (pwd !== repwd) {
                addarelt('两次密码不一致', 'erro');
                return;
            } else {
                $('#login-note').css('visibility', 'visible');
                $('#login-note').text('验证中，请稍后');
                $.post(
                    '<?php echo AJAX_URL?>', {
                        <?php
                        $userid = $_GET['id'];
                        $key = $_GET['key'];
                        echo 'action:"corepress_resetpwd",userid:"' . $userid . '",key:"' . $key . '",pwd:pwd';
                        ?>
                    }, (data) => {
                        var obj = JSON.parse(data);
                        if (obj.code === 1) {


                            $('#login-note').text(obj.msg);
                        } else {


                            $('#login-note').text(obj.msg);
                        }
                    });
            }

        });


        function getlostpass() {
            var user = $('input[name="user"]').val();
            var key = $('input[name="code"]').val();

            $('#login-note').text('检测中，请稍后');
            $('#login-note').css('visibility', 'visible');

            $.post('<?php echo AJAX_URL?>', {
                action: 'corepress_lostpass',
                user: user,
                key: key
            }, (data) => {
                var obj = JSON.parse(data);
                if (obj) {
                    if (obj.code === 1) {
                        $('#login-note').css('visibility', 'visible');
                        $('#login-note').text(obj.msg);
                    } else {
                        $('#login-note').css('visibility', 'visible');
                        $('#login-note').text(obj.msg);
                        recodeimg();
                    }
                } else {

                }
            })
        }

        $('.img-code').click(() => {
            recodeimg();
        });

        function recodeimg() {
            $('.img-code').attr('src', '<?php echo FRAMEWORK_URI . "/VerificationCode.php?t=" . time() ?>');
        }
    </script>
    <footer>
        <?php
        wp_footer();
        get_footer(); ?>
    </footer>
</div>
</body>
</html>

