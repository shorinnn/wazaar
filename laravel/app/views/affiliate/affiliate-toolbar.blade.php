<div class="container-fluid affiliate-top-header">
    <div class="row">
        @if( Auth::user()->accepted_affiliate_terms == 'yes' ) 
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <select id='linkWithDD' onchange='linkWith()'>
                        <option value='0'>Link Without Gift</option>
                        <option value='1'>Link With Gift</option>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-9">
                    <input type="text" readonly="" id='affiliate-toolbar-link' value='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}' />
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-6">
                <div class="col-xs-7 col-sm-6 col-md-6 col-lg-6">
                    <i class="fa fa-plus"></i>
                    <input class="add-tracking-id" type='text' id='affiliate-toolbar-tracking' placeholder="Add Tracking ID" style='width:90%; background-color:white' onkeyup='addAffiliateTracking() '/>
                </div>
                <div class="col-xs-5 col-sm-6 col-md-6 col-lg-6">
                    <div class="activate-dropdown">
                        <button aria-expanded="false" data-toggle="dropdown" class="add-gift dropdown-toggle right" type="button" onclick="affiliateGiftUI('{{$course->slug}}')" id="add-gift-dropdown">
                            <i class="fa fa-gift"></i>
                            <span>Manage Gifts</span>
                        </button>
                    </div> 
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        @else
            <a style='padding:10px; color:blue; display:block; text-align:center' href='{{ action('AffiliateController@acceptTerms') }}'>Accept Affiliate Terms To Promote</a>
        @endif
    </div>
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
        if( $.trim(tracking) =='' ){
            link = $('#affiliate-toolbar-link').val();
            link = link.split('&tcode');
            link = link[0];
        }
        else{
            if( link.indexOf('&tcode=') == -1){
                link += '&tcode='+tracking;
            }
            else{
                link = $('#affiliate-toolbar-link').val();
                link = link.split('&tcode');
                link = link[0] + '&tcode='+tracking;
            }
        }
        
        
        $('#affiliate-toolbar-link').val( link );

		$("#affiliate-toolbar-tracking").on("focus", function(){
		  $(".fa.fa-plus").hide();
		});
		$("#affiliate-toolbar-tracking").on("blur", function(){
		  $(".fa.fa-plus").show();
		});	
        
    }
    
    function affiliateGiftUI(slug){
        bootbox.dialog(
                {
                    title: _('Gifts'),
                    message: '<p id="gift-ui-holder"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /><p>'
                }
        );
        tcode = $('#affiliate-toolbar-tracking').val();
        $('#gift-ui-holder').load( COCORIUM_APP_PATH + 'affiliate/promote/'+slug+'/'+tcode );
    }
    
    function linkWith(){
        if( $('#linkWithDD').val() == 1 ){
            $('.add-gift').click();
        }
         $('#linkWithDD').val(0);
    }
</script>