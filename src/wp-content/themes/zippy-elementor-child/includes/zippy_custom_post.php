<?php
function year_custom_meta_post() {
    add_meta_box(
        'year_custom_meta_post', 
        'Year Of Post',
        'year_custom_meta_post_callback', 
        'post',                     
        'side',                     
        'default'                   
    );
}
add_action('add_meta_boxes', 'year_custom_meta_post');

function year_custom_meta_post_callback($post) {
    
    $custom_value = get_post_meta($post->ID, '_custom_field_key_year_post', true);

    wp_nonce_field('custom_meta_box_nonce_action', 'custom_meta_box_nonce_name');
    ?>
    <label for="custom_field">Enter Year:</label>
    <input type="text" name="custom_field" id="custom_field" value="<?php echo esc_attr($custom_value); ?>" />
    <?php
}

function save_custom_meta_box_data($post_id) {

    if (!isset($_POST['custom_meta_box_nonce_name']) || 
        !wp_verify_nonce($_POST['custom_meta_box_nonce_name'], 'custom_meta_box_nonce_action')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'post' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (isset($_POST['custom_field'])) {
        update_post_meta($post_id, '_custom_field_key_year_post', sanitize_text_field($_POST['custom_field']));
    } else {
        delete_post_meta($post_id, '_custom_field_key_year_post');
    }
}
add_action('save_post', 'save_custom_meta_box_data');
