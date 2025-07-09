# 👍👎 Like Dislike Buttons for WordPress

A simple WordPress plugin that adds "Like" and "Dislike" buttons to posts. It counts votes using AJAX and prevents duplicate voting by IP address.

## 📦 Features

- 👍 and 👎 buttons below each post
- Vote count stored in the database
- AJAX-based voting (no page reload)
- Easy integration with any theme

## 🛠 Installation

1. Download or clone the repository
2. Place the folder in `wp-content/plugins/like-dislike-buttons`
3. Activate the plugin via the WordPress admin panel
4. Done! The buttons will appear automatically under posts

## 🧠 Technical Details

- Creates a custom database table: `wp_ldb_votes` (with your table prefix)
- Uses hooks: `the_content`, `wp_enqueue_scripts`, `wp_ajax_*`
- AJAX handled via `admin-ajax.php`
- Stored per vote:
    - `post_id`
    - `ip_address`
    - like/dislike counters

## ⚠️ Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

## 🧪 Future Plans

- [ ] Cookie-based or user-based vote tracking
- [ ] Support for custom post types
- [ ] Admin panel for vote analytics
- [ ] Voting on comments

## 📄 License

MIT License
