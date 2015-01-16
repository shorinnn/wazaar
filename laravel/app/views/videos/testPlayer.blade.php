<HTML>
<HEAD>
    <TITLE>Cocorium</TITLE>
</HEAD>

<BODY>

<H1>Cocorium Video Player</H1>
<!-- player skin -->
<link rel="stylesheet" href="{{url('plugins/flowplayer/skin/minimalist.css')}}">
<!-- This HTML file plays an MP4 media file using Flowplayer.

Replace all instances of WEB-DISTRIBUTION-DOMAIN-NAME with the
domain name of your CloudFront web distribution, for example,
d111111abcdef8.cloudfront.net (begins with "d").

Update the version number that appears in the flowplayer-version filenames
with the version number of the files that you downloaded from the Flowplayer website.
The files may not have the same version number.

Ensure that URLs don't contain any spaces.
-->
<script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
<!-- Call the Flowplayer JavaScript file. -->
<script type="text/javascript" src="{{url('plugins/flowplayer/flowplayer.min.js')}}"></script>



<!-- the player -->
<div class="flowplayer" data-swf="{{url('plugins/flowplayer/flowplayer.swf')}}" data-ratio="0.4167">
    <video>
        <source type="video/mp4" src="{{$video->formats[0]->video_url}}">
    </video>
</div>



</BODY>
</HTML>