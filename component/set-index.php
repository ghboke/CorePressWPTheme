<h3>幻灯片设置</h3>

<div class="swiper-plane">
    <div class="swiper-control">
        <el-button type="primary" @click="addSwiper" size="mini">添加幻灯片</el-button>
    </div>
    <el-collapse>
        <div v-for="(item,index) in set.index.swiperlist">
            <el-collapse-item>
                <template slot="title">
                    <div>
                        <span class="swiper-title">{{item.imgurl}}</span>
                        <span class="swiper-colbtn" @click.stop="delSwiper(index)"><i class="el-icon-close"></i></span>
                        <span class="swiper-colbtn" @click.stop="moveSwiper(index,-1)"
                              v-if="index<(set.index.swiperlist.length-1)"><i class="el-icon-bottom"></i></span>
                        <span class="swiper-colbtn" @click.stop="moveSwiper(index,1)" v-if="index>0"><i
                                    class="el-icon-top"></i></span>
                    </div>
                </template>
                <div class="set-plane">
                    <div class="set-title">
                        图片地址
                    </div>
                    <div class="set-object">
                        <el-input placeholder="" v-model="item.imgurl" size="small">
                            <el-button size="mini" slot="append" icon="el-icon-picture"
                                       @click="selectImg('swiperlist',index)">上传
                            </el-button>
                        </el-input>
                    </div>
                </div>
                <div class="set-plane">
                    <div class="set-title">
                        指向链接
                    </div>
                    <div class="set-object">
                        <el-input placeholder="" v-model="item.url" size="small">
                        </el-input>
                    </div>
                </div>
                <div class="set-plane">
                    <div class="set-title">
                        标题内容
                    </div>
                    <div class="set-object">
                        <el-input placeholder="" v-model="item.title" size="small">
                        </el-input>
                    </div>
                </div>
            </el-collapse-item>
        </div>
    </el-collapse>
</div>

<h3>友情链接</h3>
<div class="set-plane">
    <div class="set-title">
        显示友情链接模块
    </div>
    <div class="set-object">
        <el-switch
                v-model="set.index.links"
                :active-value="1"
                :inactive-value="0"
               >
        </el-switch>
    </div>
</div>
<div class="set-plane">
    <div class="set-title">
        申请友链地址
    </div>
    <div class="set-object">
        <el-input placeholder="" v-model="set.index.applylink" size="small">
        </el-input>
    </div>
</div>
