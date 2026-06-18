# Proyecto-TIS-1-E3-2026
Proyecto de Taller de Ingeniería de Software 1 - 2026 (Equipo 3)

## 📝 Descripción
Este proyecto es una plataforma de gestión y trazabilidad de activos tecnológicos, desarrollada como parte del Taller de Ingeniería de Software 1. El sistema permite el control de inventario de equipos (computadores, proyectores, impresoras, servidores, etc.), la gestión de responsables (funcionarios) y la trazabilidad de proveedores, optimizando la administración de recursos tecnológicos mediante el uso de fichas técnicas y códigos QR.

## ⚙️ Instalación
Para poner en marcha el proyecto en su entorno local:
1. **Requisitos:** Tener instalado XAMPP (Apache y MySQL).
2. **Clonación:** Clone el repositorio en la carpeta `htdocs` de su instalación de XAMPP:
   `git clone https://github.com/[TU_USUARIO]/Proyecto-TIS-1-E3-2026.git`
3. **Base de Datos:**
   - Inicie Apache y MySQL desde el panel de XAMPP.
   - Acceda a `http://localhost/phpmyadmin/`.
   - Cree una base de datos denominada `nodo_activo`.
   - Importe el archivo `database/backup.sql` que se encuentra en la carpeta del proyecto.
4. **Conexión:** Configure las credenciales de base de datos en el archivo `conexion.php` según su entorno local.

## 🚀 Instrucciones de uso
1. Acceda al sistema a través de su navegador en `http://localhost/Proyecto-TIS-1-E3-2026/Pages_Admin/equipos.php`.
2. Utilice el panel principal para visualizar el inventario.
3. Haga clic en el botón "Agregar" para registrar un nuevo equipo.
4. Seleccione el tipo de dispositivo para cargar los campos específicos correspondientes.
5. Los detalles del equipo incluyen información técnica, funcionario responsable y proveedor asignado.

## 📂 Estructura de carpetas
/
├── assets/           # Archivos CSS, JS e imágenes
├── conexion.php      # Archivo de conexión a base de datos
├── database/         # Scripts SQL de respaldo
├── models/           # Lógica de negocio y funciones CRUD (Mod_Equipos.php)
├── Pages_Admin/      # Vistas (Frontend) del sistema
└── README.md         # Documentación del proyecto

## 🤝 Contribución
Este proyecto sigue un flujo de trabajo basado en Git:
1. Haga un *fork* del repositorio.
2. Cree una rama para su nueva funcionalidad (`git checkout -b feature/nombre-funcionalidad`).
3. Realice sus cambios y haga commit (`git commit -m 'Descripción del cambio'`).
4. Envíe un *Pull Request* para su revisión.

## 👥 Equipo de Desarrollo (Equipo 3)
| Nombre | Apellido | Usuario GitHub |
| :--- | :--- | :--- |
| [Nombre] | [Apellido] | [@usuario1](https://github.com/usuario1) |
| [Nombre] | [Apellido] | [@usuario2](https://github.com/usuario2) |
| [Nombre] | [Apellido] | [@usuario3](https://github.com/usuario3) |