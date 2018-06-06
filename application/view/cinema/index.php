<div class="row">
    <div class="col-md-12 mb-xs">
        <h2>Кинотеатры</h2>
    </div>
</div>
<?php var_dump($this) ?>
<div class="cinemas mb-lg">
    <?php foreach ($this->cinemas as $cinema) :?>
    <div class="row cinema">
        <div class="col-md-6">
            <a href="<?= Config::get('URL') . 'cinema/details/' . $cinema->id ?>" class="cinema-name"><?= $cinema->cinema_name ?></a>
            <a href="" class="cinema-shedule">Сеансы -></a>
        </div>
        <div class="col-md-6">
            <div class="cinema-address">
                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                <?= $cinema->address ?>
            </div>
            <div class="cinema-phone_number">
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                <?= $cinema->phone_number ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
