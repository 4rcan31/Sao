<?php 



class Sao{
    protected $path;


    function __construct($path){
        $this->path = $path;
    }

    //Start Autoloader
    public function run(){
        $this->runAppSession();
        $this->runAppHelpers();
        $this->runAppSaoHelpers();
        $this->runAppAutoloaderComposer();
        $this->runAppServe();
        $this->runAppHttp();
        $this->runAppRouting();
        $this->runAppAuth();
        $this->runAppApp();
        $this->runAppRoutes();
        exit;
    }
    //End Autoloader

 
    //Start app Http
    private function runAppHttp(){
        $this->runAppRequest();
        $this->runAppResponse();
        $this->runAppCookies();
    }
    private function runAppRequest(){
        import('Http/request.php', false, '/core');
        Request::capture($this->path);
    }
    private function runAppResponse(){
        import('Http/response.php', false, '/core');
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
        include($this->path.'/core/Helpers/files.php');
        include($this->path.'/core/Helpers/array.php');
        include($this->path.'/core/Helpers/object.php');
        include($this->path.'/core/Helpers/string.php');
        include($this->path.'/core/Helpers/print.php');
    }

    private function runAppSaoHelpers(){
        include($this->path.'/core/Helpers/sao/import.php');
        include($this->path.'/core/Helpers/sao/controller.php');
        include($this->path.'/core/Helpers/sao/core.php');
        include($this->path.'/core/Helpers/sao/model.php');
        include($this->path.'/core/Helpers/sao/response.php');
        include($this->path.'/core/Helpers/sao/server.php');
        include($this->path.'/core/Helpers/sao/validate.php');
        include($this->path.'/core/Helpers/sao/view.php');
    }


    private function runAppAuth(){
        core('Auth/auth.php', false); //Esto no se si es eficiente, por que no todos los middlewares requieren de una session
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
        //NOTA: No puede existir un grupo que no contenga por lo menos una ruta, o que contega solamente un grupo
        Route::group(function(){ // Hay un grupo por default que engloba todas las rutas que se definen por el usuario, esto es por que da error si no lo hago
            import('routes', false, '/app'); //Aca se importan todas las rutas definidas
        });
        Route::run(); // Ejecuto la app de ruteo con todas las rutas ya definidas
    }

    private function runAppServe(){
        import('server/server.php', false, '/core');
    }



    private function runAppSession(){
        session_name('SAOSESSID');
        session_start();
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