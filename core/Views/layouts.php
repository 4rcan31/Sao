<?php
function importAllLayouts(){
    import('layouts', false, 'app/Views/layouts');
}


function importLayout($file, $format = 'php'){
    require_once dirname(__DIR__, 2)."/app/Views/layouts/".$file.".".$format;
}


