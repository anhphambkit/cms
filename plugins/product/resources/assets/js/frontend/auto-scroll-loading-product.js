let page = 1;
let is_busy = false;
let stopped = false;

$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if (is_busy === true){
            return false;
        }

        if (stopped === true){
            return false;
        }

        is_busy = true;
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page){
    $.ajax(
        {
            url: '?page=' + page,
            type: "get",
            beforeSend: function()
            {
                $('.ajax-load').show();
            }
        })
        .done(function(data)
        {
            if(data.html == ""){
                $('.ajax-load').html("No more records found");
                stopped = true;
                return;
            }
            $('.ajax-load').hide();
            $("#list-products").append(data.html);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            alert('server not responding...');
        })
        .always(function()
        {
            is_busy = false;
        });
}