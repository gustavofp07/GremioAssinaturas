<!DOCTYPE html>
<html>

<head>
    <?php include_once "geral/head.php" ?>
    <title>Verificar Comprovante</title>
</head>

<body>
    <?php include_once "geral/menu.php" ?>
    <div class="px-5 mt-4">
        <div>
            <div class="d-flex mt-4">
                <?php if(isset($_GET['origem'])){
                    echo '<a href="publica.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="32" width="28"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </a>';}else{
                    echo '<a href="verificarAssinatura.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="32" width="28"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </a>';
                }
                ?>
                
                <p class="ml-2">Voltar</p>
            </div>

            <div class="<?php if (isset($_GET['erro'])) {
                echo 'd-none';
            } ?>">
                <div class="alert alert-success text-center <?php if (isset($_GET['origem'])) {
                echo 'd-none';
            } ?>" role="alert">
                    Comprovante Válido
                </div>
                <?php include_once "repo/documentoCRUD.php";
                include_once "repo/usuarioCRUD.php";
                if (isset($_GET['codigo']) && isset($_GET['comprovante'])) {

                    $codigo = $_GET['codigo'];
                    $comprovante = $_GET['comprovante'];

                    $registro = buscarVerificacao($codigo, $comprovante);
                    $usuario = buscarUsuarioPorId($registro['usuario']);
                    $signatarios = buscarSignatarios($codigo);
                }
                ?>
                <div class="d-flex justify-content-center pt-3 pb-2 mb-3 border-bottom">
                    <h4 class="h4">
                        <?php echo $registro['nome']; ?>
                    </h4>
                </div>
                <div class="mb- d-flex flex-wrap">
                    <div class="col-lg-6">
                        <p><span class="text-muted">Submissão: </span>
                            <?php echo $usuario['nome']; ?>
                        </p>
                        <p><span class="text-muted">Horário de Submissão:</span>
                            <?php echo $registro['horarioSubmissao']; ?>
                        </p>
                        <p><span class="text-muted">Tipo do Documento:</span>
                            <?php $tipo = buscarTipo($registro['tipo']);
                            echo $tipo["tipo"]; ?>
                        </p>
                        <p><span class="text-muted">Acesso:</span>
                            <?php if ($registro['acesso'] == 1) {
                                echo "Publico";
                            } else {
                                echo "Restrito";
                            } ?>
                        </p>
                        <p><span class="text-muted">Situação: </span>
                            <?php echo $registro['situacao']; ?>
                        </p>
                        <p class="text-muted">Signatários: </p>
                        <?php foreach ($signatarios as $sig) {
                            $usuario = buscarUsuarioPorId($sig['codUsuario']);
                            echo '<p>' . $usuario['nome'] . ' - ' . $sig['mudanca'] . ' [' . $sig['situacao'] . ']';
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center mb-5 col-lg-6">
                        <iframe src="<?php echo $registro['caminho'] ?>" class="frame" frameborder="0"
                            scrolling="no"></iframe>
                    </div>
                    <p></p>
                </div>
            </div>
            <div class="alert alert-danger text-center <?php if (!isset($_GET['erro'])) {
                echo 'd-none';
            } ?>" role="alert">
                Comprovante Inválido
            </div>
        </div>
    </div>
    <?php include_once "geral/js.php" ?>
</body>

</html>