<nav class="navbar navbar-expand-lg bg-body-tertiary mb-5">
	<div class="container-fluid">
		<a class="navbar-brand"
		   href="#">Notes</a>
		<button class="navbar-toggler"
				type="button"
				data-bs-toggle="collapse"
				data-bs-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent"
				aria-expanded="false"
				aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse"
			 id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<?php if (\App\Helpers\Session::check()) : ?>
					<li class="nav-item">
						<a class="nav-link"
						   aria-current="page"
						   href="<?= url('logout') ?>">Logout</a>
					</li>
				<?php else : ?>
					<li class="nav-item">
						<a class="nav-link <?= isCurrentLink('login') ? 'active' : '' ?>"
						   aria-current="page"
						   href="<?= url('login') ?>">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= isCurrentLink('register') ? 'active' : '' ?>"
						   href="<?= url('register') ?>">Register</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>
