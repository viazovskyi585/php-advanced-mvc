<?php
view('components/header');
view('components/layout/header');

$fields = $fields ?? [];
$errors = $errors ?? [];

$titleError = getFieldError('title', $errors);
?>
<div class="d-flex align-items-center py-4 bg-body-tertiary">
	<main class="form-signin mt-5 m-auto"
		  style="width: 300px">
		<form method="post"
			  action="<?= url('folders/store') ?>">
			<h1 class="h3 mb-3 fw-normal">New Folder</h1>

			<?php if (isset($errors['non_field_errors'])) : ?>
				<?php foreach ($errors['non_field_errors'] as $error) : ?>
					<div class="alert alert-danger"
						 role="alert">
						<?= $error ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="form-floating">
				<input type="text"
					   class="form-control"
					   id="floatingInput"
					   name="title"
					   value="<?= $fields['title'] ?? '' ?>"
					   placeholder="Some note title..">
				<label for="floatingInput">Title</label>
			</div>
			<?php if ($titleError) : ?>
				<div class="invalid-feedback d-block">
					<?= $titleError ?>
				</div>
			<?php endif; ?>

			<button class="btn btn-primary w-100 mt-3 py-2"
					type="submit">Create</button>
		</form>
	</main>
</div>
<?php
view('components/footer');
