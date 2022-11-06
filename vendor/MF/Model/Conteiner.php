<?php
    namespace MF\Model;
    use App\Connection;
    class Conteiner {
        public static function getModel($model) {
            // retornar o modelo selecionado já instanciado e com a conexão estabelecida
            $class = "\\App\\Models\\" . ucfirst($model);
            $conn = Connection::getDb();
            if($conn != false) {
                return new $class($conn);
            }
            else {
                return false;
            }
        }
    }



?>