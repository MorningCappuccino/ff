
<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="../../madmin">Home</a></li>
			<li><a href="<?= Config::get('URL') . 'event/index' ?>">Events</a></li>
			<li class="active">Add-or-Edit</li>
		</ol>

		<?php var_dump($this->data) ?>
		
		<h3><?= $this->data['page']->title ?></h3>

			<form enctype="multipart/form-data" method="post" action="<?= Config::get('URL') . 'event/save' ?>" class="form">
				<div class="form-group">
					<label hidden for="">id</label>
					<input type="hidden" name="event_id" class="form-control" value="<?= $this->data['event']->event_id ?>">
				</div>
				<div class="form-group">
					<label for="">Тип фестиваля</label>
					<select name="fest_type_id" class="form-control">
					<option value="">Выбирай:)</option>
						<?php foreach ($this->data['fest_types'] as $fest_type): ?>
							<option value="<?= $fest_type->id ?>"
									<?php if ($fest_type->id == $this->data['event']->fest_type_id) echo 'selected' ?>
							><?= $fest_type->name ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Год проведения</label>
					<input type="text" name="event_year" class="form-control" value="<?= $this->data['event']->year ?>" required>
				</div>

				<div class="form-group">
					<label for="">Изображение (желательно 1140x400)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
					<input id="fest-img" type="file" name="uploadFile[]">
				</div>

				<div class="form-group">
					<label for="">Дата начала</label>
					<input type="date" class="form-control" name="begin_date" value="<?= $this->data['event']->begin_date ?>" required>
				</div>

				<div class="form-group">
					<label for="">Дата окончания</label>
					<input type="date" class="form-control" name="finish_date" value="<?= $this->data['event']->finish_date ?>" required>
				</div>

				<button type="submit" class="btn btn-default">Сохранить</button>
			</form>
		
	</div>
</div>

<script>
// setTimeout(init, 1000);
init();

function init(){
	<?php if ($this->data['event']->event_id != null) {?>
	$('#fest-img').fileinput({
		// uploadAsync: false,
		// maxFileCount: 1,
		initialPreview: [
    "<img src='<?= Config::get('URL').'uploads/'. $this->data['event']->img_link . '.jpg'?>' class='file-preview-image' alt='Desert' title='Desert'>",
		]
	});
	<?php } else { ?>
		$('#fest-img').fileinput();
	<?php } ?>

}
</script>