function getData(page) {
    $.ajax({
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
        method: 'GET',
        url: 'http://newsapi.org/v2/everything?q=Linux&language=en&sortBy=publishedAt&apiKey=6e6d9f7d53644208b1e46ea7b7a47eab&pageSize=30&page='+page,
        dataType: 'json',
        contentType:'application/json',
        secure: true,

        success: function (response) {
            $('#article-box').html('')
            for(let i = 0;  i <= response.articles.length; i++){
                var block = $('#article').clone();
                var date = new Date(response.articles[i].publishedAt)
                block.find('.article-title').html(response.articles[i].title);
                block.find('.article-title').attr('href' ,response.articles[i].url);
                block.find('.article-description').html(response.articles[i].description);
                block.find('.article-image').attr('src', response.articles[i].urlToImage ? response.articles[i].urlToImage : 'http://placehold.it/350x250');
                block.find('.article-content').html(response.articles[i].content);
                block.find('.article-created').html('Published at: '+date.toLocaleDateString()+' '+date.toLocaleTimeString());
                block.find('.article-author').html('Author: '+response.articles[i].source.name);
                $('#article-box').append(block);
                $('#article').removeClass('d-none')
            }
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    })
}
$(document).ready(function () {
    getData(1)
})
$(document).on('click', '.page-num', function () {
    var page = $(this).val()
    getData(page);
});