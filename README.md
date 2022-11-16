# Sao
## _Framework basado en php_



[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/4rcan31/Sao)

Sao es un framework basado en php para construir aplicaciones web rapido y eficientes, con sistema de enrutado, siguiendo el diseno `MVC` (Modelo Vista Controlador), este framework se construyo como metodo de aprendizaje, pero puede llegar a mas


## Caracteristicas

- Creacion de rutas desde codigo php sin tocar el archivo htacces
- Sistema de maquetado `0 HTML`, que te permite escribir codigo html con funciones php
- Cuenta con un ORM basico que procesa consultas `select`
- Funciona mediante el diseno MVC

## Instalacion

Sao require [Laragon](https://laragon.org/download.html) para funcionar

Para instalar el proyecto primero debemos de clonar el repositorio de Sao en nuestro servidor apache 

```sh
git clone https://github.com/4rcan31/Sao.git
```
Y luego entrar
```sh 
cd Sao
```

Para leer nuestras variables de entorno .ENV, es necesario instalar la biblioteca `dotenv` de vlucas, teniendo en cuenta que tienes instalado [Composer](https://getcomposer.org/download/), ejecutamos: 

```sh
composer require vlucas/phpdotenv
```

Listo, ya tenemos a Sao instalado, solo faltaria encender Laragon, entrar a `sao.test:8080` y esta corriendo

## Tech ¿Como usar Sao?

### Rutas

Toda la aplicacion empieza por el diseno de rutas, para eso tienes que irte al archivo `routes/web.php`, y aca podras configurar todas las rutas de tu aplicacion, ¿Como lo haces?, para esto puedes ocupar el metodo `get, post, put, delete` de la clase `Router`:

```php
<?php
 Router::get();
 Router::post();
 Router::put();
 Router::delete();
```

Esta funcion recibe 2 parametros, el primero es la ruta definida, y el segundo es un callback (una funcion anonima) que se ejecutara cuando la ruta definida se visite

```php
<?php
Router::get('/', function($data){

});
```
El callback resive un parametro `$data` que son todos los datos que vieden del request, 

## Luego que? 

Sao es un framework unopinionated, esto significa que no requeriras aprender muchas convecciones para programar tu aplicacion, si seguimos todo lo que sabemos de Sao hasta ahora, en nuestro callback pudieramos ejecutar absolutamente toda la aplicacion sin hacer uso de diseno MVC, pero claro, tenemos que hacer `buenas practicas`, y llamar al controlador que controlara esta ruta, y para eso existe la funcion `controller()` que resive 5 parametros 

```
controller(string $nameController, string $function, string $nameModel, Array $data = [], Array imports = []): bool
```
#### $nameController
Es el nombre del controlador de esta ruta, y no hace falta poner la extencion, por que se entiende que siempre sera `.php`, los controladores se definen en `app/Controllers`, la funcion `controller()` ira a buscar el controlador a esa ruta, y el nombre del controlador debe ser igual al nombre de la clase del controlador, cada controlador se tiene que extender de la clase `BaseController`
#### $function
Esta es el metodo definido en la clase del controlador que se ejecutara cuando se llame la ruta
#### $nameModel
Cada controlador tendra su propio Modelo, y el tercer parametro es para eso, para definir el modelo del controlador, como `$nameController`, solamente tendras que especificar el nombre del modelo, y la funcion lo ira a buscar a `app/Models`, la clase del Modelo se tiene que extender de la clase `BaseModel` Esto para usar el ORM 
#### $data
Esta es toda la `data` que le podras pasar al metodo que se definio en `$function`
#### $imports
Aca se podran enviar clases para luego guardarlas en un constructor en la clase del `Controlador` que se definio en `$nameController`

## DataBase

Para configurar la base de datos tienes que crear el archivo `.env`, y pegar lo siguiente: 

```env
APP_NAME=Sao
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=testing_api
DB_USERNAME=root
DB_PASSWORD=
```
Solo tienes que igualar las variables a los datos de tu base de datos 


## Controladores

Ahora que ya sabemos como definir rutas y como llamar al controlador, podemos enviar vistas

`web.php`
```php
Router::get('/', function($data){ 
   controller('IndexController', 'home', 'table.model', $data);
});
```
`Controllers/IndexController.php`
```php
class IndexController extends BaseController{
    public function home($data){
        view('index');
    }
}
```
`app/Views/index.php`
```php
<?php

inithtml();
html('s', [
    'lang' => 'en'
]);

headRemast('Home', requires([
    'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css'
]));
    h1('s'); 
        print('Esto es un h1');
    h1('e');

html('e');
```
Cuando descubri los ORM y entender que las consultas SQL no son mas que texto, tambien podemos usar este principio en html, ya que html no es mas que texto, y php nos permite trabajar con string. en php siempre se miro feo ejecutar `bucles` o `condiciones` en el codigo html, ahora podras ejecutar `bucles` o `condiciones` en codigo php, como se deberia de hacer, las funciones de html tienen la estructura siguiente: 
```php
nameEtiqueta(string $principioOFin, Array $attributes = []);
```
poner una `s` de `start` si es el principio de la etiqueta, y luego una `e` de `end` si es el final de la etiqueta. Este modelo no soporta todas las etiquetas html, por que claramente no me las se todas, pero si quieres poner una etiqueta que no esta definida puedes hacer uso de la funcion `newHtml()`
```
newHtml(string $principioOFin, string $nameEtiqueta,  Array $attributes = []): bool
```
Pero si quieres definir la etiqueta, o sea una nueva funcion puedes irte a `core/Views/html.php`, y seguir la estructura que esta ahi, tampoco es tan dificil.

### Los atributos de las etiquetas

El segundo parametro de las funciones es `$attributes` y por defecto es un array vacio, como puedo poner atributos?
para eso, puedes seguir la siguiente estructura: 
```php
div('s', [
    'class' => 'container', 
    'id' => 'NameIdDivContainer'
]);
```
O tambien puede poner los atributos en una sola linea
```php
div('s', [
    'class="container" id="NameId"'
]);
```
Si no quieres usar este sistema de html puedes escribir el html convencional

### Funciones Helpers 

#### Encrypter
#### encrypt();
Sao cuenta con metodos de encrytptado y has 
```php
Encrypt()->encrypt(string $string, string $key): string
```

##### $string
Esta es la cadena a encriptar
##### $key
Esta es la llave para encriptar `$string`

#### encrypt();
```php
Encrypt()->decrypt(string $string, string $key): string
```
Nota: Este metodo siempre genera cadenas diferentes aunque sea la misma key o el mismo string 

##### $string
Esta es la cadena a desencriptar
##### $key
Esta es la llave con la que se encripto `$string` con la funcion `Encrypt()->decrypt();`

#### hash();
```php
Hasher()->hash(string $string): string
```
##### $string
Es la cadena que quiere hashear

Nota: la funcion `hash` es de una sola direccion, esto significa que NO podra ser desencriptada

#### verifyHash();
```php
Hasher()->verifyHash(string $string, string $hash): bool
```
##### $string
Es la cadena en texto plano para conpararla con el $hash que creo `has()`
##### $hash
El hash que creo la funcion `hash()`

### View()
```php
view(string $html, string $route = ''): bool
```
#### $html
Este es el nombre del archivo, la funcion ira a buscar los archivos html en `app/Views` 
###$ $route
En el dado caso que requieras un archivo que no este en `app/Views', puedes definirlo en esta ruta




## License

MIT

<<<<<<< HEAD
=======
**Free Software, Hell Yeah!**

>>>>>>> 56e14d9449002bad52c911d24eac60a80ebb1946

