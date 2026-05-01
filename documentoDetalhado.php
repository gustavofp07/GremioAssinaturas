<?php include_once "geral/acesso.php" ?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once "geral/head.php" ?>
    <title>Detalhes</title>
</head>

<body>
    <?php include_once "geral/menu.php" ?>
    <div class="container">
        <?php include_once "repo/documentoCRUD.php";
        include_once "repo/usuarioCRUD.php";
        if (isset($_GET['codigo'])) {

            $codigo = $_GET['codigo'];

            $registro = buscarDocumento($codigo);
            $usuario = buscarUsuarioPorId($registro['usuario']);
            $signatarios = buscarSignatarios($codigo);
            $verificarAssinatura = buscarSignatariosPorId($codigo, $dadosUsuario['codigo']);
        }
        ?>
        <div
            class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4 class="h4">
                <?php echo $registro['nome']; ?>
            </h4>
        </div>
        <div class="d-flex flex-wrap">

            <div class="col-lg-6">
                <p><span class="text-muted">Submissão: </span>
                    <?php echo $usuario['nome']; ?>
                </p>
                <p><span class="text-muted">Horário de Submissão:</span>
                    <?php echo $registro['horarioSubmissao']; ?>
                </p>
                <p><span class="text-muted">Tipo do Documento:</span>
                    <?php $tipo = buscarTipo($registro['tipo']); echo $tipo["tipo"];?>
                </p>
                <p><span class="text-muted">Acesso:</span>
                <?php if($registro['acesso'] == 1){
                    echo "Publico";
                 }else{
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
                <p></p>
                <div class="d-flex justify-content-around mt-4">
                    <a href="controle/docAssinado.php?codigo=<?php echo $codigo ?>" class="btn btn-success btn-sm ml-3 mt-2 <?php if ($registro['situacao'] == "Pendente" || $registro['situacao'] == "Recusado" || $registro['situacao'] == "Cancelado") {
                        echo 'disabled';
                    } ?>">Imprimir
                        Assinado</a>
                    <a class="btn btn-danger btn-sm ml-3 text-white mt-2 <?php if ($registro['situacao'] == "Assinado" || $registro['situacao'] == "Cancelado"){
                        echo 'disabled';
                    } if($dadosUsuario['cargo'] != 1 && $dadosUsuario['cargo'] != 5){ echo " d-none";}?>" href="controle/cancelarSubmissao.php?codigo=<?php echo $registro['codigoDocumento'] ?>">Cancelar
                        Submissão</a>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a class="btn btn-warning btn-sm ml-3 mt-2 <?php if ($registro['situacao'] == "Pendente" || $registro['situacao'] == "Recusado" || $registro['situacao'] == "Cancelado") {
                        echo 'disabled';
                    } ?> <?php if($dadosUsuario['cargo'] != 1 && $dadosUsuario['cargo'] != 5){ echo " d-none";}?>" href="controle/mudarAcesso.php?codigo=<?php echo $registro['codigoDocumento'] ?>">Mudar Acesso </a>
                </div>
            </div>
            <div class="d-flex justify-content-center mb-3 col-lg-6">
                <iframe src="<?php echo $registro['caminho'] ?>" class="frame" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>

    <?php include_once "geral/js.php" ?>
</body>

</html>