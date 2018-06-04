
<div class="row">
	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="..">Главная</a></li>
			<li><a href="<?= Config::get('URL') . 'cinema/index' ?>">Кинотеатры</a></li>
			<li class="active">Add-or-Edit</li>
		</ol>
		<!-- <?php var_dump($this->data) ?> -->
		<h3><?= $this->data['page']->title ?></h3>
		<?php if ($this->data): ?>
			<form enctype="multipart/form-data" method="post" action="<?= Config::get('URL') . 'cinema/save' ?>" class="form">
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

				<?php var_dump($this->data['films']) ?>
				<?php foreach ($this->data['films'] as $film): ?>
					<!-- Закрепленный флильм -->
					<div class="fresh-movie" id="movie-<?= $film->id ?>">
					    <div class="well green">
                            <!-- Выбор фильма-->
                            <div class="row mb-lg">
                                <div class="col-lg-12">
                                    <a href="<?= Config::get('URL') . 'film/details/' . $film->id ?>">
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
                                                <input required type="number" name="cost_from" value="<?= $film->price_from ?>" class="form-control">
                                            </div>
                                            <div class="wrap-input to-input">
                                                <span>До</span>
                                                <input required type="number" name="cost_to" value="<?= $film->price_to ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ceaнсы -->
                            <div class="row fresh-movie__session mb-lg">
                                <h3 class="text-center">Сеансы</h3>
                                <div class="col-lg-6 fresh-movie__session-add_block">
                                    <button class="btn btn-default btn-add-session">Добавить</button>
                                    <input type="text" class="form-control" value="">
                                </div>
                                <div class="col-lg-6">
                                    <div class="session-pool">
                                        <?php foreach ($film->film_sessions as $session) :?>
                                            <div class="s-item"><?= substr($session, 0, 5) ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Редактировать фильм -->
                            <div class="row">
                                <div class="col-lg-offset-4 col-lg-4 text-center">
                                    <button class="btn btn-warning btn-edit-film" film-id="<?= $film->id ?>">Редактировать</button>
                                </div>
                            </div>
                        </div>
					</div>
				<?php endforeach ?>


				<!-- Добавление нового фильма -->
				<div class="fresh-movie new" id="movie-123">
					<div class="well">
						<!-- Выбор фильма-->
						<div class="row mb-lg">
							<div class="col-lg-12">
								<select name="category_id" class="form-control" required>
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
											<input required type="number" name="cost_from" value="0" class="form-control">
										</div>
										<div class="wrap-input to-input">
											<span>До</span>
											<input required type="number" name="cost_to" value="0" class="form-control">
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Ceaнсы -->
						<div class="row fresh-movie__session mb-lg">
							<h3 class="text-center">Сеансы</h3>
							<div class="col-lg-6 fresh-movie__session-add_block">
								<button class="btn btn-default">Добавить</button>
								<input type="text" class="form-control" value="">
							</div>
							<div class="col-lg-6">
								<div class="session-pool">
									<div class="s-item">19:35</div>
									<div class="s-item">15:40</div>
								</div>
							</div>
						</div>

						<!-- Cохранить фильм -->
						<div class="row">
							<div class="col-lg-offset-4 col-lg-4 text-center">
								<button class="btn btn-success btn-add-film">Сохранить</button>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<button type="button" name="button" class="btn btn-primary btn-prepare-to-add-film">Добавить фильм</button>
				</div>

		<?php endif ?>
	</div>
</div>
