<?php include_once "geral/acesso.php" ?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once "geral/head.php" ?>
    <title>Documento</title>
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
        }
        ?>
        <div class="d-flex justify-content-center pt-3 pb-2 mb-3 border-bottom">
            <h4 class="h4">
                <?php echo $registro['nome']; ?>
            </h4>
        </div>
        <div class="mb-3">
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
        </div>
        
        <div class="form-row d-flex justify-content-center mb-3">
            <a href="controle/assinatura.php?codigo=<?php echo $registro['codigoDocumento']; ?>&&user=<?php echo $dadosUsuario['codigo']; ?>"
                class="btn btn-success mt-3 <?php foreach ($signatarios as $sig) {
                    if($sig['codUsuario'] == $dadosUsuario['codigo']){
                        if($sig['situacao'] == "Assinado"){
                            echo 'd-none';
                            break;
                        }
                    }
                } ?>">Assinar</a>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <iframe src="<?php echo $registro['caminho'] ?>" frameborder="0" scrolling="no"></iframe>
        </div>
        <div class="d-flex justify-content-center mb-3 pb-3">
            <a href="controle/docAssinado.php?codigo=<?php echo $codigo ?>" class="btn btn-success btn-sm ml-3 mt-2 text-white <?php if ($registro['situacao'] == "Pendente" || $registro['situacao'] == "Recusado" || $registro['situacao'] == "Cancelado") {
                echo 'disabled';
            } ?>">Imprimir
                Assinado</a>
        </div>


    </div>

    <?php include_once "geral/js.php" ?>
</body>

</html>