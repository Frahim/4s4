<div class="card product h-100">
    <a href="<?php the_permalink(); ?>" class="product-link">
        <?php woocommerce_show_product_sale_flash(); ?>
        <?php woocommerce_template_loop_product_thumbnail(); ?>
    </a>
    <div class="card-body text-center">
        <h5 class="card-title"><?php the_title(); ?></h5>
        <?php woocommerce_template_loop_price(); ?>
        <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-2">View Details</a>
    </div>
</div>
