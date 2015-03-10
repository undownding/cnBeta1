$('.footer').hide();
$('body > hr').hide();
$('body').css('padding-bottom', 0);
//constants
var INDEX_ARTICLE_NUM = 20;
var CHECK_NEW_ARTICLE_INTERVAL = 1000 * 60 * 5; // 5 minutes

function loadMore() {
    getMoreData();
    $(window).bind('scroll', bindScroll);
}

function bindScroll() {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
        $(window).unbind('scroll');
        loadMore();
    }
}

$(window).scroll(bindScroll);


//auto fetch new
var loadingMore = false;
var noMore = false;

function getMoreData() {
    if (loadingMore === true || noMore === true)
        return;
    var lastarticle_id = $('#article-list .row').last().attr('data-id');
    if (lastarticle_id === undefined)
        return;
    $('#more-article-loading-icon').show();
    loadingMore = true;
    $.getJSON('/api/getMoreArticles/' + lastarticle_id, function(result) {
        if (result.length === 0)
            noMore = true;
        $.each(result, function(i, field) {
            $('#article-list').append(generateArticle(field));
        });
        $('#more-article-loading-icon').hide();
        loadingMore = false;
        jQuery("time.timeago").timeago();
    });
}

function generateArticle(data) {
    var source = '';
    if (data['source']) {
        source = data['source'];
        if (data['source_link']) {
            source = '<a target="_blank" href="' + data['source_link'] + '" >' + data['source'] + '</a>';
        }
        source = '<span class="glyphicon glyphicon-import"></span>' + source;
    }

    return '<div class="row" data-id="' + data['article_id'] + '">' +
            '<div class="col-sm-10">' +
            '<div class="article-item">' +
            '<h4><strong><a target="_blank" href="/' + data['article_id'] + '">' + data['title'] + '</a></strong></h4>' +
            '<span class="text-muted">' +
                '<span class="info-item" title="发布时间"><span class="glyphicon glyphicon-time"></span><time class="timeago" datetime="' + data['date'] + '">' + data['date'] + '</time></span>' +
                '<span class="info-item" title="浏览次数"><span class="glyphicon glyphicon-eye-open"></span><span id="view_num">' + data['view_num'] + '</span></span>' +
                '<span class="info-item" title="评论数"><span class="glyphicon glyphicon-comment"></span><span id="comment_num">' + data['comment_num'] + '</span></span>' +
                '<span class="info-item" title="来源">' +
                source +
            '</span>' +

            '</div>' +
            '<p>' + data['intro'] + '</p>' +
            '</div>' +
            '<div class="col-sm-2 hidden-xs">' +
            '<a target="_blank" href="/' + data['article_id'] + '" class="thumbnail"><img src="' + data['topic'] + '" alt=""></a>' +
            '</div>' +
            '</div>' +
            '<hr />';
}

var newArticlesHTML;
var needReload;

function checkForNewArticle() {
    newArticlesHTML = '';
    needReload = false;
    console.log('checkForNewArticle');
    var firstarticle_id = $('#article-list .row').first().attr('data-id');
    if (firstarticle_id === undefined)
        return;
    $.getJSON('/api/getArticles?firstarticle_id=' + firstarticle_id, function(result) {
        var html = '';
        var count = 0;
        $.each(result, function(i, field) {
            if (field['article_id'] > firstarticle_id) {
                html += generateArticle(field);
                count++;
            }
        });
        if (count === 0) {
            $('#got-new-article-button').hide();
        } else if (count === INDEX_ARTICLE_NUM) {
            needReload = true;
            newArticlesHTML = html;
            $('#got-new-article-button').text('查看 ' + count + '+ 篇新文章').show();
        } else if (count > 0) {
            newArticlesHTML = html;
            $('#got-new-article-button').text('查看 ' + count + ' 篇新文章').show();
        }
    });
}
var interval = setInterval(checkForNewArticle, CHECK_NEW_ARTICLE_INTERVAL);

function showNewArticles() {
    $('#got-new-article-button').hide();
    if (!needReload) {
        $('#article-list').prepend(newArticlesHTML);
    } else {
        $('#article-list').html(newArticlesHTML);
    }
    jQuery("time.timeago").timeago();
    newArticlesHTML = '';
}
