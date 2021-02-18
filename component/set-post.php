<h3>文章图片设置</h3>

<div class="set-plane">
    <div class="set-title">
        图片圆角
    </div>
    <div class="set-object">
        <el-switch
            v-model="set.post.imgradius"
            :active-value="1"
            :inactive-value="0"
        >
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        图片阴影
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.post.imgshadow"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<h3>文章版权</h3>
<div class="set-plane">
    <div class="set-title">
        开启文章版权显示
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.post.copyright_show"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane set-plane-nocenter">
    <div class="set-title">
        版权内容(支持HTML)
    </div>
    <div class="set-object">
        <el-input
                type="textarea"
                :rows="5"
                placeholder="请输入内容"
                v-model="set.post.copyright">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
       可用变量
        <p><#username#>:当前文章用户名</p>
        <p><#url#>:当前文章地址</p>
        <p>换行请使用html代码:&lt;br&gt;&nbsp;&nbsp;
    </div>
</div>
<h3>文章目录设置</h3>

<div class="set-plane">
    <div class="set-title">
        默认开启目录
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.post.defaultcatalog"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<h3>打赏设置</h3>

<div class="set-plane">
    <div class="set-title">
        打赏二维码图1
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.post.reward1" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('reward1')">上传
            </el-button>
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        打赏二维码图2
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.post.reward2" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('reward2')">上传
            </el-button>
        </el-input>
    </div>
</div>