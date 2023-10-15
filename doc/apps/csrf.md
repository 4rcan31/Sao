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