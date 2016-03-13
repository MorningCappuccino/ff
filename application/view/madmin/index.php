<div class="row">
	<div class="col-md-12">
		<h2>Welcome to the festival's admin:)</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<div class="col-md-6">
			<ul class="list-group">
				<li><a class="list-group-item" href="<?php echo Config::get('URL') ?>madmin/category">Category</a></li>
				<li><a class="list-group-item" href="<?php echo Config::get('URL') ?>madmin/films">Films</a></li>
			</ul>
		</div>

		<div class="col-md-6">
			<ul class="list-group">
				<a class="list-group-item" href="<?php echo Config::get('URL') ?>nomination/index">Nominations</a>
				<a class="list-group-item" href="<?php echo Config::get('URL') ?>event/index">Events</a>
			</ul>
		</div>

		
	</div>
</div>
