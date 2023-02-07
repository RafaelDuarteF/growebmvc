<?php
     namespace App\Models;
     use MF\Model\Model;
     class Plano_user extends Model {
        private $codPlano;
        private $codPlanoUser;
        private $idUser;
        private $valorAdicional;
        public function __get($attr) {
            return $this->$attr;
        }
        public function __set($attr, $value) {
            $this->$attr = $value;
        }
        public function verificarProjetos () {
            if(!empty($this->__get('idUser'))) {
                try {
                    $query = "SELECT pu.codPlano as codPlano, pu.valorAdicional as valorAd, p.valorInicial as valorIni, p.nomePlano as nomePlano, p.descricao as descricaoPlano FROM plano_user as pu INNER JOIN plano as p on pu.codPlano = p.codPlano WHERE pu.idUser = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindValue(':id', $this->__get('idUser'));
                    $stmt->execute();
                    $infoProjeto = $stmt->fetch(\PDO::FETCH_ASSOC);
                    return $infoProjeto;
                } catch (\PDOException $e) {
                    return false;
                }
            }
            else {
                return false;
            }
        }
     }

?>