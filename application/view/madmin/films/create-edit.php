
<div class="row">
	<div class="col-md-12 wrap">
	<?php var_dump($this->data) ?>
	<?php if ($this->data): ?>
		<form method="post" action="<?= Config::get('URL') . 'film/save' ?>" class="form">
			<div class="form-group">
				<label hidden for="">id</label>
				<input type="hidden" name="film_id" class="form-control" value="<?= $this->data['film']->film_id ?>">
			</div>
			<div class="form-group">
				<label for="">Категория</label>
				<select class="form-control">
				<?php foreach ($this->data['categories'] as $category): ?>
					<option value="<?= $category->id ?>"><?= $category->cat_name ?></option>
				<?php endforeach ?>
				</select>
				<!-- <input type="text" name="cat_id" class="form-control" value="<?= $this->film->film_name ?>"> -->
			</div>
			<div class="form-group">
				<label for="">Название фильма</label>
				<input type="text" name="film_name" class="form-control" value="<?= $this->data['film']->film_name ?>">
			</div>
				<button type="submit" class="btn btn-default">Сохранить</button>
		</form>
	<?php endif ?>
	</div>
</div>