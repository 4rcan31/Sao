<?php 



class Sao{
    protected $path;


    function __construct($path){
        $this->path = $path;
    }

    //Start Autoloader
    public function run(){
        $this->runAppHelpers();
        $this->runAppAutoloaderComposer();
        $this->runAppHttp();
        $this->runAppRouting();
        $this->runAppApp();
        $this->runAppRoutes();
    }
    //End Autoloader

 
    //Start app Http
    private function runAppHttp(){
        $this->runAppRequest();
        $this->runAppReponse();
        $this->runAppCookies();
    }
    private function runAppRequest(){
        import('Http/request.php', false, '/core');
        Request::capture();
    }
    private function runAppReponse(){
        import('Http/reponse.php', false, '/core');
    }
    private function runAppCookies(){
        import('Http/cookies.php', false, '/core');
    }
    //End app Http

    private function runAppRouting(){
        import('middlewares', false);
        import('Routing/router.php', false, '/core');
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
        import('Controller/baseController.php', false, '/core');
    }
    private function runAppModel(){
      //  include($this->path.'/core/DataBase/ORM/orm.php'); //Esto no estoy muy seguro si es optimo, por que implica llamar al orm en cada peticion 
        import('Model/baseModel.php', false, '/core');
    }
    //End App App

    private function runAppRoutes(){
        Route::group(function(){ // Hay un grupo por default que engloba todas las rutas que se definen por el usuario, esto es por que da error si no lo hago
            import('routes', false, '/'); //Aca se importan todas las rutas definidas
        });
        Route::run(); // Ejecuto la app de ruteo con todas las rutas ya definidas
    }




    //Composer start app
    private function runAppAutoloaderComposer(){
        import('autoload.php', false, '/vendor');
        $this->runAppVendorDotenv();
    }

    private function runAppVendorDotenv(){
        Dotenv\Dotenv::createImmutable($this->path)->load(); //Cargo la libreria de Dotenv para leer archivos env
    }
    //Composer end   app

}