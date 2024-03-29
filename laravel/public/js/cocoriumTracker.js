var cocoriumTracker = {
  loadTime: new Date().getTime(),
  actions: [],
  add : function(e){
        var action = {
            type: e.type,
            time_after_pageload: this.getTime(),
            target_class: e.target.className,
            target_id: e.target.id,
            tracker_id: $(e.target).attr('data-c6m-tracker-id'),
            url: document.URL,
            user_agent: navigator.userAgent,
            mouse_position: e.pageX+'x'+e.pageY,
            window_scroll_top: $(window).scrollTop(),
            ajax_url: e.ajax_url || ''
        };
        this.actions.push( action );
        return true;
      },
  getTime: function(){
        return (new Date().getTime() - this.loadTime) / 1000;
      },
  upload: function(){
      url = 'http://wazaar.dev/action-tracker';
        $.post(url, {data:this.actions}, function(){
        } );
      },
  createAjaxEvent: function(type, url){
      ev = {};
      ev.target = {};
      ev.target.className = ev.target.id = '';
      ev.type = type;
      ev.pageX = ev.pageY = 'NA';
      ev.ajax_url = url;
      return ev;
  }
};

$(function(){
    $(document).click(function(e){
        cocoriumTracker.add(e);
    });
    $(window).bind('beforeunload', function() {
//        cocoriumTracker.upload(); todo: uncomment this
    });
});