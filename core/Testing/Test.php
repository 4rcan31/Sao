<?php

class Test{

    public static function executeAllTest(){
        echo "HOLA buenas estoy en el test y esto funciona!";
        Test::testingRoutes();
    }


    public static function testingRoutes(){
        import('Http/request.php', false, '/core');
        import('Routing/router.php', false, '/core');
        Route::group(function(){
            import('routes', false, '/');
        });
     
       
        var_dump(Route::$routes);
    }

}