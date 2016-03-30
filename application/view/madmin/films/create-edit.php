
<div class="row">
	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="..">Home</a></li>
			<li><a href="<?= Config::get('URL') . 'madmin/films' ?>">Films</a></li>
			<li class="active">Add-or-Edit</li>
		</ol>
		<!-- <?php var_dump($this->data) ?> -->
		<h3><?= $this->data['page']->title ?></h3>
		<?php if ($this->data): ?>
			<form enctype="multipart/form-data" method="post" action="<?= Config::get('URL') . 'film/save' ?>" class="form">
				<div class="form-group">
					<label hidden for="">id</label>
					<input type="hidden" name="film_id" class="form-control" value="<?= $this->data['film']->film_id ?>">
				</div>
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
				<div class="form-group">
					<label for="">Название фильма</label>
					<input type="text" name="film_name" class="form-control" value="<?= $this->data['film']->film_name ?>">
				</div>

				<div class="form-group">
					<label for="">Изображение (желательно 1140x400)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
					<input id="film-img" type="file" name="uploadFile[]">
				</div>

				<div class="form-group">
					<label for="">Описание</label>
					<textarea name="descr" rows="5" class="form-control"><?= $this->data['film']->descr ?></textarea>
				</div>

				<div class="form-group">
					<label for="">Событие</label>
					<select name="event_id" class="form-control">
					<option value="">...</option>
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
					<option value="">Выберите Наминацию</option>
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
	$('#film-img').fileinput({
		// uploadAsync: false,
		// maxFileCount: 1,
		initialPreview: [
    "<img src='<?= Config::get('URL').'uploads/'. $this->data['film']->img_link . '.jpg'?>' class='file-preview-image' alt='Desert' title='Desert'>",
		]
	});
	<?php } else { ?>
		$('#film-img').fileinput();
	<?php } ?>

}
</script>