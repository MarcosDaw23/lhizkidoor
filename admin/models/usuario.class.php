

<?php
class Usuario {
  private $db;

  public function __construct() {
    try {
      // Ajusta si cambia la contraseña o la BD
      $this->db = new PDO("mysql:host=localhost;dbname=lhizki;charset=utf8", "root", "sanluis");
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Error de conexión a la base de datos: " . $e->getMessage());
    }
  }

  /* ---------- LECTURA ---------- */

  // Obtiene 1 usuario por id (devuelve objeto)
  public function getById($id) {
    $sql = "SELECT id, nombre, apellido, mail AS email, rol, centro,
                   idioma, pais, formato_hora, zona_horaria, firma, avatar_url
            FROM `user`
            WHERE id = ?
            LIMIT 1";
    $st = $this->db->prepare($sql);
    $st->execute([$id]);
    $row = $st->fetch(PDO::FETCH_ASSOC);
    if (!$row) return null;

    // ‘nombre completo’ rápido si quieres usarlo
    if (!empty($row['apellido'])) {
      $row['nombre'] = trim($row['nombre'].' '.$row['apellido']);
    }
    return (object)$row;
  }

  // Lista rápida (ya la tenías como obtenerTodos)
  public function obtenerTodos() {
    $sql = "SELECT id, nombre, apellido, mail AS email, rol, centro FROM `user`";
    $st = $this->db->prepare($sql);
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  /* ---------- ESCRITURA ---------- */

  // Actualiza idioma, país, formato de hora y zona horaria
  public function updateRegional($id, array $d) {
    $sql = "UPDATE `user`
            SET idioma = ?, pais = ?, formato_hora = ?, zona_horaria = ?
            WHERE id = ?";
    $st = $this->db->prepare($sql);
    return $st->execute([
      $d['idioma'] ?? 'español',
      $d['pais'] ?? 'España',
      $d['formatoHora'] ?? '24 horas',
      $d['zonaHoraria'] ?? 'Europe/Madrid',
      $id
    ]);
  }

  // Actualiza la firma
  public function updateSignature($id, $firma) {
    $st = $this->db->prepare("UPDATE `user` SET firma = ? WHERE id = ?");
    return $st->execute([$firma, $id]);
  }

  // Actualiza la url del avatar
  public function updateAvatar($id, $url) {
    $st = $this->db->prepare("UPDATE `user` SET avatar_url = ? WHERE id = ?");
    return $st->execute([$url, $id]);
  }
}
