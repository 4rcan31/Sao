<?php 


class run{

    protected $path;
    public array $args;



    function __construct($path, $args){
        $this->path = $path;
        $this->args = $args;
    }


    public function run(){
        $this->runAppHelpers();
        $this->runAppSaoHelpers();
        $this->runAppAutoloaderComposer();
        $this->runAppDataBase();
        $this->runAppTest();
        $this->runAppConsole();
        exit;
    }

    private function runAppHelpers(){
        include($this->path.'/core/Helpers/files.php');
        include($this->path.'/core/Helpers/array.php');
        include($this->path.'/core/Helpers/object.php');
        include($this->path.'/core/Helpers/string.php');
        include($this->path.'/core/Helpers/print.php');
        include($this->path.'/core/Helpers/console.php');
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

    private function runAppTest(){
        include($this->path."/core/Testing/Test.php");
    }

    private function runAppDataBase(){
        include($this->path.'/core/DataBase/ORM/orm.php');
        include($this->path.'/core/DataBase/Migrations/app.php');
    }

    private function runAppCommandsSao(){
        include($this->path.'/core/Console/commands/help.php');
        include($this->path.'/core/Console/commands/database.php');
        include($this->path.'/core/Console/commands/server.php');
        include($this->path.'/core/Console/commands/string.php');
    }

    private function runAppCommands(){
        include($this->path.'/app/Console/console.php');
    }


    private function runAppConsole(){
        include($this->path."/core/Console/console.php");
        $this->runAppCommandsSao();
        $this->runAppCommands();
        Jenu::set($this->args);
        Jenu::run();
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