<?php
session_start();

if ($_POST) {
    $usuario  = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario == "admin" && $password == "123456") {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ruta 20 · Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --violet-deep:   #110a2e;
      --violet-dark:   #181154;
      --violet-mid:    #2e21a8;
      --violet-bright: #3373ea;
      --violet-glow:   #8684fc;
      --violet-soft:   #d5d6ff;
      --gold:          #d4a853;
      --gold-light:    #f0cc7a;
      --white:         #faf5ff;
      --glass:         rgba(255,255,255,0.06);
      --glass-border:  rgba(144, 132, 252, 0.2);
    }

    html, body {
      height: 100%;
      font-family: 'DM Sans', sans-serif;
      background: var(--violet-deep);
      overflow: hidden;
    }

    /* ── Fondo animado ── */
    .bg {
      position: fixed; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse 80% 60% at 20% 10%,  #090764 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 80% 80%,  #1f1d95 0%, transparent 55%),
        radial-gradient(ellipse 40% 40% at 55% 40%,  #2157a8 0%, transparent 50%),
        var(--violet-deep);
    }

    .bg::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        radial-gradient(circle 1px at 20% 30%, rgba(132, 188, 252, 0.4) 0%, transparent 0%),
        radial-gradient(circle 1px at 75% 60%, rgba(46, 63, 161, 0.3) 0%, transparent 0%),
        radial-gradient(circle 1px at 45% 80%, rgba(132, 140, 252, 0.2) 0%, transparent 0%);
      background-size: 180px 180px, 220px 220px, 150px 150px;
      animation: drift 20s linear infinite;
    }

    .orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(70px);
      opacity: 0.35;
      animation: pulse 8s ease-in-out infinite alternate;
      pointer-events: none;
    }
    .orb-1 { width: 500px; height: 500px; top: -150px; left: -100px; background: var(--violet-mid); animation-delay: 0s; }
    .orb-2 { width: 400px; height: 400px; bottom: -100px; right: -80px; background: #7c3aed; animation-delay: -3s; }
    .orb-3 { width: 250px; height: 250px; top: 40%; left: 55%; background: var(--gold); opacity: 0.12; animation-delay: -6s; }

    @keyframes drift   { to { background-position: 180px 180px, -220px -220px, 150px -150px; } }
    @keyframes pulse   { from { transform: scale(1); } to { transform: scale(1.15); } }

    /* ── Layout ── */
    .page {
      position: relative; z-index: 1;
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 480px 1fr;
      grid-template-rows: 1fr;
      align-items: center;
      justify-items: center;
      padding: 2rem;
    }

    /* ── Card ── */
    .card {
      grid-column: 2;
      width: 100%;
      background: var(--glass);
      backdrop-filter: blur(24px) saturate(180%);
      -webkit-backdrop-filter: blur(24px) saturate(180%);
      border: 1px solid var(--glass-border);
      border-radius: 24px;
      padding: 52px 48px 48px;
      box-shadow:
        0 0 0 1px rgba(196,132,252,0.08),
        0 32px 64px rgba(0,0,0,0.4),
        0 0 80px rgba(107,33,168,0.2),
        inset 0 1px 0 rgba(255,255,255,0.08);
      animation: cardIn 0.7s cubic-bezier(0.16,1,0.3,1) both;
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(32px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0)    scale(1);    }
    }

    /* ── Logo ── */
    .logo-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 36px;
    }

    .logo-emblem {
      width: 72px; height: 72px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--violet-mid), var(--violet-bright));
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 16px;
      box-shadow: 0 0 0 8px rgba(147,51,234,0.15), 0 8px 32px rgba(107,33,168,0.5);
      position: relative;
      overflow: hidden;
    }

    /* Si tienes el logo usa <img>, si no se muestra el SVG de ruta */
    .logo-emblem img {
  width: 100%;
  height: 100%;
  object-fit: cover;      /* llena el círculo sin deformar */
  object-position: center;
  border-radius: 50%;
  filter: none;           /* quita el filtro blanco que tenía antes */
}
    

    .logo-emblem svg {
      width: 36px; height: 36px;
      fill: none;
      stroke: #fff;
      stroke-width: 1.5;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .logo-emblem::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
      border-radius: 50%;
    }

    .logo-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 600;
      color: var(--white);
      letter-spacing: 0.08em;
      line-height: 1;
    }

    .logo-name span {
      color: var(--gold-light);
    }

    .logo-tagline {
      font-size: 0.72rem;
      font-weight: 300;
      color: rgba(196,132,252,0.7);
      letter-spacing: 0.25em;
      text-transform: uppercase;
      margin-top: 6px;
    }

    /* ── Divisor ── */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin-bottom: 28px;
    }
    .divider-line { flex: 1; height: 1px; background: var(--glass-border); }
    .divider-text {
      font-size: 0.68rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: rgba(196,132,252,0.5);
      white-space: nowrap;
    }

    /* ── Error ── */
    .alert-error {
      background: rgba(239,68,68,0.12);
      border: 1px solid rgba(239,68,68,0.3);
      color: #fca5a5;
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 0.83rem;
      margin-bottom: 20px;
      display: flex; align-items: center; gap: 8px;
      animation: shake 0.4s ease;
    }
    .alert-error::before { content: '⚠'; font-size: 0.9rem; }
    @keyframes shake {
      0%,100% { transform: translateX(0); }
      25%      { transform: translateX(-6px); }
      75%      { transform: translateX(6px); }
    }

    /* ── Inputs ── */
    .field { margin-bottom: 18px; position: relative; }

    .field label {
      display: block;
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: rgba(196,132,252,0.7);
      margin-bottom: 8px;
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap .icon {
      position: absolute;
      left: 16px; top: 50%;
      transform: translateY(-50%);
      color: rgba(196,132,252,0.45);
      width: 16px; height: 16px;
      pointer-events: none;
      transition: color 0.2s;
    }

    .field input {
      width: 100%;
      padding: 14px 16px 14px 44px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(196,132,252,0.18);
      border-radius: 12px;
      color: var(--white);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.92rem;
      font-weight: 300;
      outline: none;
      transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
    }

    .field input::placeholder { color: rgba(196,132,252,0.3); }

    .field input:focus {
      border-color: var(--violet-glow);
      background: rgba(147,51,234,0.08);
      box-shadow: 0 0 0 3px rgba(147,51,234,0.18), 0 0 20px rgba(147,51,234,0.12);
    }

    .field input:focus + .focus-line { transform: scaleX(1); }

    .field input:focus ~ .icon { color: var(--violet-glow); }

    /* ── Botón ── */
    .btn-submit {
      width: 100%;
      margin-top: 8px;
      padding: 15px;
      background: linear-gradient(135deg, var(--violet-mid) 0%, var(--violet-bright) 100%);
      border: none;
      border-radius: 12px;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 8px 24px rgba(107,33,168,0.45), 0 0 0 1px rgba(255,255,255,0.06) inset;
    }

    .btn-submit::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.18) 0%, transparent 60%);
      opacity: 0;
      transition: opacity 0.2s;
    }

    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(107,33,168,0.6); }
    .btn-submit:hover::before { opacity: 1; }
    .btn-submit:active { transform: translateY(0); }

    /* Ripple */
    .btn-submit .ripple {
      position: absolute; border-radius: 50%;
      background: rgba(255,255,255,0.25);
      transform: scale(0);
      animation: ripple 0.6s linear;
      pointer-events: none;
    }
    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    /* ── Footer ── */
    .card-footer {
      margin-top: 28px;
      text-align: center;
      font-size: 0.72rem;
      color: rgba(196,132,252,0.35);
      letter-spacing: 0.05em;
    }
    .card-footer a {
      color: rgba(196,132,252,0.6);
      text-decoration: none;
      transition: color 0.2s;
    }
    .card-footer a:hover { color: var(--violet-glow); }

    /* ── Decoración lateral ── */
    .side-text {
      font-family: 'Cormorant Garamond', serif;
      font-size: 7rem;
      font-weight: 300;
      color: rgba(107,33,168,0.08);
      letter-spacing: -0.02em;
      line-height: 1;
      user-select: none;
      writing-mode: vertical-rl;
      text-orientation: mixed;
      transform: rotate(180deg);
      animation: cardIn 1s cubic-bezier(0.16,1,0.3,1) 0.2s both;
    }
    .side-left  { grid-column: 1; justify-self: end;   padding-right: 40px; }
    .side-right { grid-column: 3; justify-self: start; padding-left: 40px; writing-mode: vertical-lr; transform: none; }

    @media (max-width: 900px) {
      .page { grid-template-columns: 1fr; padding: 1.5rem; }
      .card { grid-column: 1; padding: 40px 28px 36px; }
      .side-text { display: none; }
    }
  </style>
</head>
<body>

<div class="bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="page">

  <div class="side-text side-left">Ruta20</div>

  <div class="card">

    <!-- Logo -->
   <div class="logo-wrap">
  <div class="logo-emblem">
    <img src="/ruta20/public/images/logo.png" alt="Ruta 20">
  </div>
  <div class="logo-name">RUTA <span>20</span></div>
  <div class="logo-tagline">Panel Administrativo</div>
</div>
    <!-- Divisor -->
    <div class="divider">
      <div class="divider-line"></div>
      <div class="divider-text">Acceso restringido</div>
      <div class="divider-line"></div>
    </div>

    <!-- Error -->
    <?php if (isset($error)): ?>
      <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Formulario -->
    <form method="POST" id="loginForm">

      <div class="field">
        <label for="usuario">Usuario</label>
        <div class="input-wrap">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          <input type="text" id="usuario" name="usuario"
                 placeholder="Ingresa tu usuario"
                 value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>"
                 required autocomplete="username">
        </div>
      </div>

      <div class="field">
        <label for="password">Contraseña</label>
        <div class="input-wrap">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" id="password" name="password"
                 placeholder="••••••••"
                 required autocomplete="current-password">
        </div>
      </div>

      <button type="submit" class="btn-submit" id="btnSubmit">
        Ingresar al Panel
      </button>

    </form>

    <div class="card-footer">
      <a href="../index.php">← Volver al sitio</a>
      &nbsp;·&nbsp;
      © 2026 Ruta 20
    </div>

  </div><!-- end card -->

  <div class="side-text side-right">Ruta20</div>

</div><!-- end page -->

<script>
  // Ripple effect en botón
  document.getElementById('btnSubmit').addEventListener('click', function(e) {
    const btn = this;
    const ripple = document.createElement('span');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.cssText = `
      width: ${size}px; height: ${size}px;
      left: ${e.clientX - rect.left - size/2}px;
      top:  ${e.clientY - rect.top  - size/2}px;
    `;
    ripple.classList.add('ripple');
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  });
</script>

</body>
</html>