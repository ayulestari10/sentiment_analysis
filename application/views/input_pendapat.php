	<div class="row" style="text-align: center; padding: 15%;">
		<h3 style="margin-bottom: 2%;">Masukkan Pendapat Anda</h3>
		<div>
			<?php if(isset($msg)) {
				echo $msg;	
			}
			?>
		</div>
		<?= form_open('Proses/analysis') ?>
			<div class="form-group">
				<textarea class="form-control" name="text_input"></textarea>
				<button type="submit" name="submit-input" class="btn btn-success" value="Submit" style="margin-top: 2%;"><i class="fa fa-check"> Submit</i></button>
			</div>
		<?= form_close() ?>
	</div>
	
	
	<div class="row">
		<?php if(isset($casefolding)): ?>
		<div class="col-md-4">
			<table class="table table-striped">
				<tr><th>Case Folding</th></tr>
				<tr><td><p><?= $casefolding  ?></p></td></tr>
			</table>
		</div>
		<?php endif; ?>

		<?php if(isset($sentence_splitter)): ?>
		<div class="col-md-4">
			<table class="table table-striped">
				<th>Sentence Splitter</th>
				<?php foreach($sentence_splitter as $sentence):  ?>
					<tr>
						<td><p><?= $sentence ?></p></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>

		<?php if(isset($stemming)): ?>
		<div class="col-md-4">
			<table class="table table-striped">
				<th>Stemming</th>
				<?php foreach($stemming as $kata): ?>
					<tr>
						<td><p><?= $kata ?></p></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
	</div>

	<div class="row">
		<?php if(isset($tokenizing)): ?>
		<div class="col-md-4">
			<table class="table table-striped">
				<th>Tokenizing</th>
				<?php for($i=0; $i<count($tokenizing); $i++):  ?>
					<?php for($j=0; $j<count($tokenizing[$i]); $j++):  ?>
						<tr>
							<td><?= $tokenizing[$i][$j] ?></td>
						</tr>
					<?php endfor; ?>	
				<?php endfor; ?>
			</table>
		</div>
		<?php endif; ?>

		<?php if(isset($stopwords_removal)): ?>
		<div class="col-md-4">
			<table class="table table-striped">
				<th>Stopwords Removal</th>
				<?php foreach($stopwords_removal as $kata): ?>
					<tr>
						<td><?= implode(' ', $kata) ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
	</div>
