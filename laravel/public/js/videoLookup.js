var videoLookup = {
    'initialize' : function ($callback){
        var $lessonId = 0;

        $('#modules-list').on('click', '.show-videos-archive-modal', function (){

            $lessonId = $(this).attr('data-lesson-id');
            $('#videos-acrhive-modal').modal('show');

            $.get('/video/user/archive', function ($html){
                $('#modal-body-videos').html($html);
            });
        });

        $('#modal-body-videos').on('click','input[name=radioVideoId]', function(){
            $('#btn-use-video').removeClass('disabled');
        });

        $('#btn-use-video').on('click', function () {
            $('#btn-use-video').addClass('disabled');

            var $videoId = $('input[name=radioVideoId]:checked').val();
            $('#videos-acrhive-modal').modal('hide');
            $callback($lessonId, $videoId);
        });
    }
}