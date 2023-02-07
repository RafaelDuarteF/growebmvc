<?php
     namespace App\Models;
     use MF\Model\Model;
     class Plano extends Model {
        private $codPlano;
        private $valorInicial;
        private $descricao;
        private $nomePlano;
        private $direitosPlano;
        public function __get($attr) {
            return $this->$attr;
        }
        public function __set($attr, $value) {
            $this->$attr = $value;
        }
        public function verificarPlano() {
            if(!empty($this->__get('codPlano'))) {
                try {
                $query = "SELECT valorInicial, descricao, nomePlano, direitosPlano FROM plano WHERE codPlano = :cod";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':cod', $this->__get('codPlano'));
                $stmt->execute();
                $plano = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $plano;
                } catch (\PDOException $e) {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        public function verificarTodosPlanos() {
            $query = "SELECT * FROM plano";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $planos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $planos;
        }
     }
 ?>