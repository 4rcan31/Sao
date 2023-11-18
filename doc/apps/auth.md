# Sauth - Aplicación de Autenticación de Sao

Sauth es una biblioteca que te permite autenticar entidades en Sao de dos formas: firmando JSON Web Tokens (JWT) o utilizando tokens generados por la biblioteca. Asegúrate de tener la librería JWT en tu proyecto (verifica `composer.json`).

## Autenticación sin JSON Web Token

Si no deseas usar JWT, puedes autenticar utilizando un token generado por esta biblioteca y guardarlo en la base de datos. El proceso de autenticación en el servidor se realiza con la siguiente función:

```php
public static function NewAuthServerSave(string $table, string $column, int $id, string $idColumnName = 'id')
```

- `$table`: Nombre de la tabla donde se guarda el token de autenticación.
- `$column`: Nombre de la columna en la que se guarda el token.
- `$id`: ID (entero) de la entidad que inicia la nueva sesión.
- `$idColumnName`: Nombre de la columna de ID (por defecto, 'id').

Este método almacena un token generado en la tabla `$table`, en la columna `$column`, donde `$idColumnName` sea igual a `$id`. Sin embargo, el token aún no se ha guardado en el cliente. Para almacenarlo en el cliente, utiliza la siguiente función:

```php
public static function NewAuthClient(array $payload, string $key = null, int $timeInDays = 7)
```

- `$payload`: Información de la entidad que desees guardar en el cliente.
- `$key`: Clave para cifrar esta información. Puedes proporcionar una propia o utilizar la que está en el archivo `.env`: `$_ENV['APP_KEY']` por defecto.

Aquí tienes un ejemplo de inicio de sesión:

```php
class usersController extends baseController {
    public function login($request) {
        // Valida el request
        $validate = validate($request);
        $validate->rule('required', ['email', 'password']); 
        $validate->rule('email', ['email']);

        if (!$validate->validate()) {
            res(['Debes rellenar todos los campos']);
        }

        $email = $validate->input('email');
        $passwordTextPlain = $validate->input('password');
        $user = model('UserModel');

        if (!$user->existUserByEmail($email)) {
            res(['No tienes una cuenta creada']);
        }

        $row = $user->getByEmail($email);
        $passwordhash = $row->password; 

        // Verifica la contraseña
        core('Encrypt/hasher.php', false);
        
        if (!Hasher::verify($passwordTextPlain, $passwordhash)) {
            res(['Tu contraseña es incorrecta']);
        }

        // Autenticación del servidor
        Sauth::NewAuthServerSave('users', 'remember_token', $row->id);

        // Autenticación del cliente
        Sauth::NewAuthClient([
            'id' => $row->id,
            'name' => $row->name
        ]);

        res(['Te has logueado correctamente']); 
    }
}
```

Y aquí está tu modelo de usuarios:

```php
class UserModel extends baseModel {
    public function existUserByEmail(string $email) {
        $this->prepare(); 
        $this->select(['email'])
        ->from('users')
        ->where('email', $email);
        return $this->execute()->exists();
    }

    public function getByEmail(string $email) {
        $this->prepare();
        $this->select(['*'])
        ->from('users')
        ->where('email', $email);
        return $this->execute()->all();
    }
}
```

Si deseas obtener datos de un cliente autenticado, puedes usar el método de Sauth:

```php
public static function getPayLoadTokenClient(string $tokenRequest, string $key, string $input = '')
```

Ejemplo:

```php
$idUser = $this->clientAuth()->id;
```

Para simplificar el proceso, el controlador base tiene una función que facilita esta acción.

Si deseas un middleware para este tipo de autenticación, puedes crearlo de esta manera:

```php
class AuthMiddleware {
    public function session() {
        return $this->middlewareAuthServerAndClient();
    }

    public function middlewareAuthServerAndClient() {
        if (!isset(Request::$cookies['session'])) {
            return false;
        }
        $idUserClient = Sauth::getPayLoadTokenClient(Request::$cookies['session'], $_ENV['APP_KEY'], 'id');
        
        if (!$idUserClient) {
            return false;
        }
        
        return Sauth::middlewareAuthServerAndClient(Request::$cookies['session'], $_ENV['APP_KEY'], 'users', 'remember_token', $idUserClient);
    }
}
```

El método `session` se utiliza como middleware en la aplicación de enrutamiento. Para desautenticar a un usuario, primero utiliza el método `logoutServer` en el lado del servidor y luego el método `logoutClient` en el lado del cliente.

## Autenticación con JSON Web Token (JWT)

Para autenticar con JWT en Sao, asegúrate de que la librería Firebase JWT esté descargada en tu proyecto. Para iniciar la autenticación, utiliza:

```php
public static function NewAuthServerJWT(array $payload, string $signature, string $algorithm = 'HS256')
```

- `$payload`: Información a guardar en el token.
- `$signature`: Firma del token (puede ser `$_ENV['APP_KEY']`).
- `$algorithm`: Algoritmo para firmar el token (por defecto, 'HS256').

Esto generará un token JWT:

```php
$jsonWebToken = Sauth::NewAuthServerJWT([
    'id' => 1
], $_ENV['APP_KEY']);
```

Si deseas verificar la validez de un token JWT, utiliza el método:

```php
public static function middlewareAuthJsonWebToken(string $token, string $signature, string $algorithm = 'HS256')
```

Este método devuelve `true` si el token con la firma correspondiente es válido y `false` en caso contrario.

Para obtener el payload, utiliza el método:

```php
public static function getPayloadAuthJsonWebToken(string $token, string $signature, string $algorithm = 'HS256')
```

Ten en cuenta que la autenticación con JSON Web Token no ha sido probada exhaustivamente y puede tener errores.

Sauth ofrece flexibilidad en la autenticación y te permite elegir el método que mejor se adapte a tus necesidades en tu aplicación Sao.