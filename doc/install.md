# Instalación

Para descargar Sao, ejecuta:

```sh
git clone https://github.com/4rcan31/Sao.git
```

Una vez instalado, debes eliminar la carpeta `.git`.

En Windows, usa el comando `rmdir`:
```sh
rmdir /s /q sao\.git
```

En sistemas Unix o Linux (incluyendo macOS), usa el comando `rm`:
```sh
rm -rf sao/.git
```

Ahora solo necesitas cambiar el nombre de la carpeta `Sao` al nombre de tu proyecto. Utiliza el comando:

En Windows:
```sh
ren sao nombre_de_tu_app
```

En Unix, Linux o macOS:
```sh
mv sao nombre_de_tu_app
```

ahora ya puedes entrar a tu proyecto haciendo:

```sh
cd nombre_de_tu_app
```