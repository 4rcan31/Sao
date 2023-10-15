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
