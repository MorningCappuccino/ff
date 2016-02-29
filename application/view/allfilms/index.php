<div class='row'>
	<div class='col-md-12 wrap'>
		<h2>Все фильмы</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<table class='table table-striped'>
			<thead>
				<tr>
					<td hidden>id</td> <!-- hidden -->
					<td>name</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->films as $film): ?>
					<tr onmouseover="this.style.cursor = 'pointer'; this.style.background = '#ddd'"
							onmouseout="this.style.background = ''"
							onclick="window.location.href='<?= Config::get('URL') . 'film/details/' . $film->id ?>'">
						<td hidden><?= $film->id ?> </td> <!-- make hidden -->
						<td><?= $film->film_name ?> </td>
					</tr>
				<?php endforeach ?>
			</table>
		</tbody>
	</div>
</div>