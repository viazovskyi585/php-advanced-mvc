<?php
view('components/header');

$fields = $fields ?? [];
$errors = $errors ?? [];

$nameError = getFieldError('name', $errors);
$emailError = getFieldError('email', $errors);
$passwordError = getFieldError('password', $errors);
$passwordConfirmationError = getFieldError('password_confirmation', $errors);
?>

<link href="<?= ASSETS_URI ?>styles/auth.css"
	  rel="stylesheet">
<main class="d-flex align-items-center py-4 bg-body-tertiary">
	<div class="form-auth w-100 m-auto">
		<form class="needs-validation"
			  method="post"
			  action="<?= url('auth/sign-up') ?>">
			<h1 class="h3 mb-3 fw-normal">Register</h1>

			<?php if (isset($errors['non_field_errors'])) : ?>
				<?php foreach ($errors['non_field_errors'] as $error) : ?>
					<div class="alert alert-danger"
						 role="alert">
						<?= $error ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="fields">
				<div class="form-floating">
					<input type="text"
						   name="name"
						   class="form-control <?= getFieldState($nameError) ?>"
						   id="name"
						   placeholder="Name"
						   value="<?= $fields['name'] ?? '' ?>">
					<label for="name">Name</label>
				</div>
				<?php if ($nameError) : ?>
					<div class="invalid-feedback d-block">
						<?= $nameError ?>
					</div>
				<?php endif; ?>

				<div class="form-floating">
					<input type="email"
						   name="email"
						   class="form-control <?= getFieldState($emailError) ?>"
						   id="email"
						   placeholder="name@example.com"
						   value="<?= $fields['email'] ?? '' ?>">
					<label for="floatingInput">Email address</label>
				</div>
				<?php if ($emailError) : ?>
					<div class="invalid-feedback d-block">
						<?= $emailError ?>
					</div>
				<?php endif; ?>

				<div class="form-floating">
					<input type="password"
						   name="password"
						   class="form-control <?= getFieldState($passwordError) ?>"
						   id="password"
						   placeholder="Password">
					<label for="password">Password</label>
				</div>
				<?php if ($passwordError) : ?>
					<div class="invalid-feedback d-block">
						<?= $passwordError ?>
					</div>
				<?php endif; ?>

				<div class="form-floating">
					<input type="password"
						   name="password_confirmation"
						   class="form-control <?= getFieldState($passwordConfirmationError) ?>"
						   id="password-confirm"
						   placeholder="Password">
					<label for="password_confirmation">Confirm Password</label>
				</div>
				<?php if ($passwordConfirmationError) : ?>
					<div class="invalid-feedback d-block">
						<?= $passwordConfirmationError ?>
					</div>
				<?php endif; ?>
			</div>


			<button class="btn btn-primary w-100 py-2 mt-3"
					type="submit">Register</button>

			<div class="text-center mt-3">
				<a href="<?= url('login') ?>">Already have an account?</a>
			</div>
		</form>
</main>
</main>

<?php
view('components/footer');
?>
