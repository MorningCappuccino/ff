
<div class="row">
	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="..">Главная</a></li>
			<li><a href="<?= Config::get('URL') . 'madmin/cinemas' ?>">Кинотеатры</a></li>
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
		<?php endif ?>
	</div>
</div>
