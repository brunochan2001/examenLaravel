# 📚 Sistema de Biblioteca

Sistema en Laravel para gestionar libros, autores y la relación entre ambos (autorías), con autenticación de usuarios.

## 🚀 Cómo correr el proyecto localmente

```bash
# 1. Clonar el repositorio
git clone https://github.com/brunochan2001/examenLaravel.git
cd examenLaravel

# 2. Instalar dependencias de PHP
composer install

# 3. Instalar dependencias de JS
npm install

# 4. Configurar variables de entorno
cp .env.example .env
php artisan key:generate

# 6. Ejecutar migraciones
php artisan migrate

# 7. Levantar el servidor
php artisan serve

# 8. Ejecutar Vite
npm run dev
```

Luego abre en el navegador:

```
http://127.0.0.1:8000
```

Regístrate o inicia sesión para acceder a las secciones de **Libros**, **Autores** y **Autorías**.

## 🗂️ Tablas del sistema

- **Autores**: registra a los autores (nombre, apellido, nacionalidad, fecha de nacimiento) y los libros que han escrito.
- **Libros**: registra el catálogo de libros (título, descripción, páginas, stock, idioma) y sus autores.
- **Autorías**: tabla de relación entre `autores` y `libros` (muchos a muchos), indicando qué autor escribió qué libro.

## 🖼️ Vistas del sistema

### Libros

![Vista de Libros](https://i.postimg.cc/sgCBdrMN/Screenshot-2026-06-27-195139.png)

### Autores

![Vista de Autores](https://i.postimg.cc/JzCyVLsF/Screenshot-2026-06-27-195145.png)

### Autorías

![Vista de Autorías](https://i.postimg.cc/3xQy5Tk6/Screenshot-2026-06-27-195152.png)
