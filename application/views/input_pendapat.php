	<div class="row" style="text-align: center; padding: 15%;">
		<h3 style="margin-bottom: 2%;">Masukkan Pendapat Anda</h3>
		<div>
			<?php if(isset($msg)) {
				echo $msg;	
			}
			?>
		</div>
		<?= form_open('Proses/analysis') ?>
			<div class="box transparant">
				<div class="form-group">
					<textarea class="form-control" name="text_input"></textarea>
					<button type="submit" name="submit-input" class="btn btn-success" value="Submit" style="margin-top: 2%;"><i class="fa fa-check"> Submit</i></button>
				</div>
			</div>
		<?= form_close() ?>
	</div>
