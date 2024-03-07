# Introducción a Sao - Un Framework PHP para Desarrollo Web

Sao es un potente framework de desarrollo web en PHP que tiene como objetivo simplificar y acelerar el proceso de creación de aplicaciones web eficientes y elegantes. Aunque se originó como una herramienta de aprendizaje, Sao ha evolucionado y se ha convertido en una opción viable para proyectos más grandes. Este framework se basa en el diseño Modelo Vista Controlador (MVC) y ofrece una variedad de características y herramientas para ayudar a los desarrolladores a construir aplicaciones web de alta calidad de manera eficiente.

## Proyectos Destacados Desarrollados con Sao

Aquí te presentamos algunos proyectos destacados que se han desarrollado utilizando Sao:

1. **Proyecto FTechnology**
   - Repositorio: [FTechnology en GitHub](https://github.com/4rcan31/FTechnolgy)
   - Descripción: Este proyecto se centra en el desarrollo de una aplicación para ventas de productos de mascotas y el control de Croquette, un dispensador de comida para mascotas basado en hardware. Sao se utiliza como el framework principal para crear esta aplicación, lo que demuestra su versatilidad y capacidad para abordar proyectos variados.
# Instalación

Para descargar Sao, ejecuta:

```sh
git clone https://github.com/4rcan31/Sao.git
```

Una vez que esté instalado, debes eliminar la carpeta `.git`.

En Windows, usa el comando `rmdir`:
```sh
rmdir /s /q sao\.git
```

En sistemas Unix o Linux (incluyendo macOS), usa el comando `rm`:
```sh
rm -rf Sao/.git
```

Ahora solo necesitas cambiar el nombre de la carpeta `Sao` al nombre de tu proyecto. Utiliza el comando:

En Windows:
```sh
ren sao nombre_de_tu_app
```

En Unix, Linux o macOS:
```sh
mv Sao nombre_de_tu_app
```

Ahora puedes ingresar a tu proyecto ejecutando:

```sh
cd nombre_de_tu_app
```

Puedes verlo funcionando ejecutando

```sh
php jenu serve
```

## Configuración

Ahora debes configurar algunos datos para tu aplicación, como la asignación de variables globales. Dirígete al archivo `.env`. En este archivo, encontrarás variables de configuración. Dentro del archivo `.env`, verás lo siguiente:

```dotenv
APP_NAME=Sao
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_PORT=8080
APP_ADDRESS="127.0.0.1"
APP_KEY=7a4bd04541c36b406506b28376aafcbdc8c7a0fe45076ffb5b8b10476be3f5a6

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=name_your_database
DB_USERNAME=root
DB_PASSWORD=
```

### Configuración .env de la Aplicación
- `APP_NAME:` Este es el nombre de la aplicación.
- `APP_DEBUG:` Este es un valor booleano para establecer si la aplicación está en modo depuración o en modo producción.
- `APP_URL:` Esta es la URL de la aplicación.
- `APP_PORT:` Este es el puerto.
- `APP_ADDRESS:` Esta es la dirección IP de la aplicación.
- `APP_KEY:` Esta es una clave que la aplicación utiliza (se utiliza principalmente en la aplicación de sesiones).

### Configuración .env de la Base de Datos

##### Valores por defecto (generalmente no cambian)
- `DB_CONNECTION:` Gestor al que se conectará (por el momento Sao solamente soporta a MySQL como driver).
- `DB_HOST:` Host al que se conectará.
- `DB_PORT:` Puerto del host al que se conectará.

##### Valores que generalmente cambian
- `DB_DATABASE:` Nombre de la base de datos a la que se conectará.
- `DB_USERNAME:` Nombre de usuario para acceder al gestor de base de datos.
- `DB_PASSWORD:` Contraseña para acceder al gestor de base de datos (por defecto es vacía).

### Verificar la Conexión a la Base de Datos
Puedes comprobar si la conexión a la base de datos ha sido exitosa. Para hacerlo, ejecuta (una vez que ya estés dentro de la carpeta de tu proyecto):

```sh
php jenu comprobate:connection:mysql
```

# Estructura de Directorios

## /app
Esta carpeta contiene toda tu aplicación y se divide en 6 carpetas adicionales.

### /console
En esta carpeta, encontrarás un archivo llamado `console.php`. Aquí podrás definir los comandos necesarios para ejecutarlos posteriormente con la aplicación de comandos de Sao, llamada `jenu`.

### /Controllers
Aquí se definen todos los controladores de tu aplicación, que pueden provenir de las solicitudes (request) o de otras fuentes.

### /DataBase
Dentro de esta carpeta, encontrarás la subcarpeta:

#### /migrations
En esta subcarpeta se almacenan todas tus migraciones (tablas) para la base de datos. Para crear una migración, ejecuta:

```sh
php jenu make:migration nombre_de_tu_migración
```

### /middlewares
En esta carpeta, puedes crear todos los middlewares de tu aplicación, ya sea para la gestión de sesiones, roles, etc. Estos middlewares se aplicarán a las rutas (no a las vistas).

### /Models
Aquí se encuentran todos los modelos de tu base de datos. Básicamente, esta capa está más relacionada con la base de datos. Cada archivo en /Models representa una tabla y puede servir como controlador de tablas.

### /Views
Esta carpeta es donde puedes crear todos tus archivos de vistas para tu aplicación. Dentro de ella, hay una subcarpeta ya creada llamada:

#### /layouts
La carpeta de "layouts" te permite almacenar partes (renders) de las vistas que se repiten en todas las páginas, como encabezados, pies de página y elementos estáticos que son comunes en el sitio web. Esto te permite reutilizarlos desde las vistas.

# Uso de Sao

Para comenzar a utilizar Sao y crear tu primer "Hola Mundo", debes familiarizarte con las rutas. Sao utiliza varias bibliotecas y aplicaciones para funcionar, pero en esta sección nos centraremos en cómo hacer que una aplicación funcione. Empezaremos por la creación de rutas, que se encuentran en el directorio `app/routes`. Todos los archivos en esta carpeta serán manejados por el enrutador de Sao. Para crear una ruta, utiliza la siguiente función:

```php
Route::get('/home', function($request){
    res('Hola mundo');
});
```

Cuando visites la ruta `/home`, se enviará una respuesta en formato JSON que dirá "Hola mundo". La función `res()` toma un array o una cadena como parámetro y lo convierte en JSON para que sea la respuesta. Esto es solo un ejemplo de respuesta; puedes implementar lógica más compleja. Todos los datos de la solicitud están disponibles en la variable `$request`. Puedes acceder a datos específicos de la solicitud de la siguiente manera:

```php
Request::$path;
Request::$method;
Request::$uri;
Request::$requestTime;   
Request::$headers;
Request::$ip;
Request::$data;
Request::$cookies;
Request::$tokenRequest;
```

Ahora que tienes acceso a los datos de la solicitud, puedes realizar cualquier lógica que necesites. Puedes responder con JSON o incluso renderizar una vista. Si deseas renderizar una vista, puedes utilizar la función `view()`.

```php
Route::get('/home', function($request){
   view('home');
});
```

La función `view` busca un archivo en `app/views`, en este caso, un archivo llamado `home.php`, y lo renderiza. La función `view` también admite un segundo parámetro para pasar datos a la vista:

```php
view('home', $request);
```

Este segundo parámetro permite pasar datos a la vista para que puedan procesarse allí:

```php
<?php 
// Archivo home.php
$data = ViewData::get(); 
```

Una vez que se obtienen los datos, `ViewData::get();` se vacía automáticamente (los datos en la clase se destruyen).

Si necesitas validar datos, puedes utilizar la función `validate($data)`. Aquí tienes un ejemplo:

```php
Route::get('/home', function($request){
    $validate = validate($request);
    $validate->rule('required', ['name', 'password', 'email']);
    $validate->rule('email', ['email']);
    $validationResult = $validate->validate();
});
```

La función `validate` es parte de las bibliotecas de Sao y se utiliza para validar datos, en este caso, los datos del `$request`. El método `$validate->validate()` devuelve un valor booleano: `true` si todas las validaciones son exitosas y `false` si alguna falla. Las reglas de validación disponibles son las siguientes:

- `required`: Requerir un índice (verifica que exista y no esté vacío).
- `contain`: Verifica si una cadena contiene una subcadena.
- `email`: Valida si una cadena contiene al menos un símbolo "@".
- `is`: Valida el tipo de dato.
- `in`: Valida si un array existe dentro de otro.
- `numeric`: Valida si un valor es un número.
- `phone`: Valida si un valor es un número de teléfono.

Ten en cuenta que el validador en `/core/validate/validate.php` puede tener algunos errores en algunas de las reglas (excepto en `required`, `email`, `contain` y `phone`).

Puedes desarrollar toda tu aplicación en una sola ruta, pero es mejor dividirla en partes y usar controladores. Para usar controladores, puedes hacer lo siguiente:

```php
Route::get('/home', function($request){
     controller('ViewController', 'home', $request);
});
```

Lo que hace esto es buscar un archivo llamado `app/Controllers/ViewController.php`, instanciar su clase y ejecutar la función `home()`. El tercer parámetro es opcional y se puede utilizar para pasar datos a la función `home()`.

Cuando creas controladores, el nombre del archivo y el nombre de la clase deben ser iguales. Por ejemplo:

```php
<?php
// Archivo ViewController.php

class ViewController extends baseController{

    public function home($request){
        view('home');
    }
}
```

Ahora puedes llamar a un controlador y seguir toda tu lógica de programación para construir tu aplicación. Sin embargo, todavía no puedes realizar consultas en tu base de datos. Para hacerlo, debes usar un modelo. Para llamara los modelos, utiliza la función `model()` de la siguiente manera:

```php
<?php
// Archivo ViewController.php

class ViewController extends baseController{

    public function home($request){
       model('users');
    }
}
```

Esta función buscará un archivo llamado `app/Models/users.php` e instanciará una clase llamada `users`.

Nota: Al crear modelos, el nombre del archivo y el nombre de la clase deben ser iguales. Lo que significa que no recibirás sugerencias de métodos de la clase `users` en tu IDE. Si deseas habilitar sugerencias de métodos, puedes hacer lo siguiente:

```php
<?php
// Archivo ViewController.php

class ViewController extends baseController{

    /**
    * @return users
    */
    public function users(){
        return model('users');
    }

    public function home($request){
      $this->users();
    }
}
```

De esta manera, tu IDE reconocerá la clase y sugerirá métodos. ¿Pero cómo se ve la clase `users`?

```php
<?php
// Archivo users.php

class users extends baseModel{

    public $table = 'users';

    public function get(){
        $this->prepare();
        $this->select(['*'])
        ->from($this->table);
        return $this->execute->all('fetchAll');
    }

    public function byId(int $id){
        $this->prepare();
        $this->select(['*'])
        ->from($this->table)
        ->where('id_user', $id, '=');
        return $this->execute()->all();
    }
}
```

Si has configurado tu base de datos, tus modelos podrán interactuar con ella. En este caso, el modelo `users` contiene dos métodos: `get`, que recupera todos los registros de la tabla `users`, y `byId`, que recupera una fila por su `id` (el cual se pasa como parámetro). Si observas, Sao utiliza un constructor de consultas SQL para facilitar las consultas. Sin embargo, si deseas realizar consultas SQL estándar, puedes hacerlo de la siguiente manera:

```php
    public function byId(int $id){
        $result = $this->query(
            "SELECT * FROM users WHERE id_users = ?", 
            $id);
    }
```

Ahora, la variable `$result` contiene métodos PDO que puedes utilizar, como `fetch` o `fetchAll`, según tus necesidades.

¡Ahora tienes las herramientas necesarias para comenzar a construir tu aplicación con Sao! Puedes trabajar en las rutas, controladores y modelos para crear una aplicación web robusta y personalizada. 

# Ejemplo de Uso de Sao

En este ejemplo, crearemos una ruta que tome un nombre de usuario único como parámetro GET y muestre la información del usuario cuando se visite.

## Creación de la Ruta

Para crear la ruta, utilizamos el enrutador de Sao. Definimos una ruta que toma el nombre de usuario como un parámetro en la URL:

```php
Route::get('/user/%userName', function($request){
     controller('userController', 'user', $request);
});
```

Sao permite pasar datos a través de la URL utilizando `/` en lugar de `?=`. Sin embargo, si prefieres la forma tradicional, también puedes hacerlo.

## Controlador de Usuario

El controlador `userController` se encarga de manejar la lógica de esta ruta. Extraemos el nombre de usuario del array `$request` y luego utilizamos un modelo para obtener la información del usuario:

```php
<?php
// Archivo userController.php

class userController extends baseController{

    /**
    * @return users
    */
    public function users(){
        return model('users');
    }

    public function user($request){
    /* 
        Los datos que vienen por GET en la URL
        vienen como índices numerales
    */
        $nameUser = $request[0];
        res($this->user()->getByUserName($nameUser));
    }
}
```

## Modelo de Usuario

El modelo `users` se utiliza para interactuar con la base de datos. En este caso, hemos definido un método `getByUserName` que toma un nombre de usuario y realiza una consulta en la tabla de usuarios:

```php
<?php
// Archivo users.php

class users extends baseModel{

    public $table = 'users';

    public function getByUserName(string $userName){
        $this->prepare();
        $this->select(['*'])
        ->from($this->table)
        ->where('username', $username);
        return $this->execute->all();
    }
}
```

## Visualización de la Información del Usuario

Ahora, cuando visitemos la ruta, por ejemplo, `user/arcane`, veremos toda la información del usuario llamado "arcane". Este es solo un ejemplo de cómo puedes usar Sao para crear rutas dinámicas y mostrar información personalizada en tu aplicación. 

# Aplicaciones de Sao

Sao cuenta con aplicaciones tanto internas como externas. Puedes consultar las librerías externas utilizadas en el archivo `composer.json`. Las aplicaciones internas se encuentran en la carpeta `/core` y comprenden las siguientes:

- `Auth`: Permite autenticar cualquier entidad que ingrese al programa.
- `Console`: Es la aplicación de consola llamada Jenu.
- `DataBase`: Contiene el código para el constructor de consultas y la conexión a la base de datos.
- `Encrypt`: Incluye aplicaciones para encriptar y hashear datos.
- `Helpers`: Ofrece funciones genéricas, algunas diseñadas exclusivamente para Sao y otras de uso general.
- `Http`: Contiene librerías relacionadas con la aplicación del request y el response.
- `Resources`: Es una librería para gestionar archivos subidos.
- `Routing`: Representa la aplicación más importante de Sao, que implementa el algoritmo de enrutamiento.
- `Server`: Proporciona funciones generales para el servidor.
- `Time`: Contiene librerías para el manejo del tiempo.
- `Validate`: Ofrece el validador de datos de Sao.
- `Views`: Proporciona librerías para el manejo de vistas.


Algunas de estas librerías no necesitarás importarlas explícitamente utilizando las funciones `import()` o `core()` (las cuales serán explicadas más adelante en la sección de "Helpers"). Esto se debe a que estas librerías ya han sido autoimportadas en el cargador automático de Sao. A continuación, se presenta la lista de todas las librerías que se han importado automáticamente:

```php
$this->runAppSession();
$this->runAppHelpers();
$this->runAppSaoHelpers();
$this->runAppAutoloaderComposer();
$this->runAppServe();
$this->runAppHttp();
$this->runAppRouting();
$this->runAppAuth();
$this->runAppApp();
$this->runAppRoutes();
```

Si deseas examinar o realizar modificaciones en el cargador automático de Sao, puedes encontrarlo en el archivo `core/app.php`.


# Route - Aplicación de enrutamiento en Sao

**Route** es una de las aplicaciones más fundamentales en el ecosistema de Sao, ya que se encarga del enrutamiento de rutas amigables. Permite definir rutas de manera sencilla y asignar funciones a ejecutar cuando se accede a ellas.

## Definición de Rutas

Para definir rutas en Sao, utiliza los métodos correspondientes a los diferentes verbos HTTP:

- `get()`: Para rutas con el método HTTP GET.
- `post()`: Para rutas con el método HTTP POST.
- `put()`: Para rutas con el método HTTP PUT.
- `delete()`: Para rutas con el método HTTP DELETE.

Por ejemplo:

```php
Route::get('/home', function($request){
    // Acciones a realizar cuando se visita /home
});
```

## Prefijos de Ruta

Puedes agregar prefijos a tus rutas para agruparlas o aplicarles configuraciones comunes. Esto se logra mediante el método `prefix()`:

```php
Route::get('/home', function($request){

})->prefix('/test');
```

Con esta configuración, la ruta `/home` ahora será accesible como `/test/home`.

## Middlewares

Route te permite aplicar middlewares a tus rutas para agregar capas de seguridad o funcionalidades adicionales. Utiliza el método `middlewares()` y proporciona un array con los nombres de los middlewares a aplicar:

```php
Route::get('/panel', function($request){

})->middlewares(['AuthMiddleware@session']);
```

En este ejemplo, la ruta `/panel` está protegida por el middleware llamado `session`, que se encuentra en `app/middlewares/AuthMiddleware.php`.

## Datos en Rutas

Puedes asignar datos específicos a tus rutas con el método `setData()`. Estos datos pueden ser utilizados más adelante:

```php
Route::get('/panel', function($request){

    $data = Route::getData();

})->setData([
    'test' => 'Esto es solamente una prueba'
]);
```

De esta manera, puedes acceder a los datos asignados a la ruta con `Route::getData()`.

## Agrupación de Rutas

Para simplificar la definición de múltiples rutas con la misma configuración, puedes utilizar el método `group()`. Esto te permite agrupar rutas con un prefijo, middlewares o datos comunes:

```php
Route::group(function(){

   Route::get('/dashboard', function(){
      controller('PanelViewsController', 'home');
   });

   Route::get('/logs', function(){
      view('dashboard/logs');
   });

   Route::get('/store', function(){
      controller('PanelViewsController', 'store');
   });

   Route::get('/orders', function(){
      controller('PanelViewsController', 'ordersView');
   });

})->prefix('/panel')->middlewares(['AuthMiddleware@session']);
```

Ahora, todas las rutas definidas dentro del grupo tienen el prefijo `/panel` y están protegidas por el middleware `session`.

## Notas Importantes

El sistema de anidación de rutas es complejo y puede ser propenso a errores. Aquí se destacan dos consideraciones importantes:

1. No se pueden definir grupos de rutas vacíos, ya que esto causará errores en el constructor de atributos. Por lo tanto, es necesario eliminar grupos vacíos o definir al menos una ruta en ellos.

2. No se debe anidar un grupo dentro de otro grupo sin definir ninguna ruta en el grupo interior, ya que esto también generará errores. Asegúrate de asignar rutas dentro de los grupos anidados.

```php
Route::group(function() {
    Route::group(function() {
        Route::get('/home', function() {
            res('Estás en la página de inicio');
        });
    });

    /* 
        Este grupo es innecesario y 
        no está realizando ninguna otra acción 
        que anidar otro grupo.
        Además, generará un error.
    */
});

```

La manera de evitar este error es la siguiente:
```php
Route::group(function() {
    Route::group(function() {
        Route::get('/home', function() {
            res('Estás en la página de inicio');
        });
    });

    Route::get('/test', function() {
        res('Estás en la página de prueba');
    });
});
```


## Otros Métodos del Enrutador

El enrutador de Sao ofrece algunas funciones adicionales para satisfacer necesidades específicas. A continuación, se detallan algunas de estas funciones:

### Ruta Raíz

Puedes definir una acción que se ejecutará cuando se visite la ruta raíz, es decir, "/". Por defecto, esta acción se ejecuta con el método HTTP GET. Para configurar una acción en la ruta raíz, utiliza la función `Route::root()`:

```php
Route::root(function(){
    // Acción a ejecutar al visitar la ruta raíz
});
```

Si deseas especificar un método HTTP diferente para la ruta raíz, puedes hacerlo proporcionando un segundo parámetro a esta función.

### Manejo de Errores Personalizados

El enrutador permite definir manejadores de errores personalizados para códigos de respuesta HTTP específicos. Esto te permite tomar medidas personalizadas cuando se produce un error en una ruta. La función `Route::error()` se utiliza para definir estos manejadores de errores. 

A continuación se muestra cómo utilizar esta función:

```php
Route::error(403, function(){
   // Acción a ejecutar cuando se produce un error 403 (Prohibido)
   res(['El método no es soportado']);
});

Route::error(404, function(){
    // Acción a ejecutar cuando se produce un error 404 (No encontrado)
    res(['Página no encontrada']);
});
```

En el ejemplo anterior, se han definido manejadores de errores personalizados para los códigos de respuesta HTTP 403 y 404. Cuando el enrutador detecta uno de estos errores, ejecutará la acción especificada en el manejador correspondiente.

Estos métodos adicionales te permiten personalizar aún más el comportamiento de tu enrutador y controlar cómo se gestionan las rutas y los errores en tu aplicación.

Con esta potente aplicación de enrutamiento, podrás definir y gestionar tus rutas de manera eficiente en tu proyecto Sao.


# HTTP - Aplicación de Request and Response de Sao

La aplicación de HTTP se divide en dos componentes fundamentales: Request (solicitud) y Response (respuesta). Estos elementos son esenciales para el procesamiento de solicitudes y respuestas en una aplicación web.

## Request

La Request, o solicitud, se encarga de capturar información importante cuando un cliente ingresa a una ruta en la aplicación. Esta información se almacena para su posterior acceso en cualquier parte de la aplicación. Los datos capturados incluyen:

```php
Request::$path;
Request::$method;
Request::$uri;
Request::$requestTime;   
Request::$headers;
Request::$ip;
Request::$data;
Request::$cookies;
Request::$tokenRequest;
```

Los datos capturados son esenciales para comprender y procesar las solicitudes del usuario. Esto permite que la aplicación web responda de manera adecuada a las interacciones del cliente.

## Response

Aunque la aplicación de Response aún no está completamente desarrollada, es posible utilizar la función `res()` de los helpers. Esta función está diseñada para gestionar la generación de respuestas, lo que incluye la entrega de contenido al cliente en función de las solicitudes previamente procesadas. Esta funcion como parametro se le pasa un array, y imprime como json como respuesta

# Validate - Aplicación de Validación de Sao

La librería Validate es una herramienta esencial para garantizar la integridad de los datos en tu aplicación. Uno de los momentos más cruciales para su uso es la validación de datos del request, como se muestra a continuación:

```php
// En este caso, $request contiene todos los datos del request
$validate = validate($request);
$validate->rule('required', ['email', 'password']);
$validate->rule('email', ['email']);
$resValidate = $validate->validate();
```

## Uso de la función `validate()`

La función `validate()` es parte de las bibliotecas de Sao y desempeña un papel fundamental al validar datos. En el contexto de la validación de datos del `$request`, esta función permite definir reglas que deben cumplirse. El método `$validate->validate()` se utiliza para ejecutar la validación y devuelve un valor booleano: `true` si todas las validaciones son exitosas y `false` si alguna falla.

## Reglas de Validación Disponibles

La librería Validate proporciona una serie de reglas de validación para asegurarse de que los datos cumplan con los criterios requeridos. A continuación, se detallan algunas de las reglas de validación disponibles:

- `required`: Esta regla verifica si un índice es requerido, es decir, si existe y no está vacío.
- `contain`: Permite validar si una cadena contiene una subcadena específica.
- `email`: Se utiliza para validar si una cadena contiene al menos un símbolo "@".
- `is`: Esta regla se encarga de validar el tipo de dato, asegurando que sea el tipo esperado.
- `in`: Valida si un array existe dentro de otro array.
- `numeric`: Se utiliza para verificar si un valor es numérico.
- `phone`: Permite validar si un valor es un número de teléfono.

Es importante tener en cuenta que el validador, ubicado en `/core/validate/validate.php`, puede contener algunos errores en algunas de las reglas, con excepción de `required`, `email`, `contain`, y `phone`.



Aquí tienes la información presentada en un formato Markdown mejorado:

# Helpers - Aplicación de Funciones de Sao

Los Helpers se dividen en dos partes: aquellos que Sao utiliza para funcionar y otros Helpers generales.

## Helpers de Sao

Uno de los Helpers más importantes es la función `import()`:

```php
function import(string $module, bool $return = true, string $route = '/app', array $data = [])
```

- El primer parámetro, `$module`, es el módulo que deseas importar. Si este módulo no termina con una extensión PHP, importará todos los archivos dentro de esa carpeta. Si tiene la extensión PHP, importará ese archivo en particular.
- El segundo parámetro, `$return`, indica si deseas instanciar la clase de ese archivo o simplemente llamar al archivo.
- El tercer parámetro, `$route`, es la ruta raíz desde la cual buscará ese módulo.
- El cuarto parámetro, `$data`, es un array que se pasa a esa clase instanciada.

Ejemplo de uso:

```php
$encripter = import('/Encrypt/encrypt.php', true, '/core');
$stringEncript = $encripter->encrypt('hola', 'key');
```

Cuando se llama a `import()` y el segundo parámetro es `true`, puedes instanciar su clase de inmediato y utilizar sus funciones. Nota: Para obtener la clase del archivo, `import()` realiza lo siguiente:

```php
$module = deleteFormat(lastDir($dir));
```

Lo que significa que considera que el nombre del archivo es igual al nombre de la clase.

A partir de aquí, todos los demás Helpers de Sao ocupan esta función. Por ejemplo:

```php
function core($module, $return = true, $data = []){
    return import($module, $return, '/core', $data);
}

function csrf(){
    import('/server/csrf.php', false, '/core');
} 

function model($modelName){
    return import('Models/'.$modelName.".php");
}

// ... Otros métodos de importación ...
```

Hay algunos otros métodos como:

```php
function res(array $response, $code = 200, $errorResponseBody = null, $errorResponseHeader = null)
```
Este método envía una respuesta JSON y recibe un payload en forma de array.

```php
function serve($host = null)
```
Este método devuelve el host (aún en desarrollo).

```php
function route($route, $print = true)
```
Recibe una ruta como parámetro y devuelve la ruta completa (con host y protocolo) en la que te encuentras. Si el parámetro `$print` está en verdadero, se imprimirá; de lo contrario, se retornará.

## Helpers generales
Estos métodos se pueden usar en cualquier parte de la aplicación que se desarrolle.


### Arrays

Estas funciones son útiles para la manipulación de arrays:

```php
function sortIndex(array $array)
```

Ordena los índices de un array pasado como parámetro y devuelve el array ordenado.

- **$array**: El array que deseas ordenar.
- **Returns**: El array ordenado.

```php
function arrayToObject(array $array)
```

Convierte un array en un objeto y retorna dicho objeto.

- **$array**: El array que deseas convertir en objeto.
- **Returns**: Un objeto creado a partir del array.

```php
function isAssoc(array $array)
```

Verifica si el array pasado como parámetro es un array asociativo y retorna un booleano.

- **$array**: El array que deseas verificar.
- **Returns**: `true` si el array es asociativo, `false` si no lo es.

```php
function deleteElementArray(array $array, ...$indexes)
```

Elimina elementos de un array según los índices proporcionados y devuelve un nuevo array con los índices eliminados y ordenados utilizando `sortIndex`.

- **$array**: El array del cual deseas eliminar elementos.
- **...$indexes**: Índices que deseas eliminar.
- **Returns**: Un nuevo array con los índices especificados eliminados y ordenados.

### Console

Estas funciones están diseñadas para interactuar con la consola:

```php
function printColor($message, $color)
```

Imprime un mensaje en la consola con el color especificado utilizando códigos de color ANSI.

- **$message**: El mensaje que deseas imprimir.
- **$color**: El código de color en formato ANSI.
- **Output**: Muestra el mensaje en la consola con el color especificado.

```php
function consoleError($error)
```

Imprime un mensaje de error en la consola con el prefijo "Error:" en color rojo.

- **$error**: El mensaje de error que deseas imprimir.
- **Output**: Muestra el mensaje de error en la consola con el prefijo "Error:" en color rojo.

```php
function consoleWarning(string $warning, bool $start = true)
```

Imprime un mensaje de advertencia en la consola con color amarillo. Opcionalmente, puedes incluir un prefijo en el mensaje si el segundo parámetro, `$start`, está configurado como `true`.

- **$warning**: El mensaje de advertencia que deseas imprimir.
- **$start**: Un booleano que determina si se debe incluir un prefijo en el mensaje (predeterminado: `true`).
- **Output**: Muestra el mensaje de advertencia en la consola con color amarillo y, si está habilitado, con un prefijo.

### Files
Estos Helpers son útiles para realizar operaciones de lectura, escritura, copia y eliminación de archivos y directorios en tu aplicación. Puedes utilizarlos en diferentes partes de tu código para manejar archivos de manera eficiente.

```php
function readTxt($name){
```
Abre un archivo de texto y obtiene su contenido.

- **$name**: El nombre del archivo que deseas leer.
- **Returns**: El contenido del archivo.

```php
function format($file){
```
Obtiene la extensión de un archivo.

- **$file**: El nombre del archivo.
- **Returns**: La extensión del archivo.

```php
function lastDir($file){
```
Obtiene el nombre del directorio o archivo de un camino (path).

- **$file**: El camino del directorio o archivo.
- **Returns**: El nombre del directorio o archivo.

```php
function deleteFormat($file){
```
Obtiene el nombre del archivo sin su extensión.

- **$file**: El nombre del archivo.
- **Returns**: El nombre del archivo sin la extensión.

```php
function getFilesByDirectory($dir){
```
Obtiene una lista de archivos en un directorio.

- **$dir**: La ruta del directorio.
- **Returns**: Un array con los nombres de los archivos en el directorio.

```php
function getDirsFilesByDirectory($dir){
```
Obtiene la ruta completa de los archivos en un directorio.

- **$dir**: La ruta del directorio.
- **Returns**: Un array con las rutas completas de los archivos en el directorio.

```php
function showFiles($path){
```
Muestra una lista de archivos en un directorio y sus subdirectorios.

- **$path**: La ruta del directorio.
- **Returns**: Un array con los nombres de los archivos en el directorio y sus subdirectorios.

```php
function copyDirectory($source, $destination){
```
Copia un directorio y su contenido a otro destino.

- **$source**: La ruta del directorio de origen.
- **$destination**: La ruta del directorio de destino.

```php
function deleteDirectory($dir){
```
Elimina un directorio y su contenido.

- **$dir**: La ruta del directorio que deseas eliminar.

### Helpers de Objetos

Estas funciones son útiles para trabajar con objetos:

```php
function objectToArray(Object $object)
```

Convierte un objeto en un array asociativo utilizando la codificación y decodificación de JSON. Retorna el objeto convertido en formato de array.

- **$object**: El objeto que deseas convertir en un array.
- **Returns**: Un array asociativo que representa el objeto convertido.

### Helpers de Impresiones

Estas funciones son útiles para mostrar datos en la consola o en una página web:

```php
function printfa(...$data)
```

Imprime datos en la consola o en una página web. Concatena los datos pasados como argumentos y luego los muestra.

- **...$data**: Argumentos variables que se imprimirán.

```php
function prettyPrint($array, $json = false)
```

Realiza una impresión formateada de un array o de datos JSON en la consola o en una página web.

- **$array**: El array o datos JSON que deseas imprimir.
- **$json**: Un valor booleano que indica si los datos pasados son JSON o no (valor predeterminado: `false`).

**Nota**: En caso de que `$json` sea `true`, se imprimirá el contenido como JSON; de lo contrario, se mostrará utilizando `var_dump` con un formato más legible.

### Helpers de Strings

Estas funciones están diseñadas para trabajar con cadenas de texto:

```php
function randomString($length)
```

Genera un string aleatorio de la longitud especificada.

- **$length**: La longitud del string aleatorio que deseas generar.

```php
function token($length = 32)
```

Genera un token aleatorio, que suele utilizarse para autenticación o seguridad.

- **$length**: La longitud del token que deseas generar (valor predeterminado: `32`).


# DataBase - Aplicación de Base de Datos de Sao

La aplicación "DataBase" en Sao se enfoca en la manipulación de bases de datos. Esta aplicación se divide en tres partes esenciales: `connection`, `constructor`, y `migrations`.

## Connection

La parte de conexión es la más sencilla y se basa en establecer la conexión con la base de datos. Para lograrlo, es necesario configurar el archivo `.env`.

## Constructor

La aplicación "Constructor" te permite construir consultas SQL utilizando métodos de PHP. Veamos cómo se utiliza con un ejemplo de un pequeño CRUD.

### Crear (Create)

Para insertar datos, se realiza de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->insert('users')->values([
    'email' => 'test@gmail.com',
    'password' => '123'
]);
$lastIdInserted = $db->execute()->lastId();
```

En este caso, estamos insertando datos en la tabla `users`. En el array que se pasa al método `values`, los índices representan los nombres de las columnas y los valores son los datos que se insertarán. Al ejecutar esta consulta, puedes obtener el último ID insertado utilizando el método `lastId()`.

### Leer (Read)

Para traer datos (select), se realiza de esta manera:

```php
$db = new DataBase();
$db->prepare();
$db->select(['*'])->from('users');
$data = $db->execute()->all('fetchAll');
```

Este ejemplo selecciona todas las columnas de la tabla `users` y recupera todos sus datos. Si deseas seleccionar solo algunas columnas, puedes hacerlo de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->select(['id', 'name'])->from('users');
$data = $db->execute()->all('fetchAll');
```

Aquí se seleccionan todas las columnas de la tabla `users`, pero solo las columnas `id` y `name`. Si deseas aplicar una condición `WHERE`, puedes hacerlo de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->select(['id', 'name'])
    ->from('users')
    ->where('id', 2);
$data = $db->execute()->all();
```

En este caso, estamos solicitando el `id` y el `name` de la tabla `users` donde el `id` sea igual a `2`. No es necesario pasar `'fetchAll'` como parámetro al método `all()` porque sabemos que solo obtendremos una fila.

### Actualizar (Update)

Para actualizar tablas utilizando el constructor, se utiliza el método `update` de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->update('users', [
    'name' => 'nuevo nombre'
])->where('id', 2);
$db->execute();
```

El método `update` recibe dos parámetros: el primero es el nombre de la tabla que se va a actualizar, y el segundo es un array con los nuevos valores que se actualizarán. Similar al método `values` de `insert`, el segundo parámetro de `update` contiene índices que representan los nombres de las columnas y valores que representan los datos que se actualizarán. Luego, se establece una condición `WHERE` para especificar dónde se realizará la actualización.

### Eliminar (Delete)

Para eliminar filas, puedes hacer lo siguiente:

```php
$db = new DataBase();
$db->prepare();
$db->delete('users')->where('id', 2);
$db->execute();
```

El método `delete` recibe como parámetro el nombre de la tabla de la que se eliminarán las filas. Luego, se establece una condición `WHERE`.

Si prefieres no utilizar el constructor de consultas, puedes crear tu propia consulta SQL de esta manera:

```php
$db = new DataBase();
$data = $db->query('SELECT * FROM user WHERE id = ?', 1)->fetchAll();
```

Sao respeta la sintaxis de PDO de PHP para prevenir la inyección de SQL. El método `query` retorna métodos de PDO que puedes utilizar en cualquier momento.

## Migraciones

El sistema de migraciones aún se encuentra en desarrollo y presenta algunas limitaciones. Para crear una migración, ejecuta el siguiente comando:

```sh
php jenu make:migration name_migration
```

Este comando creará un archivo llamado `app/Database/migrations/name_migration.php`. El archivo tendrá una estructura como esta:

```php
<?php
class name_migration extends Migration {

    public function up() {
        $this->create("name_migration", function($table) {

        });
    }

    public function down() {
        $this->dropIfExist("name_migration");
    }
}
```

Para crear la tabla, debes ejecutar una consulta SQL manualmente utilizando el método `query`, de la siguiente manera:

```php
<?php
class name_migration extends Migration {

    public function up() {
        $this->create("name_migration", function($table) {
            $this->query('CREATE TABLE name_migration (
                id INT PRIMARY KEY AUTO_INCREMENT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
        });
    }

    public function down() {
        $this->dropIfExist("name_migration");
    }
}
```

Lamentablemente, el sistema de migraciones aún no admite claves foráneas (foreng keys) debido a la forma en que se ejecutan las migraciones para subirlas a la base de datos. Por lo tanto, si deseas establecer relaciones, debes crear las columnas relacionadas sin definir una clave foránea. Para ejecutar tus migraciones ejecuta:

```sh
php jenu execute:migrations
```

# Jenu - Aplicación de Comandos de Sao

## Introducción
Jenu es una herramienta que te permite crear y ejecutar comandos personalizados en la consola de Sao. Puedes utilizarlo para automatizar tareas, interactuar con tu aplicación y realizar pruebas.

## Creación de Comandos
Puedes crear nuevos comandos en `jenu` utilizando la siguiente sintaxis:

```php
public static function command(string $command, callable $execute, string $help = "undefined", $type = "undefined")
```

Por ejemplo, si deseas crear un comando simple que muestre "Hola mundo" en la consola, puedes hacerlo de la siguiente manera:

```php
Jenu::command('hi', function(){
    Jenu::print("Hola mundo!");
}, 'Un comando para saludar al mundo', 'tu_app:Test');
```

Cuando ejecutes:

```sh
php jenu hi
```

Verás en la consola la salida "Hola mundo".

## Descripción de Parámetros
- `command:` El nombre del comando que deseas crear.
- `execute:` La función que se ejecutará cuando se llame al comando.
- `help:` Una descripción opcional del comando.
- `type:` El tipo de comando, como base de datos, aplicación, etc. (Opcional).

## Ejecución de Comandos
Puedes ejecutar comandos previamente definidos utilizando la función `execute`. Por ejemplo:

```php
Jenu::command('test', function(){
    Jenu::print("Ejecutando el comando hi");
    Jenu::execute("hi");
    Jenu::print("El comando hi fue ejecutado!");
});
```

Esto mostrará en la consola:

```
Ejecutando el comando hi
Hola mundo!
El comando hi fue ejecutado!
```

## Condiciones
Puedes definir condiciones en tus comandos utilizando la función `condition`. Por ejemplo:

```php
$confirmation = Jenu::condition("¿Estás seguro de que deseas eliminar todas las tablas de la base de datos? (escribe YES o NO)");
```

El valor de `$confirmation` será un booleano según la respuesta del usuario. En la consola, verás:

```
¿Estás seguro de que deseas eliminar todas las tablas de la base de datos? (escribe YES o NO)
```

## Obtención de Argumentos
Puedes obtener argumentos pasados a un comando utilizando la función `get`. Por ejemplo:

```php
$host = Jenu::get(0, "Ingresa el Host", '127.0.0.1');
```

El primer parámetro especifica la posición del argumento. Si el argumento no existe, se mostrará un error y se detendrá la ejecución del comando. El tercer parámetro es opcional y establece un valor predeterminado.


## Ejecución de Procesos Node.js (en desarrollo)
La función `executeNodeProcess` está diseñada para ejecutar procesos de Node.js en la consola y mostrar su salida. Por ejemplo:

```php
Jenu::executeNodeProcess('test.js');
```

## Funciones de Impresión
Para imprimir datos en la consola, Jenu ofrece 4 funciones útiles:
- `Jenu::print($text, $newLine = true)`: Imprime datos de forma normal.
- `Jenu::success($text, $start = true)`: Imprime mensajes de éxito (en verde).
- `Jenu::error($text)`: Imprime mensajes de error (en rojo) y detiene la ejecución.
- `Jenu::warn($text, $start = true)`: Imprime mensajes de advertencia (en amarillo).

## Funciones Adicionales
- `Jenu::baseDir()`: Obtiene el directorio base.
- `Jenu::getDate()`: Obtiene la fecha actual.

# View - Aplicación de vistas de Sao

El módulo de Vistas se encuentra en una fase de desarrollo activo, y está en constante evolución con numerosas ideas para mejorar su implementación. Este módulo se divide en múltiples componentes, que incluyen: `Form`, `Requires`, `ViewData`, `CoreJavaScript`, `Layouts`, `htmlBuilt`. Cuando se utiliza la función `view()` para invocar una vista, se realiza la carga de todos estos componentes necesarios para el funcionamiento de la aplicación de vistas.

## Form
Esta librería, diseñada para la manipulación de formularios y la entrega de notificaciones, aún se encuentra en desarrollo, lo que significa que algunas de sus características son estáticas. La clase Form desempeña un papel fundamental en la gestión de formularios en una aplicación PHP. Esta clase proporciona una serie de métodos para facilitar el envío, recuperación y visualización de datos de formularios, además de ofrecer funciones útiles para la administración de estos formularios.

### Propiedades

- **$inputs**: Un array que almacena la información de los campos de entrada del formulario.
- **$data**: Almacena temporalmente los datos del formulario para su uso.

### Métodos

#### `send`

```php
public static function send(string $route, array $data, $type)
```

Este método envía datos a una ruta específica después de codificarlos en formato JSON y base64. Para obtener esos datos utiliza el metodo `get`

- **$route**: La ruta a la que se enviarán los datos.
- **$data**: Un array que contiene los datos.
- **$type**: Un tipo que se utilizará como parte del encabezado de los datos.

#### `isThere`

```php
public static function isThere()
```

Verifica si hay datos almacenados en algun envio.

#### `get`

```php
public static function get($json = false)
```

Obtiene los datos almacenados y los decodifica, devolviendo un objeto o un JSON.

- **$json**: Si se establece en `true`, se devuelve un JSON en lugar de un objeto.

#### `print`

```php
public static function print()
```

Imprime los datos almacenados como notificaciones en formato de toasts.

#### `setValuesInputs`

```php
public static function setValuesInputs()
```

Asigna valores a los campos de entrada en el formulario basados en los datos almacenados en la sesión.

#### `destroyData`

```php
public static function destroyData()
```

Elimina los datos almacenados en la sesión.

#### `setInputs`

```php
public static function setInputs($inputs)
```

Establece los campos de entrada del formulario y los almacena en la sesión.

- **$inputs**: Un array que contiene información sobre los campos de entrada del formulario.

#### `toast`

```php
public static function toast(string $title, string $body, $id, $delay, $verticalOffset, $toastHeight, $time = 'now', $img = '')
```

Genera una notificación estilo toast que se puede imprimir en la página.

- **$title**: El título de la notificación.
- **$body**: El cuerpo del mensaje de la notificación.
- **$id**: Un identificador único para la notificación.
- **$delay**: El retraso en milisegundos antes de mostrar la notificación.
- **$verticalOffset**: La posición vertical de la notificación.
- **$toastHeight**: La altura de la notificación.
- **$time**: La hora de la notificación (opcional).
- **$img**: La URL de una imagen a mostrar junto al mensaje (opcional).

#### `getToastHeight`

```php
public static function getToastHeight($content)
```

Calcula la altura adecuada para una notificación estilo toast basada en la longitud del contenido del mensaje.

#### `addInput`

```php
public static function addInput($name, $type, $label, $class, $placeholder = '', $id = '', $value = '')
```

Agrega un campo de entrada al formulario.

- **$name**: El nombre del campo.
- **$type**: El tipo del campo (por ejemplo, text, password, etc.).
- **$label**: La etiqueta del campo.
- **$class**: Las clases CSS para el campo.
- **$placeholder**: El texto de marcador de posición para el campo (opcional).
- **$id**: El identificador HTML del campo (opcional).
- **$value**: El valor predeterminado para el campo (opcional).

#### `addTextArea`

```php
public static function addTextArea(string $name, $label, $class, $rows = 3, $classLabel = "form-label", $placeholder = '', $id='', $value="")
```

Agrega un área de texto al formulario.

- **$name**: El nombre del área de texto.
- **$label**: La etiqueta del área de texto.
- **$class**: Las clases CSS para el área de texto.
- **$rows**: El número de filas en el área de texto (opcional, valor predeterminado: 3).
- **$classLabel**: Las clases CSS para la etiqueta del área de texto (opcional, valor predeterminado: "form-label").
- **$placeholder**: El texto de marcador de posición para el área de texto (opcional).
- **$id**: El identificador HTML del área de texto (opcional).
- **$value**: El valor predeterminado para el área de texto (opcional).

#### `PrintInputs`

```php
public static function PrintInputs()
```

Imprime los campos de entrada definidos en el formulario.

#### `processInputs`

```php
public static function processInputs($request)
```

Procesa los campos de entrada enviados en la solicitud y los almacena en un formato adecuado en la sesión.

--- 
## Layouts

El módulo "Layouts" es esencial para la gestión de archivos que se repiten en todas las vistas de una aplicación, como encabezados, pies de página, barras laterales y otros componentes similares. Este módulo consta de dos funciones clave para facilitar la inclusión de estos elementos en las vistas.

### Función `layouts`

```php
function layouts()
```

La función `layouts` cumple la función de importar y cargar todos los diseños o layouts disponibles en la carpeta `app/view/layouts`. Su principal objetivo es proporcionar una forma sencilla y conveniente de utilizar estos diseños en las vistas de la aplicación. Esta función está diseñada para llamarse típicamente desde una vista, permitiendo una integración más fluida de los diseños en el proceso de renderizado.

### Función `layout`

```php
function layout($file, $format = 'php')
```

En caso de que no se necesite importar todos los layouts disponibles, la función `layout` ofrece una solución más selectiva. Permite importar un diseño específico desde la carpeta `app/view/layouts`. Al llamar a esta función, se cargarán y aplicarán las características del diseño seleccionado. La estructura de llamada para esta función sigue un patrón predecible, donde el archivo del diseño a importar se concatena con la ruta base de la carpeta de diseños (`app/view/layouts`). El formato por defecto es PHP, aunque se puede especificar otro formato si es necesario.

---

## Requires

En la gestión de archivos estáticos, estos se llaman desde la carpeta `/public`. Aquí se presenta un ejemplo de cómo incluir archivos en la sección `<head>` de una página, junto con las funciones que hacen esto posible. Ejemplo:

```php
<?php
//Esto es app/views/layouts/head.php
function head($title) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title ?></title>
        <?php requiresStaticFiles([
            routePublic('vendor/bootstrap/css/bootstrap.min.css'),
            routePublic('assets/css/style.css'),
        ]) ?>
    </head>
    <?php
}
```
 La función `requiresStaticFiles` se encarga de gestionar la inclusión de archivos estáticos, ya sea hojas de estilo o scripts.

### Función `requiresStaticFiles`

```php
function requiresStaticFiles($files = [], string $type = 'text/javascript')
```

La función `requiresStaticFiles` recibe un array de archivos estáticos que se requieren en la página. Pueden ser archivos de diferentes tipos, como hojas de estilo CSS o scripts JavaScript. Dependiendo del tipo de archivo, esta función genera automáticamente la etiqueta HTML correspondiente, ya sea para hojas de estilo (`<link>`) o para scripts (`<script>`).

### Función `routePublic`

```php
function routePublic(string $route)
```

La función `routePublic` se utiliza para obtener la ruta completa a un archivo estático ubicado en la carpeta `/public`. Esto es fundamental para asegurarse de que los archivos estáticos se incluyan correctamente en la página. La función construye la URL completa, incluyendo el protocolo, dominio y ruta relativa al archivo estático.

### Ejemplo más Amplio

```php
function scripts() {
    Form::print();
    Form::setValuesInputs();
    Form::destroyData();
    echo requiresStaticFiles([
        routePublic('vendor/jquery/jquery.min.js'),
        routePublic('vendor/bootstrap/js/bootstrap.bundle.min.js'),
        routePublic('vendor/jquery-easing/jquery.easing.min.js'),
        routePublic('assets/js/sb-admin-2.min.js'),
        routePublic('vendor/chart.js/Chart.min.js'),
        routePublic('assets/js/demo/chart-area-demo.js'),
        routePublic('assets/js/demo/chart-pie-demo.js'),
        routePublic('vendor/datatables/jquery.dataTables.min.js'),
        routePublic('vendor/datatables/dataTables.bootstrap4.min.js')
    ]);
}
```

Este ejemplo más amplio demuestra cómo se pueden cargar múltiples archivos estáticos, incluyendo scripts y hojas de estilo, utilizando las funciones previamente mencionadas. Todos estos archivos se cargarán desde la carpeta `/public` y se incorporarán en la página, asegurando su correcta inclusión y funcionamiento.


## ViewData

El módulo ViewData es una herramienta para recuperar datos que se han pasado como segundo parámetro cuando se ejecutó la función `view()`. Esto permite acceder a los datos que se utilizan en una vista específica. Aquí se presenta cómo utilizar este módulo:

### Función `get`

Para obtener los datos pasados a través de la función `view()`, puedes utilizar la función `get()` proporcionada por el módulo ViewData. La función se utiliza de la siguiente manera:

```php
public static function get()
```

**Ejemplo de Uso:**

```php
// Uso de la función get() para obtener los datos
$data = ViewData::get();
```

La variable `$data` ahora contiene todos los datos que se pasaron al llamar a la función `view()`. Esto es esencial para acceder y utilizar los datos necesarios en la vista correspondiente.

## CoreJavaScript

El módulo CoreJavaScript es una pequeña biblioteca de lado del cliente que aún se encuentra en desarrollo. A pesar de su estado en desarrollo, esta biblioteca ofrece una serie de funcionalidades que son funcionales para la interacción del lado del cliente en una aplicación web. A continuación, se presenta una descripción general de esta biblioteca y cómo utilizarla.

### Función `requireCore`

Para utilizar las funcionalidades proporcionadas por la biblioteca CoreJavaScript, debes ejecutar la función `requireCore()`. Esta función internamente requiere varios archivos necesarios para habilitar diversas características de la biblioteca. Aquí se muestra cómo utilizar esta función:

```php
function requireCore()
```

**Ejemplo de Uso:**

```php
// Llamada a la función requireCore() para habilitar la biblioteca CoreJavaScript
requireCore();
```

La función `requireCore()` es un paso fundamental para acceder a las funciones y características ofrecidas por esta biblioteca.

### Archivos Incluidos

Los archivos necesarios para la biblioteca CoreJavaScript se encuentran en la carpeta `public/core`. A continuación, se enumeran los archivos incluidos:

- **document.js**: Proporciona funciones relacionadas con la manipulación del DOM y la gestión de elementos en la página web.

- **touch.js**: Ofrece detección y gestión de gestos táctiles en áreas específicas de la pantalla.

- **cookies.js**: Permite la gestión de cookies en el navegador, lo que es útil para almacenar datos localmente.

- **server.js**: Proporciona funciones para realizar redirecciones y manipular la ubicación del navegador.

- **string.js**: Ofrece funcionalidades relacionadas con el manejo y manipulación de cadenas de texto.


Esta estructura proporciona una descripción organizada del módulo CoreJavaScript, su función `requireCore`, y los archivos incluidos, lo que facilita la comprensión y el uso de esta biblioteca en el desarrollo de aplicaciones web.

### document.js

1. **hide(elementId)**
   - Descripción: Esta función oculta un elemento en la página web con el ID especificado. Establece el estilo `display` del elemento en `'none'`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea ocultar.
   - Ejemplo de uso:
     ```javascript
     hide('miElemento'); // Oculta el elemento con ID 'miElemento'.
     ```

2. **show(elementId)**
   - Descripción: Esta función muestra un elemento oculto en la página web con el ID especificado. Establece el estilo `display` del elemento en `'block'`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea mostrar.
   - Ejemplo de uso:
     ```javascript
     show('miElemento'); // Muestra el elemento con ID 'miElemento'.
     ```

3. **isHide(elementId)**
   - Descripción: Esta función verifica si un elemento con el ID especificado está oculto. Retorna `true` si el elemento está oculto (`display` es `'none'`), de lo contrario, retorna `false`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea verificar.
   - Ejemplo de uso:
     ```javascript
     if (isHide('miElemento')) {
         console.log('El elemento está oculto.');
     } else {
         console.log('El elemento no está oculto.');
     }
     ```

4. **isShow(elementId)**
   - Descripción: Esta función verifica si un elemento con el ID especificado está visible. Retorna `true` si el elemento no está oculto (`display` no es `'none'`), de lo contrario, retorna `false`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea verificar.
   - Ejemplo de uso:
     ```javascript
     if (isShow('miElemento')) {
         console.log('El elemento está visible.');
     } else {
         console.log('El elemento está oculto.');
     }
     ```

5. **display(elementId)**
   - Descripción: Esta función retorna el valor actual de la propiedad `display` de un elemento con el ID especificado, lo que indica si está oculto o visible.
   - Parámetros:
     - `elementId` (String): El ID del elemento del que se desea obtener el estado de visualización.
   - Valor de retorno: Una cadena que representa el valor de la propiedad `display` del elemento.
   - Ejemplo de uso:
     ```javascript
     var estado = display('miElemento');
     console.log('El estado de visualización es: ' + estado);
     ```
### cookies.js

1. **setCookie(name, value)**
   - Descripción: Esta función se utiliza para establecer una cookie en el navegador del usuario. Las cookies son pequeños fragmentos de información que se almacenan localmente en el navegador y se pueden utilizar para recordar datos entre sesiones o visitas al sitio web.
   - Parámetros:
     - `name` (String): El nombre de la cookie.
     - `value` (String): El valor que se almacenará en la cookie.
   - Ejemplo de uso:
     ```javascript
     setCookie('miCookie', 'miValor'); // Establece una cookie llamada 'miCookie' con el valor 'miValor'.
     ```

2. **getCookie(name)**
   - Descripción: Esta función se utiliza para obtener el valor de una cookie específica por su nombre.
   - Parámetros:
     - `name` (String): El nombre de la cookie de la que se desea obtener el valor.
   - Valor de retorno: El valor de la cookie si se encuentra, o `null` si la cookie no existe.
   - Ejemplo de uso:
     ```javascript
     var valor = getCookie('miCookie'); // Obtiene el valor de la cookie llamada 'miCookie'.
     if (valor !== null) {
         console.log('Valor de la cookie: ' + valor);
     } else {
         console.log('La cookie no existe.');
     }
     ```

### touch.js

**touch(selector, leftCallable = null, rightCallable = null, upCallable = null, downCallable = null)**
- **Descripción**: La función `touch` permite detectar gestos táctiles en un área específica de la pantalla y ejecutar funciones personalizadas en respuesta a diferentes gestos, como deslizar hacia la izquierda, hacia la derecha, hacia arriba o hacia abajo. Puede proporcionar funciones personalizadas que se ejecutarán cuando ocurran los gestos especificados.
- **Parámetros**:
  - `selector` (String): El selector CSS que define el área donde se detectarán los gestos táctiles.
  - `leftCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia la izquierda.
  - `rightCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia la derecha.
  - `upCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia arriba.
  - `downCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia abajo.
- **Uso**:
  - Para utilizar esta función, proporciona un selector CSS que identifique el área de la pantalla en la que se deben detectar los gestos táctiles.
  - Puedes proporcionar funciones personalizadas (`leftCallable`, `rightCallable`, `upCallable` y `downCallable`) que se ejecutarán cuando ocurran los gestos correspondientes.
- **Ejemplo de uso**:
  ```javascript
  // Ejemplo 1: Detecta gestos táctiles en un elemento con clase "area-tactil"
  touch("area-tactil", () => {
      console.log("Deslizamiento hacia la izquierda");
  }, () => {
      console.log("Deslizamiento hacia la derecha");
  }, () => {
      console.log("Deslizamiento hacia arriba");
  }, () => {
      console.log("Deslizamiento hacia abajo");
  });
  
  // Ejemplo 2: Detecta gestos táctiles en un elemento con clase "otra-area-tactil" (sin funciones personalizadas)
  touch("otra-area-tactil");
  ```

## server.js

**redirectTo(page)**
- **Descripción**: La función `redirectTo` redirige al usuario a una página web específica al cambiar la ubicación del navegador a la URL especificada en `page`. Esto se logra modificando la propiedad `window.location.href`.
- **Parámetros**:
  - `page` (String): La URL de la página a la que se desea redirigir al usuario.
- **Uso**:
  - Proporciona la URL de la página a la que deseas redirigir al usuario.
- **Ejemplo de uso**:
  ```javascript
  // Redirige al usuario a la página "nueva-pagina.html"
  redirectTo("nueva-pagina.html");
  ```

**thisUrl()**
- **Descripción**: La función `thisUrl` retorna la URL actual de la página web en la que se encuentra el usuario. Esto se logra obteniendo la propiedad `window.location`.
- **Retorno**: La función retorna un objeto `Location` que representa la URL actual de la página.
- **Uso**:
  - Puedes llamar a esta función para obtener la URL actual del navegador.
- **Ejemplo de uso**:
  ```javascript
  // Obtiene la URL actual y la muestra en la consola
  const currentUrl = thisUrl();
  console.log(currentUrl.href);
  ```


### Strings.js

**randomString(length)**
- **Descripción**: La función `randomString` genera una cadena de caracteres aleatorios de la longitud especificada. La cadena incluye caracteres alfabéticos en mayúsculas y minúsculas, así como dígitos numéricos.
- **Parámetros**:
  - `length` (Number): La longitud de la cadena aleatoria que se debe generar.
- **Retorno**: La función retorna una cadena de caracteres aleatorios con la longitud especificada.
- **Uso**:
  - Proporciona la longitud deseada para la cadena aleatoria que deseas generar.
- **Ejemplo de uso**:
  ```javascript
  // Genera una cadena aleatoria de 10 caracteres
  const randomValue = randomString(10);
  console.log(randomValue);
  ```


## htmlBuilt

La funcionalidad "htmlBuilt" es una característica que permite utilizar PHP para generar código HTML de manera dinámica. Esto se basa en la idea de que el HTML no es más que texto y, al igual que con las consultas SQL, se pueden utilizar estructuras de control como bucles y condiciones para generar código HTML de manera más eficiente y organizada.

### Estructura de las Funciones de HTML

Las funciones de HTML siguen una estructura específica:

```php
nameEtiqueta(string $principioOFin, Array $attributes = []);
```

- `nameEtiqueta`: Reemplaza "Etiqueta" por el nombre de la etiqueta HTML que deseas generar.
- `$principioOFin`: Debe ser "s" para el inicio (start) de la etiqueta o "e" para el final (end).
- `$attributes`: Es un arreglo opcional que contiene los atributos de la etiqueta.

Por ejemplo, si deseas abrir una etiqueta `div`, usarías la función `div('s', $attributes)` para el inicio y `div('e')` para el final. Esto permite generar HTML de manera más estructurada y legible.

### Añadir Atributos a las Etiquetas

Los atributos se pueden especificar mediante el arreglo `$attributes`. Puedes proporcionar varios atributos dentro de este arreglo para personalizar tu etiqueta HTML. Por ejemplo:

```php
div('s', [
    'class' => 'container',
    'id' => 'NameIdDivContainer'
]);
```

También es posible definir los atributos en una sola línea, como se muestra a continuación:

```php
div('s', [
    'class="container" id="NameId"'
]);
```

Este enfoque facilita la personalización de las etiquetas HTML con los atributos necesarios.

### Personalización de Etiquetas HTML

Si no encuentras una función predefinida para la etiqueta HTML que deseas, puedes crear tu propia función personalizada. Simplemente utiliza la función `newHtml()` para definir la etiqueta y sus atributos. Para hacerlo, consulta el archivo `core/Views/html.php`, donde encontrarás una estructura que te guiará en la creación de tus propias funciones de etiquetas HTML.

La funcionalidad "htmlBuilt" ofrece una forma más eficiente y organizada de generar código HTML dinámico utilizando PHP y estructuras de control. Esta técnica resulta especialmente útil cuando necesitas generar HTML complejo o repetitivo.


# TokenCsrf - Aplicación de Token CSRF en Sao

La aplicación TokenCsrf se utiliza para mitigar la vulnerabilidad de robo de sesión CSRF. Esto se logra mediante un sistema de tokens. Para utilizar esta librería, debes emplear la función `csrf()` en cualquier lugar donde llames a los métodos de esta clase.

## En las Vistas

En el contexto de las vistas, primero debemos configurar el input que se incluirá en el formulario con el token CSRF. Para ello, disponemos de las siguientes funciones:

### Generar e Imprimir un Input de Token

```php
public static function input();
```

Este método se utiliza para imprimir un elemento `<input>` en HTML con un valor de token generado. Si prefieres obtener el valor del token sin imprimirlo directamente, puedes hacerlo con la siguiente función:

### Obtener el Token sin Imprimir el Input

```php
public static function getInput();
```

A continuación, se presenta un ejemplo de uso en un formulario HTML:

```php
<form class="form-login" method="POST" action="<?php route('/api/v1/auth/login') ?>">
    <?php 
        TokenCsrf::input(); 
        Form::addInput('email', 'text', 'Email', 'form-control', 'Escribe tu email');
        Form::addInput('password', 'password', 'Contraseña', 'form-control', 'Escribe tu contraseña');
        Form::PrintInputs();
    ?>
    <label for="register">Si no tienes cuenta,
    <a href="<?php route('/register') ?>">registrate</a></label> <br><br>
    <button type="submit" class="btn btn-secondary">
        Iniciar sesión
    </button>
</form>
```

## En el Controlador

Una vez hemos asegurado que el token debe enviarse, debemos validar que la petición proviene de nuestro formulario y no de otra fuente. Para ello, desde el controlador, podemos hacer uso del siguiente método:

### Validar el Token CSRF

```php
public static function validateToken($request)
```

Este método recibe todo el objeto de la solicitud (`$request`) como parámetro y busca en todo el arreglo si existe una clave llamada `csrf_token`. Luego, verifica si el token es válido. Devuelve `true` si el token es correcto y `false` si la petición no se originó desde el formulario (lo que implicaría que el token no es válido).



# Encrypt - Aplicación de Encriptación de Sao

La aplicación "Encrypt" en Sao contiene dos funcionalidades principales: un encriptador y un hasheador.

## Encriptador

El encriptador proporciona dos métodos fundamentales: `encrypt` y `decrypt`. A continuación, se detalla el funcionamiento de cada uno de ellos:

### Método `encrypt`

```php
public function encrypt(string $string, string $key)

//uso
$encrypt = new Encrypt();
$encrypt->encrypt();
```

Este método toma dos parámetros. El primer parámetro, `string`, es el texto plano que deseas encriptar, y el segundo parámetro, `key`, es la clave que se utilizará para realizar la encriptación. La función `encrypt` devuelve un resultado en forma de cadena de texto. Es importante destacar que cada vez que se ejecuta este método, genera una cadena diferente y aleatoria.

### Método `decrypt`

```php
public function decrypt(string $string, string $key)

//uso
$encrypt = new Encrypt();
$encrypt->decrypt();
```

El método `decrypt` se utiliza para desencriptar una cadena previamente encriptada con el método `encrypt`. Debes proporcionar dos parámetros: el primer parámetro, `string`, es la cadena encriptada que deseas desencriptar, y el segundo parámetro, `key`, es la misma clave que se utilizó para encriptar la cadena. Al utilizar este método, obtendrás el texto plano original.

## Hasher

El "Hasher" es otra parte fundamental de esta aplicación y ofrece dos métodos principales: `make` y `verify`.

### Método `make`

```php
public static function make(string $stringInPlainText)
Hasher::make();
```

El método `make` recibe como parámetro una cadena en texto plano y devuelve un hash resultante. Este hash se utiliza para representar la cadena original de manera segura.

### Método `verify`

```php
public static function verify(string $stringInPlainText, string $hash)
Hasher::verify();
```

El método `verify` se utiliza para comparar una cadena en texto plano con su correspondiente hash. Recibe dos parámetros: el primer parámetro es la cadena en texto plano que deseas verificar, y el segundo parámetro es el hash previamente generado con el método `make`. Si el hash coincide con la cadena proporcionada, el método devuelve `true`; de lo contrario, devuelve `false`.

Estos dos componentes, el encriptador y el hasheador, brindan una capa adicional de seguridad y confidencialidad a tus datos al permitirte encriptar y hashear información de manera efectiva en tus aplicaciones desarrolladas con Sao.


# Server - Aplicación de Servidor en Sao

La parte de Server en Sao se encuentra actualmente en desarrollo y no cuenta con una amplia gama de funciones; sin embargo, una de las funciones más importantes y útiles que ofrece es la capacidad de realizar redirecciones.

## Método Principal: `redirect($route)`

La función principal de la librería Server es `redirect($route)`, la cual desempeña un papel fundamental en la navegación y redirección de tu aplicación. Este método toma una ruta como parámetro y se encarga de redirigir al usuario a la ubicación especificada. A continuación, se muestra un ejemplo de cómo se utiliza:

```php
Server::redirect('/redirectpage');
```

Este ejemplo redirigirá al usuario a la página correspondiente a la ruta '/redirectpage'. La función `redirect($route)`.


# File - Aplicación de archivos de Sao

La librería "File" de Sao se utiliza para gestionar archivos subidos a través del request. A continuación, se describen los pasos para usar esta librería:

## Configuración Inicial

1. **Setear el archivo subido:**

   Para comenzar, debes configurar el archivo subido utilizando el siguiente método:

   ```php
   public static function setFile(array|object $file, $host = null)
   ```

   - `$file` es el objeto que proviene del `$request`.
   - Esta función devuelve un valor booleano, ya que el archivo pasa por una serie de filtros para verificar que no sea malicioso.

2. **Atributos Seguros:**

   La librería comprueba que el archivo tenga los siguientes atributos seguros:

   - Formatos permitidos: `['jpg', 'jpeg', 'png', 'gif']`.
   - Tipos MIME seguros: `['image/jpeg', 'image/png', 'image/gif']`.

   Si deseas configurar formatos permitidos personalizados, puedes utilizar el método:

   ```php
   public static function setAllowedFormats(array $formats)
   ```

   Si deseas establecer tipos MIME permitidos personalizados, puedes utilizar el método:

   ```php
   public static function setSafeMimeTypes(array $mimes)
   ```

3. **Setear el Host:**

   Puedes especificar el host para definir dónde se almacenarán los archivos subidos en el servidor. Esto se hace con el siguiente método:

   ```php
   public static function setHost(string $host)
   ```

## Subir Archivos

Una vez que has configurado los atributos del archivo y el host, puedes subir el archivo utilizando el método `upload`:

```php
public static function upload($nameFile = null, $ruteServer = 'public/uploads', $ruteHost = '/uploads')
```

- Si no especificas el primer parámetro (`$nameFile`), el método `upload` generará un nombre aleatorio para el archivo.
- El segundo parámetro (`$ruteServer`) define la ubicación en el servidor donde se guardarán los archivos.
- El tercer parámetro (`$ruteHost`) especifica la ruta en la parte del cliente desde la cual se accederá a los archivos subidos.

Este método devuelve un valor booleano, `true` si el archivo se ha subido con éxito y `false` en caso de error.

## Obtener Información del Último Archivo Subido

El método `lastFileUploadInfo` te permite obtener información sobre el último archivo subido. Puedes especificar un parámetro para obtener un dato específico o, si no se proporciona ningún parámetro, se te devolverá toda la información del archivo. Los parámetros disponibles son:

- `name`: Obtiene el nombre del archivo.
- `path:upload`: Obtiene la ruta en el servidor (sin el nombre del archivo).
- `host:upload`: Obtiene la ruta completa en el host (incluyendo el nombre del archivo).
- `rute:upload`: Obtiene la ruta en el servidor (sin el host).

## Ejemplo de Implementación

Aquí hay un ejemplo de cómo implementar esta librería para subir un archivo y actualizar el avatar de un usuario:

```php
if (!File::setFile($request['avatar'])) {
    res('Tu archivo es inválido o corrupto');
    File::setHost(serve($_ENV['APP_ADDRESS'].":".$_ENV['APP_PORT']));
    if (File::upload()) {
        $this->userModel()->updateAvatar(File::lastFileUploadInfo('rute:upload'), $idUser);
        Server::redirect('/panel/profile');
    }
}
```

Con esta estructura, puedes administrar fácilmente archivos subidos en tu aplicación Sao.


# Time - Aplicación de tiempo de Sao

La librería "Time" te permite gestionar el tiempo en tu aplicación. Ofrece tres métodos útiles para realizar cálculos relacionados con fechas y edades.

## calculateAgeFromBirthdate

Este método calcula la edad a partir de la fecha de nacimiento.

```php
/**
 * Calculate age from birthdate.
 *
 * @param string $birthdate The birthdate in "YYYY-MM-DD" format.
 *
 * @return array The calculated age.
 */
public function calculateAgeFromBirthdate(string $birthdate)
```

- **Parámetro:** `$birthdate` es la fecha de nacimiento en formato "YYYY-MM-DD".
- **Retorno:** Un array que contiene los años, meses y días que han transcurrido desde la fecha de nacimiento.

## builtMessageAge

El método `builtMessageAge` recibe como parámetro un array que generalmente es el resultado del método `calculateAgeFromBirthdate`. Este método se utiliza para construir un mensaje que describe la edad en años, meses y días.

```php
public function builtMessageAge(array $date)
```

- **Parámetro:** `$date` es un array con índices específicos, como el que se obtiene del método `calculateAgeFromBirthdate`.
- **Retorno:** Un mensaje que indica la edad en el formato "X años, Y meses y Z días".

## calculateDaysDifference

Este método calcula la diferencia en días entre dos fechas.

```php
public function calculateDaysDifference(string $startDate, string $endDate, string $dateFormat = 'Y-m-d')
```

- **Parámetro:** 
  - `$startDate` es la fecha de inicio.
  - `$endDate` es la fecha de finalización.
  - `$dateFormat` es el formato de las dos fechas (por defecto, "Y-m-d").

- **Retorno:** La diferencia en días entre las dos fechas.



