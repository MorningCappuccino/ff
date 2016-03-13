
		<?php $this->renderFeedbackMessages(); ?>

<h2>Все события</h2>

<?php foreach ($this->events as $event): ?>
<div class='row festival-info'>
	<div class='col-md-4'>
		<a href="<?= Config::get('URL'). 'event/details/' . $event->id ?>"><img src="<?= Config::get('URL') . 'uploads/300x200.png'?>"></a>
	</div>
	<div class="col-md-8">
		<div class="left-info">
			<div class="country">Страна</div>
			<a href="<?= Config::get('URL'). 'event/details/' . $event->id ?>">
				<h2 class="name">
					<?= $event->fest_type_name . ' фестиваль ' . $event->year ?>
				</h2>
			</a>
			<div class="status <?= EventModel::getCSSClassEqualsStatusName($event->event_status) ?>">
				<?= $event->event_status ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach ?>