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
            videoUploader.progressCallBack($data, $progressPercentage, $(this)[0]);
        }).on('fileuploadfail', function ($e, $data) {
            videoUploader.failCallBack($data);
        }).on('fileuploaddone', function ($e,$data){
            console.log($data);
            if ($data.jqXHR.status == 201){
                //console.log($data);
                //console.log($data.files[0].name);
                if ($data.files[0].name !== undefined){
                    $.post('/video/add-by-filename',{videoFilename: $data.uniqueKey + '-' + $data.files[0].name}, function ($response){
                        videoUploader.successCallBack($response, $data);
                    },'json')
                }
            }


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