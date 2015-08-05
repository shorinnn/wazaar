/**
 * Video uploader object using jqueryUploader for ajax upload
 */

var videoUploader = {
    'fileUploadObj' : undefined,
    'successCallBack' : undefined,
    'failCallBack' : undefined,
    'progressCallBack' : undefined,
    'fileAddedCallBack' : undefined,
    'intervalId' : 0,
    'formData' : undefined,
    'url' : undefined,
    'initialize' : function ($options){
        videoUploader.successCallBack = $options.successCallBack;
        videoUploader.failCallBack = $options.failCallBack;
        videoUploader.progressCallBack = $options.progressCallBack;

        if ($options.fileAddedCallBack !== undefined){
            videoUploader.fileAddedCallBack = $options.fileAddedCallBack;
        }

        var $finalOptions = {};

        if ($options.formData !== undefined){
            $finalOptions.formData = $options.formData;
        }

        if ($options.url !== undefined){
            $finalOptions.url = $options.url;
        }

        if ($options.dropZone == undefined){
            videoUploader.fileUploadObj = $options.fileInputElem.fileupload($finalOptions);
        }
        else{
            $finalOptions.dropZone = $options.dropZoneElem;
            videoUploader.fileUploadObj = $options.fileInputElem.fileupload($finalOptions);
        }
        videoUploader.bindEvents();
    },
    'bindEvents' : function (){
        videoUploader.fileUploadObj.on('fileuploadprogress', function ($e, $data) {
            var $progressPercentage = parseInt($data.loaded / $data.total * 100, 10);
            videoUploader.progressCallBack($data, $progressPercentage, $(this)[0]);
        });

        videoUploader.fileUploadObj.on('fileuploadadd', function (e, data) {
            console.log(data.originalFiles[0]);
            if(e.currentTarget.className == 'lesson-video-file'){
                //return;
            }
            var uploadErrors = [];
            var acceptedFileTypes =  ['video/mp4', 'video/flv', 'video/wmv', 'video/avi', 'video/mpg', 'video/mpeg', 'video/MP4', 'video/FLV', 'video/WMV', 'video/AVI', 'video/MPG', 'video/MPEG', 'video/mov', 'video/MOV','video/quicktime'];

            if(acceptedFileTypes.indexOf(data.originalFiles[0].type) < 0) {
                uploadErrors.push(_('Not an accepted file type'));
            }
            if(data.originalFiles[0].size && data.originalFiles[0].size > 3000000000) {//75654966 / 1000000000
                uploadErrors.push(_('Filesize is too big'));
            }
            if(uploadErrors.length > 0) {
                alert(uploadErrors.join("\n"));
                return false;
            } else {
                if (videoUploader.fileAddedCallBack !== undefined){
                    videoUploader.fileAddedCallBack(e,data);
                }
                data.submit();
            }
            window.reloadConfirm = true;
        });
        videoUploader.fileUploadObj.on('fileuploadfail', function ($e, $data) {
            videoUploader.failCallBack($data);
        });

        videoUploader.fileUploadObj.on('fileuploaddone', function ($e,$data){
            window.reloadConfirm = false;
            if ($data.jqXHR.status == 201){
                //console.log($data);
                //console.log($data.files[0].name);
                if ($data.files[0].name !== undefined){
                    var $elem = $(this)[0];
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