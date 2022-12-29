<?php
    namespace App\Models;
    use MF\Model\Model;
    class User extends Model {
        private $nome;
        private $email;
        private $senha;
        private $telefone;
        private $userValido = false;
        private $cbConect;

        public function __get($attr) {
            return $this->$attr;
        }
        public function __set($attr, $value) {
            $this->$attr = $value;
        }
        public function validarUsuario() {
            $query = "SELECT nomeUser, email, telefone FROM user WHERE nomeUser = :nome and senha = :senha";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':senha', md5($this->__get('senha')));
            $stmt->execute();
            $usuarioV = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($usuarioV['nomeUser']) && !empty($usuarioV['email']) && !empty($usuarioV['telefone'])) {
                $this->__set('nome', $usuarioV['nomeUser']);
                $this->__set('email', $usuarioV['email']);
                $this->__set('telefone', $usuarioV['telefone']);
                $this->__set('userValido', true);
            }
            else {
                $this->__set('userValido', false);
            }
        }
        public function existsUsername() {
            $query = "SELECT count(nomeUser) as cNome FROM user WHERE nomeUser = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();
            $cNome = $stmt->fetch(\PDO::FETCH_ASSOC)['cNome'];
            if($cNome >= 1 || strlen($this->__get('nome')) < 4) {
                return true;
            }
            else {
                return false;
            }
        }
        public function validarCadastro() {
            $usernameValidate = $this->existsUsername();
            if(!$usernameValidate) {
                if(strlen($this->__get('senha')) < 8 || strlen($this->__get('telefone')) < 11) {
                    return false;
                }
                else {
                    return true;
                }
            }
            else {
                return false;
            }
        }
        public function salvar() {
            try {
                $query = "INSERT INTO user(nomeUser, senha, telefone, email)VALUES(:nome, :senha, :telefone, :email)";
                $stmt =  $this->db->prepare($query);
                $stmt->bindValue(':nome', $this->__get('nome'));
                $stmt->bindValue(':senha', md5($this->__get('senha')));
                $stmt->bindValue(':telefone', $this->__get('telefone'));
                $stmt->bindValue(':email', $this->__get('email'));
                $stmt->execute();
                session_start();
                $_SESSION['nome'] = $this->__get('nome');
                $_SESSION['telefone'] = $this->__get('telefone');
                $_SESSION['email'] = $this->__get('email');
                $_SESSION['cookiesLogin'] = false;
               header("Location: /");
            } catch(\PDOException $e) {
                header("Location: /?erroCadastro=true");
            }
        }
        public function logWithCookies() {
            $query = "SELECT nomeUser, email, telefone FROM user WHERE nomeUser = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($usuario['nomeUser'])) {
                $_SESSION['nome'] = $usuario['nomeUser'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['telefone'] = $usuario['telefone'];
                $_SESSION['cookiesLogin'] = true;
                return true;
            }
            return false;
        }
        public function validarEmail() {
            $query = "SELECT count(nomeUser) as quantEmail FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            $countUser = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($countUser['quantEmail'] > 0) {
                return true;
            }
            else {
                return false;
            }
        }
    }

?>