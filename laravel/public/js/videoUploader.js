/**
 * Video uploader object using jqueryUploader for ajax upload
 */

var videoUploader = {
    'fileUploadObj' : undefined,
    'successCallBack' : undefined,
    'failCallBack' : undefined,
    'progressCallBack' : undefined,
    'intervalId' : 0,
    'initialize' : function ($options){
        videoUploader.successCallBack = $options.successCallBack;
        videoUploader.failCallBack = $options.failCallBack,
        videoUploader.progressCallBack = $options.progressCallBack;

        if ($options.dropZone == undefined){
            videoUploader.fileUploadObj = $options.fileInputElem.fileupload({

            });
        }
        else{
            videoUploader.fileUploadObj = $options.fileInputElem.fileupload({
                dropZone: $options.dropZoneElem
            });
        }

        videoUploader.bindEvents();
    },
    'bindEvents' : function (){
        videoUploader.fileUploadObj.on('fileuploadprogress', function ($e, $data) {
            var $progressPercentage = parseInt($data.loaded / $data.total * 100, 10);
            videoUploader.progressCallBack($data, $progressPercentage);
        }).on('fileuploadfail', function ($e, $data) {
            videoUploader.failCallBack($data);
        }).on('fileuploaddone', function ($e,$data){
            videoUploader.successCallBack($data);
        });
    },
    'getVideo' : function ($videoId, $callBack){
        $.ajax({
            dataType: "json",
            url: '/video/' + $videoId + '/json',
            success: function ($video){
                $callBack($video);
            }
        });
    }


}