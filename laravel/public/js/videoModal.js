var videoModal = {
  'show' : function($obj, $event){
      $event.preventDefault();
      $('#video-player-modal').find(".modal-title").html($($obj).attr('data-filename'));
      $('#video-player-modal').find("#video-source").attr("src",$($obj).attr('data-video-url'));
      $('#video-player-modal').find("#video-source").load();
      $('#video-player-modal').modal("show");
  }
};