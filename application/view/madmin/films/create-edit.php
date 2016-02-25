
<div class="row">
	<div class="col-md-12 wrap">
	<?php var_dump($this->film) ?>
	<?php if ($this->film): ?>
		<form method="post" action="<?= Config::get('URL') . 'film/save' ?>" class="form">
			<div class="form-group">
				<label for="">Название фильма</label>
				<input type="text" name="film_name" class="form-control" value="<?php $this->film->film_name ?>">
			</div>
				<button type="submit" class="btn btn-default">Сохранить</button>
		</form>
	<?php endif ?>
	</div>
</div>