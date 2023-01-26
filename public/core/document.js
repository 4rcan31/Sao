

function hide(elementId){
    document.getElementById(elementId).style.display = 'none';
}

function show(elementId){
    document.getElementById(elementId).style.display = 'block';
}

function isHide(elementId){
  //  console.log("desde la funcion isHide "+ document.getElementById(elementId).style.display);
    if(document.getElementById(elementId).style.display == 'node'){
        return true;
    }else{
        return false;
    }
}

function isShow(elementId){
    if(document.getElementById(elementId).style.display != 'none'){ //Esto no se si pasa en todos los escenarios posibles
        return true;
    }else{
        return false;
    }
}

function display(elementId){
    return document.getElementById(elementId).style.display;
}