<?php


function view($html, $data = [], $route = '', $format = 'php'){
    try {
        print("
        <!--
            Powered by Sao
            GitHub: https://github.com/4rcan31/Sao
        
            Developed by: 4rcane31
        -->    
        ");
        core('Views', false);
        ViewData::setData($data);
        // Asegúrate de que $route esté configurado correctamente según tus necesidades.
        $viewPath = empty($route) ? "Views/$html.$format" : "$route/$html.$format";
        import($viewPath, false);
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}


function route($route, $print = true){
    return $print ? 
    print(routePublic(trim($route, '/'))) :
    routePublic(trim($route, '/'));
}


function Form(){
    core('Views/Notifier.php', false);
}