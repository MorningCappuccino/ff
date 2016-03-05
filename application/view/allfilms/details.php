
<div class="row">
	<div class="col-md-12">
		<div class="action-img">
			<img id="film-img" src="http://placehold.it/740x300">
			<input id="film-rating" class="rating rating-loading" type="number" data-size="xs">
			<h4><?= $this->data['film_info']->film_name  ?></h4>
		</div>
		<label>Номинации:</label>
		<ul>
			<?php foreach ($this->data['nominations'] as $nomination): ?>
				<li><?= $nomination->nomination_name ?></li>
			<?php endforeach ?>
		</ul>
		<div class="response"></div>
	</div>
</div>
<script>
	// $('#film-rating').rating('update', <?= $this->data['user']->film_score ?>); //Why don't work?
	setTimeout(initRating, 1000);

	function initRating(){
		var userFilmScore = <?= $this->data['user']->film_score ?>;
		if (userFilmScore != 0){
			$('#film-rating').rating('update', userFilmScore);
			//disable rating input
			$('#film-rating').rating('refresh', {readonly: true});

		}

	}

</script>