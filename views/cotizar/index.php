<?php 
require_once 'C:/xampp/htdocs/ruta20/config/config.php';
require_once BASE_PATH . '/config/conexion.php';
include BASE_PATH . '/views/layouts/header.php'; 

// Cargar datos desde BD
$destinos    = $conexion->query("SELECT * FROM destinos WHERE activo=1")->fetch_all(MYSQLI_ASSOC);
$hoteles     = $conexion->query("SELECT * FROM hoteles WHERE activo=1 ORDER BY ciudad, nombre")->fetch_all(MYSQLI_ASSOC);
$actividades = $conexion->query("SELECT * FROM actividades WHERE activo=1 ORDER BY ciudad, tipo, nombre")->fetch_all(MYSQLI_ASSOC);
$servicios   = $conexion->query("SELECT * FROM servicios WHERE activo=1")->fetch_all(MYSQLI_ASSOC);
?>

<style>
  :root {
    --v1: #0a142e;
    --v2: #2140a8;
    --v3: #337cea;
    --v4: #84b4fc;
    --gold: #d4a853;
    --gold2: #f0cc7a;
    --white: #faf5ff;
    --glass: rgba(255,255,255,0.06);
    --radius: 16px;
  }

  .cotizar_page {
    background: linear-gradient(135deg, #050a20 0%, #0a0c2e 40%, #111b54 100%);
    min-height: 100vh;
    padding: 60px 0 80px;
    font-family: 'Poppins', sans-serif;
  }

  /* Stepper */
  .stepper {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 48px;
    gap: 0;
  }
  .step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 1;
  }
  .step-circle {
    width: 48px; height: 48px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    border: 2px solid rgba(132, 164, 252, 0.2);
    display: flex; align-items: center; justify-content: center;
    font-weight: 600; font-size: 1rem;
    color: rgba(132, 170, 252, 0.5);
    transition: all 0.4s;
  }
  .step-item.active .step-circle {
    background: linear-gradient(135deg, var(--v2), var(--v3));
    border-color: var(--v3);
    color: #fff;
    box-shadow: 0 0 24px rgba(51, 78, 234, 0.5);
  }
  .step-item.done .step-circle {
    background: var(--gold);
    border-color: var(--gold2);
    color: #fff;
  }
  .step-label {
    font-size: 0.7rem;
    color: rgba(132, 154, 252, 0.4);
    margin-top: 8px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    white-space: nowrap;
  }
  .step-item.active .step-label { color: var(--v4); }
  .step-item.done .step-label   { color: var(--gold2); }
  .step-line {
    flex: 1;
    height: 2px;
    background: rgba(132, 144, 252, 0.15);
    max-width: 100px;
    margin-bottom: 24px;
    transition: background 0.4s;
  }
  .step-line.done { background: var(--gold); }

  /* Card wizard */
  .wizard-card {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(134, 132, 252, 0.15);
    border-radius: 24px;
    padding: 40px 48px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.4), 0 0 60px rgba(107,33,168,0.1);
  }

  .wizard-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.6rem;
    font-weight: 600;
    color: var(--white);
    margin-bottom: 8px;
  }
  .wizard-subtitle {
    font-size: 0.85rem;
    color: rgba(132, 180, 252, 0.6);
    margin-bottom: 32px;
  }

  /* Labels e inputs */
  .cot-label {
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(132, 184, 252, 0.7);
    margin-bottom: 8px;
    display: block;
  }
  .cot-input {
    width: 100%;
    padding: 13px 16px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(132, 140, 252, 0.2);
    border-radius: 12px;
    color: var(--white);
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    outline: none;
    transition: all 0.25s;
    -webkit-appearance: none;
  }
  .cot-input:focus {
    border-color: var(--v4);
    background: rgba(147,51,234,0.08);
    box-shadow: 0 0 0 3px rgba(51, 78, 234, 0.15);
  }
  .cot-input option { background: #1a0a2e; color: #fff; }

  /* Destino cards */
  .destino-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 8px;
  }
  .destino-card {
    border: 2px solid rgba(132, 150, 252, 0.15);
    border-radius: 16px;
    padding: 20px 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    background: rgba(255,255,255,0.03);
    position: relative;
    overflow: hidden;
  }
  .destino-card:hover {
    border-color: var(--v3);
    background: rgba(51, 94, 234, 0.08);
  }
  .destino-card.selected {
    border-color: var(--gold);
    background: rgba(212,168,83,0.1);
    box-shadow: 0 0 20px rgba(212,168,83,0.2);
  }
  .destino-card .ciudad-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--white);
    margin-bottom: 4px;
  }
  .destino-card .ciudad-aeropuerto {
    font-size: 0.7rem;
    color: rgba(132, 160, 252, 0.5);
    margin-bottom: 10px;
  }
  .destino-card .ciudad-precio {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gold2);
  }
  .destino-card .check-icon {
    position: absolute;
    top: 10px; right: 10px;
    width: 22px; height: 22px;
    background: var(--gold);
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: #fff;
  }
  .destino-card.selected .check-icon { display: flex; }

  /* Contador personas */
  .counter-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .counter-btn {
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(132, 184, 252, 0.3);
    background: rgba(255,255,255,0.05);
    color: var(--v4);
    font-size: 1.2rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
  }
  .counter-btn:hover {
    background: rgba(51, 115, 234, 0.2);
    border-color: var(--v3);
  }
  .counter-val {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--white);
    min-width: 30px;
    text-align: center;
  }

  /* Servicios toggle */
  .servicio-toggle {
    border: 1px solid rgba(132, 174, 252, 0.15);
    border-radius: 14px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.03);
  }
  .servicio-toggle:hover { border-color: var(--v3); background: rgba(147,51,234,0.05); }
  .servicio-toggle.selected {
    border-color: var(--gold);
    background: rgba(212,168,83,0.08);
  }
  .servicio-toggle .srv-info { flex: 1; }
  .servicio-toggle .srv-nombre {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--white);
  }
  .servicio-toggle .srv-desc {
    font-size: 0.75rem;
    color: rgba(132, 164, 252, 0.5);
    margin-top: 2px;
  }
  .servicio-toggle .srv-precio {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gold2);
    margin-left: 16px;
    white-space: nowrap;
  }
  .toggle-check {
    width: 24px; height: 24px;
    border-radius: 6px;
    border: 2px solid rgba(132, 154, 252, 0.3);
    margin-left: 12px;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
    font-size: 0.75rem;
    color: transparent;
  }
  .servicio-toggle.selected .toggle-check {
    background: var(--gold);
    border-color: var(--gold);
    color: #fff;
  }

  /* Sección colapsable actividades */
  .seccion-titulo {
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--v4);
    margin: 24px 0 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .seccion-titulo::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(132, 164, 252, 0.15);
  }

  /* Hoteles */
  .hotel-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  .hotel-card {
    border: 1px solid rgba(196,132,252,0.15);
    border-radius: 12px;
    padding: 16px;
    cursor: pointer;
    transition: all 0.3s;
    background: rgba(255,255,255,0.03);
  }
  .hotel-card:hover { border-color: var(--v3); }
  .hotel-card.selected { border-color: var(--gold); background: rgba(212,168,83,0.08); }
  .hotel-nombre { font-size: 0.9rem; font-weight: 600; color: var(--white); margin-bottom: 8px; }
  .hotel-precios { display: flex; gap: 8px; flex-wrap: wrap; }
  .hotel-tipo {
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 20px;
    border: 1px solid rgba(132, 170, 252, 0.2);
    color: rgba(132, 170, 252, 0.7);
    cursor: pointer;
    transition: all 0.2s;
  }
  .hotel-tipo.active-tipo {
    background: var(--v2);
    border-color: var(--v3);
    color: #fff;
  }

  /* Traslado hora */
  .traslado-item {
    border: 1px solid rgba(132, 160, 252, 0.15);
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.03);
  }
  .traslado-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
  }
  .traslado-nombre { font-size: 0.88rem; font-weight: 500; color: var(--white); }
  .traslado-precio-tag { font-size: 0.85rem; font-weight: 700; color: var(--gold2); }
  .traslado-body { margin-top: 12px; display: none; }
  .traslado-item.open .traslado-body { display: block; }

  /* Resumen */
  .resumen-box {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(196,132,252,0.15);
    border-radius: 16px;
    padding: 24px;
  }
  .resumen-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(132, 188, 252, 0.08);
    font-size: 0.88rem;
    color: rgba(132, 150, 252, 0.8);
  }
  .resumen-row:last-child { border-bottom: none; }
  .resumen-row .r-label { color: rgba(132, 164, 252, 0.6); }
  .resumen-row .r-valor { color: var(--white); font-weight: 500; }
  .resumen-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 2px solid rgba(212,168,83,0.3);
  }
  .resumen-total .t-label {
    font-size: 1rem;
    font-weight: 600;
    color: var(--white);
  }
  .resumen-total .t-valor {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gold2);
  }

  /* Botones nav */
  .wizard-nav {
    display: flex;
    justify-content: space-between;
    margin-top: 36px;
    gap: 12px;
  }
  .btn-prev {
    padding: 13px 32px;
    border-radius: 12px;
    border: 1px solid rgba(132, 164, 252, 0.3);
    background: transparent;
    color: var(--v4);
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-prev:hover { background: rgba(196,132,252,0.08); }
  .btn-next {
    padding: 13px 40px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, var(--v2), var(--v3));
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 8px 24px rgba(33, 114, 168, 0.4);
    letter-spacing: 0.05em;
    flex: 1;
  }
  .btn-next:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(33, 107, 168, 0.6); }
  .btn-whatsapp {
    padding: 13px 40px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #128c7e, #3f6b4f);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 8px 24px rgba(37,211,102,0.3);
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .btn-whatsapp:hover { transform: translateY(-2px); }

  /* Paso oculto */
  .wizard-step { display: none; animation: fadeIn 0.4s ease; }
  .wizard-step.active { display: block; }
  @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

  @media(max-width: 768px) {
    .wizard-card { padding: 24px 20px; }
    .destino-grid { grid-template-columns: 1fr; }
    .hotel-grid { grid-template-columns: 1fr; }
    .step-line { max-width: 40px; }
  }
</style>

<div class="cotizar_page">
  <div class="container">
    <div style="text-align:center; margin-bottom:40px;">
      <h1 style="font-family:'Poppins',sans-serif; font-size:2.2rem; font-weight:700; color:#fff;">
        Cotiza tu <span style="color:<?php echo '#f0cc7a'; ?>">viaje ideal</span>
      </h1>
      <p style="color:rgba(132, 180, 252, 0.6); font-size:0.95rem;">
        Personaliza cada detalle de tu aventura por el Eje Cafetero
      </p>
    </div>

    <!-- Stepper -->
    <div class="stepper" id="stepper">
      <div class="step-item active" id="si-1">
        <div class="step-circle">1</div>
        <div class="step-label">Tu viaje</div>
      </div>
      <div class="step-line" id="sl-1"></div>
      <div class="step-item" id="si-2">
        <div class="step-circle">2</div>
        <div class="step-label">Servicios</div>
      </div>
      <div class="step-line" id="sl-2"></div>
      <div class="step-item" id="si-3">
        <div class="step-circle">3</div>
        <div class="step-label">Resumen</div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="wizard-card">

          <!-- ══════════ PASO 1 ══════════ -->
          <div class="wizard-step active" id="paso-1">
            <div class="wizard-title">¿A dónde quieres ir?</div>
            <div class="wizard-subtitle">Selecciona tu destino y fechas de viaje</div>

            <!-- Destino -->
            <label class="cot-label">Destino</label>
            <div class="destino-grid" id="destinoGrid">
              <?php foreach($destinos as $d): ?>
              <div class="destino-card" 
                   data-ciudad="<?php echo $d['ciudad']; ?>"
                   data-precio="<?php echo $d['precio_base']; ?>"
                   data-aeropuerto="<?php echo htmlspecialchars($d['aeropuerto']); ?>"
                   onclick="seleccionarDestino(this)">
                <div class="check-icon">✓</div>
                <div class="ciudad-name"><?php echo $d['ciudad']; ?></div>
                <div class="ciudad-aeropuerto"><?php echo $d['aeropuerto']; ?></div>
                <div class="ciudad-precio">$<?php echo number_format($d['precio_base'],0,',','.'); ?> <small style="font-size:0.65rem;color:rgba(196,132,252,0.5)">/ persona</small></div>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="form-row mt-4">
              <div class="form-group col-md-6">
                <label class="cot-label">Ciudad de origen</label>
                <input type="text" class="cot-input" id="origen" placeholder="Ej: Bogotá, Medellín...">
              </div>
              <div class="form-group col-md-3">
                <label class="cot-label">Fecha de ida</label>
                <input type="date" class="cot-input" id="fechaIda" min="<?php echo date('Y-m-d'); ?>">
              </div>
              <div class="form-group col-md-3">
                <label class="cot-label">Fecha de regreso</label>
                <input type="date" class="cot-input" id="fechaRegreso">
              </div>
            </div>

            <div class="form-row mt-2">
              <div class="form-group col-md-6">
                <label class="cot-label">Adultos</label>
                <div class="counter-wrap">
                  <button class="counter-btn" onclick="cambiarContador('adultos',-1)">−</button>
                  <span class="counter-val" id="adultos-val">1</span>
                  <button class="counter-btn" onclick="cambiarContador('adultos',1)">+</button>
                  <span style="font-size:0.75rem;color:rgba(132, 164, 252, 0.4);margin-left:4px;">personas</span>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="cot-label">Niños (menores de 12)</label>
                <div class="counter-wrap">
                  <button class="counter-btn" onclick="cambiarContador('ninos',- 1)">−</button>
                  <span class="counter-val" id="ninos-val">0</span>
                  <button class="counter-btn" onclick="cambiarContador('ninos',1)">+</button>
                  <span style="font-size:0.75rem;color:rgba(132, 170, 252, 0.4);margin-left:4px;">niños</span>
                </div>
              </div>
            </div>

            <div class="wizard-nav">
              <div></div>
              <button class="btn-next" onclick="irPaso(2)">Siguiente → Servicios</button>
            </div>
          </div>

          <!-- ══════════ PASO 2 ══════════ -->
          <div class="wizard-step" id="paso-2">
            <div class="wizard-title">Personaliza tu viaje</div>
            <div class="wizard-subtitle">Selecciona los servicios que deseas incluir</div>

            <!-- Servicios fijos -->
            <div class="seccion-titulo">✈ Servicios adicionales</div>
            <?php foreach($servicios as $s): ?>
            <div class="servicio-toggle" 
                 data-id="s<?php echo $s['id']; ?>"
                 data-precio="<?php echo $s['precio']; ?>"
                 onclick="toggleServicio(this)">
              <div class="srv-info">
                <div class="srv-nombre"><?php echo htmlspecialchars($s['nombre']); ?></div>
                <div class="srv-desc"><?php echo htmlspecialchars($s['descripcion']); ?></div>
              </div>
              <div class="srv-precio">$<?php echo number_format($s['precio'],0,',','.'); ?></div>
              <div class="toggle-check">✓</div>
            </div>
            <?php endforeach; ?>

            <!-- Alojamiento -->
            <div class="seccion-titulo">🏨 Alojamiento</div>
            <div id="hotelesContainer">
              <p style="color:rgba(132, 150, 252, 0.4);font-size:0.85rem;">Selecciona un destino en el paso 1 para ver hoteles disponibles.</p>
            </div>

            <div class="form-row mt-2" id="habitacionesRow" style="display:none;">
              <div class="form-group col-md-6">
                <label class="cot-label">Habitaciones</label>
                <div class="counter-wrap">
                  <button class="counter-btn" onclick="cambiarContador('habitaciones',-1)">−</button>
                  <span class="counter-val" id="habitaciones-val">1</span>
                  <button class="counter-btn" onclick="cambiarContador('habitaciones',1)">+</button>
                </div>
              </div>
            </div>

            <!-- Traslados -->
            <div class="seccion-titulo" id="titTraslados" style="display:none;">🚌 Traslados</div>
            <div id="trasladosContainer"></div>

            <!-- Actividades -->
            <div class="seccion-titulo" id="titActividades" style="display:none;">🎯 Actividades</div>
            <div id="actividadesContainer"></div>

            <div class="wizard-nav">
              <button class="btn-prev" onclick="irPaso(1)">← Atrás</button>
              <button class="btn-next" onclick="irPaso(3)">Ver resumen →</button>
            </div>
          </div>

          <!-- ══════════ PASO 3 ══════════ -->
          <div class="wizard-step" id="paso-3">
            <div class="wizard-title">Resumen de tu cotización</div>
            <div class="wizard-subtitle">Revisa los detalles y compártenos tus datos</div>

            <div class="resumen-box" id="resumenBox">
              <!-- Se llena con JS -->
            </div>

            <div class="seccion-titulo mt-4">👤 Tus datos de contacto</div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="cot-label">Nombres</label>
                <input type="text" class="cot-input" id="ctNombres" placeholder="Tu nombre">
              </div>
              <div class="form-group col-md-6">
                <label class="cot-label">Apellidos</label>
                <input type="text" class="cot-input" id="ctApellidos" placeholder="Tus apellidos">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="cot-label">Teléfono / WhatsApp</label>
                <input type="text" class="cot-input" id="ctTelefono" placeholder="Ej: 3001234567">
              </div>
              <div class="form-group col-md-6">
                <label class="cot-label">Correo electrónico</label>
                <input type="email" class="cot-input" id="ctCorreo" placeholder="tu@correo.com">
              </div>
            </div>

            <div class="wizard-nav">
              <button class="btn-prev" onclick="irPaso(2)">← Atrás</button>
              <button class="btn-whatsapp" onclick="enviarWhatsApp()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Enviar por WhatsApp
              </button>
            </div>
          </div>

        </div><!-- end wizard-card -->
      </div>
    </div>
  </div>
</div>

<!-- Datos PHP → JS -->
<script>
const hotelesPHP     = <?php echo json_encode($hoteles); ?>;
const actividadesPHP = <?php echo json_encode($actividades); ?>;

// Estado global
let estado = {
  destino: null,
  precioBase: 0,
  aeropuerto: '',
  adultos: 1,
  ninos: 0,
  habitaciones: 1,
  tipoHabitacion: 'doble',
  hotelId: null,
  hotelNombre: '',
  hotelPrecio: 0,
  serviciosSeleccionados: [],   // [{id, nombre, precio}]
  trasladosSeleccionados: [],   // [{id, nombre, precio, horaLlegada, horaSalida}]
  actividadesSeleccionadas: [], // [{id, nombre, precio}]
  fechaIda: '',
  fechaRegreso: '',
  origen: ''
};

// ── Contadores ──
const contadores = { adultos: 1, ninos: 0, habitaciones: 1 };
function cambiarContador(id, delta) {
  const min = id === 'adultos' ? 1 : 0;
  contadores[id] = Math.max(min, contadores[id] + delta);
  document.getElementById(id + '-val').innerText = contadores[id];
  if(id === 'adultos') estado.adultos = contadores[id];
  if(id === 'ninos')   estado.ninos   = contadores[id];
  if(id === 'habitaciones') estado.habitaciones = contadores[id];
}

// ── Seleccionar destino ──
function seleccionarDestino(el) {
  document.querySelectorAll('.destino-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  estado.destino    = el.dataset.ciudad;
  estado.precioBase = parseFloat(el.dataset.precio);
  estado.aeropuerto = el.dataset.aeropuerto;
  cargarHoteles(estado.destino);
  cargarTraslados(estado.destino);
  cargarActividades(estado.destino);
}

// ── Cargar hoteles por ciudad ──
function cargarHoteles(ciudad) {
  const hotelesCiudad = hotelesPHP.filter(h => h.ciudad === ciudad);
  const cont = document.getElementById('hotelesContainer');
  document.getElementById('habitacionesRow').style.display = 'flex';

  if(!hotelesCiudad.length) {
    cont.innerHTML = '<p style="color:rgba(132, 150, 252, 0.4);font-size:0.85rem;">No hay hoteles disponibles para esta ciudad.</p>';
    return;
  }

  cont.innerHTML = '<div class="hotel-grid">' + hotelesCiudad.map(h => `
    <div class="hotel-card" id="hotel-${h.id}" onclick="seleccionarHotel(${h.id},'${h.nombre}')">
      <div class="hotel-nombre">${h.nombre}</div>
      <div class="hotel-precios">
        <span class="hotel-tipo active-tipo" onclick="event.stopPropagation();seleccionarTipoHabitacion(this,${h.id},'sencilla',${h.precio_sencilla})" data-tipo="sencilla">
          Sencilla $${formatNum(h.precio_sencilla)}
        </span>
        <span class="hotel-tipo" onclick="event.stopPropagation();seleccionarTipoHabitacion(this,${h.id},'doble',${h.precio_doble})" data-tipo="doble">
          Doble $${formatNum(h.precio_doble)}
        </span>
        <span class="hotel-tipo" onclick="event.stopPropagation();seleccionarTipoHabitacion(this,${h.id},'triple',${h.precio_triple})" data-tipo="triple">
          Triple $${formatNum(h.precio_triple)}
        </span>
      </div>
    </div>
  `).join('') + '</div>';
}

function seleccionarHotel(id, nombre) {
  document.querySelectorAll('.hotel-card').forEach(c => c.classList.remove('selected'));
  const card = document.getElementById('hotel-' + id);
  card.classList.add('selected');
  estado.hotelId     = id;
  estado.hotelNombre = nombre;
  // Precio según tipo activo
  const tipoActivo = card.querySelector('.hotel-tipo.active-tipo');
  if(tipoActivo) {
    estado.tipoHabitacion = tipoActivo.dataset.tipo;
  }
}

function seleccionarTipoHabitacion(el, hotelId, tipo, precio) {
  const card = document.getElementById('hotel-' + hotelId);
  card.querySelectorAll('.hotel-tipo').forEach(t => t.classList.remove('active-tipo'));
  el.classList.add('active-tipo');
  estado.tipoHabitacion = tipo;
  estado.hotelPrecio    = parseFloat(precio);
  if(estado.hotelId === hotelId) estado.hotelPrecio = parseFloat(precio);
}

// ── Cargar traslados ──
function cargarTraslados(ciudad) {
  const traslados = actividadesPHP.filter(a => a.ciudad === ciudad && a.tipo === 'traslado');
  const cont = document.getElementById('trasladosContainer');
  const tit  = document.getElementById('titTraslados');

  if(!traslados.length) { tit.style.display='none'; cont.innerHTML=''; return; }
  tit.style.display = 'flex';

  cont.innerHTML = traslados.map(t => `
    <div class="traslado-item" id="traslado-${t.id}">
      <div class="traslado-header" onclick="toggleTraslado(${t.id}, '${t.nombre}', ${t.precio})">
        <div>
          <div class="traslado-nombre">${t.nombre}</div>
          <div style="font-size:0.72rem;color:rgba(132, 180, 252, 0.4);margin-top:2px;">${t.descripcion}</div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
          <span class="traslado-precio-tag">$${formatNum(t.precio)}</span>
          <span id="tras-check-${t.id}" style="width:24px;height:24px;border-radius:6px;border:2px solid rgba(196,132,252,0.3);display:flex;align-items:center;justify-content:center;font-size:0.7rem;color:transparent;transition:all 0.2s;">✓</span>
        </div>
      </div>
      <div class="traslado-body" id="traslado-body-${t.id}">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label class="cot-label" style="font-size:0.68rem;">Hora de llegada</label>
            <input type="time" class="cot-input" style="padding:10px 12px;" id="tras-llegada-${t.id}">
          </div>
          <div class="form-group col-md-6">
            <label class="cot-label" style="font-size:0.68rem;">Hora de salida</label>
            <input type="time" class="cot-input" style="padding:10px 12px;" id="tras-salida-${t.id}">
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

function toggleTraslado(id, nombre, precio) {
  const item  = document.getElementById('traslado-' + id);
  const body  = document.getElementById('traslado-body-' + id);
  const check = document.getElementById('tras-check-' + id);
  const isOpen = item.classList.contains('open');

  if(isOpen) {
    item.classList.remove('open');
    check.style.background = 'transparent';
    check.style.borderColor = 'rgba(132, 170, 252, 0.3)';
    check.style.color = 'transparent';
    estado.trasladosSeleccionados = estado.trasladosSeleccionados.filter(t => t.id != id);
  } else {
    item.classList.add('open');
    check.style.background = '#d4a853';
    check.style.borderColor = '#d4a853';
    check.style.color = '#fff';
    if(!estado.trasladosSeleccionados.find(t => t.id == id)) {
      estado.trasladosSeleccionados.push({id, nombre, precio: parseFloat(precio)});
    }
  }
}

// ── Cargar actividades ──
function cargarActividades(ciudad) {
  const acts = actividadesPHP.filter(a => a.ciudad === ciudad && a.tipo === 'actividad');
  const cont = document.getElementById('actividadesContainer');
  const tit  = document.getElementById('titActividades');

  if(!acts.length) { tit.style.display='none'; cont.innerHTML=''; return; }
  tit.style.display = 'flex';

  cont.innerHTML = acts.map(a => `
    <div class="servicio-toggle" 
         data-id="a${a.id}"
         data-precio="${a.precio}"
         data-nombre="${a.nombre}"
         onclick="toggleActividad(this, ${a.id}, '${a.nombre}', ${a.precio})">
      <div class="srv-info">
        <div class="srv-nombre">${a.nombre}</div>
        <div class="srv-desc">${a.descripcion}</div>
      </div>
      <div class="srv-precio">$${formatNum(a.precio)}</div>
      <div class="toggle-check">✓</div>
    </div>
  `).join('');
}

function toggleActividad(el, id, nombre, precio) {
  el.classList.toggle('selected');
  const existe = estado.actividadesSeleccionadas.find(a => a.id == id);
  if(existe) {
    estado.actividadesSeleccionadas = estado.actividadesSeleccionadas.filter(a => a.id != id);
  } else {
    estado.actividadesSeleccionadas.push({id, nombre, precio: parseFloat(precio)});
  }
}

// ── Toggle servicios fijos ──
function toggleServicio(el) {
  el.classList.toggle('selected');
  const id     = el.dataset.id;
  const precio = parseFloat(el.dataset.precio);
  const nombre = el.querySelector('.srv-nombre').innerText;
  const existe = estado.serviciosSeleccionados.find(s => s.id === id);
  if(existe) {
    estado.serviciosSeleccionados = estado.serviciosSeleccionados.filter(s => s.id !== id);
  } else {
    estado.serviciosSeleccionados.push({id, nombre, precio});
  }
}

// ── Calcular total ──
function calcularTotal() {
  const adultos      = contadores.adultos;
  const habitaciones = contadores.habitaciones;

  // Base destino
  let total = estado.precioBase * adultos;

  // Hotel
  const hotelCard = document.querySelector('.hotel-card.selected');
  if(hotelCard) {
    const tipo  = hotelCard.querySelector('.hotel-tipo.active-tipo');
    const hId   = hotelCard.id.replace('hotel-','');
    const hotel = hotelesPHP.find(h => h.id == hId);
    if(hotel && tipo) {
      const precioHab = parseFloat(hotel['precio_' + tipo.dataset.tipo]) || 0;
      total += precioHab * habitaciones;
      estado.hotelNombre = hotel.nombre;
      estado.tipoHabitacion = tipo.dataset.tipo;
      estado.hotelPrecio = precioHab;
    }
  }

  // Servicios fijos
  estado.serviciosSeleccionados.forEach(s => total += s.precio * adultos);

  // Traslados
  estado.trasladosSeleccionados.forEach(t => total += t.precio * adultos);

  // Actividades
  estado.actividadesSeleccionadas.forEach(a => total += a.precio * adultos);

  return total;
}

// ── Render resumen ──
function renderResumen() {
  const total    = calcularTotal();
  const adultos  = contadores.adultos;
  const habs     = contadores.habitaciones;
  let rows       = '';

  if(estado.destino) {
    rows += resumenRow('Destino', estado.destino);
    rows += resumenRow('Precio base', `$${formatNum(estado.precioBase)} × ${adultos} adultos`, `$${formatNum(estado.precioBase * adultos)}`);
  }
  if(estado.origen)       rows += resumenRow('Origen', estado.origen);
  if(estado.fechaIda)     rows += resumenRow('Fecha de ida', estado.fechaIda);
  if(estado.fechaRegreso) rows += resumenRow('Fecha de regreso', estado.fechaRegreso);
  rows += resumenRow('Viajeros', `${adultos} adulto(s) / ${contadores.ninos} niño(s)`);

  if(estado.hotelNombre) {
    rows += resumenRow('Hotel', `${estado.hotelNombre} (${estado.tipoHabitacion}) × ${habs} hab.`, `$${formatNum(estado.hotelPrecio * habs)}`);
  }

  estado.serviciosSeleccionados.forEach(s => {
    rows += resumenRow(s.nombre, `× ${adultos} personas`, `$${formatNum(s.precio * adultos)}`);
  });

  estado.trasladosSeleccionados.forEach(t => {
    const llegada = document.getElementById('tras-llegada-' + t.id)?.value || '';
    const salida  = document.getElementById('tras-salida-'  + t.id)?.value || '';
    const horario = llegada || salida ? ` (${llegada ? 'Llegada: '+llegada : ''} ${salida ? '/ Salida: '+salida : ''})` : '';
    rows += resumenRow(t.nombre + horario, `× ${adultos} personas`, `$${formatNum(t.precio * adultos)}`);
  });

  estado.actividadesSeleccionadas.forEach(a => {
    rows += resumenRow(a.nombre, `× ${adultos} personas`, `$${formatNum(a.precio * adultos)}`);
  });

  document.getElementById('resumenBox').innerHTML = `
    ${rows}
    <div class="resumen-total">
      <div class="t-label">Total estimado</div>
      <div class="t-valor">$${formatNum(total)}</div>
    </div>
  `;
}

function resumenRow(label, valor, precio) {
  return `<div class="resumen-row">
    <span class="r-label">${label}</span>
    <span class="r-valor">${precio ? precio : valor}</span>
  </div>`;
}

// ── Navegación wizard ──
function irPaso(paso) {
  // Validar paso 1
  if(paso === 2) {
    if(!estado.destino) { alert('Por favor selecciona un destino.'); return; }
    if(!document.getElementById('origen').value) { alert('Por favor ingresa tu ciudad de origen.'); return; }
    if(!document.getElementById('fechaIda').value) { alert('Por favor selecciona la fecha de ida.'); return; }
    estado.origen      = document.getElementById('origen').value;
    estado.fechaIda    = document.getElementById('fechaIda').value;
    estado.fechaRegreso= document.getElementById('fechaRegreso').value;
    estado.adultos     = contadores.adultos;
    estado.ninos       = contadores.ninos;
  }
  if(paso === 3) {
    renderResumen();
  }

  // Cambiar paso visual
  document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
  document.getElementById('paso-' + paso).classList.add('active');

  // Actualizar stepper
  for(let i = 1; i <= 3; i++) {
    const si = document.getElementById('si-' + i);
    si.classList.remove('active','done');
    if(i < paso)  si.classList.add('done');
    if(i === paso) si.classList.add('active');
    if(i < 3) {
      const sl = document.getElementById('sl-' + i);
      sl.classList.toggle('done', i < paso);
    }
  }

  window.scrollTo({top: 0, behavior: 'smooth'});
}

// ── Enviar WhatsApp ──
function enviarWhatsApp() {
  const nombres   = document.getElementById('ctNombres').value.trim();
  const apellidos = document.getElementById('ctApellidos').value.trim();
  const telefono  = document.getElementById('ctTelefono').value.trim();
  const correo    = document.getElementById('ctCorreo').value.trim();

  if(!nombres || !telefono) { alert('Por favor ingresa tu nombre y teléfono.'); return; }

  const total = calcularTotal();
  let msg = `¡Hola Ruta 20! 👋 Me interesa cotizar un viaje:%0A%0A`;
  msg += `👤 *Cliente:* ${nombres} ${apellidos}%0A`;
  msg += `📞 *Teléfono:* ${telefono}%0A`;
  msg += `📧 *Correo:* ${correo}%0A%0A`;
  msg += `✈ *Destino:* ${estado.destino}%0A`;
  msg += `🏙 *Origen:* ${estado.origen}%0A`;
  msg += `📅 *Ida:* ${estado.fechaIda} | *Regreso:* ${estado.fechaRegreso}%0A`;
  msg += `👥 *Adultos:* ${contadores.adultos} | *Niños:* ${contadores.ninos}%0A%0A`;

  if(estado.hotelNombre) msg += `🏨 *Hotel:* ${estado.hotelNombre} (${estado.tipoHabitacion}) × ${contadores.habitaciones} hab.%0A`;

  if(estado.serviciosSeleccionados.length) {
    msg += `%0A➕ *Servicios adicionales:*%0A`;
    estado.serviciosSeleccionados.forEach(s => msg += `  • ${s.nombre}%0A`);
  }
  if(estado.trasladosSeleccionados.length) {
    msg += `%0A🚌 *Traslados:*%0A`;
    estado.trasladosSeleccionados.forEach(t => {
      const llegada = document.getElementById('tras-llegada-' + t.id)?.value || '-';
      const salida  = document.getElementById('tras-salida-'  + t.id)?.value || '-';
      msg += `  • ${t.nombre} (Llegada: ${llegada} / Salida: ${salida})%0A`;
    });
  }
  if(estado.actividadesSeleccionadas.length) {
    msg += `%0A🎯 *Actividades:*%0A`;
    estado.actividadesSeleccionadas.forEach(a => msg += `  • ${a.nombre}%0A`);
  }

  msg += `%0A💰 *Total estimado: $${formatNum(total)} COP*`;

  window.open(`https://wa.me/573205743668?text=${msg}`, '_blank');
}

// ── Utilidad ──
function formatNum(n) {
  return parseFloat(n).toLocaleString('es-CO');
}
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>