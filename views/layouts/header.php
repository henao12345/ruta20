<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/ruta20/config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- PWA -->
  <link rel="manifest" href="<?php echo BASE_URL; ?>/public/manifest.json">
  <meta name="theme-color" content="#213aa8">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Ruta 20">
  <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>/public/images/logo.png">
  <title>Ruta 20</title>

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- Bootstrap 4 CSS — solo una vez -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/bootstrap.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,500,700&display=swap" rel="stylesheet" />

  <!-- Estilos propios -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/responsive.css" />
</head>

<body>
<div class="hero_area">
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">

        <div class="fk_width">
          <div class="custom_menu-btn">
            <button onclick="openNav()">
              <span class="s-1"></span>
              <span class="s-2"></span>
              <span class="s-3"></span>
            </button>
          </div>
          <div id="myNav" class="overlay">
            <div class="overlay-content">
              <a href="<?php echo BASE_URL; ?>">Principal</a>
              <a href="<?php echo BASE_URL; ?>/about">Nosotros</a>
              <a href="<?php echo BASE_URL; ?>/paquetes">Paquetes</a>
              <a href="<?php echo BASE_URL; ?>/testimonios">Testimonios</a>
            </div>
          </div>
        </div>

        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
          <img src="<?php echo BASE_URL; ?>/public/images/logo.png" alt="Ruta 20" />
        </a>

        <div class="user_option">
          <a href="<?php echo isset($_SESSION['admin']) ? BASE_URL.'/admin/dashboard.php' : BASE_URL.'/admin/login.php'; ?>"
             data-toggle="tooltip"
             title="<?php echo isset($_SESSION['admin']) ? 'Ir al Dashboard' : 'Iniciar sesión'; ?>">
            <img src="<?php echo BASE_URL; ?>/public/images/user-icon.png" alt="Usuario" />
          </a>
          <form class="form-inline my-2 my-lg-0 mb-3 mb-lg-0">
            <button class="btn my-2 my-sm-0 nav_search-btn" type="submit"></button>
          </form>
        </div>

      </nav>
    </div>
  </header>