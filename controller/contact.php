<?php

namespace Goteo\Controller {

    use Goteo\Library\Page,
        Goteo\Core\Error,
        Goteo\Core\Redirection,
        Goteo\Core\View,
        Goteo\Library\Text,
        Goteo\Library\Message,
        Goteo\Library\Mail,
        Goteo\Library\Template;

    class Contact extends \Goteo\Core\Controller {
        
        private static $ips = array(
            '199.15.233.142',
            '208.177.76.7',
            '208.177.76.8',
            '88.190.61.93',
            '88.190.61.104',
            '91.207.5.46'
        );
        
        public function index () {

            if (in_array($_SERVER['HTTP_X_FORWARDED_FOR'], self::$ips)) {
                @mail('goteo-contactspam@doukeshi.org', 'Unauthorized', 'Este Post: <pre>'.print_r($_POST, 1).'</pre> <hr /> esta sesión: <pre>'.print_r($_SESSION, 1).'</pre> <hr /> estas variables de servidor: <pre>'.print_r($_SERVER, 1).'</pre>');
                throw new Error(Error::UNAUTHORIZED, 'Unauthorized');
            }
            
            $tags = array();
            $rawTags = Text::get('contact-form-tags');
            $listTags = explode(';', $rawTags);
            foreach ($listTags as $pair) {
                $pair = trim($pair);
                if (empty($pair)) continue;
                $pairTag = explode(']', $pair);
                $keyTag = trim(str_replace(array('[', '<br />'), '', $pairTag[0]));
                $tags[$keyTag] = trim($pairTag[1]);
            }

            $errors = array();

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {

                // verificaciones temporales para el tema spam
                if (NODE_ID == 'euskadi') {
                    @mail('goteo-contactspam@doukeshi.org', 'Formulario de contacto', 'Este Post: <pre>'.print_r($_POST, 1).'</pre> <hr /> esta sesión: <pre>'.print_r($_SESSION, 1).'</pre> <hr /> estas variables de servidor: <pre>'.print_r($_SERVER, 1).'</pre>');
                }
                
                // verificamos referer
                $URL = (NODE_ID != GOTEO_NODE) ? NODE_URL : SITE_URL;
                $referer = $URL.'/contact';
                
                // verificamos token
                if (!isset($_POST['msg_token']) || $_POST['msg_token']!=$_SESSION['msg_token'] || $_SERVER['HTTP_REFERER']!=$referer) {
                    header("HTTP/1.1 400 Bad request");
                    die('Token incorrect');
                }

                $name = $_POST['name'];

                // si falta mensaje, email o asunto, error
                if(empty($_POST['email'])) {
                    $errors['email'] = Text::get('error-contact-email-empty');
                } elseif(!\Goteo\Library\Check::mail($_POST['email'])) {
                    $errors['email'] = Text::get('error-contact-email-invalid');
                } else {
                    $email = $_POST['email'];
                }

                if(empty($_POST['subject'])) {
                    $errors['subject'] = Text::get('error-contact-subject-empty');
                } else {
                    $subject = $_POST['subject'];
                }

                if(empty($_POST['message'])) {
                    $errors['message'] = Text::get('error-contact-message-empty');
                } else {
                    $msg_content = \strip_tags($_POST['message']);
                    $msg_content = nl2br($msg_content);
                }

                $data = array(
                        'tag' => $_POST['tag'],
                        'subject' => $_POST['subject'],
                        'name'    => $_POST['name'],
                        'email'   => $_POST['email'],
                        'message' => $_POST['message']
                );

                if (empty($errors)) {

                    // Obtenemos la plantilla para asunto y contenido
                    $template = Template::get(1);

                    // Asunto, añadimos tag
                    $tag = (!empty($_POST['tag'])) ? "[{$_POST['tag']}] " : '';
                    $subject = $tag.$subject;

                    // destinatario
                    if (\defined('NODE_MAIL')) {
                        $to = \NODE_MAIL;
                        $toName = \NODE_NAME;
                    } else {
                        $to = \GOTEO_CONTACT_MAIL;
                        $toName = 'Goteo';
                    }

                    // En el contenido:
                    $search  = array('%TONAME%', '%MESSAGE%', '%USEREMAIL%');
                    $replace = array($toName, $msg_content, $name.' '.$email);
                    $content = \str_replace($search, $replace, $template->text);


                    $mailHandler = new Mail();

                    $mailHandler->to = $to;
                    $mailHandler->toName = $toName;
                    $mailHandler->subject = $subject;
                    $mailHandler->content = $content;
                    $mailHandler->reply = $email;
                    $mailHandler->html = false;
                    $mailHandler->template = $template->id;
                    if ($mailHandler->send($errors)) {
                        Message::Info('Mensaje de contacto enviado correctamente.');
                        $data = array();
                    } else {
                        Message::Error('Ha fallado al enviar el mensaje.');
                    }

                    unset($mailHandler);
                }
            }

            return new View(
                'view/about/contact.html.php',
                array(
                    'data'    => $data,
                    'tags'    => $tags,
                    'errors'  => $errors
                )
            );

        }
        
    }
    
}