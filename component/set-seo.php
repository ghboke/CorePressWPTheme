<h3>SEO开关</h3>
<div class="set-plane">
    <div class="set-title">
        开启SEO功能
    </div>
    <div class="set-object">
        <el-switch
            v-model="set.seo.openseo"
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
        使用主题自带的SEO功能，有插件的话可以关闭
    </div>
</div>

<h3>首页SEO</h3>
<div class="set-plane">
    <div class="set-title">
        首页标题
    </div>
    <div class="set-object">
        <el-input v-model="set.seo.indextitle" placeholder="留空则使用系统自带的标题设置" size="small"></el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        关键词
    </div>
    <div class="set-object">
        <el-input v-model="set.seo.keyword" placeholder="" size="small"></el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        搜索关键词，多个关键词请使用英文逗号隔开
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        站点描述
    </div>
    <div class="set-object">
        <el-input
            type="textarea"
            :rows="3"
            placeholder="请输入内容"
            v-model="set.seo.description">
        </el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        站点描述，搜索引擎搜索到的介绍
    </div>
</div>

<h3>标题样式</h3>
<div class="set-plane">
    <div class="set-title">
        标题样式
    </div>
    <div class="set-object">
        <el-select v-model="set.seo.titlestyle" size="small">
            <el-option
                    key="1"
                    label="站点名 标题"
                    value="site_title">
            </el-option>
            <el-option
                    key="2"
                    label="标题 站点名"
                    value="title_site">
            </el-option>
        </el-select>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        标题分隔符 -
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
        首页分隔符
    </div>
    <div class="set-object">
        <el-input v-model="set.seo.title_delimiter" placeholder="" size="small"></el-input>
    </div>
</div>

<div class="set-plane">
    <div class="set-title">
    </div>
    <div class="set-object">
        标题分隔符 -
    </div>
</div>