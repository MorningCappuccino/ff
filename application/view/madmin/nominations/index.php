<div class='row'>

	<div class='col-md-12 wrap'>
		<ol class="breadcrumb">
			<li><a href="../ff/madmin">Home</a></li>
			<li class="active">Nominations</li>
		</ol>
		<h2>Номинации</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<form class='form-inline' method='post' action='<?= Config::get('URL') . 'nomination/create' ?>'>
			<input class='form-control 'type='text' name='nomination_name' value=''>
			<button class='btn btn-default' type='submit' >Создать</button>
		</form>
		<table class='table table-striped'>
			<thead>
				<tr>
					<td hidden>id</td>
					<td>Название</td>
				</tr>
			</thead>
			<!-- <?php var_dump ($this->nominations) ?>  -->
			<tbody>
			<?php foreach ($this->nominations as $nomination): ?>
					<tr>
						<td><?= $nomination->nomination_id ?> </td>
						<td><?= $nomination->nomination_name ?> </td>
						<td><a href="<?= Config::get('URL') . 'nomination/edit/' . $nomination->nomination_id ?>">edit</a></td>
						<td><a href="<?= Config::get('URL') . 'nomination/delete/' . $nomination->nomination_id ?>">delete</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</tbody>
	</div>
</div>