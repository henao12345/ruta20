<?php 
require_once 'C:/xampp/htdocs/ruta20/config/config.php';
require_once BASE_PATH . '/config/conexion.php';
include BASE_PATH . '/views/layouts/header.php'; 
?>

<section class="package_section layout_padding">
  <div class="container">

    <div class="heading_container">
      <h2>Paquetes en Armenia</h2>
      <p>Descubre todas nuestras experiencias disponibles en Armenia.</p>
    </div>

    <div class="package_container">

    <?php
    $stmt = $conexion->prepare(
        "SELECT * FROM paquetes WHERE ciudad = 'Armenia' ORDER BY fecha_creacion DESC"
    );
    $stmt->execute();
    $resultado = $stmt->get_result();
    $contador = 1;

    while($paquete = $resultado->fetch_assoc()):
    ?>

      <div class="box<?php echo $contador; ?>">
        <div class="detail-box">

          <img src="<?php echo BASE_URL; ?>/public/uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>"
               alt="<?php echo htmlspecialchars($paquete['titulo']); ?>"
               style="width:100%; height:250px; object-fit:cover; margin-bottom:15px;">

          <h4><?php echo htmlspecialchars($paquete['titulo']); ?></h4>

          <div class="price_detail">
            <h5>Desde $<?php echo number_format($paquete['precio'], 0, ',', '.'); ?></h5>
            <p><?php echo htmlspecialchars($paquete['descripcion']); ?></p>
          </div>

          <a href="#"
             data-toggle="modal"
             data-target="#reservaModal"
             onclick="cargarPaquete(
               '<?php echo htmlspecialchars($paquete['titulo'], ENT_QUOTES); ?>',
               '<?php echo str_replace('.', '', $paquete['precio']); ?>',
               '<?php echo $paquete['id']; ?>',
               '<?php echo $paquete['ciudad']; ?>'
             )">
            Ver detalles
          </a>

        </div>
      </div>

    <?php
      $contador++;
      if($contador > 3) $contador = 1;
    endwhile;
    ?>

    </div>
  </div>
</section>

<!-- MODAL RESERVA -->
<div class="modal fade" id="reservaModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4" style="color:#333; background-color:#fff;">

      <div class="modal-header border-0 p-0 mb-2">
        <h4 id="modalTitulo" class="modal-title" style="color:#000;"></h4>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <p>Precio por persona: $<span id="modalPrecio"></span></p>
      <hr>

      <input type="hidden" id="modalPaqueteId" value="">
      <input type="hidden" id="modalCiudad" value="">

      <div class="form-group">
        <label style="color:#000;">Cantidad de personas</label>
        <input type="number" id="modalPersonas" class="form-control" min="1" value="1">
      </div>
      <div class="form-group">
        <label style="color:#000;">Nombres</label>
        <input type="text" id="modalNombres" class="form-control">
      </div>
      <div class="form-group">
        <label style="color:#000;">Apellidos</label>
        <input type="text" id="modalApellidos" class="form-control">
      </div>
      <div class="form-group">
        <label style="color:#000;">Teléfono</label>
        <input type="text" id="modalTelefono" class="form-control">
      </div>
      <div class="form-group">
        <label style="color:#000;">Correo</label>
        <input type="email" id="modalCorreo" class="form-control">
      </div>

      <h4>Total: $<span id="modalTotal"></span></h4>
      <br>
      <button onclick="enviarReserva()" class="btn btn-success btn-block">
        Enviar por WhatsApp
      </button>

    </div>
  </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

<!-- ✅ Script DESPUÉS del footer para que jQuery y Bootstrap ya estén cargados -->
<script>
let precioActual = 0;
let tituloActual = "";

function cargarPaquete(titulo, precio, paqueteId, ciudad) {
    tituloActual = titulo;
    precioActual = parseInt(precio.toString().replace(/\./g, '').replace(/,/g, ''));
    document.getElementById("modalTitulo").innerText = titulo;
    document.getElementById("modalPrecio").innerText = precioActual.toLocaleString('es-CO');
    document.getElementById("modalPaqueteId").value = paqueteId;
    document.getElementById("modalCiudad").value = ciudad;
    calcularTotal();
}

function calcularTotal() {
    let personas = parseInt(document.getElementById("modalPersonas").value) || 1;
    let total = precioActual * personas;
    document.getElementById("modalTotal").innerText = total.toLocaleString('es-CO');
}

document.getElementById("modalPersonas").addEventListener("input", calcularTotal);

function enviarReserva() {
    let personas  = parseInt(document.getElementById("modalPersonas").value) || 1;
    let nombres   = document.getElementById("modalNombres").value.trim();
    let apellidos = document.getElementById("modalApellidos").value.trim();
    let telefono  = document.getElementById("modalTelefono").value.trim();
    let correo    = document.getElementById("modalCorreo").value.trim();
    let paqueteId = document.getElementById("modalPaqueteId").value;
    let ciudad    = document.getElementById("modalCiudad").value;
    let total     = precioActual * personas;

    if(!nombres || !apellidos || !telefono || !correo) {
        alert("Por favor completa todos los campos.");
        return;
    }

    $.ajax({
        url: '<?php echo BASE_URL; ?>/reserva.php',
        type: 'POST',
        data: {
            paquete_id: paqueteId,
            ciudad:     ciudad,
            personas:   personas,
            nombres:    nombres,
            apellidos:  apellidos,
            telefono:   telefono,
            correo:     correo,
            total:      total
        },
        success: function(response) {
            try {
                let res = JSON.parse(response);
                if(res.status == "ok") {
                    let mensaje = `Hola, quiero reservar el paquete: ${tituloActual}%0A` +
                                  `Cantidad de personas: ${personas}%0A` +
                                  `Nombre: ${nombres} ${apellidos}%0A` +
                                  `Teléfono: ${telefono}%0A` +
                                  `Correo: ${correo}%0A` +
                                  `Total a pagar: $${total.toLocaleString('es-CO')}`;
                    window.open(`https://wa.me/573215985211?text=${mensaje}`, "_blank");
                    $('#reservaModal').modal('hide');
                } else {
                    alert("Error al guardar: " + res.message);
                }
            } catch(e) {
                alert("Error inesperado: " + response);
            }
        },
        error: function() {
            alert("No se pudo conectar con el servidor.");
        }
    });
}
</script>