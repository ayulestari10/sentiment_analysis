<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark size-middle fixed-top">
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
	<div class="container box">
		<?php if(isset($pendapat) && isset($hasil) && isset($nilai_positif) && isset($nilai_negatif)): ?>
		<div class="container" style="padding-top: 1%">
			<center>
				<h5 style="margin-bottom: 2%"><strong>Hasil Analisis</strong></h5>
				<p>
					Pendapat anda adalah <?= $pendapat ?> . <br>Hasil Analisis dengan metode Naive Bayes maka pendapat anda bernilai <strong><?= $hasil ?></strong>. <br> <br>
					<strong>Positif : <?= $nilai_positif ?></strong><br>
					<strong>Negatif : <?= $nilai_negatif ?></strong>
				</p>
			</center>
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
	</div>
</section>



<section id="about">
	<div class="container">
		<center>
			<img src="<?=base_url('assets/img/logo/asof.png')?>">
			<p class="pcolor">Website for survey on the world of informatics majors,</p>
			<p class="pcolor">analyzing student opinions whether negative or positive</p>
			<p class="pcolor">about college majors informatics</p>
			<br>
			<p class="ptext">People use text to communicate their emotion and opinion about some subjects. Currently government online media provides the facility for the citizen to express their opinions through text. E-governance system that built by the government will function better if the data that contains citizen's opinion not only saved but can be managed to be more valuable information.</p>
			<p class="ptext">Opinion Mining and Sentiment Analysis is the science of natural language processing that could identify emotions, sentiments and main ideas expressed in the text. The government can take advantage by embedding the opinion mining and sentiment analysis methods in the e-governance system.</p>	
			<p class="ptext">Citizen's opinion about the services or policies of the government is an information that required by the Government in running the good government system. In this study, will be discussed some methods of opinion mining and sentiment analysis that have been performed by some previous researchs.</p>
			
		</center>
	</div>
</section>