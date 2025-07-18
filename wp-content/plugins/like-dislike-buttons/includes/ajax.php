<?php

add_action('wp_ajax_ldb_vote', 'ldb_handle_vote');
add_action('wp_ajax_nopriv_ldb_vote', 'ldb_handle_vote');

function ldb_handle_vote() {
	if (!is_user_logged_in()) {
		wp_send_json_error('You must be logged in to vote.');
	}

	$post_id = intval($_POST['post_id'] ?? 0);
	$vote_type = sanitize_text_field($_POST['vote_type'] ?? '');
	$user_id = get_current_user_id();

	if (!$post_id || !in_array($vote_type, ['like', 'dislike'], true)) {
		wp_send_json_error('Invalid vote data.');
	}

	global $wpdb;
	$table = $wpdb->prefix . 'ldb_votes';

	$already_voted = $wpdb->get_var($wpdb->prepare(
		"SELECT COUNT(*) FROM $table WHERE post_id = %d AND user_id = %d",
		$post_id,
		$user_id
	));

	if ($already_voted) {
		wp_send_json_error('You have already voted.');
	}

	$inserted = $wpdb->insert(
		$table,
		[
			'post_id'  => $post_id,
			'user_id'  => $user_id,
			'likes'    => $vote_type === 'like' ? 1 : 0,
			'dislikes' => $vote_type === 'dislike' ? 1 : 0,
		],
		['%d', '%d', '%d', '%d']
	);

	if ($inserted === false) {
		wp_send_json_error('Database error: ' . $wpdb->last_error);
	}

	$likes = (int) $wpdb->get_var($wpdb->prepare(
		"SELECT SUM(likes) FROM $table WHERE post_id = %d", $post_id
	));

	$dislikes = (int) $wpdb->get_var($wpdb->prepare(
		"SELECT SUM(dislikes) FROM $table WHERE post_id = %d", $post_id
	));

	wp_send_json_success([
		'likes' => $likes,
		'dislikes' => $dislikes
	]);
}
