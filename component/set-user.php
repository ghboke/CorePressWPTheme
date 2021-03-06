<h3>用户中心</h3>
<div class="set-plane">
    <div class="set-title">
        开启用户中心
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.usercenter"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        自定义用户中心页面地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.usercenterurl" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        请在页面->创建页面->页面模板选择[CorrPress自定义用户中心页面]
    </div>
</div>

<h3>自定义登录</h3>
<div class="set-plane">
    <div class="set-title">
        隐藏登录注册按钮
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.hideloginbtn"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        未登录用户不会显示登录注册按钮，登录后会显示用户菜单
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        开启自定义登录页面
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.loginpage"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        自定义登录页面地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.lgoinpageurl" size="small">
        </el-input>
    </div>
</div>

<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        请在页面->创建页面->页面模板选择[CorrPress自定义登录页面]，请保证本页面能正常访问，否则设置以后可能
        <el-tag type="danger" size="mini">无法登录</el-tag>
        ！
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        还原密码
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.reuserpwd" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        如果开启自定义登录页面，无法打开，请访问域名<?php echo admin_url('admin-ajax.php'); ?>?action=resetuser&pwd=密码，还原默认登陆页面。
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        自定义登录页面背景图片
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.lgoinpageimg" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.user.lgoinpageimg')">上传
            </el-button>
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        登录验证码
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.VerificationCode"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<h3>自定义注册</h3>

<div class="set-plane">
    <div class="set-title">
        开启自定义注册页面
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.regpage"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<?php
if (!get_option('users_can_register')) {
    ?>
    <div class="set-plane set-plane-note">
        <div class="set-title"></div>
        <div class="set-object">
            当前系统未开启注册功能，请前往设置->设置允许任何注册以后，本项目设置才会生效
        </div>
    </div>
    <?php
}

?>

<div class="set-plane">
    <div class="set-title">
        自定义注册页面地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.regpageurl" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        请在页面->创建页面->页面模板选择[CorrPress自定义注册页面]，填写页面地址
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        注册页面验证码
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.regpageVerificationCode"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>


<div class="set-plane">
    <div class="set-title">
        注册页面背景图片地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.regpageimg" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.user.regpageimg')">上传
            </el-button>
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        注册审核
    </div>
    <div class="set-object">
        <el-radio v-model="set.user.regapproved" label="approved">默认通过审核</el-radio>
        <el-radio v-model="set.user.regapproved" label="manualapprov">后台手动审核</el-radio>
        <el-radio v-model="set.user.regapproved" label="mailapproved">邮箱验证激活</el-radio>

    </div>
</div>

<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        建议开启审核功能，后台审核通过的用户方可正常登陆
    </div>
</div>
<h3>自定义密码找回</h3>

<div class="set-plane">
    <div class="set-title">
        开启自定义密码找回页面
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.user.repassword"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        请在页面->创建页面->页面模板选择[CorrPress自定义密码找回页面]
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        自定义密码找回页面地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.repasswordurl" size="small">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        自定义找回密码背景图片地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.user.repasswordimg" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.user.repasswordimg')">上传
            </el-button>
        </el-input>
    </div>
</div>