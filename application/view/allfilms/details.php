
    <section class="film-detail">
      <div class="row">
        <div class="col-lg-12">
          <div class="film-action-img">
          <?php if ($this->data['film_info']->img_link != '') {?>
              <div class="img-bg" style="background-image: url(<?= Config::get('URL') .'/uploads/'. $this->data['film_info']->img_link .'.jpg'?>)"></div>
          <?php } else {?>
              <div class="img-bg" style="background-image: url(<?= Config::get('URL') .'uploads/'. '1140x400' .'.png'?>)"></div>
            <?php } ?>
            <div class="row">
              <span><?= $this->data['category']->category_name ?></span>
              <h1><?= $this->data['film_info']->film_name ?></h1>
              <input type="hidden" name="film_id" value="<?= $this->data['film_info']->film_id ?>">
            </div>
            <div class="row">
              <a href="#" id="trailer-btn" class="btn btn-default">Трейлер
                <i class="glyphicon glyphicon-play"></i>
              </a>
            </div>
            <div class="row">
            <?php if ($this->data['festival'] != false) {?>
              <div class="member">Участник: <?= $this->data['festival']->fest_type_name . ' фестиваль ' . $this->data['festival']->year ?></div>
            <?php } ?>
            </div>
          <div class="paranja"></div>
          </div>
        </div>
      </div>
      <!-- <?php var_dump($this->data) ?> -->
      <div class="row bad-section">
        <div class="col-md-9">
        	<div class="avg-score">
            <?php if ( is_object($this->data['avg_score']) ) :?>
        		    <span><?= $this->data['avg_score']->avg_score ?></span>
            <?php endif; ?>
        	</div>
          <input id="film-rating">
          <?php if ( is_object($this->data['avg_score']) ):?>
            <span id="count-score">Оценок: <?= $this->data['avg_score']->count_score ?></span>
          <?php endif ?>
        </div>
        <div class="col-md-3">
          <button type="button" class="btn btn-default" role="button" data-toggle="modal" data-target="#myModal">Награды</button>
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
              <img src="<?= Config::get('URL') . 'uploads/TomFord.jpg' ?>">
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
              <img src="<?= Config::get('URL') . 'uploads/ColinFirth.jpg' ?>">
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
              <img src="<?= Config::get('URL') . 'uploads/MetthewGoode.jpg' ?>">
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
    <!-- <?php var_dump($this->data['nominations']) ?> -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Награды</h4>
          </div>
          <div class="modal-body">
            <h2>Номинации:</h2>
              <ul>
                <?php foreach ($this->data['nominations'] as $nomination) : ?>
                  <li><?= $nomination->nomination_name ?></li>
                <?php endforeach ?>
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

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
