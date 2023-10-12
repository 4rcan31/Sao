<?php 
function add($p, $etiqueta, $attributes = []){
    if($p == 's'){
        return '<'.$etiqueta." ".attributes($attributes).'>';
    }elseif($p == 'e'){
        return '</'.$etiqueta.'>';
    }
}


function attributes($attributes = []){
    if(empty($attributes)){
        return '';
    }
    $atributter = '';
    foreach($attributes as $atributte => $value){
        if(is_int($atributte)){
            $atributter = $atributter.$value;
        }else{
            $atributter = $atributte.'="'.$value.'" '.$atributter;
        }
        
    }
    return trim($atributter);
}


function headRemast($requires = [], $charter = 'UTF-8', $httpEquiv ='X-UA-Compatible'){
    echo '<head>';
    echo        '<meta charset="'.$charter.'">';
    echo        '<meta http-equiv="'.$httpEquiv.'" content="IE=edge">';
    echo        '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    
    if(!empty($requires)){
        echo        '<link '.implode($requires).'>';
    }
    //echo       ' <title>'.$title.'</title>';
    echo   '</head>';
}

function requires(array $requires, string $type = 'text/javascript'){
    $arrayRequires =[]; 
    for($i = 0; $i < count($requires); $i++){
        $format = format($requires[$i]);
        if($format == "ico"){
             array_push($arrayRequires, '<link rel="icon" href="'.$requires[$i].'" />')."\n";
        }else if($format == "css"){
            array_push($arrayRequires, '<link rel="stylesheet" href="'.$requires[$i].'" />'."\n");
        }else if($format == 'js'){
            array_push($arrayRequires, '<script type="'.$type.'" src="'.$requires[$i].'" ></script>'."\n");
        }
    }
    return $arrayRequires;
 }


 function requiresStaticFiles($files = [], string $type = 'text/javascript'){
    echo implode(requires($files, $type));
}


 function routePublic($route){
    return server()->RouteAbsolute($route);
 }



 function routeAppPublic($route){
    return server()->RouteAbsolute("app/".$route);
 }


 function requireCore(){
    requiresStaticFiles([
        routePublic('core/document.js'),
        routePublic('core/touch.js'),
        routePublic('core/send.js'),
        routePublic('core/cookies.js'),
        routePublic('core/server.js'),
        routePublic('core/string.js')
    ]);
 }

