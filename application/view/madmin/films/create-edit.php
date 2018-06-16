
<div class="row">
	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="..">Главная</a></li>
			<li><a href="<?= Config::get('URL') . 'madmin/films' ?>">Фильмы</a></li>
			<li class="active">Добавление\Редактирование</li>
		</ol>
		<?php var_dump($this->data['age_limits']) ?>
		<h3><?= $this->data['page']->title ?></h3>
		<?php if ($this->data): ?>
			<form enctype="multipart/form-data" method="post" action="<?= Config::get('URL') . 'film/save' ?>" class="form">
				<!-- hidden id -->
				<div class="form-group">
					<label hidden for="">id</label>
					<input type="hidden" name="film_id" class="form-control" value="<?= $this->data['film']->film_id ?>">
				</div>

				<!-- film name -->
				<div class="form-group">
					<label for="">Название фильма</label>
					<input type="text" name="film_name" class="form-control" value="<?= $this->data['film']->film_name ?>">
				</div>

				<!-- description -->
				<div class="form-group">
					<label for="">Описание</label>
					<textarea name="descr" rows="5" class="form-control"><?= $this->data['film']->descr ?></textarea>
				</div>

				<!-- main img -->
				<div class="form-group">
					<label for="">Изображение (желательно 1140x400)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
					<input id="film-img" type="file" name="uploadFile[]">
				</div>

				<!-- main img -->
				<div class="form-group">
					<label for="">Изображение для афиши</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
					<input id="teaser-img" type="file" name="teaser_img[]">
				</div>

				<!-- category -->
				<div class="form-group">
					<label for="">Категория</label>
					<select name="category_id" class="form-control" required>
					<option value="">Выберите категорию</option>
						<?php foreach ($this->data['categories'] as $category): ?>
							<option value="<?= $category->id ?>"
									<?php if ($category->id == $this->data['film']->category_id) echo 'selected' ?>
							><?= $category->category_name ?></option>
						<?php endforeach ?>
					</select>
				</div>

				<!-- age_limit -->
				<div class="form-group">
					<label for="">Возраст</label>
					<select name="age_limit_id" class="form-control" required>
					<option value="">Выберите возрастное ограничение</option>
						<?php foreach ($this->data['age_limits'] as $age_limit): ?>
							<option value="<?= $age_limit->id ?>"
									<?php if ($age_limit->id == $this->data['film']->age_limit_id) echo 'selected' ?>
							><?= $age_limit->age_limit ?></option>
						<?php endforeach ?>
					</select>
				</div>

				<!-- duration -->
				<div class="form-group">
					<label for="">Продолжительность фильма</label>
					<input name="duration" class="form-control" value="<?= $this->data['film']->duration ?>">
				</div>

				<!-- link on trailer -->
				<div class="form-group">
					<label for="">Ссылка на трейлер</label>
					<input name="link_on_trailer" class="form-control" value="<?= $this->data['film']->link_on_trailer ?>">
				</div>

				<div class="form-group">
					<label for="">Событие</label>
					<select name="event_id" class="form-control">
					<option value="0">Выберите Событие</option>
						<?php foreach ($this->data['events'] as $event): ?>
							<option value="<?= $event->id ?>"
									<?php if ($event->id == $this->data['film']->event_id) echo 'selected' ?>
							><?= $event->fest_type_name .' '. $event->year?></option>
						<?php endforeach ?>
					</select>
				</div>

				<div class="form-group">
					<label for="">Номинация</label>
					<select name="nomination_id" class="form-control">
					<option value="0">Выберите Наминацию</option>
						<?php foreach ($this->data['nominations'] as $nomination): ?>
							<option value="<?= $nomination->nomination_id ?>"
							><?= $nomination->nomination_name ?></option>
						<?php endforeach ?>
					</select>
				</div>


				<button type="submit" class="btn btn-default">Сохранить</button>
			</form>
		<?php endif ?>
	</div>
</div>

<script>
// setTimeout(init, 1000);
init();

function init(){

	<?php if ($this->data['film']->film_id != null) {?>
		//main image
		$('#film-img').fileinput({
			// uploadAsync: false,
			// maxFileCount: 1,
			initialPreview: [
	    		"<img src='<?= Config::get('URL').'/uploads/'. $this->data['film']->img_link . '.jpg'?>' class='file-preview-image' alt='.<?= $this->data['film']->film_name ?>.'>",
			]
		});

		//teaser image
		$('#teaser-img').fileinput({
			// uploadAsync: false,
			// maxFileCount: 1,
			initialPreview: [
				"<img src='<?= Config::get('URL').'/uploads/'. $this->data['film']->teaser_img_link . '.jpg'?>' class='file-preview-image' alt='.<?= $this->data['film']->film_name ?>.'>",
			]
		});
	<?php } else { ?>
		$('#film-img').fileinput();
	<?php } ?>

}
</script>
