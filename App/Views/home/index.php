<?php
view('components/header');

/** @var User|null $user */
$user = $user ?? [];
?>

<main>
	<div class="container mt-3">
		<?php if ($user) : ?>
			<div class="alert alert-success"
				 role="alert">
				<?= $user->email ?> is logged in.
			</div>
			<form action="<?= url('auth/sign-out') ?>"
				  method="post">
				<button type="submit"
						class="btn btn-primary">
					Logout
				</button>
			</form>
		<?php else : ?>
			<div class="alert alert-danger"
				 role="alert">
				Not logged in.
			</div>
			<a href="<?= url('login') ?>"
			   class="btn btn-primary">
				Login
			</a>
		<?php endif ?>
	</div>
</main>

<?php
view('components/footer');
?>
