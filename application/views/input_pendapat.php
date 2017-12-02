<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark size-middle fixed-bottom">
    <div class="container">
        <a class="navbar-brand" href="#">DAZZLE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#home">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Proses/training') ?>">Training</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Logout') ?>">Logout</a>
            </li>
          </ul>
        </div>
    </div>
</nav>
<section id="home">
	<div class="container-fluid">
		<center>
			<img style="margin-top: 10%" src="<?=base_url('assets/img/logo/asof-white.png')?>">
		</center>
	</div>
	<div class="container transparant padding-16 color" style="text-align: center; padding: 5%;">
		<h5 style="margin-bottom: 2%;">Masukkan Pendapat Anda</h5>
		<div>
			<?php if(isset($msg)) {
				echo $msg;	
			}
			?>
		</div>
		<?= form_open('Proses/testing') ?>
			<div class="form-group">
				<textarea class="form-control text" name="pendapat"></textarea>
				<button type="submit" name="submit-input" class="btn button-color" value="Submit" style="margin-top: 2%; width: 100px">Analisis</button>
			</div>
		<?= form_close() ?>
	</div>
</section>

<section id="result" class="container" style="background-color: white">
	<?php if(isset($pendapat) && isset($hasil) && isset($nilai_positif) && isset($nilai_negatif)): ?>
	<div class="row" style="text-align: center;">
		<p>
			Pendapat anda adalah <?= $pendapat ?> . <br>Hasil Analisis dengan metode Naive Bayes maka pendapat anda bernilai <strong><?= $hasil ?></strong>. <br> <br>
			<strong>Positif : <?= $nilai_positif ?></strong><br>
			<strong>Negatif : <?= $nilai_negatif ?></strong>
		</p>
	</div>
	<?php endif; ?>
	
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
</section>

<section id="about">
	<div class="container-fluid">
		<center>
			<img src="<?=base_url('assets/img/logo/asof.png')?>">
			<p>Website for survey on the world of informatics majors,</p>
			<p>analyzing student opinions whether negative or positive</p>
			<p>about college majors informatics</p>
			<p></p>
		</center>
	</div>
</section>