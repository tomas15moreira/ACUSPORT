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
    <title>Planos de Subscrição | AcuSport</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* --- VARIÁVEIS GLOBAIS --- */
        :root {
            --cor-fundo: #fdfaf3;
            --cor-texto: #555555;
            --cor-titulos: #111d24;
            --cor-dourado: #cba052;
            --cor-branco: #ffffff;
            --fonte-titulos: 'Playfair Display', serif;
            --fonte-texto: 'Jost', sans-serif;
            --transicao: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* --- RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; display: flex; flex-direction: column; min-height: 100vh; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- HEADER --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        header.scrolled { padding: 15px 50px; }
        
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        
        .nav-links { display: flex; gap: 40px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); color: var(--cor-titulos); }
        .nav-links a:hover { color: var(--cor-dourado) !important; }
        
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; color: var(--cor-titulos); }
        .icones-nav a { transition: var(--transicao); }
        .icones-nav a:hover { color: var(--cor-dourado) !important; }

        /* Menu Mobile */
        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); background: var(--cor-titulos); }

        /* --- ESTILOS DA PÁGINA --- */
        .cabecalho-subscricao { text-align: center; padding: 150px 20px 60px; background: var(--cor-fundo); }
        .cabecalho-subscricao h1 { font-family: var(--fonte-titulos); font-size: 45px; color: var(--cor-titulos); margin-bottom: 15px; }
        .cabecalho-subscricao p { font-size: 18px; color: #666; max-width: 600px; margin: 0 auto; }
        
        .planos-container { max-width: 1200px; margin: 0 auto 100px auto; padding: 0 5%; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
        .plano-card { background: var(--cor-branco); border-radius: 12px; padding: 50px 40px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #eee; transition: var(--transicao); position: relative; overflow: hidden; }
        .plano-card:hover { transform: translateY(-10px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); border-color: var(--cor-dourado); }
        
        .plano-destaque { border: 2px solid var(--cor-dourado); }
        .badge-popular { position: absolute; top: 25px; right: -40px; background: var(--cor-dourado); color: var(--cor-branco); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; padding: 8px 45px; transform: rotate(45deg); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        .plano-nome { font-family: var(--fonte-titulos); font-size: 26px; color: var(--cor-titulos); margin-bottom: 15px; }
        .plano-preco { font-size: 45px; font-weight: 700; color: var(--cor-titulos); margin-bottom: 20px; font-family: var(--fonte-titulos); }
        .plano-preco span { font-size: 16px; color: #888; font-weight: 400; font-family: var(--fonte-texto); }
        .plano-desc { font-size: 15px; color: #777; margin-bottom: 30px; line-height: 1.5; }
        
        .plano-lista { text-align: left; margin-bottom: 40px; }
        .plano-lista li { margin-bottom: 15px; font-size: 15px; color: #555; display: flex; align-items: center; gap: 12px; }
        .plano-lista li::before { content: '✓'; color: var(--cor-dourado); font-weight: bold; font-size: 18px; }
        
        .btn-plano { display: block; width: 100%; background: var(--cor-titulos); color: var(--cor-branco); padding: 16px 0; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; border: none; border-radius: 6px; transition: var(--transicao); font-weight: 600; cursor: pointer; }
        .btn-plano:hover { background: var(--cor-dourado); transform: translateY(-3px); box-shadow: 0 5px 15px rgba(203, 160, 82, 0.2); }
        
        .plano-destaque .btn-plano { background: var(--cor-dourado); }
        .plano-destaque .btn-plano:hover { background: var(--cor-titulos); box-shadow: 0 5px 15px rgba(17, 29, 36, 0.2); }

        /* --- FOOTER SIMPLES --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 60px 5%; text-align: center; margin-top: auto; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin-bottom: 20px; margin-left: auto; margin-right: auto; }
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- RESPONSIVIDADE --- */
        @media (max-width: 992px) {
            header { padding: 15px 20px; }
            .menu-toggle { display: flex; }
            .nav-links { position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: var(--cor-branco); flex-direction: column; justify-content: center; box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1050; padding: 40px; }
            .nav-links.active { right: 0; }
            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; color: var(--cor-titulos) !important; }
            .icon-conta-desktop { display: none; }
        }
        @media (max-width: 768px) { .cabecalho-subscricao { padding-top: 100px; } }
    </style>
</head>
<body>

    <header id="navbar">
        <a href="index.php" class="logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="logo-img">
        </a>
        <nav class="nav-links" id="mobileNav">
            <a href="index.php">Início</a>
            <a href="loja.php">Loja</a>
            <a href="sobre_nos.php">A Nossa Essência</a>
            <a href="blog.php">Revista</a>
            <a href="contactos.php">Contactos</a>
            <a href="login.php" class="nav-item-mobile">👤 A Minha Conta</a>
        </nav>
        <div class="icones-nav">
            <a href="login.php" class="icon-conta-desktop">👤 Conta</a>
            <a href="carrinho.php">🛒 (0)</a>
            <div class="menu-toggle" id="menuBtn" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </header>

    <main>
        <div class="cabecalho-subscricao">
            <h1>Clube AcuSport</h1>
            <p>Escolha o plano ideal para a sua jornada de equilíbrio e receba as nossas fórmulas com vantagens exclusivas diretamente em sua casa.</p>
        </div>

        <div class="planos-container">
            <div class="plano-card">
                <h2 class="plano-nome">Essência</h2>
                <div class="plano-preco">29€<span> /mês</span></div>
                <p class="plano-desc">Perfeito para quem está a dar os primeiros passos na Medicina Tradicional Chinesa.</p>
                <ul class="plano-lista">
                    <li>1 Fórmula à escolha por mês</li>
                    <li>Portes de envio gratuitos</li>
                    <li>Acesso à newsletter premium</li>
                </ul>
                <button class="btn-plano" onclick="window.location.href='registo.php'">Subscrever</button>
            </div>

            <div class="plano-card plano-destaque">
                <div class="badge-popular">Popular</div>
                <h2 class="plano-nome">Vitalidade</h2>
                <div class="plano-preco">49€<span> /mês</span></div>
                <p class="plano-desc">Desenhado para atletas e utilizadores regulares focados na performance máxima.</p>
                <ul class="plano-lista">
                    <li>2 Fórmulas à escolha por mês</li>
                    <li>Portes de envio gratuitos</li>
                    <li>Acesso antecipado a novidades</li>
                    <li>15% desconto em compras extra</li>
                </ul>
                <button class="btn-plano" onclick="window.location.href='registo.php'">Subscrever</button>
            </div>

            <div class="plano-card">
                <h2 class="plano-nome">Mestre</h2>
                <div class="plano-preco">89€<span> /mês</span></div>
                <p class="plano-desc">A experiência completa e personalizada para um acompanhamento e bem-estar total.</p>
                <ul class="plano-lista">
                    <li>4 Fórmulas à escolha por mês</li>
                    <li>Portes de envio gratuitos</li>
                    <li>Consulta online de aconselhamento</li>
                    <li>25% desconto em compras extra</li>
                </ul>
                <button class="btn-plano" onclick="window.location.href='registo.php'">Subscrever</button>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo">
        </div>
        <p class="footer-texto">© 2026 AcuSport. Excelência em Medicina Tradicional Chinesa e Suplementação Desportiva.</p>
        <div class="footer-links">
            <a href="politica_de_privacidade.php">Privacidade</a>
            <a href="termos_e_condicoes.php">Termos</a>
            <a href="contactos.php">Apoio ao Cliente</a>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        function toggleMenu() { 
            document.getElementById('mobileNav').classList.toggle('active'); 
        }

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