<h3>主题信息</h3>
<p>CorePress主题，一款功能强大的博客主题，适合个人，极客，程序员使用</p>
<p>前端无任何界面框架，加载迅速，流畅</p>
<p>集成代码高亮，多种短代码，帮你打造超强文字内容</p>
<p>注重WordPress和SEO优化，设置详细</p>
<p>主题成长中，有问题请反馈</p>
<p>欢迎加入QQ群：664592923</p>
<p><a target="_blank" href="https://qm.qq.com/cgi-bin/qm/qr?k=8uHZRdj0dRXbD7yiIRJYZjB40W05Vztl&jump_from=webapi"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="果核建站交流群" title="果核建站交流群"></a></p>
<h3>功能开关</h3>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        当前版本：<?php echo THEME_VERSIONNAME?>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        开启自动检查更新
    </div>
    <div class="set-object">
        <el-switch
            v-model="set.info.themeupdate"
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
        开启以后，每日检查一次，仅在管理员后台检查，不影响前台加载速度。
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        主题下载地址
    </div>
    <div class="set-object">
        <a href="<?php echo THEME_DOWNURL?>"><?php echo THEME_DOWNURL?></a>
    </div>
</div>

