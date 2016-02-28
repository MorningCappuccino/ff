
<div class="row">
	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="../madmin">Home</a></li>
			<li><a href="<?= Config::get('URL') . 'madmin/films' ?>">Films</a></li>
			<li class="active">Add-or-Edit</li>
		</ol>
		<!-- <?php var_dump($this->data) ?> -->
		<h3><?= $this->data['page']->title ?></h3>
		<?php if ($this->data): ?>
			<form method="post" action="<?= Config::get('URL') . 'film/save' ?>" class="form">
				<div class="form-group">
					<label hidden for="">id</label>
					<input type="hidden" name="film_id" class="form-control" value="<?= $this->data['film']->film_id ?>">
				</div>
				<div class="form-group">
					<label for="">Категория</label>
					<select name="category_id" class="form-control">
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
					<label for="">Номинация</label>
					<select name="nomination_id" class="form-control">
					<option value="">Выберите Наминацию</option>
						<?php foreach ($this->data['nominations'] as $nomination): ?>
							<option value="<?= $nomination->nomination_id ?>" 
									// <?php if ($nomination->nomination_id == $this->data['film']->category_id) echo 'selected' ?>
							><?= $nomination->nomination_name ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<button type="submit" class="btn btn-default">Сохранить</button>
			</form>
		<?php endif ?>
	</div>
</div>