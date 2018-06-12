
<div class="row">
	<div class="col-md-12 add-edit-wrap">
		<ol class="breadcrumb">
			<li><a href="..">Главная</a></li>
			<li><a href="<?= Config::get('URL') . 'cinema/index' ?>">Кинотеатры</a></li>
			<li class="active">Add-or-Edit</li>
		</ol>
		<!-- <?php var_dump($this->data['films']) ?> -->
		<h3><?= $this->data['page']->title ?></h3>
		<?php if ($this->data): ?>
			<form enctype="multipart/form-data" method="post" action="<?= Config::get('URL') . 'cinema/save' ?>" class="form mb-xs">
				<div class="form-group">
					<label hidden for="">id</label>
					<input type="hidden" name="cinema_id" class="form-control" value="<?= $this->data['cinema']->cinema_id ?>">
				</div>

				<div class="form-group">
					<label for="">Название кинотеатра</label>
					<input type="text" name="cinema_name" class="form-control" required value="<?= $this->data['cinema']->cinema_name ?>">
				</div>

				<div class="form-group">
					<label for="">Адрес</label>
					<input name="address" class="form-control" value="<?= $this->data['cinema']->address ?>">
				</div>

				<div class="form-group">
					<label for="">Телефон</label>
					<input name="phone_number" class="form-control" value="<?= $this->data['cinema']->phone_number ?>">
				</div>

				<button type="submit" class="btn btn-default">Сохранить</button>
			</form>

			<div class="film-showing-in-cinema">
				<!-- <?php var_dump($this->data['films']) ?> -->
				<?php foreach ($this->data['films'] as $film): ?>
					<!-- Закрепленный флильм -->
					<div class="fresh-movie" id="movie-<?= $film->film_id ?>">
					    <div class="well green">
							<form action="" onsubmit="btnEditFilm(this); return false;" film-id="<?= $film->film_id ?>">
	                            <!-- Выбор фильма-->
	                            <div class="row mb-lg">
	                                <div class="col-lg-12">
	                                    <a href="<?= Config::get('URL') . 'film/details/' . $film->film_id ?>">
	                                        <h2 class="text-center"><?= $film->film_name ?></h2>
	                                    </a>
	                                </div>
	                            </div>

	                            <div class="row">
	                                <!-- Время в прокате -->
	                                <div class="col-lg-6">
	                                    <div class="form-group text-center">
	                                        <label for="">Время в прокате</label>
	                                        <div class="from-to-inputs">
	                                            <div class="wrap-input from-input">
	                                                <span>С</span>
	                                                <input required type="date" name="date_from" value="<?= $film->begin_date ?>" class="form-control">
	                                            </div>
	                                            <div class="wrap-input to-input">
	                                                <span>До</span>
	                                                <input required type="date" name="date_to" value="<?= $film->finish_date ?>" class="form-control">
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <!-- Цена билетов -->
	                                <div class="col-lg-6">
	                                    <div class="form-group text-center">
	                                        <label for="">Цена билетов</label>
	                                        <div class="from-to-inputs">
	                                            <div class="wrap-input from-input">
	                                                <span>От</span>
	                                                <input required type="number" step="0.01" name="cost_from" value="<?= $film->price_from ?>" class="form-control">
	                                            </div>
	                                            <div class="wrap-input to-input">
	                                                <span>До</span>
	                                                <input required type="number" step="0.01" name="cost_to" value="<?= $film->price_to ?>" class="form-control">
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>

	                            <!-- Ceaнсы -->
	                            <div class="row fresh-movie__session mb-lg">
	                                <h3 class="text-center">Сеансы</h3>
	                                <div class="col-lg-6 fresh-movie__session-add_block">
	                                    <a class="btn btn-default btn-add-session">Добавить</a>
	                                    <input type="text" class="form-control" value="">
	                                </div>
	                                <div class="col-lg-6">
	                                    <div class="session-pool">
	                                        <?php foreach ($film->film_sessions as $key => $session) :?>
	                                            <div class="s-item" session-id="<?= $key ?>"><?= substr($session, 0, 5) ?></div>
	                                        <?php endforeach; ?>
	                                    </div>
	                                </div>
	                            </div>

	                            <!-- Редактировать фильм -->
	                            <div class="row">
	                                <div class="col-lg-offset-4 col-lg-4 text-center">
	                                    <button class="btn btn-warning btn-edit-film" film-id="<?= $film->film_id ?>">Редактировать</button>
	                                </div>
									<div class="col-lg-4 text-right">
										<div class="btn-delete-wrap">
											<div class="btn btn-default btn-choice btn-del-film-yes" film-id="<?= $film->film_id ?>">Да</div>
											<div class="btn btn-default btn-choice btn-del-film-no">Нет</div>
											<a class="btn btn-danger btn-del-film">Удалить</a>
										</div>
	                                </div>
	                            </div>
							</form>
                        </div>
					</div>
				<?php endforeach ?>

			</div>

				<!-- Добавление нового фильма -->
				<div style="display: none" class="fresh-movie template" id="movie-123">
					<div class="well">
						<form action="" method="post" onsubmit="btnAddFilm(this); return false;">
							<!-- Выбор фильма-->
							<div class="row mb-lg">
								<div class="col-lg-12">
									<select name="film_id" class="form-control" required>
										<option value="">Выберите фильм</option>
									</select>
								</div>
							</div>

							<div class="row">
								<!-- Время в прокате -->
								<div class="col-lg-6">
									<div class="form-group text-center">
										<label for="">Время в прокате</label>
										<div class="from-to-inputs">
											<div class="wrap-input from-input">
												<span>С</span>
												<input required type="date" name="date_from" value="0" class="form-control">
											</div>
											<div class="wrap-input to-input">
												<span>До</span>
												<input required type="date" name="date_to" value="0" class="form-control">
											</div>
										</div>
									</div>
								</div>

								<!-- Цена билетов -->
								<div class="col-lg-6">
									<div class="form-group text-center">
										<label for="">Цена билетов</label>
										<div class="from-to-inputs">
											<div class="wrap-input from-input">
												<span>От</span>
												<input required type="number" step="0.01" name="cost_from" value="" class="form-control">
											</div>
											<div class="wrap-input to-input">
												<span>До</span>
												<input required type="number" step="0.01" name="cost_to" value="" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Ceaнсы -->
							<div class="row fresh-movie__session mb-lg">
								<h3 class="text-center">Сеансы</h3>
								<div class="col-lg-6 fresh-movie__session-add_block">
									<a class="btn btn-default btn-add-session">Добавить</a>
									<input type="text" class="form-control" value="">
								</div>
								<div class="col-lg-6">
									<div class="session-pool">
									</div>
								</div>
							</div>

							<!-- Cохранить фильм -->
							<div class="row">
								<div class="col-lg-offset-4 col-lg-4 text-center">
									<button class="btn btn-success btn-add-film">Сохранить</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="form-group">
					<button type="button" name="button" class="btn btn-primary btn-prepare-to-add-film">Добавить фильм</button>
				</div>

		<?php endif ?>
	</div>
</div>
