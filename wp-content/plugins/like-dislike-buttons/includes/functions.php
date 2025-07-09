<?php

function ldb_get_votes($post_id, $type) {
    global $wpdb;
    $table = $wpdb->prefix . 'ldb_votes';

    $row = $wpdb->get_row($wpdb->prepare("SELECT likes, dislikes FROM $table WHERE post_id = %d", $post_id));
    if (!$row) return 0;

    return $type === 'likes' ? (int)$row->likes : (int)$row->dislikes;
}
