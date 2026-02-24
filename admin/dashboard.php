<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include("../config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Ruta 20</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:     #050a20;
            --bg2:    #0a0c2e;
            --bg3:    #111b54;
            --accent: #1a3aad;
            --gold:   #d4a853;
            --gold2:  #f0cc7a;
            --text:   #c8d6f8;
            --border: rgba(200,214,248,0.1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--bg) 0%, var(--bg2) 40%, var(--bg3) 100%);
            min-height: 100vh;
            color: var(--text);
            padding: 0;
            margin: 0;
        }

        .topbar {
            background: rgba(5,10,32,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-brand { font-size: 1.2rem; font-weight: 700; color: #fff; letter-spacing: 0.08em; }
        .topbar-brand span { color: var(--gold2); }
        .topbar-right { display: flex; align-items: center; gap: 20px; }
        .topbar-right a { font-size: 0.8rem; color: rgba(200,214,248,0.5); text-decoration: none; transition: color 0.2s; }
        .topbar-right a:hover { color: var(--gold2); text-decoration: none; }
        .topbar-right .logout { color: rgba(252,165,165,0.7) !important; }
        .topbar-right .logout:hover { color: #fca5a5 !important; }

        .admin-wrap { max-width: 1100px; margin: 0 auto; padding: 36px 24px 80px; }

        .page-title { font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .page-sub { font-size: 0.78rem; color: rgba(200,214,248,0.35); margin-bottom: 32px; }

        /* Módulos */
        .modulos-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 36px;
        }
        .modulo-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 18px;
            text-decoration: none !important;
            color: inherit !important;
            transition: all 0.25s;
            display: block;
        }
        .modulo-card:hover {
            border-color: rgba(26,58,173,0.5);
            background: rgba(26,58,173,0.08);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
        }
        .modulo-icon { font-size: 1.5rem; margin-bottom: 10px; }
        .modulo-nombre { font-size: 0.88rem; font-weight: 600; color: #fff; margin-bottom: 4px; }
        .modulo-desc { font-size: 0.72rem; color: rgba(200,214,248,0.4); line-height: 1.4; }

        /* Cards */
        .card-admin {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 28px;
        }
        .card-admin h2 {
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        /* Inputs */
        .form-control {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px !important;
            color: #fff !important;
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem;
        }
        .form-control:focus {
            border-color: rgba(26,58,173,0.7) !important;
            background: rgba(26,58,173,0.08) !important;
            box-shadow: 0 0 0 3px rgba(26,58,173,0.15) !important;
            color: #fff !important;
        }
        .form-control option { background: var(--bg2); color: #fff; }
        .form-check-label { color: rgba(200,214,248,0.7); font-size: 0.85rem; }

        /* Tabla */
        .table { color: var(--text) !important; font-size: 0.85rem; }
        .table thead th {
            background: rgba(26,58,173,0.2);
            color: rgba(200,214,248,0.7);
            font-weight: 500;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-color: var(--border) !important;
        }
        .table td { border-color: rgba(200,214,248,0.06) !important; vertical-align: middle; }
        .table tr:hover td { background: rgba(26,58,173,0.05); }
        .table img { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; }
        .table-bordered { border-color: var(--border) !important; }
        .table-striped tbody tr:nth-of-type(odd) td { background: rgba(255,255,255,0.015) !important; }

        /* Botones */
        .btn-primary {
            background: linear-gradient(135deg, #1a3aad, #2a52d4) !important;
            border: none !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.85rem;
            border-radius: 10px !important;
            padding: 10px 24px !important;
            box-shadow: 0 4px 14px rgba(26,58,173,0.4);
            transition: all 0.2s !important;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,58,173,0.6) !important; background: linear-gradient(135deg, #2a52d4, #3a62e4) !important; }

        .btn-sm.btn-warning {
            background: rgba(212,168,83,0.15) !important;
            color: var(--gold2) !important;
            border: 1px solid rgba(212,168,83,0.3) !important;
            border-radius: 8px !important;
            font-size: 0.75rem !important;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s !important;
        }
        .btn-sm.btn-warning:hover { background: rgba(212,168,83,0.28) !important; }

        .btn-sm.btn-danger {
            background: rgba(239,68,68,0.12) !important;
            color: #fca5a5 !important;
            border: 1px solid rgba(239,68,68,0.2) !important;
            border-radius: 8px !important;
            font-size: 0.75rem !important;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s !important;
        }
        .btn-sm.btn-danger:hover { background: rgba(239,68,68,0.22) !important; }

        .btn-secondary {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid var(--border) !important;
            color: rgba(200,214,248,0.5) !important;
            border-radius: 10px !important;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: all 0.2s !important;
        }
        .btn-secondary:hover { color: #fff !important; background: rgba(255,255,255,0.08) !important; }

        hr { border-color: var(--border); margin: 28px 0; }

        @media(max-width: 768px) {
            .modulos-grid { grid-template-columns: repeat(2,1fr); }
            .admin-wrap { padding: 20px 16px; }
            .topbar { padding: 12px 16px; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <div class="topbar-brand">RUTA <span>20</span> &nbsp;<span style="font-weight:300;font-size:0.85rem;color:rgba(200,214,248,0.4)">/ Admin</span></div>
    <div class="topbar-right">
        <a href="../index.php" target="_blank">Ver sitio →</a>
        <a href="logout.php" class="logout">Cerrar sesión</a>
    </div>
</div>

<div class="admin-wrap">

    <div class="page-title">Dashboard</div>
    <div class="page-sub">Panel de administración — Ruta 20 Eje Cafetero</div>

    <!-- ── MÓDULOS COTIZADOR ── -->
    <div class="modulos-grid">
        <a href="destinos.php" class="modulo-card">
            <div class="modulo-icon">🗺️</div>
            <div class="modulo-nombre">Destinos</div>
            <div class="modulo-desc">Precio base por ciudad</div>
        </a>
        <a href="hoteles.php" class="modulo-card">
            <div class="modulo-icon">🏨</div>
            <div class="modulo-nombre">Hoteles</div>
            <div class="modulo-desc">Precios sencilla, doble y triple</div>
        </a>
        <a href="actividades.php" class="modulo-card">
            <div class="modulo-icon">🎯</div>
            <div class="modulo-nombre">Actividades</div>
            <div class="modulo-desc">Tours, traslados y actividades</div>
        </a>
        <a href="servicios.php" class="modulo-card">
            <div class="modulo-icon">✈️</div>
            <div class="modulo-nombre">Servicios</div>
            <div class="modulo-desc">Tiquetes, seguros y más</div>
        </a>
    </div>

    <hr>

    <!-- ── CREAR NUEVO PAQUETE (código original intacto) ── -->
    <div class="card-admin">
        <h2>➕ Crear Nuevo Paquete</h2>
        <form action="guardar_paquete.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <input type="text" name="titulo" class="form-control" placeholder="Título del paquete" required>
            </div>

            <div class="form-group">
                <select name="ciudad" class="form-control" required>
                    <option value="">Seleccionar ciudad</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Pereira">Pereira</option>
                    <option value="Manizales">Manizales</option>
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="precio" class="form-control" placeholder="Precio" required>
            </div>

            <div class="form-group">
                <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
            </div>

            <div class="form-group">
                <input type="file" name="imagen" class="form-control" required>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="destacado" class="form-check-input" value="1" id="destacado">
                <label class="form-check-label" for="destacado">Marcar como paquete principal</label>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Paquete</button>
        </form>
    </div>

    <hr>

    <!-- ── LISTAR PAQUETES (código original intacto) ── -->
    <div class="card-admin">
        <h2>📦 Paquetes Existentes</h2>
        <div style="overflow-x:auto;">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Ciudad</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Destacado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM paquetes ORDER BY fecha_creacion DESC";
                    $resultado = $conexion->query($query);

                    while($row = $resultado->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['titulo']; ?></td>
                        <td><?php echo $row['ciudad']; ?></td>
                        <td style="color:var(--gold2);font-weight:600;">$<?php echo number_format($row['precio']); ?></td>
                        <td>
                            <?php if(!empty($row['imagen'])): ?>
                                <img src="../public/uploads/<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['destacado'] ? '<span style="color:#86efac">Sí</span>' : '<span style="color:rgba(200,214,248,0.3)">No</span>'; ?></td>
                        <td>
                            <a href="editar_paquete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="borrar_paquete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Desea eliminar este paquete?');">Borrar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="logout.php" class="btn btn-secondary">← Cerrar sesión</a>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>