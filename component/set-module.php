<h3>代码高亮模块</h3>
<div class="set-plane">
    <div class="set-title">
        功能开关
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.highlight"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        高亮风格
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.highlighttheme"
                :active-value="1"
                :inactive-value="0"
                active-text="暗色风格"
                inactive-text="亮色风格"
        >
        </el-switch>
    </div>
</div>
<h3>图片设置</h3>
<div class="set-plane">
    <div class="set-title">
        图片延迟加载
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.imglazyload"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        图片延迟加载，可提高网页加载速度
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        图片灯箱
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.imglightbox"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        点击图片直接当前页面打开
    </div>
</div>
<h3>SMTP 邮件服务器</h3>
<div class="set-plane">
    <div class="set-title">
        功能开关
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.smtp"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        发件人邮箱
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.module.smtpuser" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        发件人密码
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.module.smtppwd" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        SMTP 邮件服务器地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.module.smtphost" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        SMTP端口
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.module.smtpport" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        发件人昵称
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.module.smtpname" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        SMTP加密方式
    </div>
    <div class="set-object">
        <el-radio v-model="set.module.smtpencrypttype" label="no">不加密</el-radio>
        <el-radio v-model="set.module.smtpencrypttype" label="ssl">SSL/TLS</el-radio>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        <el-input placeholder="收件邮箱地址" v-model="set.module.testmail" size="small">
        </el-input>
        <br>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        <el-button slot="append" type="primary" size="small" @click="mailtest">发信测试</el-button>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
       如果发信失败，可以使用插件：Easy WP SMTP，来替代主题发信功能。
    </div>
</div>

<h3>防转载模块</h3>

<div class="set-plane">
    <div class="set-title">
        开启防转载模块
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.reprint.open"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        超过文本长度禁止复制开关
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.reprint.copylenopen"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        允许复制文本长度
    </div>
    <div class="set-object">
        <el-input type="number" placeholder="" v-model="set.module.reprint.copylen" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        可以设置用户可以复制文本长度，超过这个长度就禁止复制，默认为10
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        复制成功提示内容
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.module.reprint.msg" size="small">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        复制成功自动添加来源网址
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.reprint.addurl"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        在用户复制内容成功以后，自动添加本站网址(复制超过100个字生效)
    </div>
</div>
<h3>防红模块</h3>

<div class="set-plane">
    <div class="set-title">
        引导外部浏览器打开
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.module.preventred"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        使用QQ或者微信访问网站，引导用户使用浏览器打开
    </div>
</div>
