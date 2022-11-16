<?php







$suma = function ($a, $b) {
    return $a + $b;
};

$resta = function ($a, $b) {
    return $a - $b;
};

function operacion($function, $a, $b){
    echo $function($a, $b);
}






class a{

    public static $request; 

    public function operacion(){
        
    }
}

function agruparPairs(array $array){
   return array_chunk($array, 2);
}

$array = [
    1, 2, 3, 4
];


class b{
    function b(){
        echo "holap desde b";
    }
}

$b = new b;


class c{
    function c(){
         
    }
}

$cesta = [
    ["Pringels",  3, 3],
    ["Vaso",  2, 5],
    ["Teclado Hyper x",  90, 1],
    ["Perfume  Hugo Boss", 45, 2]
];


for($i = 0; $i < count($cesta); $i++){
   array_push($cesta[$i],  $cesta[$i][1]*$cesta[$i][2]);
}

//var_dump($cesta);


/* for($i = 0; count($values) > 0; $i++){
    var_dump($values);
       // array_push($values, $values[$i][1]*$values[$i][2]);
   }
 */



/* for($i = 0; $i <= 50; $i++){

    $num = strval($i);

    for($j = 0; $j < strlen($num); $num++){
        $digit = intval($num[$j]);

        if($digit)
    }
    
}

$a = 44;

echo $a[0];
 */


