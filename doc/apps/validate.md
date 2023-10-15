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