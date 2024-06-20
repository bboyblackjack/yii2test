$('.action-button').on('click', function(e) {
    e.preventDefault();
    $('.action-button').addClass('disabled');

    let accept = false;
    if ($(this).attr('id') === 'accept-button') {
        accept = true;
    }
    let imageId = $(this).data('id');
    let path = $(this).data('path');

    $.post('/index.php?r=site/process-image', {
        id: imageId,
        accept: accept,
        path: path
    })
    .then(function() {
        $.get('/index.php?r=site/next-image').then(function(data) {
            let parsed = JSON.parse(data);
            if (parsed.isError) {
                $('#image-container').remove();
                $('main > .container').append('<p class="alert alert-danger">'+ parsed.errorMessage +'</p>')
            } else {
                $('#image-container img').prop('src', 'data:image;base64,' + parsed.image);
                $('.action-button').data('id', parsed.id).data('path', parsed.path).removeClass('disabled');
            }
        })
    })
})