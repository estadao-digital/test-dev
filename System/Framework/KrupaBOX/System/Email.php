<?php

class Email
{
    protected static $CI = null;
    protected static $blackListedEmailDomains = null;

    protected $host = "localhost";
    protected $port = 587;

    protected $username = "root";
    protected $password = "root";

    protected $isSmtp     = true;
    protected $smtpAuth   = true;
    protected $smtpSecure = "tls";

    protected $isHtml   = true;
    protected $subject  = "(no subject)";

    protected $body     = "";
    protected $bodyHtml = "";
    protected $bodyAlt  = "";

    protected $emailFrom     = "mailer@localhost";
    protected $emailFromName = null;
    protected $addresses     = null;
    protected $addressesBcc  = null;

    protected $gateway = "PHPMailer";

    public function __construct($host = null, $username = null, $password = null)
    {
        $this->addresses    = Arr();
        $this->addressesBcc = Arr();

        $host     = stringEx($host)->toString();
        $username = stringEx($username)->toString();
        $password = stringEx($password)->toString();

        if (!stringEx($host)->isEmpty())     $this->host = $host;
        if (!stringEx($username)->isEmpty()) $this->username = $username;
        if (!stringEx($password)->isEmpty()) $this->password = $password;
    }

    protected static function getCI()
    {
        if (self::$CI == null)
            self::$CI = \CodeIgniter::getInstance();

        self::$CI->load->library('email');
        return self::$CI;      
    }

    public function __set($key, $value)
    {
        if ($key == host)
            $this->host = stringEx($value)->toString();
        elseif ($key == port)
        {
            $this->port = intEx($value)->toInt();
            if ($this->port <= 0) $this->port = 587;
        }
        elseif ($key == isSmtp)
            $this->isSmtp = boolEx($value)->toBool();
        elseif ($key == smtpAuth)
            $this->smtpAuth = boolEx($value)->toBool();
        elseif ($key == smtpSecure)
        {
            $value = stringEx($value)->toString();
            if ($value == tls || $value == ssl || $value == "")
                $this->smtpSecure = $value;
        }
        elseif ($key == isHtml)
            $this->isHtml = boolEx($value)->toBool();
        elseif ($key == subject)
            $this->subject = stringEx($value)->toString();
        elseif ($key == body)
            $this->body = stringEx($value)->toString();
        elseif ($key == bodyHtml)
            $this->bodyHtml = stringEx($value)->toString();
        elseif ($key == bodyAlt)
            $this->bodyAlt = stringEx($value)->toString();
        elseif ($key == gateway)
        {
            $value = stringEx($value)->toString();
            if ($value == "PHPMailer" || $value == "CodeIgniter")
                $this->gateway = $value;
        }
    }

    public function fromEmail($email, $name = null)
    {
        $email = stringEx($email)->toString();
        $name  = stringEx($name)->toString();

        $this->emailFrom = $email;
        if (stringEx($name)->isEmpty())
            $this->emailFromName = null;
        else $this->emailFromName = $name;
    }

    public function from($email, $name = null)
    { return $this->fromEmail($email, $name); }

    public function toEmail($email, $name = null)
    {
        $email = stringEx($email)->toString();
        if (stringEx($email)->isEmpty()) return null;

        $name = stringEx($name)->toString();
        if (stringEx($name)->isEmpty()) $name = null;
        $this->addresses->addKey($email, $name);
    }

    public function to($email, $name = null)
    { return $this->toEmail($email, $name); }

    public function toEmailBCC($email, $name = null)
    {
        $email = stringEx($email)->toString();
        if (stringEx($email)->isEmpty()) return null;

        $name = stringEx($name)->toString();
        if (stringEx($name)->isEmpty()) $name = null;
        $this->addressesBcc->addKey($email, $name);
    }

    public function send()
    {
        if ($this->gateway == "PHPMailer")
            return $this->sendByPHPMailer();

        return Arr([error => INTERNAL_SERVER_ERROR, success => false]);
    }

    protected function sendByPHPMailer()
    {
        \KrupaBOX\Internal\Library::load("PhpMailer");

        $mail = new \PHPMailer();
        $mail->CharSet = "UTF-8";

        if ($this->isSmtp == true)
            $mail->isSMTP();

        $mail->Host       = $this->host;
        $mail->Port       = $this->port;
        $mail->SMTPAuth   = $this->smtpAuth;
        $mail->Username   = $this->username;
        $mail->Password   = $this->password;
        $mail->SMTPSecure = $this->smtpSecure;
		
		if ($this->isSmtp == true)
			$mail->SMTPOptions = array('ssl' => array('verify_peer'  => false, 'verify_peer_name'  => false, 'allow_self_signed' => true));

        $mail->From = $this->emailFrom;
        if ($this->emailFromName != null)
            $mail->FromName = $this->emailFromName;

        foreach ($this->addresses as $email => $name)
            if ($name != null)
                $mail->addAddress($email, $name);
            else $mail->addAddress($email);

        $mail->Subject = $this->subject;

        if ($this->bodyAlt != null && $this->bodyAlt != "" && $this->bodyHtml != null && $this->bodyHtml != "")
        {
            $mail->Body    = $this->bodyHtml;
            $mail->BodyAlt = $this->bodyAlt;
        }
        else
        {
            $mail->Body = $this->body;

            if ($this->bodyAlt != null && $this->bodyAlt != "")
                $mail->BodyAlt = $this->bodyAlt;
            else $mail->BodyAlt = $this->body;
        }

        $mail->isHTML($this->isHtml);

        foreach ($this->addressesBcc as $email => $name)
            if ($name != null)
                $mail->addBCC($email, $name);
            else $mail->addBCC($email);

        if(!$mail->Send())
            return Arr([error => $mail->ErrorInfo, success => false]);

        return Arr([error => null, success => true]);
    }

    public static function isValidAddress($email, $checkSendable = false, $checkBlacklist = false)
    {
        $email = stringEx($email)->toString();
        
        $CI = self::getCI();
        $CI->load->helper('email');

        $validEmail = null;
        if (function_exists("valid_email"))
            $validEmail = @valid_email($email);
        else $validEmail = (filter_var($email, FILTER_VALIDATE_EMAIL) !== false);

        if ($validEmail == false) return false;
        if ($checkSendable == true && self::isAddressSendable($email) == false)  return false;
        if ($checkBlacklist == true && self::isAddressBlackListed($email) == true) return false;

        return true;
    }


    protected static function userFromEmail($email)
    {
        $parts = explode('@', $email);
        if (count($parts) == 2)
            return strtolower($parts[0]);
        return null;
    }

    protected static function hostnameFromEmail($email)
    {
        $parts = explode('@', $email);
        if (count($parts) == 2)
            return strtolower($parts[1]);
        return null;
    }

    public static function isAddressSendable($email)
    {
        if (!self::isValidAddress($email)) return false;
        $hostname = self::hostnameFromEmail($email);
        if ($hostname)  return checkdnsrr($hostname, 'MX');
        return null;
    }

    public static function isAddressBlackListed($email)
    {
        if (self::$blackListedEmailDomains == null) {
            self::$blackListedEmailDomains = Arr();
            $blackListPath = (__KRUPA_PATH_INTERNAL__ . "System/Email/blacklisted.domains.conf");
            if (\File::exists($blackListPath))
            {
                $mailDomainsKO = file($blackListPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $mailDomainsKO = array_fill_keys($mailDomainsKO, true);
                self::$blackListedEmailDomains = Arr($mailDomainsKO);
            }
        }

        $hostName = self::hostnameFromEmail($email);
        return self::$blackListedEmailDomains->containsKey($hostName);
    }

   
}