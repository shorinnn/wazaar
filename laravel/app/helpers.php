<?php

function cloudfrontUrl($url = ''){
    if(trim($url)=='' || $url == false) return $url;
    if( !App::environment( 'production' ) ) return $url;
    $url = explode('.com/', $url);
    $url = str_replace('wazaardev/', '', $url[1]);
    $url = str_replace('wazaar/', '', $url);
    $url = str_replace('wazaar-demo/', '', $url);
    return "//s3-us-west-2.amazonaws.com/wazaar-demo/".$url;
    return '//'.getenv('CLOUDFRONT_DOMAIN').'/'.$url;
}

function singplural($count, $word){
    if($count==1) return str_singular($word);
    else return str_plural ($word);
}

function alphanum($string){
    return preg_replace("/[^a-zA-Z0-9]+/", "", $string);
}

function mimetype($file){
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    //if( is_string($file) ){
//    if(  file_exists($file) ){
//        $file = file_get_contents($file);
//    }
//    $return = '';
    try{
        $info = pathinfo($file);
        $file = file_get_contents($file);
        $return = $finfo->buffer($file);
    }
    catch(Exception $e){
        
        $return = $finfo->buffer($file);
    }
    return $return;
}

function mime_to_extension($mime){
    $definitive = array (
        'application/pdf'   => '.pdf',
        'application/zip'   => '.zip',
        'image/gif'         => '.gif',
        'image/jpeg'        => '.jpg',
        'image/png'         => '.png',
        'text/css'          => '.css',
        'text/html'         => '.html',
        'text/javascript'   => '.js',
        'text/plain'        => '.txt',
        'text/xml'          => '.xml',
      'application/x-authorware-bin' => '.aab',
      'application/x-authorware-map' => '.aam',
      'application/x-authorware-seg' => '.aas',
      'text/vnd.abc' => '.abc',
      'video/animaflex' => '.afl',
      'application/x-aim' => '.aim',
      'text/x-audiosoft-intra' => '.aip',
      'application/x-navi-animation' => '.ani',
      'application/x-nokia-9000-communicator-add-on-software' => '.aos',
      'application/mime' => '.aps',
      'application/arj' => '.arj',
      'image/x-jg' => '.art',
      'text/asp' => '.asp',
      'application/x-mplayer2' => '.asx',
      'video/x-ms-asf-plugin' => '.asx',
      'audio/x-au' => '.au',
      'application/x-troff-msvideo' => '.avi',
      'video/avi' => '.avi',
      'video/msvideo' => '.avi',
      'video/x-msvideo' => '.avi',
      'video/avs-video' => '.avs',
      'application/x-bcpio' => '.bcpio',
      'application/mac-binary' => '.bin',
      'application/macbinary' => '.bin',
      'application/x-binary' => '.bin',
      'application/x-macbinary' => '.bin',
      'image/x-windows-bmp' => '.bmp',
      'application/x-bzip' => '.bz',
      'application/vnd.ms-pki.seccat' => '.cat',
      'application/clariscad' => '.ccad',
      'application/x-cocoa' => '.cco',
      'application/cdf' => '.cdf',
      'application/x-cdf' => '.cdf',
      'application/java' => '.class',
      'application/java-byte-code' => '.class',
      'application/x-java-class' => '.class',
      'application/x-cpio' => '.cpio',
      'application/mac-compactpro' => '.cpt',
      'application/x-compactpro' => '.cpt',
      'application/x-cpt' => '.cpt',
      'application/pkcs-crl' => '.crl',
      'application/pkix-crl' => '.crl',
      'application/x-x509-user-cert' => '.crt',
      'application/x-csh' => '.csh',
      'text/x-script.csh' => '.csh',
      'application/x-pointplus' => '.css',
      'text/css' => '.css',
      'application/x-deepv' => '.deepv',
      'video/dl' => '.dl',
      'video/x-dl' => '.dl',
      'application/commonground' => '.dp',
      'application/drafting' => '.drw',
      'application/x-dvi' => '.dvi',
      'drawing/x-dwf (old)' => '.dwf',
      'model/vnd.dwf' => '.dwf',
      'application/acad' => '.dwg',
      'application/dxf' => '.dxf',
      'text/x-script.elisp' => '.el',
      'application/x-bytecode.elisp (compiled elisp)' => '.elc',
      'application/x-elc' => '.elc',
      'application/x-esrehber' => '.es',
      'text/x-setext' => '.etx',
      'application/envoy' => '.evy',
      'application/vnd.fdf' => '.fdf',
      'application/fractals' => '.fif',
      'image/fif' => '.fif',
      'video/fli' => '.fli',
      'video/x-fli' => '.fli',
      'text/vnd.fmi.flexstor' => '.flx',
      'video/x-atomic3d-feature' => '.fmf',
      'image/vnd.fpx' => '.fpx',
      'image/vnd.net-fpx' => '.fpx',
      'application/freeloader' => '.frl',
      'image/g3fax' => '.g3',
      'image/gif' => '.gif',
      'video/gl' => '.gl',
      'video/x-gl' => '.gl',
      'application/x-gsp' => '.gsp',
      'application/x-gss' => '.gss',
      'application/x-gtar' => '.gtar',
      'multipart/x-gzip' => '.gzip',
      'application/x-hdf' => '.hdf',
      'text/x-script' => '.hlb',
      'application/hlp' => '.hlp',
      'application/x-winhelp' => '.hlp',
      'application/binhex' => '.hqx',
      'application/binhex4' => '.hqx',
      'application/mac-binhex' => '.hqx',
      'application/mac-binhex40' => '.hqx',
      'application/x-binhex40' => '.hqx',
      'application/x-mac-binhex40' => '.hqx',
      'application/hta' => '.hta',
      'text/x-component' => '.htc',
      'text/webviewhtml' => '.htt',
      'x-conference/x-cooltalk' => '.ice ',
      'image/x-icon' => '.ico',
      'application/x-ima' => '.ima',
      'application/x-httpd-imap' => '.imap',
      'application/inf' => '.inf ',
      'application/x-internett-signup' => '.ins',
      'application/x-ip2' => '.ip ',
      'video/x-isvideo' => '.isu',
      'audio/it' => '.it',
      'application/x-inventor' => '.iv',
      'i-world/i-vrml' => '.ivr',
      'application/x-livescreen' => '.ivy',
      'audio/x-jam' => '.jam ',
      'application/x-java-commerce' => '.jcm ',
      'image/x-jps' => '.jps',
      'application/x-javascript' => '.js ',
      'image/jutvision' => '.jut',
      'music/x-karaoke' => '.kar',
      'application/x-ksh' => '.ksh',
      'text/x-script.ksh' => '.ksh',
      'audio/x-liveaudio' => '.lam',
      'application/lha' => '.lha',
      'application/x-lha' => '.lha',
      'application/x-lisp' => '.lsp ',
      'text/x-script.lisp' => '.lsp ',
      'text/x-la-asf' => '.lsx',
      'application/x-lzh' => '.lzh',
      'application/lzx' => '.lzx',
      'application/x-lzx' => '.lzx',
      'text/x-m' => '.m',
      'audio/x-mpequrl' => '.m3u ',
      'application/x-troff-man' => '.man',
      'application/x-navimap' => '.map',
      'application/mbedlet' => '.mbd',
      'application/x-magic-cap-package-1.0' => '.mc$',
      'application/mcad' => '.mcd',
      'application/x-mathcad' => '.mcd',
      'image/vasa' => '.mcf',
      'text/mcf' => '.mcf',
      'application/netmc' => '.mcp',
      'application/x-troff-me' => '.me ',
      'application/x-frame' => '.mif',
      'application/x-mif' => '.mif',
      'www/mime' => '.mime ',
      'audio/x-vnd.audioexplosion.mjuicemediafile' => '.mjf',
      'video/x-motion-jpeg' => '.mjpg ',
      'application/x-meme' => '.mm',
      'audio/mod' => '.mod',
      'audio/x-mod' => '.mod',
      'audio/x-mpeg' => '.mp2',
      'video/x-mpeq2a' => '.mp2',
      'audio/mpeg3' => '.mp3',
      'audio/x-mpeg-3' => '.mp3',
      'application/vnd.ms-project' => '.mpp',
      'application/marc' => '.mrc',
      'application/x-troff-ms' => '.ms',
      'application/x-vnd.audioexplosion.mzz' => '.mzz',
      'application/vnd.nokia.configuration-message' => '.ncm',
      'application/x-mix-transfer' => '.nix',
      'application/x-conference' => '.nsc',
      'application/x-navidoc' => '.nvd',
      'application/oda' => '.oda',
      'application/x-omc' => '.omc',
      'application/x-omcdatamaker' => '.omcd',
      'application/x-omcregerator' => '.omcr',
      'text/x-pascal' => '.p',
      'application/pkcs10' => '.p10',
      'application/x-pkcs10' => '.p10',
      'application/pkcs-12' => '.p12',
      'application/x-pkcs12' => '.p12',
      'application/x-pkcs7-signature' => '.p7a',
      'application/x-pkcs7-certreqresp' => '.p7r',
      'application/pkcs7-signature' => '.p7s',
      'text/pascal' => '.pas',
      'image/x-portable-bitmap' => '.pbm ',
      'application/vnd.hp-pcl' => '.pcl',
      'application/x-pcl' => '.pcl',
      'image/x-pict' => '.pct',
      'image/x-pcx' => '.pcx',
      'application/pdf' => '.pdf',
      'audio/make.my.funk' => '.pfunk',
      'image/x-portable-graymap' => '.pgm',
      'image/x-portable-greymap' => '.pgm',
      'application/x-newton-compatible-pkg' => '.pkg',
      'application/vnd.ms-pki.pko' => '.pko',
      'text/x-script.perl' => '.pl',
      'application/x-pixclscript' => '.plx',
      'text/x-script.perl-module' => '.pm',
      'application/x-portable-anymap' => '.pnm',
      'image/x-portable-anymap' => '.pnm',
      'model/x-pov' => '.pov',
      'image/x-portable-pixmap' => '.ppm',
      'application/powerpoint' => '.ppt',
      'application/x-mspowerpoint' => '.ppt',
      'application/x-freelance' => '.pre',
      'paleovu/x-pv' => '.pvu',
      'text/x-script.phyton' => '.py ',
      'applicaiton/x-bytecode.python' => '.pyc ',
      'audio/vnd.qcelp' => '.qcp ',
      'video/x-qtc' => '.qtc',
      'audio/x-realaudio' => '.ra',
      'application/x-cmu-raster' => '.ras',
      'image/x-cmu-raster' => '.ras',
      'text/x-script.rexx' => '.rexx ',
      'image/vnd.rn-realflash' => '.rf',
      'image/x-rgb' => '.rgb ',
      'application/vnd.rn-realmedia' => '.rm',
      'audio/mid' => '.rmi',
      'application/ringing-tones' => '.rng',
      'application/vnd.nokia.ringing-tone' => '.rng',
      'application/vnd.rn-realplayer' => '.rnx ',
      'image/vnd.rn-realpix' => '.rp ',
      'text/vnd.rn-realtext' => '.rt',
      'application/x-rtf' => '.rtf',
      'video/vnd.rn-realvideo' => '.rv',
      'audio/s3m' => '.s3m ',
      'application/x-lotusscreencam' => '.scm',
      'text/x-script.guile' => '.scm',
      'text/x-script.scheme' => '.scm',
      'video/x-scm' => '.scm',
      'application/sdp' => '.sdp ',
      'application/x-sdp' => '.sdp ',
      'application/sounder' => '.sdr',
      'application/sea' => '.sea',
      'application/x-sea' => '.sea',
      'application/set' => '.set',
      'application/x-sh' => '.sh',
      'text/x-script.sh' => '.sh',
      'audio/x-psid' => '.sid',
      'application/x-sit' => '.sit',
      'application/x-stuffit' => '.sit',
      'application/x-seelogo' => '.sl ',
      'audio/x-adpcm' => '.snd',
      'application/solids' => '.sol',
      'application/x-pkcs7-certificates' => '.spc ',
      'application/futuresplash' => '.spl',
      'application/streamingmedia' => '.ssm ',
      'application/vnd.ms-pki.certstore' => '.sst',
      'application/sla' => '.stl',
      'application/vnd.ms-pki.stl' => '.stl',
      'application/x-navistyle' => '.stl',
      'application/x-sv4cpio' => '.sv4cpio',
      'application/x-sv4crc' => '.sv4crc',
      'x-world/x-svr' => '.svr',
      'application/x-shockwave-flash' => '.swf',
      'application/x-tar' => '.tar',
      'application/toolbook' => '.tbk',
      'application/x-tcl' => '.tcl',
      'text/x-script.tcl' => '.tcl',
      'text/x-script.tcsh' => '.tcsh',
      'application/x-tex' => '.tex',
      'application/plain' => '.text',
      'application/gnutar' => '.tgz',
      'audio/tsp-audio' => '.tsi',
      'application/dsptype' => '.tsp',
      'audio/tsplayer' => '.tsp',
      'text/tab-separated-values' => '.tsv',
      'text/x-uil' => '.uil',
      'application/i-deas' => '.unv',
      'application/x-ustar' => '.ustar',
      'multipart/x-ustar' => '.ustar',
      'application/x-cdlink' => '.vcd',
      'text/x-vcalendar' => '.vcs',
      'application/vda' => '.vda',
      'video/vdo' => '.vdo',
      'application/groupwise' => '.vew ',
      'application/vocaltec-media-desc' => '.vmd ',
      'application/vocaltec-media-file' => '.vmf',
      'audio/voc' => '.voc',
      'audio/x-voc' => '.voc',
      'video/vosaic' => '.vos',
      'audio/voxware' => '.vox',
      'audio/x-twinvq' => '.vqf',
      'application/x-vrml' => '.vrml',
      'x-world/x-vrt' => '.vrt',
      'application/wordperfect6.1' => '.w61',
      'audio/wav' => '.wav',
      'audio/x-wav' => '.wav',
      'application/x-qpro' => '.wb1',
      'image/vnd.wap.wbmp' => '.wbmp',
      'application/vnd.xara' => '.web',
      'application/x-123' => '.wk1',
      'windows/metafile' => '.wmf',
      'text/vnd.wap.wml' => '.wml',
      'application/vnd.wap.wmlc' => '.wmlc ',
      'text/vnd.wap.wmlscript' => '.wmls',
      'application/vnd.wap.wmlscriptc' => '.wmlsc ',
      'application/x-wpwin' => '.wpd',
      'application/x-lotus' => '.wq1',
      'application/mswrite' => '.wri',
      'application/x-wri' => '.wri',
      'text/scriplet' => '.wsc',
      'application/x-wintalk' => '.wtk ',
      'image/x-xbitmap' => '.xbm',
      'image/x-xbm' => '.xbm',
      'image/xbm' => '.xbm',
      'video/x-amt-demorun' => '.xdr',
      'xgl/drawing' => '.xgz',
      'image/vnd.xiff' => '.xif',
      'audio/xm' => '.xm',
      'application/xml' => '.xml',
      'text/xml' => '.xml',
      'xgl/movie' => '.xmz',
      'application/x-vnd.ls-xpix' => '.xpix',
      'image/xpm' => '.xpm',
      'video/x-amt-showrun' => '.xsr',
      'image/x-xwd' => '.xwd',
      'image/x-xwindowdump' => '.xwd',
      'application/x-compress' => '.z',
      'application/x-zip-compressed' => '.zip',
      'application/zip' => '.zip',
      'multipart/x-zip' => '.zip',
      'text/x-script.zsh' => '.zsh',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
      'application/msword' => '.doc'
    );
    if(key_exists($mime, $definitive)) return $definitive[$mime];
    return false;    
}

function format_errors(Array $errors, $start='<br />', $end=''){
    if($end=='')    return implode($start, $errors);
    else{
        $return = [];
        foreach($errors as $err){
            $return[] = $start.$err.$end;
        }
        return $return;
    }
}

/**
 * Alternative to Input::except() which fails in codeception
 * @param array $exclude Request params to exclude
 * @return array The resulting array
 */
function input_except(array $exclude){    
    return array_except(Input::all(), (array) $exclude);
}

function username(){
    $profile = Student::find( Auth::user()->id )->profile;
    if( $profile ){
        return trim($profile->first_name) == '' ? Auth::user()->email : $profile->first_name;
    }
    else{
        return trim(Auth::user()->first_name) == '' ?  Auth::user()->email : Auth::user()->first_name;
    }
}

/**
 * Cycles through each argument added
 * Based on Rails `cycle` method
 * 
 * if last argument begins with ":" 
 * then it will change the namespace
 * (allows multiple cycle calls within a loop)
 * 
 * @param mixed $values infinite amount can be added
 * @return mixed
 * @author Baylor Rae'
 */
function cycle($first_value, $values = '*') {
  // keeps up with all counters
  static $count = array();

  // get all arguments passed
  $values = is_array($first_value) ? $first_value : func_get_args();

  // set the default name to use
  $name = 'default';

  // check if last items begins with ":"
  $last_item = end($values);
  if( substr($last_item, 0, 1) === ':' ) {

    // change the name to the new one
    $name = substr($last_item, 1);

    // remove the last item from the array
    array_pop($values);
  }

  // make sure counter starts at zero for the name
  if( !isset($count[$name]) )
    $count[$name] = 0;

  // get the current item for its index
  $index = $count[$name] % count($values);

  // update the count and return the value
  $count[$name]++;
  return $values[$index];  
}

/**
 * If the supplies string is a valid json resource, return an associative array
 * @param string $json The string to be checked for valid json
 * @return mixed False if not valid json, associative array otherwise
 */
function json2Array($json){
    if($json==null) return array();
    $arr = json_decode($json, true);
    if( json_last_error() != JSON_ERROR_NONE) return array();
    return $arr;
}

function money_val($number){
    return number_format($number, Config::get('custom.currency_decimals'), '', '');
}

function appendToQueryString($key, $val){
    $params = array_merge( $_GET, array( $key => $val ) );
    return http_build_query($params);
}

function doPostCurl($url, $data)
{
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
}

function serveMobile(){
    if(Cookie::get('force-mobile')==1) return true;
    return false;
}

/**
 * @param  string  $filename
 * @return string
 */
function asset_path($filename) {
    $manifest_path = base_path()."/public/assets/rev-manifest.json";

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), TRUE);
    } else {
        $manifest = [];
    }
    
    if (array_key_exists($filename, $manifest)) {
        return $manifest[$filename];
    }

    return $filename;
}

function round2($number, $roundTo=0){
    return (round($number/$roundTo)) * $roundTo; 
}

function getDomainFromEmail($email){
    // Get the data after the @ sign
    $domain = substr(strrchr($email, "@"), 1);
 
    return $domain;
}

function courseStepsRemaining($course){
    $remaining = 3;
    if( $course->short_description !='' ) $remaining--;
    if( $course->lessonCount() > 0 ) $remaining--;
    if( $course->course_difficulty_id > 0 ) $remaining--;
    return $remaining;
}

function validateExternalVideo($url){
    // see if youtube
    $videoID = parse_yturl($url);
    // see if vimeo
    if( !$videoID ) $videoID = get_vimeoid($url);
    // not Youtube or Vimeo
    if( !$videoID ) return false;
    return true;
    //https://www.googleapis.com/youtube/v3/videos/?part=id&id=gvmrxFFhKDE
}

/**
 *  Check if input string is a valid YouTube URL
 *  and try to extract the YouTube Video ID from it.
 *  @author  Stephan Schmitz <eyecatchup@gmail.com>
 *  @param   $url   string   The string that shall be checked.
 *  @return  mixed           Returns YouTube Video ID, or (boolean) false.
 */        
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

function get_vimeoid( $url ) {
    $urls = parse_url($url);
    if (isset($urls['host']) && $urls['host'] == 'vimeo.com'){
        $urls =  explode( '/', $urls['path'] );
        $vimid = $urls[ count($urls) - 1 ];
        return trim($vimid);
    }
    return false;
}

function filenameFromS3Key($url){
    $url = explode('/', $url);
    $url = $url[ count($url) - 1];
    $url = explode('.', $url);
    unset( $url[ count($url) - 1 ]);
    $url = implode('.', $url);
    $url = explode('--', $url);    
    return $url[1];
}

function externalVideoPreview($url, $big=false, $iframe=false, $justId = false){
    $preview = '';
//    $width = $big ? 1280 : 560;
    $width = $big ? 853 : 658;
//    $height = $big ? 720 : 315;
    $height = $big ? 480 : 370;

    $width = '100%';
    //$height = '100%';
    if( $id = parse_yturl($url) ){
        if( $justId ) return $id;
        if($iframe) $preview = '<iframe id="embeded-video" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$id.'?showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>';
        else $preview = '<img data-video-url="https://www.youtube.com/embed/'.$id.'" data-yt=1  onclick="showVideoPreview(this)" src="http://img.youtube.com/vi/'.$id.'/0.jpg" width="100%"/>';
    }
    if( $id = get_vimeoid($url)){
        $vimeo = new \Vimeo\Vimeo( Config::get('custom.vimeo.client_id'), Config::get('custom.vimeo.client_secret') );
        $vimeo->setToken( Config::get('custom.vimeo.access_token') );
        $response = $vimeo->request('/videos/'.$id, array('per_page' => 2), 'GET');
        
        $link = $response['body']['pictures']['sizes'][1]['link'];
        if($iframe) $preview = '<iframe  id="embeded-video" src="https://player.vimeo.com/video/'.$id.'?color=ffffff&title=0&portrait=0&badge=0&rel=0" width="'.$width.'" height="'.$height.'"     frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        else $preview = '<img data-video-url="https://player.vimeo.com/video/'.$id.'" data-v=1  onclick="showVideoPreview(this)" src="'.$link.'" width="100%" />';
    }
    return $preview;
}

function timeUntil($futureDate, $returnSeconds = false){
    $future_date = new DateTime($futureDate);
    
    $now = new DateTime();
    if($returnSeconds) return $future_date->getTimestamp() - $now->getTimestamp();
    $int = $interval = $future_date->diff($now);
    if($int->format("%d")>0){
//        $time = $interval->format("%d days %h:%i:%s");
        $time = $interval->days.'days '.$interval->format("%h:%i:%s");
    }
    else{
        $time = $interval->format("%h:%i:%s");
    }
    return $time;
}

function timeProgress($start, $end){
    $total = strtotime($end) - strtotime($start);
    $elapsed = time() - strtotime($start);
    return floor( ($elapsed * 100 ) / $total );
}

function difficultyToCss($dif){
    if( $dif == 'Beginner' ) return 'beginner';
    if( $dif == 'Intermediate' ) return 'intermediate';
    return 'advanced';
}

function admin(){
    if(Auth::check() && Auth::user()->hasRole('Admin')) return true;
    return false;
}
function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}


function courseApprovedVersion($course){
    if( trim($course->approved_data) != ''){
        $approvedData = @json_decode( $course->approved_data );
        if($approvedData == null) return $course;
        foreach($approvedData as $k => $v){
            if($k=='student_count' || $k=='total_reviews' || $k=='reviews_positive_score') continue;
            $course->$k = $v;
        }
    }
    if($course->courseDifficulty == null){
        if($course->course_difficulty_id == 2) $course->course_difficulty_id = 3;
        if($course->course_difficulty_id == 4) $course->course_difficulty_id = 1;
    }
    return $course;
}
function getYTDurationSeconds($duration){
    preg_match_all('/[0-9]+[HMS]/',$duration,$matches);
    $duration=0;
    foreach($matches as $match){
        //echo '<br> ========= <br>';       
        //print_r($match);      
        foreach($match as $portion){        
            $unite=substr($portion,strlen($portion)-1);
            switch($unite){
                case 'H':{  
                    $duration +=    substr($portion,0,strlen($portion)-1)*60*60;            
                }break;             
                case 'M':{                  
                    $duration +=substr($portion,0,strlen($portion)-1)*60;           
                }break;             
                case 'S':{                  
                    $duration +=    substr($portion,0,strlen($portion)-1);          
                }break;
            }
        }
    //  echo '<br> duratrion : '.$duration;
    //echo '<br> ========= <br>';
    }
     return $duration;

}

function strip_tags_and_attributes($text, $tags){
    $text = strip_tags($text, $tags);
    return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text);
}

function nonHttps($url){
    $url = str_replace('https://', 'http://', $url);
    return $url;
}

function percentage($val, $total){
    return $val * 100 / $total;
}

function externalVideoType($url){
    if( $id = parse_yturl($url) ) return 'yt';
    return 'vimeo';
}