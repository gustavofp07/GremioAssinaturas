<nav class="navbar navbar-expand-lg navbar-light shadow-sm mb-4" id="mainNav">
    <div class="container px-2 d-flex justify-content-center">
        <a href="index.php"><img class="img-fluid logo ml-4" src="imagens/logo.jpeg" alt="logo do grêmio"></a>
        <a class="navbar-brand fw-bold" href="index.php">Grêmio Assinaturas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                <li class="nav-item"><a class="nav-link me-lg-3 <?php if ($dadosUsuario['cargo'] != 5 && $dadosUsuario['cargo'] != 1) {
                            echo "d-none";
                        } ?>" href="administrador.php">Administrativo</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3 <?php if (!isset($dadosUsuario)) {
                            echo "d-none";
                        } ?>" href="signatario.php">Documentos</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="publica.php">Página Pública</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="controle/sair.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>