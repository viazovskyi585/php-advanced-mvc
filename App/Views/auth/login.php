<?php
view('components/header');
?>
<link href="<?= ASSETS_URI ?>styles/auth.css" rel="stylesheet">
<main class="d-flex align-items-center py-4 bg-body-tertiary">
	<div class="form-auth w-100 m-auto">
		<form method="post" action="<?= url('auth/sign-in') ?>">
			<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

			<div class="fields">
				<div class="form-floating">
					<input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
					<label for="floatingInput">Email address</label>
				</div>
				<div class="form-floating">
					<input type="password" class="form-control" id="floatingPassword" placeholder="Password">
					<label for="floatingPassword">Password</label>
				</div>
			</div>

			<button class="btn btn-primary w-100 py-2 mt-3" type="submit">Sign in</button>

			<div class="text-center mt-3">
				<a href="<?= url('register') ?>">Don't have an account?</a>
			</div>
		</form>
</main>
</main>

<?php
view('components/footer');
?>
