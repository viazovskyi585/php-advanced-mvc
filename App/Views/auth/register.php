<?php
view('components/header');
?>
<link href="<?= ASSETS_URI ?>styles/auth.css" rel="stylesheet">
<main class="d-flex align-items-center py-4 bg-body-tertiary">
	<div class="form-auth w-100 m-auto">
		<form>
			<h1 class="h3 mb-3 fw-normal">Register</h1>

			<div class="fields">
				<div class="form-floating">
					<input type="text" name="name" class="form-control" id="name" placeholder="Name">
					<label for="name">Name</label>
				</div>
				<div class="form-floating">
					<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
					<label for="floatingInput">Email address</label>
				</div>
				<div class="form-floating">
					<input type="password" name="password" class="form-control" id="password" placeholder="Password">
					<label for="password">Password</label>
				</div>
				<div class="form-floating">
					<input type="password-confirm" name="password-confirm" class="form-control" id="password-confirm" placeholder="Password">
					<label for="password-confirm">Confirm Password</label>
				</div>
			</div>


			<button class="btn btn-primary w-100 py-2 mt-3" type="submit">Register</button>

			<div class="text-center mt-3">
				<a href="/login">Already have an account?</a>
			</div>
		</form>
</main>
</main>

<?php
view('components/footer');
?>
