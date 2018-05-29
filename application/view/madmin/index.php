<div class="row">
	<h2>Welcome to the festival's admin:)</h2>

	<?php $this->renderFeedbackMessages(); ?>

	<div class="col-md-6">
		<ul class="list-group">
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>cinema/index">Кинотеатры</a>
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>madmin/films">Фильмы</a>
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>madmin/category">Жанры</a>
		</ul>
	</div>

	<div class="col-md-6">
		<ul class="list-group">
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>event/index">Фестивали</a>
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>nomination/index">Номинации</a>
		</ul>
	</div>
</div>
