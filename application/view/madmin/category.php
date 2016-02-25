<div class='row'>

	<div class='col-md-12 wrap'>
		<h2>Film category</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<form class='form-inline' method='post' action='<?= Config::get('URL') . 'category/create/' ?>'>
			<input class='form-control'type='text' name='category_name' value=''>
			<button class='btn btn-default' type='submit' >create</button>
		</form>
		<table class='table table-striped'>
			<thead>
				<tr>
					<td>id</td>
					<td>Category name</td>
				</tr>
			</thead>
			<!-- <?php print_r ($this) ?> -->
			<tbody>
			<?php foreach ($this->categories as $category): ?>
					<tr>
						<td><?= $category->category_id ?> </td>
						<td><?= $category->category_name ?> </td>
						<td><a href="<?= Config::get('URL') . 'category/edit/' . $category->category_id ?>">edit</a></td>
						<td><a href="<?= Config::get('URL') . 'category/delete/' . $category->category_id ?>">delete</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</tbody>
	</div>
</div>
