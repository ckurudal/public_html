<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  
	$firma =  @$_GET["firma"];


?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-mobile-phone fa-2x pull-left"></i>
	Sms Ayarları
	<p> <small> Sms Yönetimi </small> </p> 
</section>
<section class="content">
	<div class="row">	
		<div class="col-md-6">			
			<div class="box">
				<div class="box-header with-border">
				  <h4><i class="fa fa-check"></i> NetGSM SMS Ayarları </h4>					  
				</div>
				<div class="box-body pad" style="">
					<div class="form-horizontal"> 
						
						<form class="form-horizontal" method="post" action="" enctype="multipart/form-data"> 
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>NetGSM sms sisteminin çalışabilmesi için NetGSM'e ait bir kullanıcı hesabı gereklidir. <a target="_blank" style="color:#333; text-decoration:none;" href="https://www.netgsm.com.tr/"><strong>NetGSM Üyelik İçin Tıklayınız.</strong></a> </span>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label text-right">Kullanıcı:</label>
							  <div class="col-sm-5"> 
									<input type="text" class="form-control" name="netgsm_username" value="<?=$ayar["netgsm_username"];?>"/> 
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label text-right">Şifre:</label>
							  <div class="col-sm-5"> 
									<input type="text" class="form-control" name="netgsm_password" value="<?=$ayar["netgsm_password"];?>"/> 
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label text-right">SMS Başlık:</label>
							  <div class="col-sm-5"> 
									<input type="text" class="form-control" name="netgsm_baslik" value="<?=$ayar["netgsm_baslik"];?>"/> 
							  </div>
							</div>
						</div>
						<div class="box-footer">						
							<button type="submit" name="netgsm_kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
						</div>
					</form>
					
					<?php 

						// NETGSM SMS AYAR KAYIT

						if (isset($_POST["netgsm_kaydet"])) { 

							$netgsm_username = trim($_POST["netgsm_username"]);
							$netgsm_password = trim($_POST["netgsm_password"]); 
							$netgsm_baslik = trim($_POST["netgsm_baslik"]); 

							$mailayarkaydet = $vt->query("UPDATE ayarlar SET netgsm_username = '$netgsm_username', netgsm_password = '$netgsm_password', netgsm_baslik = '$netgsm_baslik' where id = '1'");
							
							go("index.php?do=ayar/smsayar",0);

						}

					?> 
					
				</div>
			</div>
		</div> 
		<div class="col-md-6">
			<div class="box">
				<div class="box-header with-border">
				  <h4><i class="fa fa-check"></i> SMS Sistemi </h4>					  
				</div>
				<div class="box-body pad" style="">
					<div class="form-horizontal"> 							
						<form class="form-horizontal" method="post" action="" enctype="multipart/form-data"> 
							<label class="control-label">SMS sistemini buradan aktif / pasif yapabilirsiniz.</label>
							<div class="alert alert-warning">							
								<label for="yetki">
									<input type="radio" name="sms_durum" <?php if ($ayar["sms_durum"] == 0) {echo "checked";} ?> value="0" class="minimal">
									<strong>Aktif</strong> (Sms sistemini açarak, üyelere bildirimler gönderilecektir. Sms paketinizin olması gerekir)
								</label>
								<br>
								<label for="yetki">
									<input type="radio" name="sms_durum" <?php if ($ayar["sms_durum"] == 1) {echo "checked";} ?> value="1" class="minimal">
									<strong>Pasif</strong> (Sms sistemini kapatırsanız, üyelere bildirim ve onay mesajları gönderilmeyecektir.)
								</label>
							</div>
							<br>
							<button type="submit" name="sms_durum_kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
						</form>
					
						<?php 

							// NETGSM SMS AYAR KAYIT

							if (isset($_POST["sms_durum_kaydet"])) { 

								$sms_durum = trim($_POST["sms_durum"]); 

								$mailayarkaydet = $vt->query("UPDATE ayarlar SET sms_durum = '$sms_durum' where id = '1'");
								
								go("index.php?do=ayar/smsayar",0);

							}

						?> 
						
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-6 hidden">			
			<div class="box">
				<div class="box-header with-border">
				  <h4><i class="fa fa-check"></i> Vatan SMS Ayarları </h4>					  
				</div>
				<div class="box-body pad" style="">
					<div class="form-horizontal"> 
						
						<form class="form-horizontal" method="post" action="" enctype="multipart/form-data"> 
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>Vatan SMS sisteminin çalışabilmesi için Vatan SMS 'e ait bir kullanıcı hesabı gereklidir. <a target="_blank" style="color:#333; text-decoration:none;" href="https://app.vatansms.com/register"><strong>Vatan SMS Üyelik İçin Tıklayınız.</strong></a> </span>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-3 control-label text-right">Post URL:</label>
							  <div class="col-sm-9"> 
									<input type="text" class="form-control" name="smspost" value="<?=$ayar["smspost"];?>"/> 
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-3 control-label text-right">Kullanıcı No:</label>
							  <div class="col-sm-9"> 
									<input type="text" class="form-control" name="smskadino" value="<?=$ayar["smskadino"];?>"/> 
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-3 control-label text-right">Kullanıcı Adı:</label>
							  <div class="col-sm-9"> 
									<input type="text" class="form-control" name="smskadi" value="<?=$ayar["smskadi"];?>"/> 
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-3 control-label text-right">Şifre:</label>
							  <div class="col-sm-9"> 
									<input type="text" class="form-control" name="smssifre" value="<?=$ayar["smssifre"];?>"/> 
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-3 control-label text-right">SMS Başlık:</label>
							  <div class="col-sm-9"> 
									<input type="text" class="form-control" name="smsbaslik" value="<?=$ayar["smsbaslik"];?>"/> 
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-3 control-label text-right">SMS Numarası:</label>
							  <div class="col-sm-9"> 
									<input type="text" class="form-control" name="smsno" value="<?=$ayar["smsno"];?>"/> 
							  </div>
							</div>   
						</div>
						<div class="box-footer">						
							<button type="submit" name="vatan_sms_kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
						</div>
					</form>
					
					<?php 

						// VATANA SMS AYAR KAYIT

						if (isset($_POST["vatan_sms_kaydet"])) { 

							$smspost = trim($_POST["smspost"]);
							$smskadino = trim($_POST["smskadino"]);
							$smskadi = trim($_POST["smskadi"]);
							$smssifre = trim($_POST["smssifre"]);
							$smsbaslik = trim($_POST["smsbaslik"]);
							$smsno 	= trim($_POST["smsno"]);

							$mailayarkaydet = $vt->query("UPDATE ayarlar SET smspost = '$smspost', smskadino = '$smskadino', smskadi = '$smskadi', smssifre = '$smssifre', smsbaslik = '$smsbaslik', smsno = '$smsno' where id = '1'");
							
							go("index.php?do=ayar/smsayar",0);

						}

					?> 
					
				</div>
			</div>
		</div> 
	</div>	
</section>