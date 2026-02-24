<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/ruta20/config/config.php';
include BASE_PATH . '/views/layouts/header.php';
?>

  <!-- slider section -->
  <section class="slider_section position-relative">
    <div class="detail-box">
      <div class="row">
        <div class="col-md-8 col-lg-6 mx-auto">
          <h1>Descubre el <br /> Eje Cafetero con Ruta 20</h1>
          <p>
            En Ruta 20 diseñamos experiencias únicas a Armenia, Pereira y Manizales.
            Disfruta paisajes cafeteros, cultura, naturaleza y aventura en un solo viaje.
          </p>
          <div>
            <a href="<?php echo BASE_URL; ?>/paquetes">Reservar ahora</a>
          </div>
        </div>
      </div>
    </div>
    <div class="img-box">
      <div class="play_btn">
        <a href="#">
          <img src="<?php echo BASE_URL; ?>/public/images/play.png" alt="" />
        </a>
      </div>
      <img src="<?php echo BASE_URL; ?>/public/images/slider-img.png" class="slider-img" alt="" />
    </div>
  </section>
</div>
<!-- fin hero_area -->


<!-- cotizar section -->
<section class="book_section">
  <div class="container">
    <div class="row">
      <div class="col text-center">
        <div class="heading_container">
  <h2 style="color:#ffffff;">¿Listo para vivir el Eje Cafetero?</h2>
  <p style="color:rgba(255,255,255,0.75);">
    Diseña tu viaje ideal eligiendo hotel, actividades, traslados y más.<br>
    Tú decides cada detalle, nosotros lo hacemos realidad.
  </p>
</div>
        <a href="<?php echo BASE_URL; ?>/cotizar"
           style="
             display:inline-flex;
             align-items:center;
             gap:10px;
             background:linear-gradient(135deg,#d4a853,#f0cc7a);
             color:#1a0a2e;
             font-weight:700;
             font-size:0.95rem;
             padding:15px 40px;
             border-radius:30px;
             text-decoration:none;
             letter-spacing:0.05em;
             box-shadow:0 8px 24px rgba(212,168,83,0.4);
             transition:all 0.3s;
           "
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 32px rgba(212,168,83,0.6)'"
           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 24px rgba(212,168,83,0.4)'"
        >
          ✨ Cotiza tu viaje personalizado
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>
<!-- end cotizar section -->



<!-- paquetes destacados -->
<section class="package_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>Nuestros Paquetes Destacados</h2>
      <p>Descubre nuestras mejores experiencias en el Eje Cafetero.</p>
    </div>
    <div class="package_container">
      <?php
        require_once BASE_PATH . '/config/config.php';
        $stmt = $conexion->prepare(
          "SELECT * FROM paquetes WHERE destacado = 1 ORDER BY ciudad ASC, fecha_creacion DESC LIMIT 9"
        );
        $stmt->execute();
        $resultado = $stmt->get_result();
        $contador = 1;
        while ($paquete = $resultado->fetch_assoc()):
      ?>
        <div class="box<?php echo $contador; ?>">
          <div class="detail-box">
            <img src="<?php echo BASE_URL; ?>/public/uploads/<?php echo htmlspecialchars($paquete['imagen']); ?>"
                 alt="<?php echo htmlspecialchars($paquete['titulo']); ?>"
                 style="width:100%; margin-bottom:15px;">
            <h4><?php echo htmlspecialchars($paquete['titulo']); ?></h4>
            <div class="price_detail">
              <h5>Desde $<?php echo number_format($paquete['precio'], 0, ',', '.'); ?></h5>
              <p><?php echo htmlspecialchars($paquete['descripcion']); ?></p>
            </div>
            <a href="<?php echo BASE_URL . '/' . strtolower(htmlspecialchars($paquete['ciudad'])); ?>">Ver más</a>
          </div>
        </div>
      <?php $contador++; endwhile; ?>
    </div>
  </div>
</section>
<!-- end package section -->


<!-- about section -->
<section class="about_section layout_padding">
  <div class="heading_container">
    <h2>Sobre Ruta 20</h2>
    <p>
      Ruta 20 es una empresa especializada en paquetes turísticos al Eje Cafetero colombiano.
      Nuestro objetivo es brindarte experiencias memorables con servicio personalizado,
      comodidad y seguridad en cada viaje.
    </p>
  </div>
  <div class="img-box">
    <img src="<?php echo BASE_URL; ?>./public/images/about-img.png" class="slider-img" alt="" />
  </div>
  <div class="btn-box">
    <a href="<?php echo BASE_URL; ?>/about">Conocer más</a>
  </div>
</section>
<!-- end about section -->


<!-- client section -->
<section class="client_section">
  <div class="container">
    <div class="heading_container">
      <h2>Lo que dicen nuestros viajeros</h2>
      <p>Conoce las experiencias de quienes ya viajaron con Ruta 20 al Eje Cafetero.</p>
    </div>
  </div>
  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="container">
          <div class="client_container">
            <div class="client_box b-1">
              <div class="client-id">
                <div class="img-box">
                  <img src="<?php echo BASE_URL; ?>/public/images/client-1.jpg" alt="" />
                </div>
                <div class="name">
                  <h5>Alina Jorch</h5>
                  <p>Viajero</p>
                </div>
              </div>
              <div class="detail">
                <p>
                  Fue una experiencia increíble. Todo estuvo perfectamente organizado y los paisajes
                  del Eje Cafetero superaron nuestras expectativas. ¡Recomendado 100%!
                </p>
                <div><div class="arrow_img"></div></div>
              </div>
            </div>
            <div class="client_box b2">
              <div class="client-id">
                <div class="img-box">
                  <img src="<?php echo BASE_URL; ?>/public/images/client-2.jpg" alt="" />
                </div>
                <div class="name">
                  <h5>Carlosh Den</h5>
                  <p>Viajero</p>
                </div>
              </div>
              <div class="detail">
                <p>
                  Fue un viaje maravilloso de principio a fin. La organización fue excelente y cada lugar
                  que visitamos en el Eje Cafetero fue simplemente espectacular. Sin duda volveríamos a viajar con Ruta 20.
                </p>
                <div><div class="arrow_img"></div></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="container">
          <div class="client_container">
            <div class="client_box b-1">
              <div class="client-id">
                <div class="img-box">
                  <img src="<?php echo BASE_URL; ?>/public/images/client-1.jpg" alt="" />
                </div>
                <div class="name">
                  <h5>Alina Jorch</h5>
                  <p>Viajero</p>
                </div>
              </div>
              <div class="detail">
                <p>
                  Una experiencia inolvidable. Los paisajes, la atención y el servicio superaron
                  todo lo que imaginábamos. Gracias a Ruta 20 por hacer de nuestro viaje algo tan especial.
                </p>
                <div><div class="arrow_img"></div></div>
              </div>
            </div>
            <div class="client_box b2">
              <div class="client-id">
                <div class="img-box">
                  <img src="<?php echo BASE_URL; ?>/public/images/client-2.jpg" alt="" />
                </div>
                <div class="name">
                  <h5>Carlosh Den</h5>
                  <p>Viajero</p>
                </div>
              </div>
              <div class="detail">
                <p>
                  Una experiencia inolvidable. Los paisajes, la atención y el servicio superaron
                  todo lo que imaginábamos. Gracias a Ruta 20 por hacer de nuestro viaje algo tan especial.
                </p>
                <div><div class="arrow_img"></div></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item">
        <div class="container">
          <div class="client_container">
            <div class="client_box b-1">
              <div class="client-id">
                <div class="img-box">
                  <img src="<?php echo BASE_URL; ?>/public/images/client-1.jpg" alt="" />
                </div>
                <div class="name">
                  <h5>Alina Jorch</h5>
                  <p>Viajero</p>
                </div>
              </div>
              <div class="detail">
                <p>
                  Todo estuvo perfectamente coordinado. Disfrutamos cada momento en Armenia, Pereira y Manizales.
                  El Eje Cafetero es mágico y la experiencia fue aún mejor gracias al gran equipo de Ruta 20.
                </p>
                <div><div class="arrow_img"></div></div>
              </div>
            </div>
            <div class="client_box b2">
              <div class="client-id">
                <div class="img-box">
                  <img src="<?php echo BASE_URL; ?>/public/images/client-2.jpg" alt="" />
                </div>
                <div class="name">
                  <h5>Carlosh Den</h5>
                  <p>Viajero</p>
                </div>
              </div>
              <div class="detail">
                <p>
                  Un servicio impecable y una experiencia llena de naturaleza, cultura y tranquilidad.
                  Definitivamente el mejor plan para conocer el Eje Cafetero. ¡Totalmente recomendado!
                </p>
                <div><div class="arrow_img"></div></div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- end carousel-inner -->

    <div class="carousel_btn-container">
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="next-icon" aria-hidden="true"></span>
        <span class="sr-only">Próximo</span>
      </a>
    </div>
  </div>
</section>
<!-- end client section -->


<?php include BASE_PATH . '/views/layouts/footer.php'; ?>