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


