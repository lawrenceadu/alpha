<?php
    /*
    * this is the base controller
    * this loads the model and views
    */
namespace App\Lib;

use App\Models as Model;
class Base
{

    public function __construct()
    {
        
    }

    public function model($model)
    {
        $parts = explode("\\", $model);
        $m     = end($parts);

        // require model file
        require_once dirname(__dir__)."/models/{$m}.php";
        return new $model();
    }

    public function view($view, $data = [])
    {
        extract($data, EXTR_PREFIX_SAME, "wddx");
        if (file_exists(dirname(__dir__)."/views/{$view}.php"))
            include_once dirname(__dir__)."/views/{$view}.php";
        else
            include_once dirname(dirname(__dir__))."/public/html/404.html";
    }

    public function file_upload($path, $file, $file_category = "image")
    {
        // get file details
        $name = strtolower(strtotime(date("Y-m-d H:i:s")).'_'.str_replace(" ", "",$file["name"]));
        $temp = $file["tmp_name"];
        $size = $file["size"];

        $target_dir     =   $path;                                                  // destination path
        $target_file    =   $target_dir . basename($name);                    // destination file
        $upload_ok      =   true;                                                      // upload checker
        $file_type      =   strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // file type


        echo $target_file;
            
        if (!file_exists($path)):
            mkdir($path, 0777, true);
        endif;
        
        // Check if file already exists
        if (file_exists($target_file)) {
            return [true, $name];
        }
        // Check file size
        if ($size > 10000000) {
            return [false, "file too big"];
        }
        // Allow certain file formats
        switch ($file_category) {
            case 'image':
                $extensions = ['jpg', 'jpeg', 'png', 'gif'];
                break;
            
            case 'audio':
                $extensions = ['wav', 'mp3', 'ogg', 'wav', 'm4a'];
                break;
        }

        if (!in_array($file_type, $extensions)) {
            return [false, $name." format not acceptable"];
        }
        // Check if $upload_ok is set to 0 by an error
        if (move_uploaded_file($temp, $target_file)) {
            return [true, $name];
        } else {
            return [false, "Wasn't able to upload {$file_category}"];
        }
    }

    public function sendmail($emails, $subject, $message, $view)
    {

        // headers
        $headers    =   "From: " . strip_tags("no-reply@klikgh.com") . "\r\n";
        $headers    .=  "MIME-Version: 1.0\r\n";
        $headers    .=  "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if (is_array($emails)) :
            foreach ($emails as $email) {
                if (isset($email) && !empty($email)) :
                    mail($email, $subject, $this->email_template($message, $view), $headers);
                endif;
            };
        else :
                mail($emails, $subject, $this->email_template($message, $view), $headers);
        endif;
    }

    public function email_template($message, $view)
    {
        ob_start();
        include dirname(__dir__)."/views/mailers/{$view}.html.php";
        $template = ob_get_clean();
        return $template;
    }


    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public function objectify($array){
        return \json_decode(\json_encode($array));
    }

    public function return($code, $return)
    {
        http_response_code($code);
        echo json_encode($return);

        exit();
    }
    
    public function image_path($path_to_image)
    {
        return __URLROOT__.'/public/assets/img/' . $path_to_image;
    }

    public function permit($parent, $permitables, $array)
    {
        $permits = [];

        foreach ($permitables as $key => $permitable) {
            $permits[$permitable] = $array[$parent][$permitable];
        }

        return $permits;
    }
}
