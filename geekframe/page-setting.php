<?php
file_load_lib('element/index.css', 'css');
file_load_css('admin.css');
wp_enqueue_media();
?>
    <br><br>
    <div id="app" v-cloak>
        <div class="setmain">
            <div class="header-set-title">
                <div class="header-set-title-name">
                    <?php file_load_img('wordpress.svg') ?><h2>CorePress 设置中心</h2>
                </div>
                <div>
                    <el-link href="https://www.yuque.com/applek/corepress" :underline="false" target="_blank">
                        <el-button icon="el-icon-document" size="mini">
                            主题文档
                        </el-button>
                    </el-link>
                </div>
            </div>
            <div class="set-main-plane">
                <div class="set-main-menu">
                    <el-menu
                            default-active="2"
                            class="set-main-menu-list"
                            @select="selectMenu"
                    >
                        <el-menu-item index="1">
                            <i class="el-icon-menu"></i>
                            <span slot="title">常规设置</span>
                        </el-menu-item>
                        <el-menu-item index="2">
                            <i class="el-icon-s-home"></i>
                            <span slot="title">首页设置</span>
                        </el-menu-item>
                        <el-menu-item index="8">
                            <i class="el-icon-tickets"></i>
                            <span slot="title">文章设置</span>
                        </el-menu-item>
                        <el-menu-item index="9">
                            <i class="el-icon-chat-square"></i>
                            <span slot="title">评论设置</span>
                        </el-menu-item>
                        <el-menu-item index="11">
                            <i class="el-icon-s-tools"></i>
                            <span slot="title">功能模块</span>
                        </el-menu-item>
                        <el-menu-item index="10">
                            <i class="el-icon-user-solid"></i>
                            <span slot="title">用户中心</span>
                        </el-menu-item>
                        <el-menu-item index="3">
                            <i class="el-icon-s-open"></i>
                            <span slot="title">外观设置</span>
                        </el-menu-item>
                        <el-menu-item index="4">
                            <i class="el-icon-s-marketing"></i>
                            <span slot="title">优化加速</span>
                        </el-menu-item>
                        <el-menu-item index="5">
                            <i class="el-icon-search"></i>
                            <span slot="title">SEO设置</span>
                        </el-menu-item>
                        <el-menu-item index="6">
                            <i class="el-icon-link"></i>
                            <span slot="title">插入代码</span>
                        </el-menu-item>
                        <el-menu-item index="12">
                            <i class="el-icon-s-order"></i>
                            <span slot="title">广告代码</span>
                        </el-menu-item>
                        <el-menu-item index="7">
                            <i class="el-icon-info"></i>
                            <span slot="title">关于主题</span>
                        </el-menu-item>
                    </el-menu>
                </div>
                <div class="set-main-form">
                    <div v-if="menu_active==1">
                        <?php get_template_part('component/set-routine'); ?>
                    </div>
                    <div v-if="menu_active==2">
                        <?php get_template_part('component/set-index'); ?>
                    </div>
                    <div v-if="menu_active==3">
                        <?php get_template_part('component/set-interface'); ?>
                    </div>
                    <div v-if="menu_active==4">
                        <?php get_template_part('component/set-optimization'); ?>
                    </div>
                    <div v-if="menu_active==5">
                        <?php get_template_part('component/set-seo'); ?>
                    </div>
                    <div v-if="menu_active==6">
                        <?php get_template_part('component/set-insertcode'); ?>
                    </div>
                    <div v-if="menu_active==7">
                        <?php get_template_part('component/set-info'); ?>
                    </div>
                    <div v-if="menu_active==8">
                        <?php get_template_part('component/set-post'); ?>
                    </div>
                    <div v-if="menu_active==9">
                        <?php get_template_part('component/set-comment'); ?>
                    </div>
                    <div v-if="menu_active==10">
                        <?php get_template_part('component/set-user'); ?>
                    </div>
                    <div v-if="menu_active==11">
                        <?php get_template_part('component/set-module'); ?>
                    </div>
                    <div v-if="menu_active==12">
                        <?php get_template_part('component/set-ad'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-plane">
            <el-button @click="save" size="mini">保存</el-button>
        </div>
    </div>
<?php
file_load_js('vue.min.js');
file_load_js('axios.min.js');
file_load_js('base64.js');
file_load_js('jquery.min.js');
file_load_lib('element/index.js', 'js');
global $set;

$setJosn = base64_encode(json_encode($set));

?>
    <script>
        var set = JSON.parse(BASE64.decode('<?php echo $setJosn ?>'));
        var adminurl = '<?php echo admin_url('admin-ajax.php')?>';
    </script>
<?php
file_load_js('admin.js');
?>