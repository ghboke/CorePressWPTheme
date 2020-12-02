<?php

$range = 4;
global $paged,$wp_query;
if ( !$max_page ) {
    $max_page = $wp_query->max_num_pages;
}
if( $max_page >1 ) {
    echo "<div class='fenye'>";
    if( !$paged ){
        $paged = 1;
    }
    if( $paged != 1 ) {
        echo "<a href='".get_pagenum_link(1) ."' class='extend' title='跳转到首页'>首页</a>";
    }
    previous_posts_link('上一页');
    if ( $max_page >$range ) {
        if( $paged <$range ) {
            for( $i = 1; $i <= ($range +1); $i++ ) {
                echo "<a href='".get_pagenum_link($i) ."'";
                if($i==$paged) echo " class='current'";echo ">$i</a>";
            }
        }elseif($paged >= ($max_page -ceil(($range/2)))){
            for($i = $max_page -$range;$i <= $max_page;$i++){
                echo "<a href='".get_pagenum_link($i) ."'";
                if($i==$paged)echo " class='current'";echo ">$i</a>";
            }
        }elseif($paged >= $range &&$paged <($max_page -ceil(($range/2)))){
            for($i = ($paged -ceil($range/2));$i <= ($paged +ceil(($range/2)));$i++){
                echo "<a href='".get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";
            }
        }
    }else{
        for($i = 1;$i <= $max_page;$i++){
            echo "<a href='".get_pagenum_link($i) ."'";
            if($i==$paged)echo " class='current'";echo ">$i</a>";
        }
    }
    next_posts_link('下一页');
    if($paged != $max_page){
        echo "<a href='".get_pagenum_link($max_page) ."' class='extend' title='跳转到最后一页'>尾页</a>";
    }
    echo '<span class="page-count pagedbox">'.$paged.'/'.$max_page.'</span>';
    echo "</div>\n";
}
