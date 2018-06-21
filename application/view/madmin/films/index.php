<div class='row'>
	<div class='col-md-12 wrap'>
		<ol class="breadcrumb">
			<li><a href="../madmin">Главная</a></li>
			<li class="active">Фильмы</li>
		</ol>
		<h2>Список фильмов</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<a href="<?= Config::get('URL') . 'film/create' ?>" class="btn btn-default">Создать фильм</a>
		<!-- <?php var_dump($this->films) ?> -->
		<table class='table table-striped'>
			<thead>
				<tr>
					<td>id</td> <!-- hidden -->
					<td>Название</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->films as $film): ?>
					<tr>
						<td><?= $film->id ?> </td> <!-- make hidden -->
						<td><?= $film->film_name ?> </td>
						<td><a href="<?= Config::get('URL') . 'film/edit/' . $film->id ?>">Редактировать</a></td>
						<td><a href="<?= Config::get('URL') . 'film/delete/' . $film->id ?>">Удалить</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</tbody>
	</div>
</div>
