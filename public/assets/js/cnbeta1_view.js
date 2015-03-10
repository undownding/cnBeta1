function syncArticleDetail(articleId) {
    if (!articleId) return;
    $.getJSON('/api/syncArticleDetail/' + articleId, function(result) {
        if (result.view_num) $('#view_num').html(result.view_num);
        if (result.comment_num) $('#comment_num').html(result.comment_num);
        if (result.hotlist && result.hotlist.length > 0) {
            var comments = '';
            $.each(result.hotlist, function(i, field) {
                comments += generateComments(field);
            });
            var commentsContainer = $('.hot-comment .panel-body .list-group');
            if ($('.hot-comment .panel-body .list-group li').length > 0) {
                commentsContainer.fadeOut(500, function() {
                    commentsContainer.html(comments);
                    commentsContainer.fadeIn(500);
                });
            } else {
                $('.article-main').removeClass('col-md-12');
                $('.article-main').addClass('col-md-8');
                $('.hot-comment').removeClass('hidden');
                commentsContainer.html(comments);
                commentsContainer.fadeIn(500);
            }
        }
    });
}

function generateComments(data) {
    return '<li class="list-group-item">' +
                '<div class="list-item-info">' +
                '<span class="right">' +
                    '<span class="glyphicon glyphicon-map-marker"></span>' +
                        data['from'] +
                    '<span class="glyphicon glyphicon-time"></span>' +
                        data['date'] +
                '</span>' +
                '<span class="glyphicon glyphicon-user"></span>' +
                    data['author'] +
                '</div>' +
                '<div class="comment-text">' +
                    data['content'] +
                '</div>' +
                '<div class="action">' +
                    '<button type="button" class="btn btn-success btn-xs" disabled="disabled">' +
                        '<span class="glyphicon glyphicon-thumbs-up"></span>' +
                        '<span class="vote_num">' + data['up'] + '</span>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-xs" disabled="disabled">' +
                        '<span class="glyphicon glyphicon-thumbs-down"></span>' +
                        '<span class="vote_num">' + data['down'] + '</span>' +
                    '</button>' +
                '</div>' +
            '</li>';
}