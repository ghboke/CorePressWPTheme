<h3>自定义登录</h3>
<div class="set-plane">
    <div class="set-title">
        隐藏登录按钮
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
        未登录用户不会显示登录按钮，登录后会显示用户菜单
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


<?php

