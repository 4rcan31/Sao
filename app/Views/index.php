<?php

inithtml();


html('s', [
    'lang' => 'en'
]);

headRemast('Home', requires([
    'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css'
]));


    div('s');
        h1('s'); 
            print('Esto es un h1');
        h1('e');
    div('e');



div('s', [
    'class="container" id="NameId"'
]);

div('e');




html('e');



