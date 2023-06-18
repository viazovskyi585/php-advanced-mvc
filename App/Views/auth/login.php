<?php
view('components/header');

$fields = $fields ?? [];
$errors = $errors ?? [];

$emailError = getFieldError('email', $errors);
$passwordError = getFieldError('password', $errors);
?>
<link href="<?= ASSETS_URI ?>styles/auth.css"
	  rel="stylesheet">
<main class="d-flex align-items-center py-4 bg-body-tertiary">
	<div class="form-auth w-100 m-auto">
		<form method="POST"
			  action="<?= url('auth/sign-in') ?>">
			<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

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
					<input type="email"
						   name="email"
						   class="form-control <?= getFieldState($emailError) ?>"
						   id="floatingInput"
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
						   id="floatingPassword"
						   placeholder="Password">
					<label for="floatingPassword">Password</label>
				</div>
				<?php if ($passwordError) : ?>
					<div class="invalid-feedback d-block">
						<?= $passwordError ?>
					</div>
				<?php endif; ?>
			</div>

			<button class="btn btn-primary w-100 py-2 mt-3"
					type="submit">Sign in</button>

			<div class="text-center mt-3">
				<a href="<?= url('register') ?>">Don't have an account?</a>
			</div>
		</form>
</main>
</main>

<?php
view('components/footer');
?>
