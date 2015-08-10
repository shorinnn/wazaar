<div style="background-color:silver;" class='text-center'>
    {{ trans('courses/promote.your-link') }}
    <input type='text' style='width:400px; background-color:white'
           id='affiliate-toolbar-link'
           value='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}'
           data-clipboard-text='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}' />
    
    <input type='text' id='affiliate-toolbar-tracking' placeholder="Tracking ID" style='width:150px; background-color:white'
           onkeyup='addAffiliateTracking() '/>
    <button class='btn btn-default' onclick="clearAffiliateTracking()"><i class='fa fa-times'></i></button>
    <button class='btn btn-default' onclick="affiliateGiftUI('{{$course->slug}}')"><i class='fa fa-gift'></i></button>
   
</div>
<script>
    function clearAffiliateTracking(){
        $('#affiliate-toolbar-tracking').val('');
        link = $('#affiliate-toolbar-link').val();
        link = link.split('&tcode');
        $('#affiliate-toolbar-link').val( link[0] );
    }
    
    function addAffiliateTracking(){
        tracking = $('#affiliate-toolbar-tracking').val();
        link = $('#affiliate-toolbar-link').val();
        if( link.indexOf('&tcode=') == -1){
            link += '&tcode='+tracking;
        }
        else{
            link = $('#affiliate-toolbar-link').val();
            link = link.split('&tcode');
            link = link[0] + '&tcode='+tracking;
        }
        
        $('#affiliate-toolbar-link').val( link );
        
    }
    
    function affiliateGiftUI(slug){
        bootbox.dialog(
                {
                    title: _('Gifts'),
                    message: '<p class="text-center" id="gift-ui-holder"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /><p>'
                }
        );
        tcode = $('#affiliate-toolbar-tracking').val();
        $('#gift-ui-holder').load( COCORIUM_APP_PATH + 'affiliate/promote/'+slug+'/'+tcode );
    }
</script>