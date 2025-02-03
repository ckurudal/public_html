<div class="alert alert-primary">
	<strong> <?=$y["adsoyad"];?> İlanları </strong>
</div>
<div class="box box-body">
	<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
		<table id="example3" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example4_info">
			<thead>
				<tr>
					<th class="text-center" style="width: 3%"><p><strong>ID</strong></p></th>
					<th style="width: 15%"><p><strong>Başlık</strong></p></th>
					<th style="width: 15%"><p><strong>Fiyat</strong></p></th>
					<th style="width: 15%"><p><strong>Durum</strong></p></th>
					<th style="width: 15%"><p><strong>Ekleme Tarihi</strong></p></th>
					<td class="text-center" style="width:8% !important; white-space: nowrap;"> İşlemler </td>
				</tr>
			</thead>
			<tbody>
				<?php

					$uye_ilan = $vt->query("SELECT * FROM emlak_ilan WHERE yonetici_id = '$id'")->fetchAll(PDO::FETCH_OBJ);

					foreach ($uye_ilan as $ilan) {
				?>
				<tr>
					<th class="text-center" <?php if ($ilan->doping == "var") { ?> style="background:#f2dede;" <?php } ?>>
						<?php echo $ilan->id; ?>
					</td>
					<td>
						<?php if ($ilan->doping == "var") { ?> <a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan->id; ?>" class="btn bg-primary btn-block btn-xs"> <strong>DOPİNGLİ İLAN</strong> </a> <br> <?php } ?>
						<?php echo $ilan->baslik; ?>
					</td>
					<td><?php echo $ilan->fiyat; ?> <?php echo $ilan->fiyatkur; ?> </td>
					<td>

						<?php if ($ilan->durum == 0) { ?>
							<span class="btn btn-success btn-xs btn-block">Yayında</span>
						<?php } ?>
						<?php if ($ilan->durum == 1) { ?>
							<span class="btn btn-danger btn-xs btn-block">Yayında Değil</span>
						<?php } ?>
						<?php if ($ilan->onay == 1) { ?>
							<span class="btn btn-info btn-xs btn-block">Onaylı</span>
						<?php } ?>
						<?php if ($ilan->onay == 0) { ?>
							<span class="btn btn-warning btn-xs btn-block">Onay Bekliyor</span>
						<?php } ?>

					</td>
					<td><?php echo $ilan->eklemetarihi; ?></td>
					<td>
						
						<?php if (yetki() == 2 || yetki() == 0): ?>
						
						<a href="index.php?do=islem&emlak=emlak_duzenle&danisman=degistir&id=<?php echo $ilan->id; ?>" class="btn btn-primary btn-xs btn-block"> <i class="fa fa-edit"></i> Danışman Değiştir</a>
						
						<?php endif; ?>
						
						<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan->id; ?>" class="btn btn-block btn-warning btn-xs"> <i class="fa fa-rocket"></i> Doping Yap </a>
						
						<!--
						
						<a href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $ilan->id; ?>" class="btn btn-primary btn-xs btn-block"> <i class="fa fa-edit"></i> Düzenle </a>
						
						-->
						
						<a href="#" data-toggle="modal" data-target="#<?php echo $ilan->id; ?>" title="Sil" class="btn btn-danger btn-xs btn-block"> <i class="fa fa-trash"></i> Sil </a>
						

						<div class="modal modal-default fade" id="<?php echo $ilan->id; ?>" style="display: none;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">×</span></button>
								<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
							  </div>
							  <div class="modal-body">
									<h4 style="display: grid; width: 100%;">"<?php echo $ilan->baslik; ?>" isimli paket silinecektir. İşlemi onaylıyor musunuz?</h4>
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
								<a href="index.php?do=islem&emlak=emlak_ilanlar&sil=<?php echo $ilan->id; ?>&islemno=<?php echo $ilan->emlakno; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
							  </div>
							</div>
						  </div>
						</div>

					</td>
				</tr>


			<?php } ?>
			</tbody>
		</table>
	</div>

</div>