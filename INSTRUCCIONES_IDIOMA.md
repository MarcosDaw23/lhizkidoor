# 🌐 Sistema de Idiomas - Instrucciones de Instalación

## ⚠️ IMPORTANTE: Ejecutar el script SQL primero

Antes de usar el sistema, debes ejecutar el siguiente script en **phpMyAdmin** o **MySQL Workbench**:

### Pasos:

1. Abre **phpMyAdmin** en tu navegador: `http://localhost/phpmyadmin`
2. Selecciona la base de datos **lhizki** en el panel izquierdo
3. Haz clic en la pestaña **SQL**
4. Copia y pega el siguiente código:

```sql
USE lhizki;

-- Añadir columna idioma a la tabla user
ALTER TABLE `user` ADD COLUMN `idioma` VARCHAR(20) DEFAULT 'español' AFTER `clase`;

-- Actualizar usuarios existentes al idioma por defecto
UPDATE `user` SET `idioma` = 'español' WHERE `idioma` IS NULL;
```

5. Haz clic en el botón **Continuar** para ejecutar el script
6. ¡Listo! La base de datos ahora soporta el campo de idioma

---

## ✅ Cambios Realizados

### 1. **Base de Datos**
- ✅ Campo `idioma` añadido a la tabla `user`
- ✅ Valores por defecto: 'español'

### 2. **Modelo de Usuario**
- ✅ Clase `User_class.php` actualizada con propiedad `idioma`
- ✅ Getters y setters añadidos

### 3. **Sistema de Registro**
- ✅ Campo de selección de idioma en formulario de registro
- ✅ Validación actualizada para incluir idioma
- ✅ Controlador de registro guarda el idioma en BD

### 4. **Sistema de Login**
- ✅ El idioma se carga en la sesión del usuario al iniciar sesión
- ✅ Variable `$_SESSION['user']['idioma']` disponible en toda la app

### 5. **Sistema de Traducciones**
- ✅ Archivo `core/idiomas.php` con traducciones español/euskera
- ✅ Función helper `t('clave')` para traducir textos
- ✅ Función `idiomaActual()` para obtener el idioma actual
- ✅ Función `cambiarIdioma($nuevo)` para cambiar el idioma

### 6. **Interfaz de Usuario**
- ✅ Menú de navegación traducido dinámicamente
- ✅ Botones y textos comunes traducidos
- ✅ Menú móvil también traducido

---

## 🎯 Cómo Usar el Sistema de Traducciones

### En tus archivos PHP:

```php
<?php
// Incluir el sistema de traducciones
require_once __DIR__ . '/../core/Helpers.php';

// Usar traducciones
echo t('inicio');        // Muestra "Inicio" o "Hasiera" según el idioma
echo t('perfil');        // Muestra "Perfil" o "Profila"
echo t('guardar');       // Muestra "Guardar" o "Gorde"

// Obtener el idioma actual
$idioma = idiomaActual(); // Devuelve 'español' o 'euskera'
?>

<!-- En HTML -->
<button><?= t('guardar') ?></button>
<h1><?= t('bienvenido') ?></h1>
<a href="#"><?= t('cerrar_sesion') ?></a>
```

### Añadir Nuevas Traducciones:

Edita el archivo `core/idiomas.php` y añade nuevas claves:

```php
$traducciones = [
    'español' => [
        'tu_clave' => 'Texto en español',
        // ...
    ],
    'euskera' => [
        'tu_clave' => 'Testua euskaraz',
        // ...
    ]
];
```

---

## 🧪 Probar el Sistema

1. **Registra un nuevo usuario** seleccionando **Euskera** como idioma
2. **Inicia sesión** con ese usuario
3. **Verifica** que el menú de navegación aparezca en euskera:
   - Inicio → Hasiera
   - Juegos → Jokoak
   - Rankings → Sailkapenak
   - Glosario → Glosarioa
   - Cerrar Sesión → Saioa Itxi

---

## 📝 Notas Adicionales

- El idioma se guarda en la **base de datos** y en la **sesión**
- Al cerrar sesión y volver a iniciar, el idioma se mantiene
- Los usuarios existentes tendrán **español** como idioma por defecto
- Puedes ampliar el sistema a más idiomas editando `core/idiomas.php`

---

## 🐛 Solución de Problemas

**Problema:** Las traducciones no aparecen
- **Solución:** Verifica que hayas incluido `require_once __DIR__ . '/../core/Helpers.php';` en tu archivo

**Problema:** Error SQL al registrar usuario
- **Solución:** Asegúrate de haber ejecutado el script SQL para añadir la columna `idioma`

**Problema:** El idioma no cambia
- **Solución:** Cierra sesión y vuelve a iniciar sesión para que se cargue el nuevo idioma

---

¡Sistema de idiomas instalado con éxito! 🎉

