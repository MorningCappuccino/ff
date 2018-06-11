<div class='row'>
	<div class='col-md-12 wrap'>
		<ol class="breadcrumb">
			<li><a href="../madmin">Главная</a></li>
			<li class="active">Кинотеатры</li>
		</ol>
		<h2>Список кинотеатров</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<a href="<?= Config::get('URL') . 'cinema/create' ?>" class="btn btn-default">Создать</a>
		<table class='table table-striped'>
			<thead>
				<tr>
					<td>id</td>
					<td>Название</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->cinemas as $cinema): ?>
					<tr>
						<td><?= $cinema->id ?> </td>
						<td><?= $cinema->cinema_name ?> </td>
						<td><a href="<?= Config::get('URL') . 'cinema/edit/' . $cinema->id ?>">Редактировать</a></td>
						<td><a href="<?= Config::get('URL') . 'cinema/delete/' . $cinema->id ?>">Удалить</a></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</tbody>
	</div>
</div>
