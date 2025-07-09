document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ldb-vote-buttons').forEach(function (container) {
        const postId = container.dataset.postId;

        container.querySelector('.ldb-like-button').addEventListener('click', function () {
            sendVote(postId, 'like', container);
        });

        container.querySelector('.ldb-dislike-button').addEventListener('click', function () {
            sendVote(postId, 'dislike', container);
        });
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
                    container.querySelector('.ldb-like-count').textContent = data.data.likes;
                    container.querySelector('.ldb-dislike-count').textContent = data.data.dislikes;
                }
            });
    }
});
