<div class="row">

	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="../../madmin">Главная</a></li>
			<li><a href="../../madmin/category">Жанры</a></li>
			<li class="active">Редактирование</li>
		</ol>

		<!-- <?php var_dump ($this->category) ?> -->
		<?php if ($this->category) {?>
		<form class='form-inline' method="post" action="<?php echo Config::get('URL'); ?>category/editSave">
			<label>Название жанра: </label>
			<!-- we use htmlentities() here to prevent user input with " etc. break the HTML -->
			<input class='form-control' type="hidden" name="category_id" value="<?php echo htmlentities($this->category->category_id); ?>" />
			<input class='form-control' type="text" name="category_name" value="<?php echo htmlentities($this->category->category_name); ?>" />
			<button class='btn btn-default' type="submit">Изменить</button>
		</form>
		<?php } else { ?>
		<p>Этой записи не существует.</p>
		<?php } ?>
	</div>
</div>
