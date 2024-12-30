<?php

add_action('wp_enqueue_scripts', 'slick_scripts');

function slick_scripts()
{
    $version = time();

    if(is_product()){
        wp_enqueue_style('slick-theme-css', THEME_URL . '-child' . '/assets/slick/slick-theme.css', array(), $version, 'all');
        wp_enqueue_script('slick-scripts-js', THEME_URL . '-child' . '/assets/slick/slick.min.js', array('jquery'), $version, true);
        wp_enqueue_script('gallery-slick-scripts-js', THEME_URL . '-child' . '/assets/slick/slick-gallery-product.js', array('jquery'), $version, true);

        
    }
    
    
}


function image_product_single_custom(){

    global $product;

    $product_id = $product->get_id();

    $gallery_image_ids = get_post_meta($product_id, '_product_image_gallery', true);
    $gallery_image_ids = explode(',', $gallery_image_ids);
    $gallery_images = [];
    foreach ($gallery_image_ids as $image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full'); // Use 'full' for the full-size image
        if ($image_url) {
            $gallery_images[] = $image_url;
        }
    }
    $image_url = get_the_post_thumbnail_url($product_id, 'full');
    ?>
    <div class="slider-container">
        <!-- Main Slider -->
        <div class="main-slider">
            <div><img src="<?php echo $image_url;?>"></div>
            <?php foreach ($gallery_images as $key=>$value){?>
            <div><img src="<?php echo $gallery_images[$key];?>"></div>
            <?php }?>
        </div>

        <!-- Thumbnail Slider -->
        <div class="thumbnail-slider">
            <div><img src="<?php echo $image_url;?>"></div>
            <?php foreach ($gallery_images as $key=>$value){?>
                <div><img src="<?php echo $gallery_images[$key];?>"></div>
            <?php }?>
        </div>
    </div>
    <?php
}

add_shortcode('image_product_single_custom','image_product_single_custom');