<div class='row'>
	<div class='col-md-12 wrap'>
		<ol class="breadcrumb">
			<li><a href="../madmin">Home</a></li>
			<li class="active">Films</li>
		</ol>
		<h2>Список фильмов</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<a href="<?= Config::get('URL') . 'film/create' ?>" class="btn btn-default">create film</a>
		<!-- <?php var_dump($this->films) ?> -->
		<table class='table table-striped'>
			<thead>
				<tr>
					<td>id</td> <!-- hidden -->
					<td>name</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->films as $film): ?>
					<tr>
						<td><?= $film->id ?> </td> <!-- make hidden -->
						<td><?= $film->film_name ?> </td>
						<td><a href="<?= Config::get('URL') . 'film/edit/' . $film->id ?>">edit</a></td>
						<td><a href="<?= Config::get('URL') . 'film/delete/' . $film->id ?>">delete</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</tbody>
	</div>
</div>
