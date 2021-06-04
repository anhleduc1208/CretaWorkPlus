<aside class="sidebar col-md-4 text-left">
    <div class="blog-sidebar">
        <?php
            if(is_active_sidebar('sidebar')){
                dynamic_sidebar( 'sidebar' );
            }
        ?>
    </div>
</aside>