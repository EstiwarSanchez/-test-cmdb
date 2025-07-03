# Sistema de Gestión CMDB con API Aleph

Aplicación Laravel para gestionar categorías y registros CMDB consumiendo la API de Aleph, con funcionalidades de exportación/importación Excel.

---

## Requisitos Técnicos
- PHP 8.1+
- Laravel 10+
- Composer 2+
- Redis 6+ (para caché)
- MySQL 8+ o PostgreSQL 13+
- Node.js 16+ (para frontend)

---

## Instalación

1. **Clonar repositorio**:
```bash
git clone [url-del-repositorio]
cd nombre-del-proyecto
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

CACHE_DRIVER=redis
SESSION_DRIVER=redis

ALEPH_API_BASE_URL=https://url-api-aleph.com/api
ALEPH_API_TOKEN=tu_token_aleph
```

6. **Migrar base de datos** (si aplica):
```bash
php artisan migrate
```

---

## Frontend

7. **Instalar dependencias JavaScript**:
```bash
npm install
```

8. **Compilar assets**:
```bash
npm run dev
```

> Para compilar en producción:
```bash
npm run build
```

---

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
- Redis es usado para cachear categorías. Puedes vaciar caché con:

```bash
php artisan cache:clear
```

---

## Licencia

Este proyecto está licenciado bajo MIT.
