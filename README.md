# Sistema de Gestión CMDB con API Aleph

Aplicación Laravel para gestionar categorías y registros CMDB consumiendo la API de Aleph, con funcionalidades de exportación/importación Excel.

---

## Requisitos Técnicos
- PHP 8.1+
- Laravel 10+
- Composer 2+

---

## Instalación

1. **Clonar repositorio**:
```bash
git clone https://github.com/EstiwarSanchez/-test-cmdb.git
cd -test-cmdb
```

2. **Instalar dependencias PHP**:
```bash
composer install
```

3. **Copiar archivo `.env`**:
```bash
cp .env.example .env
```

4. **Generar clave de aplicación**:
```bash
php artisan key:generate
```

5. **Configurar variables de entorno**  
Edita el archivo `.env` y ajusta los siguientes valores:

```dotenv
APP_NAME=CMDB
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña


ALEPH_API_BASE_URL=https://url-api-aleph.com/api
ALEPH_API_TOKEN=tu_token_aleph
```

6. **Migrar base de datos** (si aplica):
```bash
php artisan migrate
```

## Servidor local

9. **Levantar servidor Laravel**:
```bash
php artisan serve
```

Accede a: `http://localhost:8000`

---

## Tareas disponibles

- `php artisan cmdb:export {categoriaId}` → Exporta Excel de una categoría
- `php artisan cmdb:import {archivo.xlsx}` → Importa registros desde archivo Excel
- Interfaz de carga y descarga desde `/cmdb`

---

## Consideraciones

- Las categorías y campos dinámicos provienen de la API Aleph, por lo que es importante tener configurado correctamente el endpoint y token.
- El sistema detecta automáticamente si un item debe crearse o actualizarse, basándose en el campo `identificador`.

```bash
php artisan cache:clear
```

---

## Licencia

Este proyecto está licenciado bajo MIT.
