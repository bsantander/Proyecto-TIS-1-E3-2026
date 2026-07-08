# Proyecto-TIS-1-E3-2026
Proyecto de Taller de Ingeniería de Software 1 - 2026 (Equipo 3).


## Descripción
Este proyecto es una plataforma de gestión y trazabilidad de activos tecnológicos, desarrollada como parte del Taller de Ingeniería de Software 1. El sistema permite el control de inventario de equipos (computadores, proyectores, impresoras, servidores, etc.), la gestión de responsables (funcionarios) y la trazabilidad de proveedores, optimizando la administración de recursos tecnológicos mediante el uso de fichas técnicas y códigos QR.Actualizado el antiguo sistema de gestion Excel que ya se encontraba ineficiente 

## Instalación
Para poner en marcha el proyecto en su entorno local:
1. **Requisitos:** Tener instalado XAMPP (Apache y MySQL).
2. **Clonación:** Clone el repositorio en la carpeta `htdocs` de su instalación de XAMPP:
   `git clone https://github.com/bsantander/Proyecto-TIS-1-E3-2026.git`
3. **Base de Datos:**
   - Inicie Apache y MySQL desde el panel de XAMPP.
   - Acceda a `http://localhost/phpmyadmin/`.
   - Cree una base de datos denominada `bdd_tis`.
   - Importe el archivo `database/backup.sql` que se encuentra en la carpeta del proyecto o copie el backup directamente desde el archivo bdd_tis.sql y péguelo en la parte de Sql de phpmyadmin
4. **Conexión:** Confirme que las credenciales de base de datos en el archivo `conexion.php` esten adaptadas ya a su entorno local.

## Instrucciones de uso
1. Acceda al sistema a través de su navegador en `http://localhost/Proyecto-TIS-1-E3-2026/`.
2. Utilice el panel principal para visualizar el inventario de equipos, los funcionarios, departamentos o proovedores disponibles.
3. Haga clic en el botón "Agregar" para registrar un nuevo equipo, departamento, proovedor o funcionario.
4. Para agregar un equipo seleccione el tipo de dispositivo para cargar los campos específicos correspondientes.
5. Los detalles del equipo incluyen información técnica, funcionario responsable y proveedor asignado.

## Estructura de carpetas

| Archivo / Carpeta | Descripción |
| :--- | :--- |
| `/` | Directorio raíz del proyecto |
| `assets/` | Archivos CSS, JS|
| `includes/` | Código reciclado (inicio de sesión y verificación) |
| `models/` | Lógica y funciones CRUD |
| `Pages_Admin/` | Vistas (Frontend) del sistema para Administradores |
| `Pages_Tecnico/` | Vistas (Frontend) del sistema para Técnicos |
| `bdd_tis.sql` | Base de datos del sistema |
| `conexion.php` | Archivo de conexión a base de datos |
| `index.php` | Página de inicio del sistema |
| `LICENSE` | Licencias del proyecto |
| `README.md` | Documentación del proyecto |
| `sesion.php` | Gestión de inicio de sesión |

## Contribución

| Nombre | Rol | Contribucion | 
| --- | --- | --- |
| Debora Huerta| Especificacion de requisitos |Contenedor gestion de costo y dashboards de equipo|
| Andres Lopez| Diseño de bases de datos|Contenedor de Equipos y proovedores|
| Matias Olave | Especificacion de requisitos | Contenedor de departamentos|
| Bastian Santander|Lider de equipo | Contenedor de Mantenimiento y reportes|
| Martin Williams |Mockaps y diagramas de casos de uso |Contenedor de funcionarios |


## Equipo de Desarrollo
| Nombre | Apellido | Usuario GitHub |
| :--- | :--- | :--- |
| Andres | Lopez | [alopezm22](https://github.com/alopezm22) |
| Matias | Olave | [matiasolave1](https://github.com/matiasolave1) |
| Bastian | Santander | [bsantander](https://github.com/bsantander) |
| Martin | Williams | [mwilliams-pixel](https://github.com/mwilliams-pixel) |
| Devora | Huerta | [KDeebie](https://github.com/KDeebie) |