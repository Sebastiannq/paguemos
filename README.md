# SISPAGUEMENOS - Sistema de Información para Ventas e Inventario

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Kotlin](https://img.shields.io/badge/kotlin-%237F52FF.svg?style=for-the-badge&logo=kotlin&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Android Studio](https://img.shields.io/badge/android%20studio-34b271?style=for-the-badge&logo=android-studio&logoColor=white)

## Descripción del Proyecto
**Pague Menos** es una solución integral diseñada para optimizar el control de inventario y ventas de una tienda de ropa. El sistema surge para resolver la problemática del control manual, evitando la pérdida de stock, la falta de sincronización entre bodega y punto de venta, y facilitando la toma de decisiones administrativas.

El ecosistema cuenta con una **Plataforma Web (Administración)** y una **Aplicación Móvil (Gestión de Inventario)** que se comunican en tiempo real mediante una API REST.

---

##  Características Principales
- **Gestión de Inventario (CRUD):** Registro detallado de prendas con atributos de talla, color y género.
- **App Móvil Nativa:** Registro de productos desde dispositivos móviles con captura de imágenes.
- **Sincronización Real-Time:** Comunicación mediante API REST y formato JSON.
- **Control de Acceso (RBAC):** Roles diferenciados para Administradores, Empleados y Clientes.
- **Seguridad:** Autenticación de sesiones y encriptación de contraseñas (Bcrypt).
- **Reportes:** Visualización de stock y movimientos de inventario.

---

##  Stack Tecnológico

### Backend & Web
*   **Lenguaje:** PHP 8.x
*   **Framework:** [Laravel](https://laravel.com/)
*   **Base de Datos:** MySQL
*   **Servidor Local:** Laragon

### Mobile
*   **Lenguaje:** Kotlin
*   **Entorno:** Android Studio
*   **Comunicación:** Volley (Consumo de API REST)
*   **Procesamiento de Imágenes:** Base64 encoding/decoding

---

##  Arquitectura de Comunicación (API REST)
El sistema utiliza una arquitectura desacoplada donde la App Móvil consume servicios expuestos por Laravel:

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/prendas/parametros` | Obtiene listas de tallas, colores y géneros. |
| `POST` | `/api/registrar-prenda` | Envía datos de una nueva prenda (incluye imagen en Base64). |

---

##  Instalación y Configuración

### Requisitos
*   PHP >= 8.1
*   Composer
*   Laragon o XAMPP
*   Android Studio (para la App)

### Pasos (Backend)
1. Clonar el repositorio:
   ```bash
   git clone [https://github.com/tu-usuario/sispaguemos.git](https://github.com/tu-usuario/sispaguemos.git)
