<div class="cinema-details">
    <div class="row">
        <div class="col-md-12 mb-xs">
            <div class="breadcrumb">
                <a href="#" class="to-cinemas">Кинотеатры</a>
            </div>
        </div>
    </div>
    <!-- <?= var_dump($this->data['films']) ?> -->
    <div class="cinema">
        <div class="row cinema-info mb-lg">
            <div class="col-md-6">
                <input type="hidden" name="cinema_id" value="<?= $this->data['cinema']->id ?>">
                <h2 class="cinema-name"><?= $this->data['cinema']->cinema_name ?></h2>
                <div class="cinema-address">
                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                    <?= $this->data['cinema']->address ?>
                </div>
                <div class="cinema-phone_number">
                    <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                    <?= $this->data['cinema']->phone_number ?>
                </div>
            </div>
            <div class="col-md-offset-2 col-md-4">
                <div class="ymap" data-lon="<?= $this->data['cinema']->lon ?>" data-lat="<?= $this->data['cinema']->lat ?>">
                    <div class="overlay"></div>
                    <div class="btn btn-default">Посмотреть на карте</div>
                </div>
            </div>
        </div>

        <!-- Расписание -->
        <div class="cinema-shedule">
            <div class="calendar-filter">
                <div class="calendar">
                    <span class="calendar-prefix">Расписание на</span>
                    <span class="calendar-day">сегодня, 5 июня</span>
                </div>
                <input type="text" class="form-control">
            </div>
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
                            <input type="hidden" name="price_to" value="<?= $film->price_to ?>">
                        </div>
                        <div class="movie-info_rating"><?= $film->score ?></div>
                    </div>
                    <div class="movie-formats">
                        <div class="format">2D</div>
                        <div class="sessions">
                            <?php foreach ($film->film_sessions as $key => $session) :?>
                                <div class="session" session-id="<?= $key ?>"><?= substr($session, 0, 5) ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="buy-ticket">
                        <a href="#" class="btn btn-danger" data-toggle="modal">Купить билет</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- TEMPLATE: movie -->
        <div class="movie -template" id="" style="display: none">
            <a class="link-to-movie" href="<?= Config::get('URL') . 'film/details/' ?>">
                <div class="picture" style="background-image: url(https://st.kp.yandex.net/images/film_iphone/iphone360_893681.jpg)">
                </div>
            </a>
            <div class="movie-info">
                <a href="<?= Config::get('URL') . 'film/details/' ?>" class="link-to-movie movie-info_title"></a>
                <div class="movie-info_summary">
                    <span class="genres">Фантастика, боевик</span>
                    <span class="duration">1 час 59 минут</span>
                    <span class="age-limit">18+</span>
                </div>
                <div class="movie-info_rating"></div>
            </div>
            <div class="movie-formats">
                <div class="format">2D</div>
                <div class="sessions">
                </div>
            </div>
            <div class="buy-ticket">
                <a href="#" class="btn btn-danger" data-toggle="modal">Купить билет</a>
            </div>
        </div>

        <!-- TEMPLATE: hall -->
        <div class="modal fade" tabindex="-1" role="dialog" id="hall-modal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Заказ билета</h4>
              </div>
              <div class="modal-body">

                <div class="info-section">
                    <div class="left">
                        <div class="cinema">Кинотеатр: <span>Мир</span></div>
                        <div class="movie">Фильм: <span>Дэдпул</span></div>
                    </div>
                    <div class="right">
                        <div class="date">Дата: <span class="order-date">воскресенье, 12 июня</span></div>
                        <div class="time">Время: <span>23:00</span></div>
                    </div>
                </div>

                <div class="hall">
                    <div class="screen">Экран</div>
                    <!-- hall grid -->
                    <div class="hall-grid" id="cinema-film-modal">
                        <div class="hall-grid__seats">
                        </div>
                    </div>
                </div>

                <div class="pay-section">
                    <div class="cost">Стоимость: <span></span> руб.</div>
                    <a href="#" class="btn btn-primary btn-pay">Оплатить</a>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div>
</div>

<div id="map_container" style="width: 80%;" data-fancybox></div>
