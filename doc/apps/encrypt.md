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