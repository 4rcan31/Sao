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