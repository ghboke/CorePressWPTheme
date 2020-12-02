<form class="search-form" action="<?php echo get_bloginfo('url');?>" method="get" role="search">
    <div class="search-form-input-plane">
        <input type="text" class="search-keyword" name="s" placeholder="搜索内容"  value="<?php echo get_search_query(); ?>">
    </div>
  <div>
      <button type="submit" class="search-submit" value="&#xf002;">搜索</button>
  </div>
</form>