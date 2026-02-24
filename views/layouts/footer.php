<?php if(!defined('BASE_URL')) require_once 'C:/xampp/htdocs/ruta20/config/config.php'; ?>

<!-- info section -->
<section class="info_section">
  <div class="info_container layout_padding-top">
    <div class="container">
      <div class="heading_container">
        <h2>Contáctanos</h2>
      </div>
      <div class="info_logo">
        <img src="<?php echo BASE_URL; ?>/public/images/logo.png" alt="Ruta 20">
      </div>
      <div class="info_top">
        <div class="info_form">
          <form action="">
            <input type="text" placeholder="Ingresa tu correo electrónico">
            <button type="submit">Suscribirse</button>
          </form>
        </div>
        <div class="social_box">
          <a href="#"><img src="<?php echo BASE_URL; ?>/public/images/facebook.png" alt="Facebook"></a>
          <a href="#"><img src="<?php echo BASE_URL; ?>/public/images/twitter.png" alt="Twitter"></a>
          <a href="#"><img src="<?php echo BASE_URL; ?>/public/images/linkedin.png" alt="LinkedIn"></a>
          <a href="#"><img src="<?php echo BASE_URL; ?>/public/images/instagram.png" alt="Instagram"></a>
          <a href="#"><img src="<?php echo BASE_URL; ?>/public/images/youtube.png" alt="YouTube"></a>
        </div>
      </div>

      <div class="info_main">
        <div class="row">
          <div class="col-md-3">
            <h5>Sobre Nosotros</h5>
            <p>Somos una empresa especializada en paquetes turísticos al Eje Cafetero colombiano.</p>
          </div>
          <div class="col-md-3 col-lg-2 offset-lg-1">
            <h5>Información</h5>
            <ul>
              <li><a href="<?php echo BASE_URL; ?>/armenia">Armenia</a></li>
              <li><a href="<?php echo BASE_URL; ?>/pereira">Pereira</a></li>
              <li><a href="<?php echo BASE_URL; ?>/manizales">Manizales</a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <h5>Enlaces útiles</h5>
            <ul>
              <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
              <li><a href="<?php echo BASE_URL; ?>/about">Sobre nosotros</a></li>
              <li><a href="<?php echo BASE_URL; ?>/paquetes">Paquetes</a></li>
              <li><a href="<?php echo BASE_URL; ?>/cotizar">Cotiza tu viaje</a></li>
            </ul>
          </div>
          <div class="col-md-3 col-lg-2 offset-lg-1">
            <h5>Soporte</h5>
            <ul>
              <li><a href="#">Preguntas frecuentes</a></li>
              <li><a href="#">Política de privacidad</a></li>
              <li><a href="#">Términos y condiciones</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-9 col-md-10 mx-auto">
          <div class="info_contact layout_padding2">
            <div class="row">
              <div class="col-md-5">
                <a href="tel:+573205743668" class="link-box">
                  <div class="img-box"><img src="<?php echo BASE_URL; ?>/public/images/call.png" alt="Teléfono"></div>
                  <div class="detail-box"><h6>+57 320 574 3668</h6></div>
                </a>
              </div>
              <div class="col-md-2">
                <a href="#" class="link-box">
                  <div class="img-box"><img src="<?php echo BASE_URL; ?>/public/images/location.png" alt="Ubicación"></div>
                  <div class="detail-box"><h6>Pereira, Colombia</h6></div>
                </a>
              </div>
              <div class="col-md-5">
                <a href="mailto:ruta20@gmail.com" class="link-box">
                  <div class="img-box"><img src="<?php echo BASE_URL; ?>/public/images/mail.png" alt="Email"></div>
                  <div class="detail-box"><h6>ruta20@gmail.com</h6></div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="footer_section">
  <p>&copy; 2026 Ruta 20. Todos los derechos reservados.</p>
</section>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- Bootstrap 4 CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Owl Carousel CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<script>
  if('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/ruta20/service-worker.js')
        .then(() => console.log('PWA activa'))
        .catch(err => console.log('Error SW:', err));
    });
  }
</script>

</body>
</html>