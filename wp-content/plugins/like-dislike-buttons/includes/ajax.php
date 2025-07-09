<?php

add_action('wp_ajax_ldb_vote', 'ldb_handle_vote');
add_action('wp_ajax_nopriv_ldb_vote', 'ldb_handle_vote');

function ldb_handle_vote() {
    check_ajax_referer('ldb_nonce', 'nonce');

    $post_id = intval($_POST['post_id'] ?? 0);
    $vote_type = sanitize_text_field($_POST['vote_type'] ?? '');

    if (!$post_id || !in_array($vote_type, ['like', 'dislike'])) {
        wp_send_json_error('Invalid data');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'ldb_votes';
    $column = $vote_type === 'like' ? 'likes' : 'dislikes';

    $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE post_id = %d", $post_id));

    if ($exists) {
        $wpdb->query($wpdb->prepare("UPDATE $table SET $column = $column + 1 WHERE post_id = %d", $post_id));
    } else {
        $wpdb->insert($table, [
            'post_id' => $post_id,
            'likes' => $vote_type === 'like' ? 1 : 0,
            'dislikes' => $vote_type === 'dislike' ? 1 : 0,
        ]);
    }

    wp_send_json_success([
        'likes' => ldb_get_votes($post_id, 'likes'),
        'dislikes' => ldb_get_votes($post_id, 'dislikes'),
    ]);
}
