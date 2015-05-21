var videoLookup = {
    'lessonId' : 0,
    'callback' : '',
    'prepareModalEvents' : function (){
        $('#modal-body-videos').on('click','input[name=radioVideoId]', function(){
            $('#btn-use-video').removeClass('disabled');
        });

        $('#btn-use-video').on('click', function () {
            $('#btn-use-video').addClass('disabled');

            var $videoId = $('input[name=radioVideoId]:checked').val();
            $('#videos-archive-modal').modal('hide');
            videoLookup.callback(videoLookup.lessonId, $videoId);
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
    },
    'initialize' : function ($callback){

        videoLookup.callback = $callback;


            $('#modules-list').on('click', '.show-videos-archive-modal', function ($e) {
                $e.preventDefault();
                videoLookup.lessonId = $(this).attr('data-lesson-id');
                $('#videoFilter').val('');
                $('#videos-archive-modal').modal('show');

                $.get('/video/user/archive', function ($html) {
                    $('.video-list-container').html($html);
                });
            });

            $('.course-video-select-existing-anchor').on('click', function ($e) {
                $e.preventDefault();

                //$lessonId = $(this).attr('data-lesson-id');
                $('#videoFilter').val('');
                $('#videos-archive-modal').modal('show');

                $.get('/video/user/archive', function ($html) {
                    $('.video-list-container').html($html);
                });
            });
    }
}