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
- `DB_CONNECTION:` Gestor al que se conectará (por el momento Sao solamente soporta a mysql como driver).
- `DB_HOST:` Host al que se conectará.
- `DB_PORT:` Puerto del host al que se conectará.

##### Valores que generalmente cambian
- `DB_DATABASE:` Nombre de la base de datos a la que se conectará.
- `DB_USERNAME:` Nombre de usuario para acceder al gestor de base de datos.
- `DB_PASSWORD:` Contraseña para acceder al gestor de base de datos (por defecto es vacía).


Ahora que ya configuraste los valores de tu base de datos, puedes comprobar si la conexion ha sido exitosa o no, para eso ejecuta (una vez que ya estes dentro de tu carpeta de tu proyecto):

```sh
php jenu comprobate:connection:mysql
```