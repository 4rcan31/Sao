# Server - Aplicación de Servidor en Sao

La parte de Server en Sao se encuentra actualmente en desarrollo y no cuenta con una amplia gama de funciones; sin embargo, una de las funciones más importantes y útiles que ofrece es la capacidad de realizar redirecciones.

## Método Principal: `redirect($route)`

La función principal de la librería Server es `redirect($route)`, la cual desempeña un papel fundamental en la navegación y redirección de tu aplicación. Este método toma una ruta como parámetro y se encarga de redirigir al usuario a la ubicación especificada. A continuación, se muestra un ejemplo de cómo se utiliza:

```php
Server::redirect('/redirectpage');
```

Este ejemplo redirigirá al usuario a la página correspondiente a la ruta '/redirectpage'. La función `redirect($route)`.