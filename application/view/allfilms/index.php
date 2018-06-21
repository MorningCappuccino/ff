<div class='row'>
	<div class='col-md-12 film-list wrap'>
		<h2>Все фильмы</h2>

		<?php $this->renderFeedbackMessages(); ?>

<!-- <?php var_dump($this->data['films']) ?> -->
		<div class="cinema-shedule">
			<div class="movies">
				<?php foreach ($this->data['films'] as $film) :?>
				<div class="movie" id="<?= $film->film_id ?>">
					<a href="<?= Config::get('URL') . 'film/details/' . $film->film_id ?>">
						<div class="picture" style="background-image: url(<?= Config::get('URL') .'/uploads/'. $film->teaser_img_link .'.jpg'?>)">
						</div>
					</a>
					<div class="movie-info">
						<a href="<?= Config::get('URL') . 'film/details/' . $film->film_id ?>" class="movie-info_title"><?= $film->film_name ?></a>
						<div class="movie-info_summary">
							<span class="genres"><?= $film->cat_name ?></span>
							<span class="duration"><?= $film->duration_mod ?></span>
							<span class="age-limit"><?= $film->age_limit ?></span>
						</div>
						<div class="movie-info_rating"><?= $film->score ?></div>
					</div>
					<div class="movie-formats">
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
