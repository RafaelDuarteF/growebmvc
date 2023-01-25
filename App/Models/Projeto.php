<?php
    namespace App\Models;
    use MF\Model\Model;
    class Projeto extends Model {
        private $nome;
        private $situacao;
        private $previsaoEntrega;
        private $atualizacao;
        private $path;
        private $idUser;
        private $codProjeto;
        private $dataAtualizacao;

        public function __get($attr) {
            return $this->attr;
        }
        public function __set($attr, $value) {
            $this->attr = $value;
        }
        public function retornarProjeto () {
            $query = "SELECT * FROM projeto WHERE idUser = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('idUser'));
            $stmt->execute();
            $infosProj = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $infosProj;
        }
    }