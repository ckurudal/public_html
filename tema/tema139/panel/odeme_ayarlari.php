<?php	
	if ($_SESSION["uyelogin"] == false) {go("index.php?do=hesabim&islem=girisyap",0);}
	$stmt_uye = $vt->prepare("SELECT * FROM yonetici where id = ?");
	$stmt_uye->execute([(int)$_SESSION["id"]]);
	$uye = $stmt_uye->fetch();

?>

<section class="">
	<div class="row"> 
		<div class="col-md-3">
			<div class="card">
				<?php include 'uye-menu.php'; ?>
            </div>
		</div>
		<div class="col-md-9">
			
			<div class="card">
			    <div class="card-header">
			        <h3 class="card-title"><strong>Ödeme Ayarları</strong></h3>
			    </div>
			    <div class="card-body">
			        <div class="card-pay">
			            <ul class="tabs-menu nav">
			                <li class=""><a href="#tab1" class="active" data-toggle="tab"><i class="fa fa-credit-card"></i> Credit Card</a></li>
			                <li><a href="#tab2" data-toggle="tab" class=""><i class="fa fa-paypal"></i> Paypal</a></li>
			                <li><a href="#tab3" data-toggle="tab" class=""><i class="fa fa-university"></i> Bank Transfer</a></li>
			            </ul>
			            <div class="tab-content">
			                <div class="tab-pane active show" id="tab1">
			                    <div class="form-group"> <label class="form-label">CardHolder Name</label> <input type="text" class="form-control" id="name1" placeholder="First Name"> </div>
			                    <div class="form-group"> <label class="form-label">Card number</label>
			                        <div class="input-group"> <input type="text" class="form-control" placeholder="Search for..."> <span class="input-group-append"> <button class="btn btn-info" type="button"><i class="fa fa-cc-visa"></i> &nbsp; <i class="fa fa-cc-amex"></i> &nbsp; <i class="fa fa-cc-mastercard"></i></button> </span>                            </div>
			                    </div>
			                    <div class="row">
			                        <div class="col-sm-8">
			                            <div class="form-group"> <label class="form-label">Expiration</label>
			                                <div class="input-group"> <input type="number" class="form-control" placeholder="MM" name="expire-month"> <input type="number" class="form-control" placeholder="YY" name="expire-year"> </div>
			                            </div>
			                        </div>
			                        <div class="col-sm-4">
			                            <div class="form-group"> <label class="form-label">CVV <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Please Enter last 3 digits"></i></label> <input type="number" class="form-control" required="">                                </div>
			                        </div>
			                    </div> <a href="#" class="btn btn-primary">Submit</a> </div>
			                <div class="tab-pane" id="tab2">
			                    <h6 class="font-weight-semibold">Paypal is easiest way to pay online</h6>
			                    <p><a href="#" class="btn btn-primary"><i class="fa fa-paypal"></i> Log in my Paypal</a></p>
			                    <p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. </p>
			                </div>
			                <div class="tab-pane" id="tab3">
			                    <h6 class="font-weight-semibold">Bank account details</h6>
			                    <dl class="card-text"> <dt>BANK: </dt>
			                        <dd> THE UNION BANK 0456</dd>
			                    </dl>
			                    <dl class="card-text"> <dt>Accaunt number: </dt>
			                        <dd> 67542897653214</dd>
			                    </dl>
			                    <dl class="card-text"> <dt>IBAN: </dt>
			                        <dd>543218769</dd>
			                    </dl>
			                    <p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. </p>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>

		</div> 
	</div>
</section>