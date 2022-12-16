<?php 



class Sao{
    protected $path;

    function __construct($path){
        $this->path = $path;
    }

    //Start Autoloader
    public function run(){
        $this->runAppAutoloaderComposer();
        $this->runAppConfig();
        $this->runAppHelpers();
        $this->runAppHttp();
        $this->runAppRouting();
        $this->runAppApp();
        $this->runAppWeb();
    }
    //End Autoloader

 
    //Start app Http
    private function runAppHttp(){
        $this->runAppRequest();
        $this->runAppReponse();
        $this->runAppCookies();
    }
    private function runAppRequest(){
        include($this->path.'/core/Http/request.php');
        request()->capture();
    }
    private function runAppReponse(){
        include($this->path.'/core/Http/reponse.php');
    }
    private function runAppCookies(){
        include($this->path.'/core/Http/cookies.php');
    }
    //End app Http

    private function runAppRouting(){
        import('middlewares', false);
        include($this->path.'/core/Routing/router.php');
    }

    private function runAppConfig(){
        include($this->path.'/Config/app.php');
    }

    private function runAppHelpers(){
        include($this->path.'/core/Helpers/helpers.php');
    }


    //Star App App
    private function runAppApp(){
        $this->runAppController();
        $this->runAppModel();
    }
    private function runAppController(){
       include($this->path.'/core/Controller/baseController.php');
    
    }
    private function runAppModel(){
        include($this->path.'/core/DataBase/ORM/orm.php'); //Esto no estoy muy seguro si es optimo, por que implica llamar al orm en cada peticion 
        include($this->path.'/core/Model/baseModel.php');
    }
    //End App App


    private function runAppWeb(){
        include($this->path.'/routes/web.php'); 
        Router::run();
    }




    //Composer start app
    private function runAppAutoloaderComposer(){
        include($this->path.'/vendor/autoload.php');
        $this->runAppVendorDotenv();
    }

    private function runAppVendorDotenv(){
        $dotenv = Dotenv\Dotenv::createImmutable($this->path);
        $dotenv->load();
    }
    //Composer end   app

}