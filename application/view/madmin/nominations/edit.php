<div class="row">

	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="../../madmin">Home</a></li>
			<li><a href="../../madmin/nomination">Category</a></li>
			<li class="active">Edit</li>
		</ol>
		<h3>Редактирование номинации</h3>


		<!-- <?php var_dump ($this->nomination) ?> -->
		<?php if ($this->nomination) {?>
		<form class='form-inline' method="post" action="<?php echo Config::get('URL'); ?>nomination/save">
			<label>Название номинации</label>
			<input class='form-control' type="hidden" name="nomination_id" value="<?php echo htmlentities($this->nomination->nomination_id); ?>" />
			<input class='form-control' type="text" name="nomination_name" value="<?php echo htmlentities($this->nomination->nomination_name); ?>" />
			<button class='btn btn-default' type="submit">Изменить</button>
		</form>
		<?php } else { ?>
		<p>This note does not exist.</p>
		<?php } ?>
	</div>
</div>
</div>