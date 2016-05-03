<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Core;

class MailUtils
{
	/**
	 * @var string
	 * Correo remitente
	 */
	private $from;

	/**
	 * @var string
	 * Correo destinatario
	 */
	private $to;

	/**
	 * @var string
	 * Asunto del email
	 */
	private $title;

	/**
	 * @var string
	 * Texto o cuerpo html del mensaje
	 */
	private $message;

	/**
	 * @var bool
	 * Valor booleano que indica si es texto plano (false) o texto html (true)
	 */
	private $is_html;

	/**
	 * @var string
	 * Codificacion del mensaje
	 */
	private $encoding;

	/**
	 * @var string
	 * Caveceras extra del mensaje
	 */
	private $extra_headers;

    /**
     * @var bool
     * Valor booleano que indica si se debe limpiar el mensaje (true) o no (false)
     */
	private $clean_msg;

    /**
     * @var array
     * valores para llenado de un template
     */
	private $template_keys;

    /**
     * @var string
     * Email de respuesta
     */
	private $reply_to;


    /**
     * MailUtils constructor.
     * @param array|null $config
     */
	public function __construct(array $config = null)
    {
		$this->from = '';
		$this->to = '';
		$this->title = '';
		$this->message = '';
		$this->is_html = false;
		$this->encoding = 'iso-8859-1';
		$this->extra_headers = '';
		$this->clean_msg = false;
		$this->template_keys = array();
		$this->reply_to = '';

		if(!empty($config)){
            foreach($config as $key => $value){
				if(isset($this->$key)){
					$this->$key = $value;
				}
			}
        }
	}


	/**
	 * @param $key
	 * @return mixed
	 * Getter´s de clase
	 */
	public function __get($key)
    {
		return $this->$key;
	}


	/**
	 * @param $key
	 * @param $value
	 * Setter's de clase
	 */
	public function __set($key, $value)
    {
		$this->$key = $value;
	}


    /**
     * Limpia y separa el mensaje en renglones de 100 caracteres agregando un salto de line entre ellos
     */
	public function cleanupMessage()
    {
		$this->message = wordwrap($this->message, 100, "\r\n");
	}


	/**
	 * @param $template
	 * @return bool
	 * Procesa un Template para crear el cuerpo del mensaje
	 * Requiere que antes se inicialize la variable $template_keys
	 */
	public function fromTemplate($template)
    {
		if (file_exists($template)) {
			$gettemplate = file_get_contents($template);

			foreach ($this->template_keys as $key => $value) {
				$gettemplate = str_replace($key, $value, $gettemplate);
			}

			$this->message = $gettemplate;
			return true;
		}

		return false;
	}


	/**
	 * @return bool
	 * Envia un email en formato de texto plano
	 */
	private function sendPlain()
    {
		$headers = 'From: '.$this->from."\r\n".
				   'Reply-to: '.$this->reply_to."\r\n".
				   $this->extra_headers;

		return mail($this->to, $this->title, $this->message, $headers);

	}


	/**
	 * @return bool
	 * Envia un email en formato HTML
	 */
	private function sendHTML()
    {
		$headers = 'From: '.$this->from."\r\n".
				   'Reply-to: '.$this->reply_to."\r\n".
				   'MIME-Version: 1.0' . "\r\n".
				   'Content-type: text/html; charset='.$this->encoding."\r\n".
				   $this->extra_headers;
				   
		return mail($this->to, $this->title, $this->message, $headers);
	}


	/**
	 * @return bool
	 * Ejecuta el envio de email dependiendo de el tipo de mensaje a enviar
	 */
	public function sendEmail()
    {
		if ($this->is_html) {
			return $this->SendHTML();
		} else {
			return $this->SendPlain();
		}
	}


	/**
	 * @param string $email
	 * @return bool
	 * Comprueba la valides de un Email
	 */
	public function validarMail($email)
    {
		$mail_correcto = 0;

		if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){

		  if ((!strstr($email,"'")) && (!strstr($email,'/')) && (!strstr($email,"\$")) && (!strstr($email," "))){
			  if (substr_count($email,".")>= 1){
				$term_dom = substr(strrchr ($email, '.'),1);

				if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){

					$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
					$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
					if ($caracter_ult != "@" && $caracter_ult != "."){
					  $mail_correcto = 1;
					}
				}
			  }
		  }
		}

		if ($mail_correcto){
			return true;
		}else{
			return false;
		}

	}
	
}