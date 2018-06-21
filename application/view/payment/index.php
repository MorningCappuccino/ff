<div class="row">
	<div class="col-lg-12">

		<!-- echo out the system feedback (error and success messages) -->
		<?php $this->renderFeedbackMessages(); ?>

		<?php if( $this->data['status'] == 'success') :?>
			<h3>Оплата прошла успешно</h3>
			<p>
				Для просмотра ключа заказа перейдите в личный кабинет.
			</p>
		<?php endif; ?>

		<?php if( $this->data['status'] == 'error') :?>
			<h3>Ошибка оплаты. Свяжить, пожалуйста, со службой поддержки.</h3>
		<?php endif; ?>

<!--		--><?php //var_dump($this->data['status']); ?>

	</div>
</div>
