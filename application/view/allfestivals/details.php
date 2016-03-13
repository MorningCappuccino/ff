<section class="festival-detail">
	<div class="row">
		<div class="col-lg-12">
			<div class="fest-action-img">
				<img src="<?= Config::get('URL') .'uploads/'. $this->event->img_link . '.jpg' ?>" alt="">
				<!-- <div class="col-sm-12 img-wrapper"> -->
					<div class="row">
						<h1><?= $this->event->fest_type_name . ' фестиваль ' . $this->event->year ?></h1>
					</div>
					<!-- <div class="row" style="height: 350px"></div> -->
					<div class="row">
						<div class="time-line">Время проведения: <span class="">
							<?= $this->event->begin_date .' - '. $this->event->finish_date?></span>
						</div>
					<!-- </div> -->
				</div>
				<div class="paranja"></div>
			</div>
		</div>
	</div>
<!-- 	<div class="row">
		<div class="col-lg-12">
		</div>
	</div>
-->	<div class="row">
<div class="col-md-5 pull-right">
	<div class="status pull-right">Статус:<span class="<?= EventModel::getCSSClassEqualsStatusName($this->event->event_status	) ?>">
		<?= $this->event->event_status ?></span></div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<h2>О фестивале:</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto porro laborum tempora magni perspiciatis saepe vel, ratione aut minus temporibus. Enim ducimus quisquam ratione deserunt facilis quibusdam nemo, qui esse repellendus illum numquam necessitatibus praesentium, minima fugit doloremque, provident ut? Id a blanditiis voluptates, ipsa officia illo ea sapiente voluptatem delectus iusto harum nisi repudiandae accusamus consectetur obcaecati distinctio nobis, cum fugit quo, possimus, enim. Assumenda beatae, excepturi vel, aperiam impedit inventore ex sint iure iusto aliquid, eum earum modi.</p>
		<h3>Программа фестиваля:</h3>
		<ul>
			<li>
				<h4>Главный конкурс</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis tempora, omnis eos dolorem illo! Et illo, eveniet numquam odio. Cumque nam a sit, vitae accusamus.</p>
			</li>
			<li>
				<h4>Короткометражные</h4>
				<p>Voluptates fugit temporibus numquam atque similique provident quibusdam dolor eos praesentium dolore explicabo, vel excepturi autem quo neque consequuntur, veritatis laudantium fuga sed ex recusandae!</p>
			</li>
			<li>
				<h4>Документальные</h4>
				<p>Odit a iste voluptas porro soluta voluptate nulla iusto quo, odio necessitatibus nemo laudantium earum! Nulla quos, impedit harum commodi, saepe soluta suscipit rem at!</p>
			</li></ul>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-4 col-sm-6 col-sm-offset-6 some-btns">
			<button class="btn btn-default">Участники</button>
			<?php if ($this->event->event_status != 'Мотор') {?>
			<button class="btn btn-default disabled">Победители</button>
			<button class="btn btn-default">Подать заявку</button>
			<?php } ?>
		</div>
	</div>
</section>