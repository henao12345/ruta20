<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit; }
include("../config/conexion.php");

$msg = '';

// Guardar cambios
if($_POST && isset($_POST['id'])){
    $id     = intval($_POST['id']);
    $precio = floatval($_POST['precio_base']);
    $aero   = $conexion->real_escape_string($_POST['aeropuerto']);
    $activo = isset($_POST['activo']) ? 1 : 0;
    $conexion->query("UPDATE destinos SET precio_base=$precio, aeropuerto='$aero', activo=$activo WHERE id=$id");
    $msg = 'success';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Destinos — Admin Ruta 20</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{ --bg:#050a20;--bg2:#0a0c2e;--bg3:#111b54;--gold2:#f0cc7a;--text:#c8d6f8;--border:rgba(200,214,248,0.1); }
body{ font-family:'Poppins',sans-serif;background:linear-gradient(135deg,var(--bg) 0%,var(--bg2) 40%,var(--bg3) 100%);min-height:100vh;color:var(--text);margin:0; }
.topbar{ background:rgba(5,10,32,0.95);border-bottom:1px solid var(--border);padding:14px 32px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100; }
.topbar-brand{ font-size:1.1rem;font-weight:700;color:#fff; }
.topbar-brand span{ color:var(--gold2); }
.topbar a{ font-size:0.8rem;color:rgba(200,214,248,0.5);text-decoration:none; }
.topbar a:hover{ color:var(--gold2); }
.wrap{ max-width:900px;margin:0 auto;padding:36px 24px; }
.page-title{ font-size:1.3rem;font-weight:700;color:#fff;margin-bottom:4px; }
.page-sub{ font-size:0.78rem;color:rgba(200,214,248,0.35);margin-bottom:28px; }
.card-admin{ background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:16px;padding:28px;margin-bottom:24px; }
.card-admin h3{ font-size:0.95rem;font-weight:600;color:#fff;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid var(--border); }
.adm-label{ font-size:0.72rem;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:rgba(200,214,248,0.5);margin-bottom:6px;display:block; }
.form-control{ background:rgba(255,255,255,0.05)!important;border:1px solid var(--border)!important;border-radius:10px!important;color:#fff!important;font-family:'Poppins',sans-serif;font-size:0.88rem; }
.form-control:focus{ border-color:rgba(26,58,173,0.7)!important;background:rgba(26,58,173,0.08)!important;box-shadow:0 0 0 3px rgba(26,58,173,0.15)!important;color:#fff!important; }
.btn-save{ background:linear-gradient(135deg,#1a3aad,#2a52d4);border:none;color:#fff;padding:10px 28px;border-radius:10px;font-family:'Poppins',sans-serif;font-weight:500;font-size:0.85rem;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 14px rgba(26,58,173,0.4); }
.btn-save:hover{ transform:translateY(-1px);box-shadow:0 6px 20px rgba(26,58,173,0.6); }
.destino-block{ border:1px solid var(--border);border-radius:14px;padding:22px;margin-bottom:16px;background:rgba(255,255,255,0.02);transition:border-color 0.2s; }
.destino-block:hover{ border-color:rgba(26,58,173,0.4); }
.ciudad-badge{ display:inline-block;padding:4px 14px;border-radius:20px;font-size:0.78rem;font-weight:600;margin-bottom:14px; }
.badge-armenia{ background:rgba(212,168,83,0.15);color:var(--gold2); }
.badge-pereira{ background:rgba(26,58,173,0.2);color:#93c5fd; }
.badge-manizales{ background:rgba(34,197,94,0.15);color:#86efac; }
.alert-ok{ background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.25);color:#86efac;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:0.85rem; }
</style>
</head>
<body>
<div class="topbar">
    <div class="topbar-brand">RUTA <span>20</span> <span style="font-weight:300;font-size:0.85rem;color:rgba(200,214,248,0.4)">/ Destinos</span></div>
    <a href="dashboard.php">← Dashboard</a>
</div>
<div class="wrap">
    <div class="page-title">Destinos y precios base</div>
    <div class="page-sub">Edita el precio base por persona que aparece en el cotizador</div>

    <?php if($msg === 'success'): ?>
    <div class="alert-ok">✓ Precios actualizados correctamente</div>
    <?php endif; ?>

    <?php
    $destinos = $conexion->query("SELECT * FROM destinos ORDER BY id");
    while($d = $destinos->fetch_assoc()):
    ?>
    <div class="card-admin">
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
            <div class="ciudad-badge badge-<?php echo strtolower($d['ciudad']); ?>">
                <?php echo $d['ciudad']; ?>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="adm-label">Precio base / persona</label>
                    <input type="number" name="precio_base" class="form-control"
                           value="<?php echo $d['precio_base']; ?>" required>
                </div>
                <div class="col-md-5 form-group">
                    <label class="adm-label">Aeropuerto</label>
                    <input type="text" name="aeropuerto" class="form-control"
                           value="<?php echo htmlspecialchars($d['aeropuerto']); ?>">
                </div>
                <div class="col-md-3 form-group">
                    <label class="adm-label">Estado</label>
                    <div style="margin-top:8px;">
                        <label style="color:rgba(200,214,248,0.7);font-size:0.85rem;cursor:pointer;">
                            <input type="checkbox" name="activo" value="1" <?php echo $d['activo'] ? 'checked' : ''; ?>>
                            Activo en cotizador
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-save">Guardar cambios</button>
        </form>
    </div>
    <?php endwhile; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>