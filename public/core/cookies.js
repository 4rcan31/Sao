function setCookie(name,value) {
    document.cookie = name+"="+value;
}

function getCookie(name) {
    var list = document.cookie.split(";");
    for (i in list){
        var search = list[i].search(name);
        if (search > -1){
            cookie=list[i];
        }
    }
    var igual = cookie.indexOf("=");
    var value = cookie.substring(igual+1);
    return value;
}