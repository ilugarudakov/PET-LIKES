<?php

function ldb_activate() {
	global $wpdb;

	$table = $wpdb->prefix . 'ldb_votes';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT UNSIGNED NOT NULL,
        user_id BIGINT UNSIGNED NOT NULL,
        likes INT UNSIGNED NOT NULL DEFAULT 0,
        dislikes INT UNSIGNED NOT NULL DEFAULT 0,
        PRIMARY KEY (id),
        UNIQUE KEY post_user_unique (post_id, user_id)
    ) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);
}
