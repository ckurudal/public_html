<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	session_destroy();
	go(URL."/", 1);
?>
<section class="content">
	<div >
		<p class="alert alert-success"> <i class="fa fa-check-circle"></i> Başarı ile çıkış yaptınız. Yönlendiriliyorsunuz... </p>
	</div>
</section>