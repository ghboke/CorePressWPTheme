<div class="set-plane set-plane-nocenter">
    <div class="set-title">
        页头代码
    </div>
    <div class="set-object">
        <el-input
                type="textarea"
                :rows="5"
                placeholder="请输入内容"
                v-model="set.code.headcode">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        添加在页面head前的代码
    </div>
</div>

<div class="set-plane set-plane-nocenter">
    <div class="set-title">
        页脚代码
    </div>
    <div class="set-object">
        <el-input
                type="textarea"
                :rows="5"
                placeholder="请输入内容"
                v-model="set.code.footcode">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        在文章末尾添加的代码
    </div>
</div>

<div class="set-plane set-plane-nocenter">
    <div class="set-title">
        自定义CSS
    </div>
    <div class="set-object">
        <el-input
                type="textarea"
                :rows="5"
                placeholder="请输入内容"
                v-model="set.code.css">
        </el-input>
    </div>
</div>

<div class="set-plane set-plane-nocenter">
    <div class="set-title">
        阿里Iconfont地址
    </div>
    <div class="set-object">
        <el-input
                size="small"
                placeholder="请输入内容"
                v-model="set.code.alifront">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        自定义阿里云图标Symbol地址，设置以后可以调用自选的阿里云图标。注意这儿只能填写js地址
        调用方式，复制下面html内容，只需要替换图标名称即可：<br><br>
        <el-tag type="danger" size="mini">&lt;svg class=&quot;icon&quot; aria-hidden=&quot;true&quot;&gt;&lt;use xlink:href=&quot;#图标名称&quot;&gt;&lt;/use&gt;&lt;/svg&gt;</el-tag>
    <p>帮助地址：<a href="https://www.yuque.com/applek/corepress/icon" target="_blank">CorePress菜单图标使用教程</a> </p>
    </div>
</div>