<nav class="navbar navbar-expand-md sticky-top navbar-shrink py-2 navbar-light" id="mainNav">
	<div class="container">
		<a class="navbar-brand d-flex align-items-center" href="/"><img alt="EMPRESA" class="img-fluid" src="/assets/img/logo.svg" width="162" height="49"></a>
		<button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navcol-1">
			<ul class="navbar-nav ms-auto">
				<li class="nav-item"><a class="nav-link" href="/">Home</a></li>
				<li class="nav-item"><a class="nav-link active" href="/productos/">Productos</a></li>
				<li class="nav-item"><a class="nav-link" href="/categorias">Categorias</a></li>
				<li class="nav-item"><a class="nav-link rounded text-white" href="/contacto">Contacto</a></li>
				<?php if(isset($_SESSION["P3xN3w"])): ?>
					<li class="nav-item dropdown bg-dark rounded ms-1 session-user">
						<a class="dropdown-toggle nav-link text-white" aria-expanded="false" data-bs-toggle="dropdown" href="#">Mi cuenta</a>
						<div class="dropdown-menu rounded bg-dark">
							<a class="dropdown-item" href="#">Mis datos</a>
							<a class="dropdown-item" href="#">Mis pedidos</a>
							<a class="dropdown-item" href="javascript: logout();">Desconectarme</a>
						</div>
					</li>
				<?php else: ?>

				<?php endif ?>
			</ul>
		</div>
	</div>
</nav>