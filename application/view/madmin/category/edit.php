<div class="row">

	<div class="col-md-12 wrap">
		<ol class="breadcrumb">
			<li><a href="../../madmin">Home</a></li>
			<li><a href="../../madmin/category">Category</a></li>
			<li class="active">Edit</li>
		</ol>
		<h3>Edit category</h3>


		<!-- <?php var_dump ($this->category) ?> -->
		<?php if ($this->category) {?>
		<form class='form-inline' method="post" action="<?php echo Config::get('URL'); ?>category/editSave">
			<label>Change text of category: </label>
			<!-- we use htmlentities() here to prevent user input with " etc. break the HTML -->
			<input class='form-control' type="hidden" name="category_id" value="<?php echo htmlentities($this->category->category_id); ?>" />
			<input class='form-control' type="text" name="category_name" value="<?php echo htmlentities($this->category->category_name); ?>" />
			<button class='btn btn-default' type="submit">change</button>
		</form>
		<?php } else { ?>
		<p>This note does not exist.</p>
		<?php } ?>
	</div>
</div>
</div>
