<?php
if (isset($_GET['result'])) {
    $result = $_GET['result'];
    $alertClass = ($result == 1) ? 'alert-success' : 'alert-danger';
    $alertMessage = ($result == 1) ? 'Registro salvo com sucesso!' : 'Error';
    ?>
    <div id="alerta" class="alert <?php echo $alertClass; ?> alert-dismissible fade show mt-2" role="alert">
        <?php echo $alertMessage; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var alertDiv = document.getElementById('alerta');

            // Adiciona a classe "show" ao alerta para exibi-lo
            alertDiv.classList.add('show');

            // Esconde o alerta suavemente após 3 segundos
            setTimeout(function () {
                // Adiciona a classe "fade" para criar uma transição suave
                alertDiv.classList.add('fade');
                // Remove a classe "show" para ocultar o alerta
                alertDiv.classList.remove('show');

                // Aguarda o término da transição antes de adicionar a classe "d-none"
                setTimeout(function () {
                    // Adiciona a classe "d-none" para ocultar o alerta
                    alertDiv.classList.add('d-none');
                }, 500); // Tempo correspondente à duração da transição em milissegundos
            }, 1000);
        });
    </script>
    <?php
}

    
    function sucesso($pagina){
        echo  "<script>window.location.replace('../".$pagina."?result=1');</script>";
    }
    function error($pagina){
        echo  "<script>window.location.replace('../".$pagina."?result=2');</script>";
    }