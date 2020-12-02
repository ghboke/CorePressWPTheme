<div class="set-plane">
    <div class="set-title">
        网站logo
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.logo" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.routine.logo')">上传
            </el-button>
        </el-input>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        建议高度为50px
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        favicon图标
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.favicon" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.routine.favicon')">上传
            </el-button>
        </el-input>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        标题栏旁边图标，建议大小32*32，不支持ico图标上传，如果使用ico图标，可以直接传favicon.ico文件到网站根目录
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        默认缩略图
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.defaultthumbnail" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.routine.defaultthumbnail')">上传
            </el-button>
        </el-input>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        文章没有特色图片的时候，显示本图片，建议大小 240 x 160 的倍数
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        自动缩略图
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.routine.autothumbnail"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
<div class="set-plane set-plane-note">
    <div class="set-title"></div>
    <div class="set-object">
        文章里面有图片的情况下，自动读取第一张图片作为缩略图
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        底部图片1
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.footer_1_imgurl" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.routine.footer_1_imgurl')">上传
            </el-button>
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        底部图片1名称
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.footer_1_imgname" size="small">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        底部图片2
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.footer_2_imgurl" size="small">
            <el-button size="mini" slot="append" icon="el-icon-picture"
                       @click="selectImg('set.routine.footer_2_imgurl')">上传
            </el-button>
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        底部图片2名称
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.footer_2_imgname" size="small">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        文章摘要长度
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.summary_lenth" size="small">
        </el-input>
    </div>
</div>
<div class="set-plane">
    <div class="set-title"></div>
    <div class="set-object">
        文章列表每一项摘要内容，默认长度150字
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        ICP备案号
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.routine.icp" size="small">
        </el-input>
    </div>
</div>
<h3>文章设置</h3>
<div class="set-plane">
    <div class="set-title">
        文章新窗口打开
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.routine.opennewlink"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>
