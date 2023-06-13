<?php
view('components/header');
?>

<main class="d-flex vh-100 align-items-center py-4 bg-body-tertiary">
	<div class="form-signin w-100 px-4 m-auto" style="max-width: 400px;">
		<form>
			<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

			<div class="form-floating mt-3">
				<input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
				<label for="floatingInput">Email address</label>
			</div>
			<div class="form-floating mt-3">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password">
				<label for="floatingPassword">Password</label>
			</div>

			<button class="btn btn-primary w-100 py-2 mt-3" type="submit">Sign in</button>
		</form>
	</div>
</main>

<?php
view('components/footer');
?>
