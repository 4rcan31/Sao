<?php
function layouts(){
    import('Views/layouts', false);
}


function layout($file, $format = 'php'){
    import("/Views/layouts/$file.$format", false);
}


