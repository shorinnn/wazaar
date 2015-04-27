var videoLookup = {
    'initialize' : function ($callback){
        var $lessonId = 0;

        $('#modules-list').on('click', '.show-videos-archive-modal', function ($e){
            $e.preventDefault();
            $lessonId = $(this).attr('data-lesson-id');
            $('#videoFilter').val('');
            $('#videos-archive-modal').modal('show');

            $.get('/video/user/archive', function ($html){
                $('.video-list-container').html($html);
            });
        });

        $('#modal-body-videos').on('click','input[name=radioVideoId]', function(){
            $('#btn-use-video').removeClass('disabled');
        });

        $('#btn-use-video').on('click', function () {
            $('#btn-use-video').addClass('disabled');

            var $videoId = $('input[name=radioVideoId]:checked').val();
            $('#videos-archive-modal').modal('hide');
            $callback($lessonId, $videoId);
        });

        $('#modal-body-videos').on('click', '.videos-lookup-pagination-wrapper .page-numbers-container ul li a', function($e){
            $e.preventDefault();

            var $url = $(this).attr('href');

            $.get($url, function($html){
                $('.video-list-container').html($html);
            });

        });

        $('#modal-body-videos').on('keyup','#videoFilter',function(){
            $('.video-list-container').html($('#ajax-loader-wrapper').html());
            $.post('/video/user/archive', {filter: $('#videoFilter').val()}, function ($html){
                $('.video-list-container').html($html);
            });
        });
    }
}