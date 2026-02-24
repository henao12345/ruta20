<?php include("config/conexion.php"); ?>
<?php include("header.php"); ?>

<section class="package_section layout_padding">
  <div class="container">

    <div class="heading_container">
      <h2>Paquetes en Manizales</h2>
      <p>Descubre todas nuestras experiencias disponibles en Manizales.</p>
    </div>

   <div class="package_container">

<?php
$consulta = "SELECT * FROM paquetes 
             WHERE ciudad = 'Manizales' 
             ORDER BY fecha_creacion DESC";

$resultado = $conexion->query($consulta);

$contador = 1;

while($paquete = $resultado->fetch_assoc()){
?>

  <div class="box<?php echo $contador; ?>">
    <div class="detail-box">

      <img src="uploads/<?php echo $paquete['imagen']; ?>" 
           alt="<?php echo $paquete['titulo']; ?>" 
           style="width:100%; height:250px; object-fit:cover; margin-bottom:15px;">

      <h4><?php echo $paquete['titulo']; ?></h4>

      <div class="price_detail">
        <h5>Desde $<?php echo $paquete['precio']; ?></h5>
        <p><?php echo $paquete['descripcion']; ?></p>
      </div>

            <a href="#"
   data-toggle="modal"
   data-target="#reservaModal"
   onclick="cargarPaquete(
       '<?php echo $paquete['titulo']; ?>',
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

if($contador > 3){
  $contador = 1; // reinicia para que vuelva a usar box1, box2, box3
}

}
?>

</div>
  </div>
</section>
<!-- MODAL RESERVA -->

<div class="modal fade" id="reservaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-4" style="color:#333; background-color:#fff;">

      <h4 id="modalTitulo" style="color:#000;"></h4>
      <p>Precio por persona: $<span id="modalPrecio"></span></p>

      <hr>

      <!-- Campos ocultos -->
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

      <button onclick="enviarReserva()" class="btn btn-success">
        Enviar por WhatsApp
      </button>

    </div>
  </div>
</div>

<script>
let precioActual = 0;
let tituloActual = "";

// Cargar datos en modal
function cargarPaquete(titulo, precio, paqueteId, ciudad) {
    tituloActual = titulo;
    precioActual = parseInt(precio.toString().replace(/,/g, ''));
    document.getElementById("modalTitulo").innerText = titulo;
    document.getElementById("modalPrecio").innerText = precioActual.toLocaleString();
    document.getElementById("modalPaqueteId").value = paqueteId;
    document.getElementById("modalCiudad").value = ciudad;

    calcularTotal();
}

// Calcular total dinámico
function calcularTotal() {
    let personas = parseInt(document.getElementById("modalPersonas").value);
    let total = precioActual * personas;
    document.getElementById("modalTotal").innerText = total.toLocaleString();
}

// Actualizar total al cambiar cantidad
document.getElementById("modalPersonas").addEventListener("input", calcularTotal);

// Función principal: guarda en DB y abre WhatsApp
function enviarReserva() {
    let personas = parseInt(document.getElementById("modalPersonas").value);
    let nombres = document.getElementById("modalNombres").value;
    let apellidos = document.getElementById("modalApellidos").value;
    let telefono = document.getElementById("modalTelefono").value;
    let correo = document.getElementById("modalCorreo").value;
    let paqueteId = document.getElementById("modalPaqueteId").value;
    let ciudad = document.getElementById("modalCiudad").value;
    let total = precioActual * personas;

    $.ajax({
        url: 'reserva.php',
        type: 'POST',
        data: {
            paquete_id: paqueteId,
            ciudad: ciudad,
            personas: personas,
            nombres: nombres,
            apellidos: apellidos,
            telefono: telefono,
            correo: correo,
            total: total
        },
        success: function(response){
            try {
                let res = JSON.parse(response);
                if(res.status == "ok") {
                    alert("Reserva guardada correctamente!");

                    // Abrir WhatsApp
                    let mensaje = `Hola, quiero reservar el paquete: ${tituloActual}%0A
Cantidad de personas: ${personas}%0A
Nombre: ${nombres} ${apellidos}%0A
Teléfono: ${telefono}%0A
Correo: ${correo}%0A
Total a pagar: $${total}`;

                    let numero = "573215985211";
                    window.open(`https://wa.me/${numero}?text=${mensaje}`, "_blank");

                    // Cerrar modal
                    $('#reservaModal').modal('hide');
                } else {
                    alert("Error al guardar la reserva: " + res.message);
                }
            } catch(e) {
                alert("Error inesperado: " + response);
            }
        }
    });
}


</script>
<?php include("footer.php"); ?>