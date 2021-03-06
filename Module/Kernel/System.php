<?php

$system = new System();

class System extends Controller
{

    public function protect($string)
    {
        $protection = htmlspecialchars(trim($string), ENT_QUOTES);
        return $protection;
    }

    public function xssFix($string){

        $string = $this->protect($string);

        $string = str_replace('<','', $string);
        $string = str_replace('>','', $string);
        $string = str_replace('´','', $string);
        $string = str_replace('[','(', $string);
        $string = str_replace(']',')', $string);
        $string = str_replace("'",'', $string);

        return $string;
    }

    public function getSetting($data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `settings`");
        $SQL->execute();
        $response = $SQL->fetch(PDO::FETCH_ASSOC);
        return $response[$data];
    }

    public function nl2br2($string)
    {
        $string = $this->xssFix($string);
        $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
        return $string;
    }

    public function generateRandomString($length = 10, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function formatDate($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y H:i:s');
    }

}
?>