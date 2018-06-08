<div class="cinema-details">
    <div class="row">
        <div class="col-md-12 mb-xs">
            <div class="breadcrumb">
                <a href="#" class="to-cinemas">Кинотеатры</a>
            </div>
        </div>
    </div>
    <?= var_dump($this->data['films']) ?>
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
                <div class="movie" id="1">
                    <div class="picture" style="background-image: url(//avatars.mds.yandex.net/get-kino-vod-films-gallery/33804/2a00000162b1bba045cb4c5fe8243f1d76f3/60x)"></div>
                    <div class="movie-info">
                        <a href="#" class="movie-info_title">Дэдпул 2</a>
                        <div class="movie-info_summary">
                            <span class="genres">Фантастика, боевик</span>
                            <span class="duration">1 час 59 минут</span>
                            <span class="age-limit">18+</span>
                        </div>
                        <div class="movie-info_rating">7.7</div>
                    </div>
                    <div class="movie-formats">
                        <div class="format">2D</div>
                        <div class="session">21:20</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
