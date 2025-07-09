<?php

add_filter('the_content', 'ldb_append_buttons');
add_action('wp_enqueue_scripts', 'ldb_enqueue_assets');

function ldb_append_buttons($content) {
    if (!is_singular('post')) return $content;

    global $post;
//    echo '<pre>' . print_r($post, true) . '</pre>';
    $post_id = $post->ID;
    $likes = ldb_get_votes($post_id, 'likes');
    $dislikes = ldb_get_votes($post_id, 'dislikes');

    ob_start();
    ?>
    <div class="ldb-vote-buttons" data-post-id="<?php echo esc_attr($post_id); ?>">
        <button class="ldb-like-button">👍 <span class="ldb-like-count"><?php echo $likes; ?></span></button>
        <button class="ldb-dislike-button">👎 <span class="ldb-dislike-count"><?php echo $dislikes; ?></span></button>
    </div>
    <?php

    return $content . ob_get_clean();
}

function ldb_enqueue_assets() {
    wp_enqueue_script('ldb-vote', plugin_dir_url(__FILE__) . '../js/ldb-vote.js', ['jquery'], null, true);
    wp_localize_script('ldb-vote', 'LDB_VARS', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('ldb_nonce'),
    ]);
}
