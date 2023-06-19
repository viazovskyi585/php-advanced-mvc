<?php
view('components/header');
view('components/layout/header');

$fields = $fields ?? [];
$errors = $errors ?? [];

$titleError = getFieldError('title', $errors);

$title = $fields['title'] ?? $folder->title;
?>
<div class="d-flex align-items-center py-4 bg-body-tertiary">
	<main class="form-signin mt-5 m-auto"
		  style="width: 300px">
		<form method="post"
			  action="<?= url('folders/store') ?>">
			<h1 class="h3 mb-3 fw-normal">New Folder</h1>

			<div class="form-floating">
				<input type="text"
					   class="form-control"
					   id="floatingInput"
					   name="title"
					   value="<?= $title ?>"
					   placeholder="Some note title..">
				<label for="floatingInput">Title</label>
			</div>
			<?php if ($titleError) : ?>
				<div class="invalid-feedback d-block">
					<?= $titleError ?>
				</div>
			<?php endif; ?>


			<div class="d-flex justify-content-between mt-3">
				<a href="<?= url("folders/{$folder->id}/") ?>"
				   class="d-block btn btn-secondary">Back</a>
				<button class="d-block btn btn-primary"
						type="submit">Save</button>
			</div>
		</form>
	</main>
</div>
<?php
view('components/footer');
