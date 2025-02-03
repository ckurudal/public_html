<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	 
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  


?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-envelope fa-2x pull-left"></i>
	SMTP Mail Ayarları
	<p> <small> E-posta SMTP Yönetimi </small> </p> 
</section>
<section class="content">
<?php 

	if (isset($_POST["kaydet"])) { 

		$gonderici = $_POST["gonderici"];
		$smtpserver = $_POST["smtpserver"];
		$smtpport = $_POST["smtpport"];
		$smtpsunucu = $_POST["smtpsunucu"];
		$eposta = $_POST["eposta"];
		$mailsifre = $_POST["mailsifre"];

		$mailayarkaydet = mysql_query("UPDATE ayarlar SET gonderici = '$gonderici', smtpserver = '$smtpserver', smtpport = '$smtpport', smtpsunucu = '$smtpsunucu', eposta = '$eposta', mailsifre = '$mailsifre' where id = '1'");

		go("index.php?do=islem&ayarlar=mailayar&hareket=onay",0);		


		
	}

?>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-6">  
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">
					<div class="box-header with-border">
					  <h4><i class="fa fa-check"></i> E-posta SMTP Ayarları </h4>					  
					</div>
				<!-- /.box-header -->
					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>E-posta bildirimlerinin çalışabilmesi için aşağıdaki bilgileri doldurmak zorunludur. Sunucunuza ait bir smtp e-posta hesabı gereklidir. </span>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-4 control-label">Gönderici Bilgisi:</label>
							  <div class="col-sm-6"> 
									<input type="text" class="form-control" name="gonderici" value="<?=$ayar["gonderici"];?>"/> 
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-4 control-label">SMTP Server:</label>
							  <div class="col-sm-6"> 
									<input type="text" class="form-control" name="smtpserver" value="<?=$ayar["smtpserver"];?>"/> 
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-4 control-label">SMTP Port:</label>
							  <div class="col-sm-6"> 
									<input type="text" class="form-control" name="smtpport" value="<?=$ayar["smtpport"];?>"/> 
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-4 control-label">SMTP Sunucu:</label>
							  <div class="col-sm-6"> 
									<select class="form-control select2" name="smtpsunucu">
										<option selected="selected"><?=$ayar["smtpsunucu"];?></option>
										<option>Yok</option>
										<option>TLS</option>
										<option>SSL</option>
									</select>
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-4 control-label">E-Posta:</label>
							  <div class="col-sm-6"> 
									<input type="text" class="form-control" name="eposta" value="<?=$ayar["eposta"];?>"/> 
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-4 control-label">E-Posta Şifre:</label>
							  <div class="col-sm-6"> 
									<input type="text" class="form-control" name="mailsifre" value="<?=$ayar["mailsifre"];?>"/> 
							  </div>
							</div>   
						</div>
						<div class="box-footer">						
							<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<div class="box">
				<div class="box-header with-border">
				  <h4><i class="fa fa-check"></i> E-posta Sistemi </h4>					  
				</div>
				<div class="box-body pad" style="">
					<div class="form-horizontal"> 							
						<form class="form-horizontal" method="post" action="" enctype="multipart/form-data"> 
							<label class="control-label">E-posta sistemini buradan aktif / pasif yapabilirsiniz.</label>
							<div class="alert alert-warning">							
								<label for="yetki">
									<input type="radio" name="mail_durum" <?php if ($ayar["mail_durum"] == 0) {echo "checked";} ?> value="0" class="minimal">
									<strong>Aktif</strong> (E-posta sistemini açarak, üyelere bildirimler gönderilecektir.)
								</label>
								<br>
								<label for="yetki">
									<input type="radio" name="mail_durum" <?php if ($ayar["mail_durum"] == 1) {echo "checked";} ?> value="1" class="minimal">
									<strong>Pasif</strong> (E-posta sistemini kapatırsanız, üyelere bildirim ve onay mesajları gönderilmeyecektir.)
								</label>
							</div>
							<br>
							<button type="submit" name="eposta_durum_kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
						</form>
					
						<?php 

							// NETGSM E-posta AYAR KAYIT

							if (isset($_POST["eposta_durum_kaydet"])) { 

								$mail_durum = trim($_POST["mail_durum"]); 

								$mailayarkaydet = mysql_query("UPDATE ayarlar SET mail_durum = '$mail_durum' where id = '1'");
								
								go("index.php?do=ayar/mailayar",0);

							}

						?> 
						
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>