<html>
 <head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="http://weissnew.ntic.fr/media/css/911a6a1ff5745e53e0bc50107fa31097.css" />
<link rel="stylesheet" type="text/css" href="http://weissnew.ntic.fr/media/css/0880b525e50408f1fd124162e3367b88.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://weissnew.ntic.fr/media/css/220e67ab6f46985aa3107fe2900a0fde.css" media="print" />
<script type="text/javascript" src="http://weissnew.ntic.fr/js/prototype/prototype.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/lib/ccard.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/prototype/validation.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/scriptaculous/builder.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/scriptaculous/effects.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/scriptaculous/dragdrop.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/scriptaculous/controls.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/scriptaculous/slider.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/varien/js.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/varien/form.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/varien/menu.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/mage/translate.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/mage/cookies.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/magestore/storepickup/tooltip/tooltip.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/magestore/storepickup.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/calendar/calendar.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/jquery/jquery-noconflict.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/jquery/plugins/jquery.easing.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/jquery/plugins/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/jquery/plugins/jquery.placeholder.1.3.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/ajaxcart/ajaxaddto.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/ajaxcart/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/ajaxcart/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/tbt/rewardssocial/widgets/init.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/tbt/rewardssocial/facebook/like/reward.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/magestore/promotionalgift/tooltip/tooltip.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/jquery_etalage/jquery.etalage.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/js/jquery.zoom.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/js/mobile-custom.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/js/jquery.selectbox.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/jquery_nicescroll/jquery.nicescroll.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/js/twitterfetcher.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/jquery_accordion/jquery.akordeon.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/default/trego/js/jquery.slides.min.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/base/default/js/eucookielaw.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/skin/frontend/base/default/js/bundle.js"></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/quickview/js/trego_quickview.js" trego_quickview></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/varien/product.js" trego_quickview></script>
<script type="text/javascript" src="http://weissnew.ntic.fr/js/trego/quickview/configurable.js" trego_quickview></script>
 </head>
 <body>
  
 <?php
 /*
	echo 'Start : '.date('H:i:s', time()).'<br>';
 
	$pdo = new PDO('mysql:host=localhost;dbname=weissnew','weissnew', 'JQLb6x');
	$sql = 'SELECT count(*) as nb FROM catalog_product_option';     
	
	
	for ($i = 1; $i <= 100; $i++) 
	{
		$req = $pdo->query($sql);    
		$row = $req->fetch();
		echo '-'.$row['nb'].'<br/>';   
		$req->closeCursor(); 
	}    
	

	echo 'End : '.date('H:i:s', time()).'<br>';
*/
?>
 
 
 </body>
</html>