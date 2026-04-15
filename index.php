<?php 
$user = 'root';
$pass = '';
$dbname = 'acusport_db';

try {
    $dbh = new PDO('mysql:host=localhost;dbname=' . $dbname, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro na ligação: ' . $e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KP2BXBCE6T"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-KP2BXBCE6T');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcuSport | Suplementação Natural & MTC</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* --- VARIÁVEIS DE COR E TIPOGRAFIA --- */
        :root {
            --cor-fundo: #fdfaf3;
            --cor-texto: #555555;
            --cor-titulos: #111d24;
            --cor-dourado: #cba052;
            --cor-dourado-hover: #b38941;
            --cor-branco: #ffffff;
            --fonte-titulos: 'Playfair Display', serif;
            --fonte-texto: 'Jost', sans-serif;
            --transicao: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            --transicao-suave: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* --- RESET BÁSICO --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* ==========================================================
           INTRO / SPLASH SCREEN (VÍDEO)
           ========================================================== */

        body.intro-activa { overflow: hidden; }

        #intro-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: all;
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease-in-out;
        }

        #intro-video {
            width: 100vw;
            height: 100vh;
            object-fit: cover; 
            pointer-events: none;
            object-position: center center; 
        }

        /* ==========================================================
           MOTOR DE ANIMAÇÕES: MASK REVEAL & ZOOM
           ========================================================== */
        .mask-wrapper { overflow: hidden; display: block; position: relative; padding-bottom: 5px; }
        .mask-text { transform: translateY(110%); opacity: 0; transition: var(--transicao-suave); display: block; }
        .anim-trigger.in-view .mask-text { transform: translateY(0); opacity: 1; }
        .fade-element { opacity: 0; transform: translateY(30px); transition: var(--transicao-suave); }
        .anim-trigger.in-view .fade-element, .fade-element.in-view { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .zoom-img-wrapper { overflow: hidden; position: relative; }
        .zoom-img { transform: scale(1.2); transition: transform 1.8s cubic-bezier(0.16, 1, 0.3, 1); display: block; }
        .zoom-img-wrapper.in-view .zoom-img { transform: scale(1); }

        /* --- NAVEGAÇÃO (HEADER) --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        header.scrolled { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 15px 50px; border-bottom: none; }
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        header:not(.scrolled) .logo-img { filter: brightness(0) invert(1); }
        header:not(.scrolled) .nav-links a, header:not(.scrolled) .icones-nav { color: var(--cor-branco); }
        .nav-links { display: flex; gap: 40px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .nav-links a:hover { color: var(--cor-dourado) !important; }
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }
        .icones-nav a { transition: var(--transicao); }
        .icones-nav a:hover { color: var(--cor-dourado) !important; }
        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); }
        header:not(.scrolled) .menu-toggle span { background: var(--cor-branco); }
        header.scrolled .menu-toggle span { background: var(--cor-titulos); }

        /* --- HERO SECTION --- */
        .hero {
            height: 100vh; display: flex; align-items: center; padding: 0 10%;
            background: linear-gradient(rgba(17, 29, 36, 0.4), rgba(17, 29, 36, 0.7)), url('img/foto-index2.png') center/cover no-repeat;
            background-attachment: fixed;
        }
        .hero-conteudo { max-width: 700px; color: var(--cor-branco); }
        .hero-tag { display: inline-block; color: var(--cor-dourado); font-weight: 600; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 20px; font-size: 13px; }
        .hero h1 { font-family: var(--fonte-titulos); font-size: 65px; color: var(--cor-branco); line-height: 1.1; margin-bottom: 30px; }
        .hero p { font-size: 20px; margin-bottom: 40px; color: #eee; font-weight: 300; }
        .btn-principal {
            display: inline-block; background: var(--cor-dourado); color: var(--cor-branco);
            padding: 16px 40px; font-size: 15px; text-transform: uppercase; letter-spacing: 2px;
            border-radius: 4px; transition: var(--transicao); font-weight: 600; border: 1px solid var(--cor-dourado);
        }
        .btn-principal:hover { background: transparent; transform: translateY(-3px); }
        .btn-secundario {
            display: inline-block; background: transparent; color: var(--cor-branco);
            padding: 16px 40px; font-size: 15px; text-transform: uppercase; letter-spacing: 2px;
            border-radius: 4px; transition: var(--transicao); font-weight: 600; border: 1px solid var(--cor-branco); margin-left: 15px;
        }
        .btn-secundario:hover { background: var(--cor-branco); color: var(--cor-titulos); transform: translateY(-3px); }

        /* --- SECÇÃO CREDIBILIDADE --- */
        .credibilidade { padding: 100px 5%; text-align: center; background: var(--cor-fundo); }
        .titulo-seccao { font-family: var(--fonte-titulos); font-size: 42px; color: var(--cor-titulos); margin-bottom: 15px; }
        .subtitulo-seccao { font-size: 16px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 60px; font-weight: 500; display: block; }
        
        .grid-cred { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .card-cred { background: var(--cor-branco); padding: 50px 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: var(--transicao); border-bottom: 3px solid transparent; }
        .card-cred:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-bottom-color: var(--cor-dourado); }
        .card-cred i { font-size: 45px; margin-bottom: 20px; display: block; font-style: normal; }
        .card-cred h3 { font-family: var(--fonte-titulos); font-size: 24px; color: var(--cor-titulos); margin-bottom: 15px; }

        /* --- TEASER: A NOSSA ESSÊNCIA --- */
        .teaser-essencia { display: flex; align-items: center; max-width: 1200px; margin: 0 auto; padding: 100px 5%; gap: 60px; }
        .teaser-img-container { flex: 1; position: relative; }
        .teaser-img-container::before { content: ''; position: absolute; top: -20px; left: -20px; width: 100%; height: 100%; border: 2px solid var(--cor-dourado); border-radius: 8px; z-index: -1; }
        .teaser-img-container .zoom-img-wrapper { border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
        .teaser-img-container .zoom-img { width: 100%; }

        .teaser-texto { flex: 1; }
        .teaser-texto h2 { font-family: var(--fonte-titulos); font-size: 42px; color: var(--cor-titulos); margin-bottom: 20px; line-height: 1.2; }
        .teaser-texto p { font-size: 17px; margin-bottom: 30px; text-align: justify; }
        .link-dourado { color: var(--cor-dourado); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 14px; position: relative; transition: var(--transicao); }
        .link-dourado::after { content: '→'; position: absolute; right: -20px; transition: var(--transicao); }
        .link-dourado:hover::after { right: -25px; }

        /* --- DESTAQUES (Mini-Loja) --- */
        .produtos-destaque { padding: 100px 5%; background-color: var(--cor-branco); text-align: center; }
        .grid-produtos { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; max-width: 1200px; margin: 0 auto 50px auto; }
        .produto-card { text-align: center; transition: var(--transicao); padding: 20px; border-radius: 12px; border: 1px solid transparent; cursor: pointer; }
        .produto-card:hover { border-color: #eee; box-shadow: 0 15px 35px rgba(0,0,0,0.04); transform: translateY(-5px); }
        .produto-img-wrapper { background: #fdfaf3; padding: 40px; border-radius: 10px; margin-bottom: 20px; transition: var(--transicao); position: relative; }
        .badge-bestseller { position: absolute; top: 15px; left: 15px; background: var(--cor-titulos); color: var(--cor-branco); font-size: 10px; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 20px; }
        .produto-img-wrapper img { width: 100%; max-width: 160px; height: 160px; object-fit: contain; transition: var(--transicao); mix-blend-mode: multiply; }
        .produto-card:hover img { transform: scale(1.1); }
        .produto-categoria { font-size: 11px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; display: block; font-weight: 600; }
        .produto-nome { font-family: var(--fonte-titulos); font-size: 22px; color: var(--cor-titulos); margin-bottom: 10px; }
        .produto-preco { font-size: 18px; font-weight: 600; color: var(--cor-titulos); }

        /* --- TESTEMUNHOS --- */
        .testemunhos { padding: 100px 5%; background: var(--cor-fundo); text-align: center; }
        .grid-testemunhos { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; max-width: 1200px; margin: 0 auto; }
        .card-testemunho { background: var(--cor-branco); padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); text-align: left; position: relative; }
        .card-testemunho::before { content: '"'; font-family: var(--fonte-titulos); font-size: 80px; color: rgba(203, 160, 82, 0.1); position: absolute; top: 10px; left: 20px; line-height: 1; }
        .estrelas { color: var(--cor-dourado); margin-bottom: 15px; font-size: 18px; }
        .texto-testemunho { font-size: 16px; font-style: italic; margin-bottom: 20px; color: #666; position: relative; z-index: 2; }
        .autor-testemunho { font-family: var(--fonte-titulos); font-size: 18px; color: var(--cor-titulos); font-weight: 600; }
        .autor-tag { font-size: 13px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 1px; }

        /* --- CTA BANNER (CLUBE) --- */
        .cta-clube {
            margin: 0 auto 100px auto; max-width: 1200px; border-radius: 16px;
            background: linear-gradient(rgba(203, 160, 82, 0.9), rgba(203, 160, 82, 0.9)), url('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3') center/cover;
            padding: 80px 50px; text-align: center; color: var(--cor-branco); box-shadow: 0 20px 40px rgba(203, 160, 82, 0.2);
        }
        .cta-clube h2 { font-family: var(--fonte-titulos); font-size: 42px; margin-bottom: 15px; }
        .cta-clube p { font-size: 18px; max-width: 600px; margin: 0 auto 30px auto; }
        .cta-clube .btn-principal { background: var(--cor-titulos); border-color: var(--cor-titulos); }
        .cta-clube .btn-principal:hover { background: var(--cor-branco); color: var(--cor-titulos); border-color: var(--cor-branco); }

        /* --- FOOTER SIMPLES --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 80px 5% 40px; text-align: center; }
        .footer-logo { margin-bottom: 20px; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin: 0 auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- RESPONSIVIDADE --- */
        @media (max-width: 992px) {
            header, header.scrolled { padding: 15px 20px; }
            .menu-toggle { display: flex; }
            .nav-links { 
                position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; 
                background: var(--cor-branco); flex-direction: column; justify-content: center; 
                box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1050; padding: 40px;
            }
            .nav-links.active { right: 0; }
            header:not(.scrolled) .nav-links.active a { color: var(--cor-titulos) !important; }
            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; color: var(--cor-titulos) !important; }
            .icon-conta-desktop { display: none; }
            .grid-produtos { grid-template-columns: repeat(2, 1fr); }
            .teaser-essencia { flex-direction: column; text-align: center; }
            .teaser-img-container::before { display: none; }
        }
        @media (max-width: 768px) {
            .hero { height: auto; min-height: 100vh; padding-top: 130px; padding-bottom: 60px; align-items: flex-start; }
            .hero h1 { font-size: 42px; margin-bottom: 20px; }
            .hero-tag { font-size: 11px; letter-spacing: 2px; }
            .btn-principal, .btn-secundario { display: block; width: 100%; text-align: center; }
            .btn-secundario { margin-left: 0; margin-top: 15px; }
            .grid-testemunhos { grid-template-columns: 1fr; }
            .grid-produtos { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="intro-activa">

    <div id="intro-overlay" aria-hidden="true">
        <video id="intro-video" autoplay muted playsinline>
            <source src="img/intro-index.mp4" type="video/mp4">
        </video>
    </div>

    <header id="navbar">
        <a href="index.php" class="logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="logo-img">
        </a>
        <nav class="nav-links" id="mobileNav">
            <a href="index.php" style="color: var(--cor-dourado) !important;">Início</a>
            <a href="loja.php">Loja</a>
            <a href="sobre_nos.php">A Nossa Essência</a>
            <a href="blog.php">Revista</a>
            <a href="contactos.php">Contactos</a>
            <a href="login.php" class="nav-item-mobile">👤 A Minha Conta</a>
        </nav>
        <div class="icones-nav">
            <a href="login.php" class="icon-conta-desktop">👤 Conta</a>
            <a href="carrinho.php" style="margin-left: 15px;">🛒 (<span id="contador-header">0</span>)</a>
            <div class="menu-toggle" id="menuBtn" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-conteudo">
            <div class="mask-wrapper anim-trigger">
                <span class="hero-tag mask-text">A sua saúde no estado puro</span>
            </div>
            <div class="mask-wrapper anim-trigger">
                <h1 class="mask-text delay-1">A sabedoria milenar,</h1>
            </div>
            <div class="mask-wrapper anim-trigger" style="margin-top: -30px; margin-bottom: 30px;">
                <h1 class="mask-text delay-2">com a ciência de hoje.</h1>
            </div>
            <div class="mask-wrapper anim-trigger">
                <p class="mask-text delay-3">Fórmulas de Medicina Tradicional Chinesa e suplementação natural de excelência. Projetadas para recuperar, nutrir e otimizar o seu corpo.</p>
            </div>
            <div class="mask-wrapper anim-trigger">
                <div class="mask-text delay-4" style="padding-top: 10px;">
                    <a href="loja.php" class="btn-principal">Explorar Loja</a>
                    <a href="subscricao.php" class="btn-secundario">Ver Planos</a>
                </div>
            </div>
        </div>
    </section>

    <section class="credibilidade anim-trigger">
        <div class="mask-wrapper" style="display: flex; justify-content: center;">
            <span class="subtitulo-seccao mask-text">O Nosso Padrão</span>
        </div>
        <div class="mask-wrapper" style="display: flex; justify-content: center;">
            <h2 class="titulo-seccao mask-text delay-1">Rigor Científico & Qualidade Europeia</h2>
        </div>
        <div class="grid-cred" style="margin-top: 50px;">
            <div class="card-cred fade-element delay-1">
                <i>🌿</i>
                <h3>100% Naturais</h3>
                <p>Extratos puros e isentos de químicos nocivos para máxima absorção e tolerância pelo seu organismo.</p>
            </div>
            <div class="card-cred fade-element delay-2">
                <i>🔬</i>
                <h3>Rigor Clínico</h3>
                <p>Lotes analisados em laboratórios independentes para garantir a concentração dos princípios ativos.</p>
            </div>
            <div class="card-cred fade-element delay-3">
                <i>🇪🇺</i>
                <h3>Qualidade EU</h3>
                <p>Produzidos sob as mais rígidas e exigentes normas de fabrico da União Europeia.</p>
            </div>
            <div class="card-cred fade-element delay-4">
                <i>☯️</i>
                <h3>Sabedoria MTC</h3>
                <p>Unimos a eficácia comprovada da Medicina Chinesa milenar com a precisão tecnológica atual.</p>
            </div>
        </div>
    </section>

    <section class="teaser-essencia anim-trigger">
        <div class="teaser-img-container">
            <div class="zoom-img-wrapper">
                <img src="img/foto-card-index.png" alt="Medicina Chinesa" class="zoom-img">
            </div>
        </div>
        <div class="teaser-texto">
            <div class="mask-wrapper">
                <span class="subtitulo-seccao mask-text" style="margin-bottom: 15px;">A Nossa História</span>
            </div>
            <div class="mask-wrapper">
                <h2 class="mask-text delay-1">O equilíbrio perfeito para o seu corpo.</h2>
            </div>
            <div class="mask-wrapper">
                <p class="mask-text delay-2">A AcuSport nasceu de uma inquietação profunda: porque é que a suplementação moderna ignora o equilíbrio interno do organismo? Mergulhámos nos princípios milenares da MTC para criar fórmulas que tratam a origem do desgaste, e não apenas os sintomas.</p>
            </div>
            <div class="mask-wrapper">
                <div class="mask-text delay-3">
                    <a href="sobre_nos.php" class="link-dourado">Conhecer a Nossa Essência</a>
                </div>
            </div>
        </div>
    </section>

    <section class="produtos-destaque anim-trigger">
        <div class="mask-wrapper" style="display: flex; justify-content: center;">
            <span class="subtitulo-seccao mask-text">Para Si</span>
        </div>
        <div class="mask-wrapper" style="display: flex; justify-content: center; margin-bottom: 50px;">
            <h2 class="titulo-seccao mask-text delay-1">Fórmulas em Destaque</h2>
        </div>
        <div class="grid-produtos">
            <div class="produto-card fade-element delay-1" onclick="window.location.href='loja.php'">
                <div class="produto-img-wrapper">
                    <span class="badge-bestseller">Top Vendas</span>
                    <img src="https://acusport.pt/wp-content/uploads/2020/11/3@3x-8-600x600.png" alt="Ponderalfit 1">
                </div>
                <span class="produto-categoria">Emagrecimento</span>
                <h3 class="produto-nome">Ponderalfit 1</h3>
                <div class="produto-preco">25.00 €</div>
            </div>
            <div class="produto-card fade-element delay-2" onclick="window.location.href='loja.php'">
                <div class="produto-img-wrapper">
                    <img src="https://acusport.pt/wp-content/uploads/2020/11/4@3x-8-600x600.png" alt="Ponderalfit 2">
                </div>
                <span class="produto-categoria">Emagrecimento</span>
                <h3 class="produto-nome">Ponderalfit 2</h3>
                <div class="produto-preco">23.00 €</div>
            </div>
            <div class="produto-card fade-element delay-3" onclick="window.location.href='loja.php'">
                <div class="produto-img-wrapper">
                    <img src="https://acusport.pt/wp-content/uploads/2020/11/1@3x-8-600x600.png" alt="Neuro Mais">
                </div>
                <span class="produto-categoria">Cérebro</span>
                <h3 class="produto-nome">Neuro Mais</h3>
                <div class="produto-preco">29.66 €</div>
            </div>
            <div class="produto-card fade-element delay-4" onclick="window.location.href='loja.php'">
                <div class="produto-img-wrapper">
                    <img src="https://acusport.pt/wp-content/uploads/2020/11/2@3x-8-600x600.png" alt="Flexicalcium">
                </div>
                <span class="produto-categoria">Sistema Nervoso</span>
                <h3 class="produto-nome">Flexicalcium</h3>
                <div class="produto-preco">29.66 €</div>
            </div>
        </div>
        <div class="fade-element delay-3" style="margin-top: 50px;">
            <a href="loja.php" class="btn-principal" style="background: var(--cor-titulos); border-color: var(--cor-titulos);">Ver Catálogo Completo</a>
        </div>
    </section>

    <section class="testemunhos anim-trigger">
        <div class="mask-wrapper" style="display: flex; justify-content: center;">
            <span class="subtitulo-seccao mask-text">Comunidade</span>
        </div>
        <div class="mask-wrapper" style="display: flex; justify-content: center; margin-bottom: 50px;">
            <h2 class="titulo-seccao mask-text delay-1">O que dizem os nossos atletas</h2>
        </div>
        <div class="grid-testemunhos">
            <div class="card-testemunho fade-element delay-1">
                <div class="estrelas">★★★★★</div>
                <p class="texto-testemunho">"A dor lombar acompanhava-me em todos os treinos pesados. A fórmula F-25B mudou completamente a minha recuperação. Sinto-me limpo e sem a dependência de anti-inflamatórios de farmácia."</p>
                <h4 class="autor-testemunho">Miguel R.</h4>
                <span class="autor-tag">Atleta de Crossfit</span>
            </div>
            <div class="card-testemunho fade-element delay-2">
                <div class="estrelas">★★★★★</div>
                <p class="texto-testemunho">"Sou assinante do plano Vitalidade. Receber as fórmulas em casa todos os meses sem me preocupar é fantástico. O foco que o Neuro Mais me dá no trabalho é inexplicável."</p>
                <h4 class="autor-testemunho">Sofia T.</h4>
                <span class="autor-tag">Empreendedora</span>
            </div>
            <div class="card-testemunho fade-element delay-3">
                <div class="estrelas">★★★★★</div>
                <p class="texto-testemunho">"Finalmente uma marca que entende que a nutrição vai além da proteína. A abordagem da AcuSport à Medicina Tradicional Chinesa elevou o meu rendimento nas maratonas."</p>
                <h4 class="autor-testemunho">João P.</h4>
                <span class="autor-tag">Maratonista</span>
            </div>
        </div>
    </section>

    <section class="cta-clube anim-trigger">
        <div class="fade-element">
            <h2>Junte-se ao Clube VIP</h2>
            <p>Subscreva os nossos planos mensais e receba as fórmulas em casa com portes grátis, descontos exclusivos e acompanhamento.</p>
            <a href="subscricao.php" class="btn-principal">Descobrir Vantagens</a>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo">
        </div>
        <p class="footer-texto">A sabedoria milenar, com a ciência de hoje. Excelência em Medicina Tradicional Chinesa e Suplementação.</p>
        <div class="footer-links">
            <a href="politica_de_privacidade.php">Privacidade</a>
            <a href="termos_e_condições.php">Termos e Condições</a>
            <a href="contactos.php">Apoio ao Cliente</a>
        </div>
    </footer>

    <script>
        (function() {
            const overlay   = document.getElementById('intro-overlay');
            const video     = document.getElementById('intro-video');
            const CHAVE_SS  = 'acusport_intro_visto';

            function fecharIntro() {
                overlay.style.opacity = '0';
                setTimeout(() => {
                    overlay.style.display = 'none';
                    document.body.classList.remove('intro-activa');
                    sessionStorage.setItem(CHAVE_SS, '1');
                    const hero = document.querySelector('.hero');
                    if (hero) hero.classList.add('in-view');
                }, 800);
            }

            if (sessionStorage.getItem(CHAVE_SS)) {
                overlay.style.display = 'none';
                document.body.classList.remove('intro-activa');
            } else {
                if (video) {
                    video.addEventListener('error', function() {
                        fecharIntro();
                    });

                    video.play().catch(function(error) {
                        fecharIntro();
                    });
                    
                    video.onended = fecharIntro;
                    setTimeout(fecharIntro, 6000);
                } else {
                    fecharIntro();
                }
            }
        })();

        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        function toggleMenu() { 
            document.getElementById('mobileNav').classList.toggle('active'); 
        }

        document.addEventListener('DOMContentLoaded', function() {
            // --- Atualização do Carrinho ---
            const carrinhoAtual = JSON.parse(localStorage.getItem('acusport_carrinho')) || [];
            const totalItens = carrinhoAtual.reduce((acc, item) => acc + item.qtd, 0);
            const contadorHeader = document.getElementById('contador-header');
            if(contadorHeader) contadorHeader.innerText = totalItens;
            // -------------------------------

            const observerOptions = { threshold: 0.2 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        entry.target.querySelectorAll('.fade-element').forEach(el => el.classList.add('in-view'));
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.anim-trigger').forEach(el => observer.observe(el));
            
            if (sessionStorage.getItem('acusport_intro_visto')) {
                setTimeout(() => {
                    const hero = document.querySelector('.hero');
                    if (hero) hero.classList.add('in-view');
                }, 50);
            }
        });

        window.addEventListener('click', function(e) {
            const nav = document.getElementById('mobileNav');
            const btn = document.getElementById('menuBtn');
            if (nav && btn && nav.classList.contains('active') && !nav.contains(e.target) && !btn.contains(e.target)) {
                nav.classList.remove('active');
            }
        });
    </script>
</body>
</html>