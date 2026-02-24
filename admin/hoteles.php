<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit; }
include("../config/conexion.php");

$msg = '';

// Agregar hotel
if($_POST && isset($_POST['accion']) && $_POST['accion'] === 'agregar'){
    $nombre   = $conexion->real_escape_string($_POST['nombre']);
    $ciudad   = $conexion->real_escape_string($_POST['ciudad']);
    $desc     = $conexion->real_escape_string($_POST['descripcion']);
    $s = floatval($_POST['precio_sencilla']);
    $do= floatval($_POST['precio_doble']);
    $t = floatval($_POST['precio_triple']);
    $conexion->query("INSERT INTO hoteles (nombre,ciudad,descripcion,precio_sencilla,precio_doble,precio_triple) VALUES ('$nombre','$ciudad','$desc',$s,$do,$t)");
    $msg = 'agregado';
}

// Editar hotel
if($_POST && isset($_POST['accion']) && $_POST['accion'] === 'editar'){
    $id     = intval($_POST['id']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $ciudad = $conexion->real_escape_string($_POST['ciudad']);
    $desc   = $conexion->real_escape_string($_POST['descripcion']);
    $s  = floatval($_POST['precio_sencilla']);
    $do = floatval($_POST['precio_doble']);
    $t  = floatval($_POST['precio_triple']);
    $activo = isset($_POST['activo']) ? 1 : 0;
    $conexion->query("UPDATE hoteles SET nombre='$nombre',ciudad='$ciudad',descripcion='$desc',precio_sencilla=$s,precio_doble=$do,precio_triple=$t,activo=$activo WHERE id=$id");
    $msg = 'editado';
}

// Borrar hotel
if(isset($_GET['borrar'])){
    $id = intval($_GET['borrar']);
    $conexion->query("DELETE FROM hoteles WHERE id=$id");
    header("Location: hoteles.php?msg=borrado"); exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Hoteles — Admin Ruta 20</title>
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
.wrap{ max-width:1100px;margin:0 auto;padding:36px 24px; }
.page-title{ font-size:1.3rem;font-weight:700;color:#fff;margin-bottom:4px; }
.page-sub{ font-size:0.78rem;color:rgba(200,214,248,0.35);margin-bottom:28px; }
.card-admin{ background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:16px;padding:28px;margin-bottom:24px; }
.card-admin h3{ font-size:0.95rem;font-weight:600;color:#fff;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid var(--border); }
.adm-label{ font-size:0.72rem;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:rgba(200,214,248,0.5);margin-bottom:6px;display:block; }
.form-control{ background:rgba(255,255,255,0.05)!important;border:1px solid var(--border)!important;border-radius:10px!important;color:#fff!important;font-family:'Poppins',sans-serif;font-size:0.88rem; }
.form-control:focus{ border-color:rgba(26,58,173,0.7)!important;background:rgba(26,58,173,0.08)!important;box-shadow:0 0 0 3px rgba(26,58,173,0.15)!important;color:#fff!important; }
.form-control option{ background:var(--bg2); }
.btn-save{ background:linear-gradient(135deg,#1a3aad,#2a52d4);border:none;color:#fff;padding:10px 28px;border-radius:10px;font-family:'Poppins',sans-serif;font-weight:500;font-size:0.85rem;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 14px rgba(26,58,173,0.4); }
.btn-save:hover{ transform:translateY(-1px); }
.table{ color:var(--text)!important;font-size:0.83rem; }
.table thead th{ background:rgba(26,58,173,0.2);color:rgba(200,214,248,0.7);font-weight:500;font-size:0.7rem;letter-spacing:0.1em;text-transform:uppercase;border-color:var(--border)!important; }
.table td{ border-color:rgba(200,214,248,0.06)!important;vertical-align:middle; }
.table tr:hover td{ background:rgba(26,58,173,0.05); }
.table-striped tbody tr:nth-of-type(odd) td{ background:rgba(255,255,255,0.015)!important; }
.table-bordered{ border-color:var(--border)!important; }
.btn-edit-sm{ background:rgba(212,168,83,0.15);color:var(--gold2);border:1px solid rgba(212,168,83,0.3);padding:4px 12px;border-radius:8px;font-size:0.73rem;cursor:pointer;font-family:'Poppins',sans-serif;text-decoration:none;transition:all 0.2s; }
.btn-edit-sm:hover{ background:rgba(212,168,83,0.25);color:var(--gold2); }
.btn-del-sm{ background:rgba(239,68,68,0.12);color:#fca5a5;border:1px solid rgba(239,68,68,0.2);padding:4px 12px;border-radius:8px;font-size:0.73rem;cursor:pointer;font-family:'Poppins',sans-serif;text-decoration:none;transition:all 0.2s; }
.btn-del-sm:hover{ background:rgba(239,68,68,0.22);color:#fca5a5; }
.badge-ciudad{ display:inline-block;padding:3px 10px;border-radius:20px;font-size:0.7rem;font-weight:500; }
.badge-armenia{ background:rgba(212,168,83,0.15);color:var(--gold2); }
.badge-pereira{ background:rgba(26,58,173,0.2);color:#93c5fd; }
.badge-manizales{ background:rgba(34,197,94,0.15);color:#86efac; }
.badge-on{ background:rgba(34,197,94,0.15);color:#86efac;padding:3px 10px;border-radius:20px;font-size:0.7rem; }
.badge-off{ background:rgba(239,68,68,0.12);color:#fca5a5;padding:3px 10px;border-radius:20px;font-size:0.7rem; }
.alert-ok{ background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.25);color:#86efac;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:0.85rem; }
/* Modal editar */
.modal-content{ background:#0a0c2e!important;border:1px solid var(--border)!important;border-radius:16px!important;color:var(--text)!important; }
.modal-header{ border-bottom:1px solid var(--border)!important; }
.modal-footer{ border-top:1px solid var(--border)!important; }
.modal-title{ color:#fff!important;font-family:'Poppins',sans-serif; }
.close{ color:rgba(200,214,248,0.5)!important; }
</style>
</head>
<body>
<div class="topbar">
    <div class="topbar-brand">RUTA <span>20</span> <span style="font-weight:300;font-size:0.85rem;color:rgba(200,214,248,0.4)">/ Hoteles</span></div>
    <a href="dashboard.php">← Dashboard</a>
</div>
<div class="wrap">
    <div class="page-title">Gestión de Hoteles</div>
    <div class="page-sub">Agrega, edita y ajusta precios de habitaciones por ciudad</div>

    <?php if($msg): ?>
    <div class="alert-ok">✓ Hotel <?php echo $msg; ?> correctamente</div>
    <?php endif; ?>
    <?php if(isset($_GET['msg']) && $_GET['msg']==='borrado'): ?>
    <div class="alert-ok">✓ Hotel eliminado</div>
    <?php endif; ?>

    <!-- Agregar -->
    <div class="card-admin">
        <h3>➕ Agregar hotel</h3>
        <form method="POST">
            <input type="hidden" name="accion" value="agregar">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="adm-label">Nombre del hotel</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Hotel Centenario" required>
                </div>
                <div class="col-md-2 form-group">
                    <label class="adm-label">Ciudad</label>
                    <select name="ciudad" class="form-control" required>
                        <option value="">Seleccionar</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Pereira">Pereira</option>
                        <option value="Manizales">Manizales</option>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label class="adm-label">Precio sencilla</label>
                    <input type="number" name="precio_sencilla" class="form-control" placeholder="150000" required>
                </div>
                <div class="col-md-2 form-group">
                    <label class="adm-label">Precio doble</label>
                    <input type="number" name="precio_doble" class="form-control" placeholder="200000" required>
                </div>
                <div class="col-md-2 form-group">
                    <label class="adm-label">Precio triple</label>
                    <input type="number" name="precio_triple" class="form-control" placeholder="260000" required>
                </div>
            </div>
            <div class="form-group">
                <label class="adm-label">Descripción (opcional)</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Breve descripción">
            </div>
            <button type="submit" class="btn-save">Agregar hotel</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="card-admin">
        <h3>🏨 Hoteles registrados</h3>
        <div style="overflow-x:auto;">
        <table class="table table-bordered table-striped">
            <thead>
                <tr><th>Hotel</th><th>Ciudad</th><th>Sencilla</th><th>Doble</th><th>Triple</th><th>Estado</th><th>Acciones</th></tr>
            </thead>
            <tbody>
            <?php
            $hots = $conexion->query("SELECT * FROM hoteles ORDER BY ciudad, nombre");
            while($h = $hots->fetch_assoc()):
            ?>
            <tr>
                <td style="font-weight:500"><?php echo htmlspecialchars($h['nombre']); ?></td>
                <td><span class="badge-ciudad badge-<?php echo strtolower($h['ciudad']); ?>"><?php echo $h['ciudad']; ?></span></td>
                <td style="color:var(--gold2)">$<?php echo number_format($h['precio_sencilla'],0,',','.'); ?></td>
                <td style="color:var(--gold2)">$<?php echo number_format($h['precio_doble'],0,',','.'); ?></td>
                <td style="color:var(--gold2)">$<?php echo number_format($h['precio_triple'],0,',','.'); ?></td>
                <td><span class="<?php echo $h['activo'] ? 'badge-on':'badge-off'; ?>"><?php echo $h['activo']?'Activo':'Inactivo'; ?></span></td>
                <td>
                    <button class="btn-edit-sm" onclick="abrirEditar(<?php echo htmlspecialchars(json_encode($h)); ?>)">Editar</button>
                    <a href="hoteles.php?borrar=<?php echo $h['id']; ?>" class="btn-del-sm"
                       onclick="return confirm('¿Eliminar hotel?')">Borrar</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- Modal editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title">✏️ Editar hotel</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form method="POST">
        <input type="hidden" name="accion" value="editar">
        <div class="modal-body">
            <input type="hidden" name="id" id="edit-id">
            <div class="row">
                <div class="col-md-5 form-group">
                    <label class="adm-label">Nombre</label>
                    <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                </div>
                <div class="col-md-3 form-group">
                    <label class="adm-label">Ciudad</label>
                    <select name="ciudad" id="edit-ciudad" class="form-control">
                        <option value="Armenia">Armenia</option>
                        <option value="Pereira">Pereira</option>
                        <option value="Manizales">Manizales</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label class="adm-label">Descripción</label>
                    <input type="text" name="descripcion" id="edit-desc" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="adm-label">Precio sencilla</label>
                    <input type="number" name="precio_sencilla" id="edit-s" class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                    <label class="adm-label">Precio doble</label>
                    <input type="number" name="precio_doble" id="edit-d" class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                    <label class="adm-label">Precio triple</label>
                    <input type="number" name="precio_triple" id="edit-t" class="form-control" required>
                </div>
            </div>
            <label style="color:rgba(200,214,248,0.7);font-size:0.85rem;cursor:pointer;">
                <input type="checkbox" name="activo" id="edit-activo" value="1"> Activo en cotizador
            </label>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn-save">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function abrirEditar(h) {
    document.getElementById('edit-id').value     = h.id;
    document.getElementById('edit-nombre').value = h.nombre;
    document.getElementById('edit-ciudad').value = h.ciudad;
    document.getElementById('edit-desc').value   = h.descripcion || '';
    document.getElementById('edit-s').value      = h.precio_sencilla;
    document.getElementById('edit-d').value      = h.precio_doble;
    document.getElementById('edit-t').value      = h.precio_triple;
    document.getElementById('edit-activo').checked = h.activo == 1;
    $('#modalEditar').modal('show');
}
</script>
</body>
</html>