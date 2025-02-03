
<div class="alert alert-warning">
	<strong> Danışmanlar </strong>
</div>
<div class="box">
	<div class="box-body">
		<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-boots trap table-responsive">
			<table id="example5" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example6_info" style="width: 100% !important;">
				<thead>
					<tr>
						<td style="width:1%;"> Adı Soyadı </td>
						<td style="width:1%;"> E-Posta </td>
						<td style="width:1%;"> Telefon </td>
						<td style="width:1%;"> Adres </td>
						<td class="text-center" style="width:1% !important; white-space: nowrap;"> İşlemler </td>
					</tr>
				</thead>
				<tbody>
				<?php

					$magazalar=$vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$id."'")->fetchAll();
					foreach ($magazalar as $magaza) {

						$danisman=$vt->query("SELECT * FROM yonetici WHERE ofis = '".$magaza["id"]."' AND id != {$id}")->fetchAll();

						foreach ($danisman as $dan) {


				?>
					<tr>
						<th><?php echo $dan["adsoyad"]; ?></th>
						<th><?php echo $dan["email"]; ?></th>
						<th>
						<?php if (!empty($dan["tel"])) { ?>
							<strong>Telefon: </strong><?php echo $dan["tel"]; ?>
							<br>
						<?php } ?>
						<?php if (!empty($dan["gsm"])) { ?>
							<strong>GSM: </strong><?php echo $dan["gsm"]; ?>
						<?php } ?>
						</th>
						<th><?php echo $dan["adres"]; ?></th>
						<th>

							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $dan["id"]; ?>&yetki=<?php echo $dan["yetki"]; ?>" class="btn btn-primary btn-xs btn-block"> <i class="fa fa-edit"></i> Düzenle </a>
							<a href="index.php?do=islem&ofis=yonetici&islem=liste&sifre=sifre&id=<?=$dan['id']?>&yetki=<?=$dan["yetki"];?>" title="Şifre Değiştir" class="btn btn-warning btn-block btn-xs">
								<i class="fa fa-key"></i> Şifre Değiştir
							</a>
							<?php if ($_SESSION["id"] != $dan["id"]): ?>
                                <a href="#" data-toggle="modal" data-target="#<?php echo $dan["id"]; ?>" title="Sil" class="btn btn-danger btn-xs btn-block"> <i class="fa fa-trash"></i> Sil </a>
                            <?php endif; ?>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $dan["id"]; ?>&tab_goster=ilanlari" class="btn btn-warning btn-xs btn-block"> <i class="fa fa-check"></i> <strong>Tüm İlanları</strong> </a>

							<div class="modal modal-default fade" id="<?php echo $dan["id"]; ?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
										<h4 style="display: grid; width: 100%;">"<?php echo $dan["adsoyad"]; ?>" isimli danışman silinecektir. İşlemi onaylıyor musunuz?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&ofis=yonetici&islem=liste&hareket=sil&id=<?php echo $dan["id"]; ?>&yetki=<?php echo $dan["yetki"]; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
								  </div>
								</div>
							  </div>
							</div>

						</th>
					</tr>
					<?php } ?>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
