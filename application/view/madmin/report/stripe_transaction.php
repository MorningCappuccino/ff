<div class="user-profile">
    <h2>Stripe транзакции</h2>

    <?php $this->renderFeedbackMessages(); ?>

    <!-- <?= var_dump($this) ?> -->

    <div class="row orders">
        <div class="col-lg-12">
            <table class="table table-bordered">
                 <thead>
                     <tr>
                         <th>Пользователь</th>
                         <th>Номер заказа</th>
                         <th>Цена</th>
                         <th>Номер транзакции</th>
                         <th>Фильм</th>
                         <th>Дата</th>
                         <th>Сеанс</th>
                         <th>Место</th>
                         <th>Кинотеатр</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php foreach ($this->transactions as $order) :?>
                         <tr>
                             <td><a href="<?= Config::get('URL') . 'profile/showProfile/'. $order->user_id?>"><?= $order->user_name ?></a></td>
                             <td><?= $order->order_number ?></td>
                             <td><?= $order->price ?></td>
                             <td><a target="_blank" href="https://dashboard.stripe.com/test/payments/<?= $order->stripe_order_id ?>"><?= $order->stripe_order_id ?></a></td>
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
