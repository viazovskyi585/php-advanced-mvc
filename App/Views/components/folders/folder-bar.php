<div class="p-4 bg-body-tertiary border rounded-3 d-flex justify-content-between align-items-center">
	<h2>Folder: <?= $activeFolder->title ?></h2>
	<div class="d-flex gap-2">
		<?php if (!\App\Models\Folder::isFrozen($activeFolder->id)) : ?>
			<a href="<?= url("folders/{$activeFolder->id}/edit") ?>"
			   class="btn btn-primary">
				<i class="fa fa-pencil"
				   aria-hidden="true"></i>
			</a>
			<form action="<?= url("folders/{$activeFolder->id}/destroy") ?>"
				  method="POST">
				<button type="submit"
						class="btn btn-danger">
					<i class="fa fa-trash"
					   aria-hidden="true"></i>
				</button>
			</form>
		<?php endif; ?>
	</div>
</div>
