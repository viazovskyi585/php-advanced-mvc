<header class="mb-4 p-3 text-bg-light">
	<div class="container">
		<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

			<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
				<li><a href="<?= url() ?>"
					   class="nav-link px-2">Dashboard</a></li>
			</ul>

			<div class="text-end">
				<form action="<?= url('auth/sign-out') ?>"
					  method="post">
					<button type="submit"
							class="btn btn-outline-dark me-2">Log out</button>
				</form>
			</div>
		</div>
	</div>
</header>
