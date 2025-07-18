document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ldb-vote-buttons').forEach(function (container) {
        const postId = container.dataset.postId;

        const likeBtn = container.querySelector('.ldb-like-button');
        const dislikeBtn = container.querySelector('.ldb-dislike-button');

        if (likeBtn) {
            likeBtn.addEventListener('click', function () {
                sendVote(postId, 'like', container);
            });
        }

        if (dislikeBtn) {
            dislikeBtn.addEventListener('click', function () {
                sendVote(postId, 'dislike', container);
            });
        }
    });

    function sendVote(postId, voteType, container) {
        fetch(LDB_VARS.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'ldb_vote',
                post_id: postId,
                vote_type: voteType,
                nonce: LDB_VARS.nonce
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const likeCount = container.querySelector('.ldb-like-count');
                    const dislikeCount = container.querySelector('.ldb-dislike-count');

                    if (likeCount) likeCount.textContent = data.data.likes;
                    if (dislikeCount) dislikeCount.textContent = data.data.dislikes;
                } else {

                    showAlreadyVotedMessage(container, data.data || data.message || 'Error occurred');
                }
            })
            .catch(err => {
                console.error('AJAX error:', err);
                alert('Request failed');
            });
    }

    function showAlreadyVotedMessage(container, message) {
        if (container.querySelector('.ldb-vote-message')) return;

        const msg = document.createElement('div');
        msg.className = 'ldb-vote-message';
        msg.textContent = message;
        msg.style.marginTop = '10px';
        msg.style.color = 'red';
        msg.style.fontSize = '1em';

        container.appendChild(msg);
    }
});
