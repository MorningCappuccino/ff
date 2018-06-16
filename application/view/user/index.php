<div class="user-profile">
    <h2>Профиль</h2>

    <?php $this->renderFeedbackMessages(); ?>

    <!-- <?= var_dump($this) ?> -->

    <div class="row user-info">
        <div class="col-lg-1">
            <div class="profile__image">
                <?php if (Config::get('USE_GRAVATAR')) { ?>
                    <img src='<?= $this->user_gravatar_image_url; ?>' />
                <?php } else { ?>
                    <img src='<?= $this->user_avatar_file; ?>' />
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-5">
            <div>Имя пользователя: <?= $this->user_name; ?></div>
            <div>Электронный адрес: <?= $this->user_email; ?></div>

            <div>Тип аккаунта: <?= $this->user_account_type; ?></div>
        </div>
    </div>

    <div class="row orders">
        <div class="col-lg-12">
            <table class="table table-bordered">
                 <thead>
                     <tr>
                         <th>Номер заказа</th>
                         <th>Фильм</th>
                         <th>Дата</th>
                         <th>Сеанс</th>
                         <th>Место</th>
                         <th>Кинотеатр</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php foreach ($this->orders as $order) :?>
                         <tr>
                             <td><?= $order->order_number ?></td>
                             <td><?= $order->film_name ?></td>
                             <td><?= $order->order_date ?></td>
                             <td><?= $order->film_session ?></td>
                             <td><?= $order->seat_num ?></td>
                             <td><?= $order->cinema_name ?></td>
                         </tr>
                     <?php endforeach;?>
                 </tbody>
            </table>
        </div>
    </div>

</div>
