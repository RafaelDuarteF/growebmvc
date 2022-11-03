<?php

    namespace MF\phpmailer;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    class Mensagem {
        private $nome;
        private $destino;
        public function __get($attr) {
            return $this->$attr;
        }
        public function __set($attr, $value) {
            $this->$attr = $value;
        }
        
        public function enviarEmail() {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = false;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'growebdev@gmail.com';                     //SMTP username
                $mail->Password   = 'hjpbzwcjoyjzzlaw';                               //SMTP password
                $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('growebdev@gmail.com', 'Groweb Development');
                $mail->addAddress($this->__get('destino'), $this->__get('nome'));     //Add a recipient
                $mail->addReplyTo('growebdev@gmail.com', 'Reply');

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Boas vindas.';
                $mail->Body    = 'Seja bem vindo ao groweb, ' . $this->__get('nome') . '.';
                $mail->AltBody = 'Seja bem vindo ao groweb.' . $this->__get('nome') . '.';

                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }



?>