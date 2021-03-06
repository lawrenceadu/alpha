<?php
    /*
    * this is the base controller
    * this loads the model and views
    */
namespace App\Lib;

use Illuminate\Support\Str;

class Base
{
    public $twig;
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__DIR__)) . '/app/views');
        $this->twig = new \Twig\Environment($loader);
    }

    public function view($view, $data = [])
    {
        if (file_exists(dirname(__dir__)."/views/{$view}.twig")):
            return $this->twig->render($view . '.twig', $data);
        else:
            require_once dirname(dirname(__dir__))."/public/html/404.html";
        endif;
    }

    public function file_upload($path, $file, $file_category = "image"): Array
    {
        // get file details
        $name = strtolower(Str::random() . '-' .str_replace(" ", "", $file["name"]));
        $temp = $file["tmp_name"];
        $size = $file["size"];

        $target_dir     =   $path;                                                  // destination path
        $target_file    =   $target_dir . basename($name);                    // destination file
        $upload_ok      =   true;                                                      // upload checker
        $file_type      =   strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // file type

            
        if (!file_exists($path)):
            mkdir($path, 0777, true);
        endif;
        
        // Check if file already exists
        if (file_exists($target_file)) {
            return [true, $name];
        }
        // Check file size
        if ($size > 2000000) {
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
            return [false, $file['name']." format not acceptable"];
        }
        // Check if $upload_ok is set to 0 by an error
        if (move_uploaded_file($temp, $target_file)) {
            return [true, $name];
        } else {
            return [false, "Wasn't able to upload {$file_category}"];
        }
    }
}
