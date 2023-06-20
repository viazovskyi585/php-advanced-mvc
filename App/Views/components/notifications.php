<div class="container w-50">
	<?php foreach (App\Helpers\Notifications::get() as $notification) : ?>
		<div class="alert alert-<?= $notification['type'] ?> alert-dismissible fade show"
			 role="alert">
			<?= $notification['message'] ?>
			<button type="button"
					class="btn-close"
					data-bs-dismiss="alert"
					aria-label="Close"></button>
		</div>
	<?php endforeach; ?>
</div>
