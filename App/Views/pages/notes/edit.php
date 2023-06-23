<?php
view('components/full-header');
/** @var \App\Models\Note $note */
$fields = $fields ?? [];
$errors = $errors ?? [];

$titleError = getFieldError('title', $errors);
$folderIdError = getFieldError('folder_id', $errors);
$contentError = getFieldError('content', $errors);

$selectedOptionId = $fields['folder_id'] ?? $note->folder_id;
?>
<div class="container">
	<div class="row">
		<form action="<?= url("notes/{$note->id}/update") ?>"
			  method="post">
			<div class="col-12">
				<ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center justify-content-between">
					<li class="nav-item d-flex flex-row">
						<a href="<?= url("notes/{$note->id}") ?>"
						   class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2"><i class="fa fa-arrow-left"
							   aria-hidden="true"></i> &nbsp; Back</a>
					</li>
				</ul>
			</div>

			<?php if (isset($errors['non_field_errors'])) : ?>
				<?php foreach ($errors['non_field_errors'] as $error) : ?>
					<div class="alert alert-danger"
						 role="alert">
						<?= $error ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="col-12 d-flex flex-column"
				 style="padding: 0 1rem">
				<div class="mb-3">
					<label for="title"
						   class="form-label">Title</label>
					<input type="text"
						   name="title"
						   class="form-control"
						   id="title"
						   placeholder="Put some title"
						   value="<?= $fields['title'] ?? $note->title ?>">
				</div>
				<?php if ($titleError) : ?>
					<div class="invalid-feedback d-block">
						<?= $titleError ?>
					</div>
				<?php endif; ?>

				<div class="mb-3">
					<label for="folders"
						   class="form-label">Folder</label>
					<select class="form-select"
							name="folder_id"
							id="folders">
						<?php foreach ($folders as $folder) : ?>
							<option value="<?= $folder->id ?>"
									<?= $selectedOptionId === $folder->id ? 'selected' : '' ?>>
								<?= $folder->title ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php if ($folderIdError) : ?>
					<div class="invalid-feedback d-block">
						<?= $folderIdError ?>
					</div>
				<?php endif; ?>

				<div class="mb-3">
					<div class="form-check form-switch">
						<input class="form-check-input"
							   type="checkbox"
							   role="switch"
							   id="pinned"
							   name="pinned"
							   <?= $fields['pinned'] ?? $note->pinned ? 'checked' : '' ?>>
						<label class="form-check-label"
							   for="pinned">Pin note</label>
					</div>
				</div>

				<div class="mb-3">
					<div class="form-check form-switch">
						<input class="form-check-input"
							   type="checkbox"
							   role="switch"
							   id="completed"
							   name="completed"
							   <?= $fields['completed'] ?? $note->completed ? 'checked' : '' ?>>
						<label class="form-check-label"
							   for="completed">Complete note</label>
					</div>
				</div>

				<div class="mb-3">
					<label for="content"
						   class="form-label">Content</label>
					<textarea class="form-control"
							  name="content"
							  id="content"
							  rows="5"
							  placeholder="Note content.."><?= $fields['content'] ?? $note->content ?></textarea>
				</div>
				<?php if ($contentError) : ?>
					<div class="invalid-feedback d-block">
						<?= $contentError ?>
					</div>
				<?php endif; ?>

				<div class="mb-3">
					<label for="users"
						   class="form-label">Share note with users</label>
					<select name="users[]"
							id="users"
							class="form-control"
							multiple>
						<?php foreach ($users as $user) : ?>
							<option value="<?= $user->id ?>"
									<?= in_array($user->id, $sharedUsers) ? 'selected' : '' ?>><?= $user->email ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="mb-3 d-flex justify-content-end">
					<button type="submit"
							class="btn btn-primary">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php view('components/footer'); ?>
