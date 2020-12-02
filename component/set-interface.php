<div class="set-plane">
    <div class="set-title">
        主题颜色：
    </div>
    <div class="set-object">
        <div class="set-plane">
            <el-color-picker v-model="set.theme.themeColor"></el-color-picker>
            <div style="max-width: 200px;margin-left: 10px;margin-right: 10px">
                <el-input v-model="set.theme.themeColor" placeholder="" size="small"></el-input>
            </div>
            <div>
                <el-button type="primary" size="small" @click="reThemeColor(0)">恢复默认</el-button>
            </div>
        </div>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        热点颜色：
    </div>
    <div class="set-object">
        <div class="set-plane">
            <el-color-picker v-model="set.theme.themeHoverColor"></el-color-picker>
            <div style="max-width: 200px;margin-left: 10px;margin-right: 10px">
                <el-input v-model="set.theme.themeHoverColor" placeholder="" size="small"></el-input>
            </div>
            <div>
                <el-button type="primary" size="small" @click="reThemeColor(2)">恢复默认</el-button>
            </div>
        </div>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        链接，按钮等鼠标放上去显示的颜色
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        侧边栏位置
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.theme.sidebar_position"
                :active-value="1"
                :inactive-value="0"
                active-text="右边"
                inactive-text="左边">
        </el-switch>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        文字选中颜色：
    </div>
    <div class="set-object">
        <div class="set-plane">
            <el-color-picker v-model="set.theme.fontSelectedColor"></el-color-picker>
            <div style="max-width: 200px;margin-left: 10px;margin-right: 10px">
                <el-input v-model="set.theme.fontSelectedColor" placeholder="" size="small"></el-input>
            </div>
            <div>
                <el-button type="primary" size="small" @click="reThemeColor(1)">恢复默认</el-button>
            </div>
        </div>
    </div>
</div>

