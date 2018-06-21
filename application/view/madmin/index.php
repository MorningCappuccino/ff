<div class="row">

	<div class="col-md-12 mb-xs">
		<h2>Панель управления</h2>
	</div>

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
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>admin/index">Пользователи</a>
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>event/index">Фестивали</a>
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>nomination/index">Номинации</a>
		</ul>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<h3>Отчёты</h3>
		<div class="report-list">
			<a class="list-group-item" href="<?php echo Config::get('URL') ?>madmin/stripeTransactions">Stripe транзакции</a>
		</div>
	</div>
</div>
