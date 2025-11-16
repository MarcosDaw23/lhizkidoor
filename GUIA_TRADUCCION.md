# 🌍 Guía de Traducción - Sistema Multiidioma LHizki

## ✅ ¿Qué se ha traducido?

### Archivos completamente traducidos:
- ✅ `auth/sections/login.php` - Formulario de inicio de sesión
- ✅ `auth/sections/registro.php` - Formulario de registro (incluye JavaScript)
- ✅ `auth/index.php` - Página principal de autenticación con features
- ✅ `usuario/index.php` - Menú de navegación principal

### Diccionario de Traducciones Expandido:
El archivo `core/idiomas.php` ahora incluye **más de 120 traducciones** que cubren:
- ✅ Navegación y menús
- ✅ Formularios de autenticación
- ✅ Página de inicio (home)
- ✅ Sección de juegos
- ✅ Perfil de usuario
- ✅ Rankings
- ✅ Mensajes del sistema
- ✅ Botones y acciones comunes

---

## 🚀 Cómo Traducir Archivos Adicionales

Para traducir cualquier archivo PHP en la carpeta `usuario` o `auth`:

### Paso 1: Incluir el sistema de traducciones

Al inicio del archivo PHP, añade:

```php
<?php
// Cargar sistema de traducciones
require_once __DIR__ . '/../../core/Helpers.php';
?>
```

### Paso 2: Reemplazar textos estáticos

**Antes:**
```php
<h1>Bienvenido</h1>
<p>Tu puntuación: <?= $puntos ?></p>
<button>Guardar</button>
```

**Después:**
```php
<h1><?= t('bienvenido') ?></h1>
<p><?= t('tu_puntuacion') ?>: <?= $puntos ?></p>
<button><?= t('guardar') ?></button>
```

### Paso 3: Añadir nuevas traducciones si es necesario

Si un texto no está en el diccionario, añádelo en `core/idiomas.php`:

```php
$traducciones = [
    'español' => [
        // ...
        'mi_nuevo_texto' => 'Mi texto en español',
    ],
    'euskera' => [
        // ...
        'mi_nuevo_texto' => 'Nire testua euskaraz',
    ]
];
```

---

## 📚 Traducciones Disponibles

### Navegación
- `inicio`, `perfil`, `juegos`, `rankings`, `glosario`
- `cerrar_sesion`, `salir`

### Autenticación
- `iniciar_sesion`, `registrate`, `email`, `contraseña`
- `olvido_contraseña`, `no_tienes_cuenta`, `registrate_aqui`
- `ya_tienes_cuenta`, `inicia_sesion_aqui`

### Formularios
- `nombre`, `apellido`, `centro`, `sector`, `clase`, `idioma`
- `selecciona_centro`, `selecciona_sector`, `selecciona_clase`
- `guardar`, `cancelar`, `editar`, `eliminar`, `buscar`
- `siguiente`, `anterior`, `atras`

### Home Usuario
- `kaixo`, `aun_no_jugado`, `completaste_partida`
- `jugar_partida_semanal`, `repasar_preguntas`
- `tu_puntuacion`, `partida_disponible`, `juega_ahora`

### Juegos
- `practica_libre`, `traduccion_rapida`, `ahorcado_tecnico`
- `desc_practica_libre`, `desc_traduccion`, `desc_ahorcado`
- `mas_popular`, `nuevo`, `proximamente`

### Perfil
- `mi_perfil_titulo`, `informacion_personal`, `informacion_academica`
- `nueva_password`, `confirmar_password`, `guardar_cambios`
- `perfil_actualizado`, `password_no_coinciden`

### Y muchas más... (ver `core/idiomas.php`)

---

## 🎯 Ejemplos de Uso

### En HTML
```php
<h1><?= t('inicio') ?></h1>
<p><?= t('bienvenido') ?>, <?= $usuario['nombre'] ?>!</p>
```

### En Atributos
```php
<input placeholder="<?= t('tu_email') ?>" />
<button title="<?= t('guardar') ?>">💾</button>
```

### En JavaScript (dentro de PHP)
```javascript
alert('<?= t('mensaje_exito') ?>');
console.log('<?= t('cargando') ?>...');
```

### Condicional
```php
<?php if ($yaJugo): ?>
    <p><?= t('completaste_partida') ?></p>
<?php else: ?>
    <p><?= t('aun_no_jugado') ?></p>
<?php endif; ?>
```

---

## 🔧 Funciones Disponibles

### `t($clave, $idioma = null)`
Traducir un texto (alias de `obtenerTraduccion`)

```php
echo t('inicio');        // "Inicio" o "Hasiera"
echo t('guardar');       // "Guardar" o "Gorde"
```

### `idiomaActual()`
Obtener el idioma actual del usuario

```php
$idioma = idiomaActual(); // "español" o "euskera"
```

### `cambiarIdioma($nuevoIdioma)`
Cambiar el idioma de la sesión

```php
cambiarIdioma('euskera'); // Cambiar a euskera
```

---

## 📝 Archivos que PUEDES Traducir

### Carpeta `usuario/sections/`:
- `home.php` - Ya tiene traducciones disponibles
- `juegos.php` - Ya tiene traducciones disponibles  
- `perfil.php` - Ya tiene traducciones disponibles
- `rankings.php`
- `preguntas.php`
- `verGlosario.php`
- `resultadosPartidas.php`
- `traduccionJuego.php`
- Y todos los demás archivos en esta carpeta

### Carpeta `auth/`:
- ✅ Ya traducida completamente

---

## ⚠️ IMPORTANTE: NO Traducir

**NO traduzcas archivos en estas carpetas:**
- ❌ `/admin/` - Área de administración (excluida por petición del usuario)
- ❌ `/profesor/` - Área de profesores (excluida por petición del usuario)

---

## 🧪 Probar las Traducciones

1. **Ejecuta el script SQL** (ver `INSTRUCCIONES_IDIOMA.md`)
2. **Registra un usuario en euskera**
3. **Inicia sesión** y verifica que:
   - El menú está en euskera
   - Los formularios están en euskera
   - Los botones están en euskera
   - Los mensajes están en euskera

---

## 💡 Tips y Mejores Prácticas

1. **Usa claves descriptivas**: Mejor `jugar_partida_semanal` que `btn1`
2. **Mantén consistencia**: Si usas `guardar` en un lugar, úsalo siempre
3. **No traduzcas nombres propios**: "LHizki" siempre es "LHizki"
4. **Prueba en ambos idiomas**: Verifica que todo se vea bien
5. **Añade contexto**: Los textos deben tener sentido sin el contexto visual

---

## 🎨 Añadir Más Idiomas

Para añadir un nuevo idioma (ej: inglés):

```php
$traducciones = [
    'español' => [ /* ... */ ],
    'euskera' => [ /* ... */ ],
    'ingles' => [
        'inicio' => 'Home',
        'perfil' => 'Profile',
        'juegos' => 'Games',
        // ...
    ]
];
```

Luego actualiza el formulario de registro para incluir la nueva opción.

---

¡El sistema de idiomas está listo para ser usado! 🎉

Si encuentras algún texto sin traducir, simplemente:
1. Añádelo a `core/idiomas.php`
2. Usa `<?= t('mi_clave') ?>` donde lo necesites
3. ¡Listo!

