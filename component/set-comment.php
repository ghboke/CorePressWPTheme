<h3>评论功能开关</h3>

<div class="set-plane">
    <div class="set-title">
        评论表情
    </div>
    <div class="set-object">
        <el-switch
            v-model="set.comment.face"
            :active-value="1"
            :inactive-value="0"
        >
        </el-switch>
    </div>
</div>


<h3>评论保护</h3>

<div class="set-plane">
    <div class="set-title">
        禁止纯英文评论
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.comment.encomment"
                :active-value="1"
                :inactive-value="0"
        >
        </el-switch>
    </div>
</div>