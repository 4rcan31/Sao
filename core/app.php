<?php 



class App{
    protected $path;

    function __construct($path){
        $this->path = $path;
    }

    //Start Autoloader
    public function run(){
        $this->runAppConfig();
        $this->runAppHelpers();
        $this->runAppHttp();
        $this->runAppRouting();
        $this->runAppApp();
        $this->runAppApi();
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
        Request::capture();
    }
    private function runAppReponse(){
        include($this->path.'/core/Http/reponse.php');
    }
    private function runAppCookies(){
        include($this->path.'/core/Http/cookies.php');
    }
    //End app Http

    private function runAppRouting(){
        include($this->path.'/core/Routing/router.php');
    }

    private function runAppConfig(){
        include($this->path.'/core/Config/app.php');
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
        include($this->path.'/core/Model/baseModel.php');
    }
    //End App App


    private function runAppApi(){
        include($this->path.'/routes/api.php'); 
    }

}