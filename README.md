#  Supermercado IC Norte - Proyecto Web
# Características Principales

-  Carrito de compras interactivo
-  Chatbot para atención al cliente
-  Sistema de login con múltiples roles
-  Diseño moderno y responsivo
-  Interfaz adaptable a móviles
-  Panel de administración seguro

# Tecnologías Utilizadas

- HTML5 & CSS3
- JavaScript
- PHP 
- MySQL
- Bootstrap 5
- jQuery

#  Estructura del Proyecto

```
backup_ithan_2025-10-17/
FINALWEBII/              # Frontend principal
    img/                 # Imágenes y recursos
   style.css           # Estilos principales
   carrito.js          # Lógica del carrito
   index.html          # Página principal
admin_access.php        # Panel de administración
login_rol.php          # Sistema de login
chatbot_api.php        # API del chatbot
coneccion.php         # Configuración de BD
```

##  Características Detalladas

- **Carrito de Compras:**
  - Agregar/eliminar productos
  - Actualizar cantidades
  - Cálculo automático del total
  - Generación de facturas

- **Sistema de Usuarios:**
  - Login para clientes
  - Panel de administración
  - Gestión de empleados
  - Historial de compras

- **Chatbot:**
  - Respuestas automáticas
  - FAQs integradas
  - Asistencia en tiempo real

# Instalación y Configuración

1. **Configurar XAMPP:**
   - Instala XAMPP en tu sistema
   - Inicia los servicios de Apache y MySQL

3. **Configuración de la Base de Datos:**
   - Edita `coneccion.php` con tus credenciales:
   ```php
   $host = "localhost";
   $user = "tu_usuario";
   $password = "tu_contraseña";
   $database = "icnorte";
   ```

4. **Acceso al Sistema:**
   

   - Panel Admin: http://localhost/backup_ithan_2025-10-17/admin_register.php 
              

# Roles de Usuario

- **Administrador:** Acceso total al sistema
- **Empleado:** Gestión de productos y ventas
- **Cliente:** Compras y historial

# Notas Importantes

- Mantén actualizado XAMPP para mejor seguridad
- Haz respaldos regulares de la base de datos
- Revisa los logs de error en caso de problemas

#  Contribuciones

¡Las contribuciones son bienvenidas! Si encuentras bugs o tienes sugerencias, por favor:
1. Haz un fork del proyecto
2. Crea una rama para tu feature
3. Haz commit de tus cambios
4. Envía un pull request





# backup_ithan_2025-10-17
