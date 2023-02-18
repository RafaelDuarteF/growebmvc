<?php
    namespace App\Models;
    use MF\Model\Model;
    class User extends Model {
        private $nome;
        private $email;
        private $senha;
        private $telefone;
        private $id;
        private $cep;
        private $cidade;
        private $bairro;
        private $logradouro;
        private $userValido = false;
        private $cbConect;

        public function __get($attr) {
            return $this->$attr;
        }
        public function __set($attr, $value) {
            $this->$attr = $value;
        }
        public function validarUsuario() {
            $query = "SELECT nomeUser, email, telefone, id, cep, logradouro, bairro, cidade FROM user WHERE email = :email and senha = :senha";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', md5($this->__get('senha')));
            $stmt->execute();
            $usuarioV = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($usuarioV['nomeUser']) && !empty($usuarioV['email']) && !empty($usuarioV['telefone']) && !empty($usuarioV['id'])) {
                $this->__set('nome', $usuarioV['nomeUser']);
                $this->__set('email', $usuarioV['email']);
                $this->__set('telefone', $usuarioV['telefone']);
                $this->__set('cep', $usuarioV['cep']);
                $this->__set('logradouro', $usuarioV['logradouro']);
                $this->__set('bairro', $usuarioV['bairro']);
                $this->__set('cidade', $usuarioV['cidade']);
                $this->__set('id', $usuarioV['id']);
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
            $emailValidate = $this->validarEmail();
            if(!$usernameValidate && !$emailValidate) {
                if(strlen($this->__get('senha')) < 8 || strlen($this->__get('telefone')) < 11 || strlen($this->__get('cep')) < 8) {
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
        public function getID() {
            $query = "SELECT id FROM user WHERE nomeUser = :nome AND email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            $stmt = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->__set('id', $stmt['id']);
        }
        public function salvar() {
            try {
                $query = "INSERT INTO user(nomeUser, senha, telefone, email, cep, bairro, logradouro, cidade)VALUES(:nome, :senha, :telefone, :email, :cep, :bairro, :logradouro, :cidade)";
                $stmt =  $this->db->prepare($query);
                $stmt->bindValue(':nome', $this->__get('nome'));
                $stmt->bindValue(':senha', md5($this->__get('senha')));
                $stmt->bindValue(':telefone', $this->__get('telefone'));
                $stmt->bindValue(':email', $this->__get('email'));
                $stmt->bindValue(':cep', $this->__get('cep'));
                $stmt->bindValue(':bairro', md5($this->__get('bairro')));
                $stmt->bindValue(':logradouro', $this->__get('logradouro'));
                $stmt->bindValue(':cidade', $this->__get('cidade'));
                $stmt->execute();
                session_start();
                $_SESSION['nome'] = $this->__get('nome');
                $_SESSION['telefone'] = $this->__get('telefone');
                $_SESSION['email'] = $this->__get('email');
                $_SESSION['cep'] = $this->__get['cep'];
                $_SESSION['bairro'] = $this->__get['bairro'];
                $_SESSION['logradouro'] = $this->__get['logradouro'];
                $_SESSION['cidade'] = $this->__get['cidade'];
                $_SESSION['cookiesLogin'] = false;
                $this->getID();
                $_SESSION['id'] = $this->__get('id');
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
        public function restaurarConta() {
            $query = "SELECT nomeUser, email, telefone, id FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":email", $this->__get("email"));
            $stmt->execute();
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->__set("nome", $usuario['nomeUser']);
            $this->__set("email", $usuario['email']);
            $this->__set("telefone", $usuario['telefone']);
            $this->__set("id", $usuario['id']);
        }
        public function validarSenha() {
            $query = "SELECT senha FROM user WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $stmt = $stmt->fetch(\PDO::FETCH_ASSOC);
            $senha = $stmt['senha'];
            return $senha;
        }
        public function alterarDados() {
            try {
                $query = "UPDATE user SET nomeUser = :novoNome, senha = :novaSenha, telefone = :novoTelefone, email = :novoEmail WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':novoNome', $this->__get('nome'));
                $stmt->bindValue(':novaSenha', $this->__get('senha'));
                $stmt->bindValue(':novoTelefone', $this->__get('telefone'));
                $stmt->bindValue(':novoEmail', $this->__get('email'));
                $stmt->bindValue(':id', $this->__get('id'));
                $stmt->execute();
                return 1;
            }
            catch (\PDOException $e) {
                return 0;
            }
        }
    }

?>