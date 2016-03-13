
    <section class="film-detail">
      <div class="row">
        <div class="col-lg-12">
          <div class="film-action-img">
          <?php if ($this->data['film_info']->img_link != '') {?>
            <img id="main" src="<?= Config::get('URL') .'uploads/'. $this->data['film_info']->img_link .'.jpg'?>" alt="">
          <?php } else {?>
            <img id="main" src="<?= Config::get('URL') .'uploads/'. '1140x400' .'.png'?>" alt="">
					<?php } ?>
            <div class="row">
              <span><?= $this->data['film_info']->category_id ?></span>
              <h1><?= $this->data['film_info']->film_name ?></h1>
            </div>
            <div class="row">
              <a href="#" id="trailer-btn" class="btn btn-default">Трейлер
                <i class="glyphicon glyphicon-play"></i>
              </a>
            </div>
            <div class="row">
              <div class="member">Участник: Каннский фестиваль 2015</div>
            </div>
          <div class="paranja"></div>
          </div>
        </div>
      </div>
      <div class="row bad-section">
        <div class="col-md-9">
        	<div class="avg-score">
        		<span><?= $this->data['avg_score']->avg_score ?></span>
        	</div>
          <input id="film-rating">
          <span id="count-score">Оценок: <?= $this->data['avg_score']->count_score ?></span>
        </div>
        <div class="col-md-3">
          <button type="button" class="btn btn-default" role="button">Награды</button>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-9">
          <h2>О фильме:</h2>
            <p><?= $this->data['film_info']->descr ?></p>
          </div>
          <div class="col-lg-3">
          <div class="directors">
            <h3>Режиссёр</h3>
            <div class="person-info">
            <a class="person-photo">
              <img src="http://placehold.it/60x80">
            </a>
              <div class="person-name">
                <a href="#">Том форд</a>
              </div>
              <div class="person-other">
                <p>«Queenie Eye», «Образцовый самец» и еще 10 фильмов</p>
              </div>
            </div>
            </div>
            <div class="clearfix"></div>
          <div class="actors">
            <h3>В ролях</h3>
            <div class="person-info">
            <a class="person-photo">
              <img src="http://placehold.it/60x80">
            </a>
              <div class="person-name">
                <a href="#">Колин Фёрт</a>
              </div>
              <div class="person-other">
                <p>«Гордость и предубеждение», «Таинственный сад» и еще 93 фильма</p>
              </div>
            </div>
            <div class="person-info">
            <a class="person-photo">
              <img src="http://placehold.it/60x80">
            </a>
              <div class="person-name">
                <a href="#">Меттью Гуд</a>
              </div>
              <div class="person-other">
                <p>«Аббатство Даунтон», «Правильная жена» и еще 31 фильм</p>
              </div>
            </div>
          </div>

        </div>
    </section>

<script>
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