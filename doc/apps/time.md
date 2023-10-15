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