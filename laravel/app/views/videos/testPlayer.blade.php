<HTML>
<HEAD>
    <TITLE>Amazon CloudFront Streaming with Flowplayer</TITLE>
</HEAD>

<BODY>

<H1>This video is streamed by CloudFront and played in Flowplayer.</H1>

<!-- This HTML file plays an MP4 media file using Flowplayer.

Replace all instances of WEB-DISTRIBUTION-DOMAIN-NAME with the
domain name of your CloudFront web distribution, for example,
d111111abcdef8.cloudfront.net (begins with "d").

Update the version number that appears in the flowplayer-version filenames
with the version number of the files that you downloaded from the Flowplayer website.
The files may not have the same version number.

Ensure that URLs don't contain any spaces.
-->

<script type="text/javascript" src="http://cocorium.com/js/jquery.min.js"></script>
<!-- Call the Flowplayer JavaScript file. -->
<script src="http://d378r68ica1xoa.cloudfront.net/flowplayer.min.js"></script>

<!-- Style section. Specify the attributes of the player
such as height, width, color, and so on.
-->
<style>
    a.rtmp {
        display:block;
        width:720px;
        height:480px;
        margin:25px 0;
        text-align:center;
        background-color:black;
    }
</style>

<!--  Replace VIDEO-FILE-NAME with the name of your .mp4 video file,
excluding the .mp4 filename extension. For example, if you uploaded a file
called my-vacation-video.mp4, enter my-vacation-video.

If you're streaming an .flv file, use the following format:
<a class="rtmp" href="VIDEO-FILE-NAME"/>
-->
<a class="rtmp" href="mp4:fqPzQw5imFnq3OA31351620000001000001.mp4"/>

<script type="text/javascript">
    flowplayer("a.rtmp", "http://d378r68ica1xoa.cloudfront.net/flowplayer.swf", {
        // Configure Flowplayer to use the RTMP plugin for streaming.
        clip: {
            provider: 'rtmp'
        },

        // Specify the location of the RTMP plugin.
        plugins: {
            rtmp: {
                url: 'http://d378r68ica1xoa.cloudfront.net/flowplayer.rtmp-3.2.13.swf',

                // Replace RTMP-DISTRIBUTION-DOMAIN-NAME with the domain name of your
                // CloudFront RTMP distribution, for example, s5c39gqb8ow64r.cloudfront.net.
                netConnectionUrl: 'rtmp://s3f9alypdt4o4h.cloudfront.net/cfx/st'
            }
        }
    });
</script>

</BODY>
</HTML>