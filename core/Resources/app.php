<?php
class File {

    //Server vars
    public static $basePath = "";
    public static $host = "";


    //File request vars
    public static $nameFile = "";
    public static $routeFile = "";
    public static $format = "";
    public static $fullPath = "";
    public static $type = "";
    public static $imageUpload = "";
    public static $error = "";
    public static $size = "";
    public static $file;
    public static $pathHostUpload = "";
    public static $routeHostUpload = "";

    //Secure vars
    public static $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    public static $safeMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    public static function setAllowedFormats(array $formats){
        self::$allowedFormats = $formats;
    }
    public static function setSafeMimeTypes(array $mimes){
        self::$safeMimeTypes = $mimes;
    }
    public static function setBasePath(string $path){
        self::$basePath = $path;
    }
    public static function setHost(string $host){
        self::$host = $host;
    }

    public static function setFile(array|object $file, $host = null) {
        self::$host = $host === null ? serve($_ENV['APP_ADDRESS'].":".$_ENV['APP_PORT']) : $host;
        self::$nameFile = $file['name'];
        self::$fullPath = $file['full_path'];
        self::$type = $file['type'];
        self::$imageUpload = $file['tmp_name'];
        self::$error = $file['error'];
        self::$size = $file['size'];
        self::$file = $file;
        self::$format = strtolower(pathinfo(self::$nameFile, PATHINFO_EXTENSION));
        if (!self::isSafeMimeType(self::$type)) {
            return false;
        }
        if(!self::isAllowedFormat(self::$format)){
            return false;
        }
        return true;
    }

    public static function upload($nameFile = null, $ruteServer = 'public/uploads', $ruteHost = '/uploads') {
        if (!in_array(self::$format, self::$allowedFormats)) {
            return false; // Formato no permitido
        }
        self::$nameFile = $nameFile == null ? token() . "." . self::$format : self::$nameFile;
        self::$routeFile = self::$basePath . '/' . ltrim($ruteServer, '/')."/"; //Esta es la ruta en el servidor (sin el file)
        self::$routeHostUpload = '/' . ltrim($ruteHost, '/')."/".self::$nameFile; //Esto es la ruta en el servidor (sin el host)
        self::$pathHostUpload = self::$host."/".self::$routeHostUpload; //Esta es la ruta en el host (toda la ruta)
        return move_uploaded_file(self::$imageUpload, self::$routeFile . self::$nameFile);
    }

    public static function deleteThis() {
        if (!empty(self::$routeFile) && !empty(self::$nameFile)) {
            $filePath = self::$routeFile . self::$nameFile;
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function deleteNameAndPath($fileName, $relativePath) {
        $filePath = self::$basePath . '/' . ltrim($relativePath, '/') . '/' . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
            return true; 
        } else {
            return false;
        }
    }

    public static function delete($filePath, $dir) {
        $filePath = self::$basePath . '/'.ltrim($dir, '/') ."/". ltrim($filePath, '/');
        if (file_exists($filePath)) {
            unlink($filePath); 
            return true;
        } else {
            return false;
        }
    }

    public static function isInDirectory($file, $directory) {
        $file = realpath($file);
        $directory = realpath($directory);
    
        if ($file === false || $directory === false) {
            return false; // Al menos una de las rutas no es válida
        }
    
        // Comprobar si $file está dentro de $directory o es igual a $directory
        return strpos($file, $directory) === 0;
    }
    
    
    
    

    public static function lastFileUploadInfo(string $input) {
        if ($input == 'name') {
            return self::$nameFile;
        } elseif ($input == 'path:updload') {
            return self::$routeFile;
        }else if($input == 'host:upload'){
            return self::$pathHostUpload;
        }else if($input == 'rute:upload'){
            return self::$routeHostUpload;
        }
        return get_object_vars(new self());
    }

    private static function isSafeMimeType($mime) {
        return in_array($mime, self::$safeMimeTypes);
    }

    private static function isAllowedFormat($format){
        return in_array($format, self::$allowedFormats);
    }
}
