<?php include_once "geral/acesso.php" ?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once "geral/head.php" ?>
    <title>Administrador</title>
</head>

<body>
    <?php include_once "geral/menu.php" ?>
    <div class="container">
        <?php include_once "geral/alertas.php" ?>
        <div
            class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4 class="h4">Administrador</h4>
        </div>
        <ul class="nav nav-tabs d-flex justify-content-center" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Todos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#meus" role="tab" aria-controls="profile"
                    aria-selected="false">Meus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="criar-tab" data-toggle="tab" href="#cadastrar" role="tab" aria-controls="criar"
                    aria-selected="false">Cadastrar</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="form-group col-md-4">
                    <label for="filtro">Filtrar</label>
                    <select id="filtro" class="form-control" name="filtro" onchange="filtroEscolhido()" required>
                        <option selected hidden value=''>
                            <?php 
                            include_once 'repo/documentoCRUD.php';
                            if (isset($_GET['tipo'])) {
                                $tipoSelecionado = $_GET['tipo'];
                                if (!$tipoSelecionado == 0) {
                                    $registros = buscarTipo($tipoSelecionado);
                                    echo $registros["tipo"];
                                } else {
                                    echo "Todos";
                                }
                            } else {
                                echo "Escolha...";
                            }
                            ?>
                        </option>
                        <option value='0'> Todos </option>
                        <?php
                        $tipos = listarTipos();
                        foreach ($tipos as $tipo) {
                            echo "<option value='" . $tipo['id'] . "'>{$tipo['tipo']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Seção de Documentos Ativos (Não Cancelados) -->
                <h2>Documentos Ativos</h2>
                <div class="row mt-4">
                    <?php
                    include_once 'repo/documentoCRUD.php';
                    include_once 'repo/usuarioCRUD.php';
                    $registros = isset($_GET['tipo']) && !$_GET['tipo'] == 0 ? filtrarPorTipo($_GET['tipo']) : listar();

                    $countAtivos = 0;
                    foreach ($registros as $registro) {
                        if ($registro['situacao'] !== 'cancelado') { // Verifica se o documento não está cancelado
                            $countAtivos++;
                            $nomeUsuario = buscarUsuarioPorId($registro['usuario']);
                            echo ' <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">' . $registro['nome'] . '</h5>
                                            <p class="card-text text-muted text-center">' . $nomeUsuario['nome'] . '</p>
                                            <p class="card-text text-muted text-center">[' . $registro['situacao'] . ']</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="documentoDetalhado.php?codigo=' . $registro['codigoDocumento'] . '"
                                                        class="btn btn-sm btn-outline-secondary">Ver</a>
                                                </div>
                                                <small class="text-muted">' . $registro['horarioSubmissao'] . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                    if ($countAtivos == 0) {
                        echo '<p class="text-center text-muted mt-3">Não há documentos ativos</p>';
                    }
                    ?>
                </div>

                <!-- Seção de Documentos Cancelados -->
                <h2>Documentos Cancelados</h2>
                <div class="row mt-4">
                    <?php
                    $countCancelados = 0;
                    foreach ($registros as $registro) {
                        if ($registro['situacao'] === 'cancelado') { // Verifica se o documento está cancelado
                            $countCancelados++;
                            $nomeUsuario = buscarUsuarioPorId($registro['usuario']);
                            echo ' <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">' . $registro['nome'] . '</h5>
                                            <p class="card-text text-muted text-center">' . $nomeUsuario['nome'] . '</p>
                                            <p class="card-text text-muted text-center">[' . $registro['situacao'] . ']</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="documentoDetalhado.php?codigo=' . $registro['codigoDocumento'] . '"
                                                        class="btn btn-sm btn-outline-secondary">Ver</a>
                                                </div>
                                                <small class="text-muted">' . $registro['horarioSubmissao'] . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                    if ($countCancelados == 0) {
                        echo '<p class="text-center text-muted mt-3">Não há documentos cancelados</p>';
                    }
                    ?>
                </div>
            </div>

                <div class="row mt-4">
                    <?php
                    include_once 'repo/documentoCRUD.php';
                    include_once 'repo/usuarioCRUD.php';
                    $registros = [];

                    // Verifica se o filtro por tipo foi aplicado
                    
                    if (isset($_GET['tipo'])) {
                        if(!$_GET['tipo'] == 0){
                            $tipoSelecionado = $_GET['tipo'];
                            $registros = filtrarPorTipo($tipoSelecionado);
                        }else{
                            $registros = listar();
                        }
                    } else {
                        $registros = listar();
                    }

                    $count1 = 0;
                    foreach ($registros as $registro) {
                        $count1 = 1;
                        $nomeUsuario = buscarUsuarioPorId($registro['usuario']);
                        echo ' <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">' . $registro['nome'] . '</h5>
                                            <p class="card-text text-muted text-center">' . $nomeUsuario['nome'] . '</p>
                                            <p class="card-text text-muted text-center">[' . $registro['situacao'] . ']</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="documentoDetalhado.php?codigo=' . $registro['codigoDocumento'] . '"
                                                        class="btn btn-sm btn-outline-secondary">Ver</a>
                                                </div>
                                                <small class="text-muted">' . $registro['horarioSubmissao'] . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                    if ($count1 == 0) {
                        echo '<p class="text-center text-muted mt-3">Não há documentos</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="meus" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row mt-4">
                    <?php
                    include_once 'repo/documentoCRUD.php';
                    include_once 'repo/usuarioCRUD.php';
                    $registros = listar();
                    $count2 = 0;
                    foreach ($registros as $registro) {
                        $count2 = 1;
                        if ($registro['usuario'] == $dadosUsuario['codigo']) {
                            $nomeUsuario = buscarUsuarioPorId($registro['usuario']);
                            echo ' <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">' . $registro['nome'] . '</h5>
                                                <p class="card-text text-muted text-center">' . $nomeUsuario['nome'] . '</p>
                                                <p class="card-text text-muted text-center">[' . $registro['situacao'] . ']</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <a href="documentoDetalhado.php?codigo=' . $registro['codigoDocumento'] . '"
                                                            class="btn btn-sm btn-outline-secondary">Ver</a>
                                                    </div>
                                                    <small class="text-muted">' . $registro['horarioSubmissao'] . '</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                        }

                    }
                    if ($count2 == 0) {
                        echo '<p class="text-center text-muted mt-3">Não há documentos</p>';
                    }
                    ?>
                </div>
            </div>




            
            <div class="tab-pane fade" id="cadastrar" role="tabpanel" aria-labelledby="criar-tab">
                <?php if (isset($_GET['alert'])) {
                    if ($_GET['alert'] == 1) {
                        echo '<div class="alert alert-danger text-center mt-4" role="alert">
                    Apenas arquivos PDF são aceitos
                </div>';
                    }
                }
                ?>
                <form id="formulario" class="mt-2" action="controle/submeterDocumento.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome">Nome do Documento</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="doc">Documento</label>
                            <input type="file" id="doc" name="doc" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="signatario">Signatário</label>
                            <select id="signatario" class="form-control" name="signatario"
                                onchange="adicionarElemento()" required>
                                <option selected hidden value=''>Escolha...</option>

                                <?php
                                include_once 'repo/usuarioCRUD.php';
                                $usuarios = listarUsuarios();
                                // echo "<option value='' selected disabled>Escolha o Armário à Transferir</option>";
                                foreach ($usuarios as $user) {
                                    echo "<option value='" . $user['codigo'] . " - " . $user['nome'] . "'>{$user['nome']}</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" id="nomesArray" name="nomesArray" value="">
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $dadosUsuario['codigo'] ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tipo">Tipo do Documento</label>
                            <select id="tipo" class="form-control" name="tipo" required>
                                <option selected hidden value=''>Escolha...</option>

                                <?php
                                include_once 'repo/documentoCRUD.php';
                                $tipos = listarTipos();
                                // echo "<option value='' selected disabled>Escolha o Armário à Transferir</option>";
                                foreach ($tipos as $tipo) {
                                    echo "<option value='" . $tipo['id'] . "'>{$tipo['tipo']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="acesso">Acesso</label>
                            <select id="acesso" class="form-control" name="acesso" required>
                                <option selected hidden value=''>Escolha...</option>
                                <option value='1'>Público</option>
                                <option value='2'>Não Público</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <ul class="list-group" id="lista">
                                <li class="list-group-item">Lista de Signatários</li>

                            </ul>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-end">
                        <button type="button" class="btn btn-success" onclick="verificarElementos()">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

    </script>
    <script type="text/javascript" src="js/filtro.js"></script>
    <script type="text/javascript" src="js/submissaoDoc.js"></script>
    <?php include_once "geral/js.php" ?>
</body>