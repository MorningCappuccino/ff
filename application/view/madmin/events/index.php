<div class='row'>
	<div class='col-md-12'>
		<ol class="breadcrumb">
			<li><a href="madmin">Home</a></li>
			<li class="active">Events</li>
		</ol>
		<h2>Все события</h2>

		<?php $this->renderFeedbackMessages(); ?>

		<!-- <?php var_dump($this->events) ?> -->
		<a href="<?= Config::get('URL') . 'event/create' ?>" class="btn btn-default">create event</a>
		<table class='table table-striped'>
			<thead>
				<tr>
					<td>id</td> <!-- hidden -->
					<td>name</td>
					<td>status</td>
					<td>begin date</td>
					<td>finish date</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->events as $event): ?>
					<tr>
						<td><?= $event->id ?> </td> <!-- make hidden -->
						<td><?= $event->fest_type_name .' '. $event->year ?> </td>
						<td><?= $event->event_status ?> </td>
						<td><?= $event->begin_date ?> </td>
						<td><?= $event->finish_date ?> </td>
						<td><a href="<?= Config::get('URL') . 'event/edit/' . $event->id ?>">edit</a></td>
						<td><a href="<?= Config::get('URL') . 'event/delete/' . $event->id ?>">delete</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</tbody>
	</div>
</div>
