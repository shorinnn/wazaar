<?php
function get($name){
    if(isset($_GET[$name])) return urldecode ($_GET[$name]);
    return '';
}

function getErrors(){
    if(get('errors')=='') return '';
    return implode('<br />', json_decode( get('errors') ) );
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <script src="alertify.min.js"></script>
    <script>
    function alerts(){
        var errors = "<?php echo getErrors() ;?>";
        alertify.alert(errors);
    }
    </script>
<meta charset="UTF-8" />
<meta name="keywords" content=",,,,," />
<meta name="description" content=",,,,," />
<meta name="author" content="" /> 
<link rel="stylesheet" href="css/salesweb.css" type="text/css" />
<!-- include the core styles -->
<link rel="stylesheet" href="css/alertify.core.css" />
<!-- include a theme, can be included into the core instead of 2 separate files -->
<link rel="stylesheet" href="css/alertify.default.css" />
<title>技のフリーマーケット・Wazaarワザール</title>
</head>



<body <?php if(get('errors') != ''):?>
    onload="alerts()"
        <?php endif;?>>
<!-- header -->
<header>
<div id="header"><img src="img/header/01.png" /></div>
</header>
<!-- /header -->

<div class="container">
    <img src="img/contents/title10.png" alt="毎月10万円以上の副収入を得たい人はこちらの動画をご覧ください。">
    <!-- movie -->
    <iframe width="700" height="395" src="https://www.youtube.com/embed/KkyigoKXVG4" frameborder="0" scrolling="" class="movie01"></iframe>
    <!-- /movie -->
    
    
    <!-- contents -->
    
    
    
    <img src="img/contents/title_present.png" alt="先行登録6大特典" />
</div>
<!-- 特典 -->
<div class="bg_prs"><div id="present">
	<div class="container">
        <img src="img/present/01.png" alt="特典1" />
        <img src="img/present/02.png" alt="特典2" />
        <img src="img/present/03.png" alt="特典3" />
        <img src="img/present/04.png" alt="特典4" />
        <img src="img/present/05.png" alt="特典5" />
        <img src="img/present/06.png" alt="特典6" />
	</div>
</div></div>
<!-- /特典 -->



<!-- form -->
<div class="form_bg">
	<div class="container">
        <form method="post" class="af-form-wrapper" accept-charset="UTF-8" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/lp';?>"  >
            <!--<form method="post" class="af-form-wrapper" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl"  >-->
<div style="display: none;">
<input type='hidden' name='stpi' value='<?php echo @$_GET['stpi'];?>' />
<input type="hidden" id="awf_field-74444845" class="text" name="custom STPI" value="<?php echo @$_GET['stpi'];?>" tabindex="502" />
<input type='hidden' name='lp-val' value='LP1' />
<input type="hidden" name="meta_web_form_id" value="2051478497" />
<input type="hidden" name="meta_split_id" value="" />
<input type="hidden" name="listname" value="awlist3910087" />
<input type="hidden" name="redirect" value="http://wazaar.jp/lp1/success.php" id="redirect_307b2f963055014508b9c9a4122095fa" />
<input type="hidden" name="meta_forward_vars" value="1" />
<input type="hidden" name="meta_adtracking" value="My_Web_Form" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="name,email" />
</div>
<input type="hidden" name="meta_tooltip" value="" />
        <img src="img/form/name.png" class="imgl"><input type="text" name="name" value="<?=get('name');?>" class="inputtext"><br />
        <img src="img/form/mail.png" class="imgl"><input type="text" name="email" value="<?=get('email');?>" class="inputtext"><br />
        <input type="image" name="submit" src="img/form/btn_01.png" alt="??"  class="submitbutton" value=""
         onmouseover="this .src='img/form/btn_02.png'"
         onmouseout="this .src='img/form/btn_01.png'" />
        </form>
	</div>
</div>
<!-- /form -->

<div class="container">
	<img src="img/contents/title07.png" alt="追伸" />
</div>
<div class="bg08">
	<div class="textbox">
		<div class="container">
<p>
私は出身が滋賀県になります。
</p>
<p>
私が高校生だった20年前には、<br />
滋賀県の高校生が一流大学に入ろうと思えば、<br />
滋賀県ではなく、京都府や大阪府などの都市圏に行って<br />
有名講師の講義を受けるのが当たり前でした。
</p>
<p>
今でも状況はほとんど変わっていません。
</p>
<p>
それは滋賀県に一流講師がいないからですが、<br />
このように地方に住んでいると予備校に限らず<br />
地元でよい講義を受けることはできません。
</p>
<p>
しかし、ワザールでは、あらゆるジャンルの講義が<br />
地方や都市圏に関係なく、インターネットで受講することができます。
</p>
<p>
日本のこれからの若者も素晴らしい「技」の動画から学び、<br />
その道のプロフェッショナルとして、世界で通用する人材に<br />
育ってもらうことを願って、ワザールというサービスを始めました。
</p>
<p>
動画教育事業を通じて、日本の未来へ貢献することが、<br />
Wazaarのミッションになります。
</p>
<p>
<span class="b-bg">あなたの技を必要としている人が日本のどこかに必ずいます。</span>
</p>
<p>
それを動画教材として届けることで、<br />
あなたの自身の収入を増やすだけではなく、<br />
それを見る方も素晴らしいノウハウが身に付き人生が豊かになります。
</p>
<p>
まずは、その第一歩として、<br />
ワザラーとしてご登録いただけることを<br />
心より願っております。
</p>
<p>
最後までお読みいただき、ありがとうございました。<br />
本当に感謝いたします。
</p>
		</div>
	</div>
</div>

<div class="container">
    <img src="img/contents/profile.png" alt="プロフィール" />
    
    <img src="img/contents/title09.png" alt="Wazaar 日本法人代表からの挨拶">
    <!-- movie -->
    <iframe width="700" height="395" src="https://www.youtube.com/embed/noXIKl1WMiI" frameborder="0" scrolling="" class="movie01"></iframe>
    <!-- /movie -->
    
</div>


</div>
<!-- /user -->

<!-- form -->
<div class="form_bg">
	<div class="container">
             <a name="form"></a>
        <form method="post" class="af-form-wrapper" accept-charset="UTF-8" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/lp';?>"  >
        <!--<form method="post" class="af-form-wrapper" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl"  >-->
<div style="display: none;">
<input type='hidden' name='stpi' value='<?php echo @$_GET['stpi'];?>' />
<input type="hidden" id="awf_field-74444845" class="text" name="custom STPI" value="<?php echo @$_GET['stpi'];?>" tabindex="502" />
<input type='hidden' name='lp-val' value='LP1' />
<input type="hidden" name="meta_web_form_id" value="2051478497" />
<input type="hidden" name="meta_split_id" value="" />
<input type="hidden" name="listname" value="awlist3910087" />
<input type="hidden" name="redirect" value="http://wazaar.jp/lp1/success.php" id="redirect_307b2f963055014508b9c9a4122095fa" />
<input type="hidden" name="meta_forward_vars" value="1" />
<input type="hidden" name="meta_adtracking" value="My_Web_Form" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="name,email" />
</div>
<input type="hidden" name="meta_tooltip" value="" />
        <img src="img/form/name.png" class="imgl"><input type="text" name="name" value="<?=get('name');?>" class="inputtext"><br />
        <img src="img/form/mail.png" class="imgl"><input type="text" name="email" value="<?=get('email');?>" class="inputtext"><br />
        <input type="image" name="submit" src="img/form/btn_01.png" alt="??"  class="submitbutton" value=""
         onmouseover="this .src='img/form/btn_02.png'"
         onmouseout="this .src='img/form/btn_01.png'" />
        </form>
	</div>
</div>
<!-- /form -->

</div>


<!-- footer -->
<footer>
<address>Copyright&copy; Wazaar. All Rights Reserved.</address>
</footer>
<!-- /footer -->

</body>

</html>