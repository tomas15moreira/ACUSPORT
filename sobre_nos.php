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
    <title>A Nossa Essência | AcuSport</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
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
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.7; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- HEADER --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        header.scrolled { 
            background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 15px 50px; border-bottom: none; 
        }
        
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        header:not(.scrolled) .logo-img { filter: brightness(0) invert(1); }
        header:not(.scrolled) .nav-links a, header:not(.scrolled) .icones-nav { color: var(--cor-branco); }
        header.scrolled .nav-links a, header.scrolled .icones-nav { color: var(--cor-titulos); }

        .nav-links { display: flex; gap: 40px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .nav-links a:hover { color: var(--cor-dourado) !important; }
        
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }
        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); }
        header:not(.scrolled) .menu-toggle span { background: var(--cor-branco); }
        header.scrolled .menu-toggle span { background: var(--cor-titulos); }

        /* --- ANIMAÇÕES --- */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animar { animation: fadeUp 1s ease forwards; opacity: 0; }
        .delay-1 { animation-delay: 0.3s; }
        .delay-2 { animation-delay: 0.6s; }

        /* --- HERO SECTION --- */
        .hero-sobre {
            height: 70vh;
            display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;
            background: linear-gradient(rgba(17, 29, 36, 0.8), rgba(17, 29, 36, 0.9)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            background-attachment: fixed;
            color: var(--cor-branco);
            padding: 0 20px;
        }
        .hero-sobre h1 { font-family: var(--fonte-titulos); font-size: 65px; margin-bottom: 20px; }
        .hero-sobre p { font-size: 20px; font-weight: 300; max-width: 600px; letter-spacing: 1px; color: #ddd; }
        .hero-dourado { color: var(--cor-dourado); font-style: italic; }

        /* --- HISTÓRIA (EDITORIAL) --- */
        .historia {
            display: flex; align-items: center; justify-content: center; gap: 80px;
            padding: 120px 5%; max-width: 1300px; margin: 0 auto;
        }
        .historia-texto { flex: 1; max-width: 500px; }
        .historia-tag { color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 3px; font-weight: 600; font-size: 13px; margin-bottom: 20px; display: block; }
        .historia-texto h2 { font-family: var(--fonte-titulos); font-size: 45px; color: var(--cor-titulos); line-height: 1.2; margin-bottom: 30px; }
        .historia-texto p:first-of-type::first-letter {
            float: left; font-family: var(--fonte-titulos); font-size: 65px; line-height: 50px;
            padding-top: 4px; padding-right: 8px; color: var(--cor-dourado);
        }
        .historia-texto p { font-size: 17px; margin-bottom: 20px; text-align: justify; }

        .historia-img-container { flex: 1; position: relative; }
        .historia-img { width: 100%; border-radius: 5px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); position: relative; z-index: 2; }
        .historia-img-container::after {
            content: ''; position: absolute; top: 40px; right: -40px;
            width: 100%; height: 100%; border: 3px solid var(--cor-dourado); border-radius: 5px; z-index: 1;
        }

        /* --- CITAÇÃO --- */
        .citacao-seccao {
            background-color: var(--cor-titulos); color: var(--cor-branco);
            padding: 100px 20px; text-align: center;
        }
        .citacao-texto {
            font-family: var(--fonte-titulos); font-size: 38px; font-style: italic;
            max-width: 900px; margin: 0 auto; line-height: 1.4; color: #fdfaf3;
        }
        .citacao-autor { margin-top: 30px; font-size: 16px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 2px; }

        /* --- PILARES --- */
        .pilares { padding: 120px 5%; max-width: 1300px; margin: 0 auto; text-align: center; }
        .pilares-header h2 { font-family: var(--fonte-titulos); font-size: 45px; color: var(--cor-titulos); margin-bottom: 15px; }
        .pilares-header p { font-size: 18px; color: #777; margin-bottom: 70px; max-width: 600px; margin-left: auto; margin-right: auto; }

        .pilares-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
        .pilar-card {
            background: var(--cor-branco); padding: 50px 30px; border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: var(--transicao);
            border-top: 4px solid transparent; text-align: left;
        }
        .pilar-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-top-color: var(--cor-dourado); }
        .pilar-numero { font-family: var(--fonte-titulos); font-size: 50px; color: #f0ebd8; font-weight: 700; line-height: 1; margin-bottom: 20px; transition: var(--transicao); }
        .pilar-card:hover .pilar-numero { color: var(--cor-dourado); }
        .pilar-titulo { font-family: var(--fonte-titulos); font-size: 24px; color: var(--cor-titulos); margin-bottom: 15px; }
        .pilar-texto { font-size: 16px; color: #666; }

        /* --- FOOTER SIMPLES (Igual ao Index) --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 80px 5% 40px; text-align: center; }
        .footer-logo { margin-bottom: 20px; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin: 0 auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- RESPONSIVIDADE E MENU MOBILE --- */
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

            .historia { flex-direction: column; text-align: center; gap: 60px; }
            .historia-texto p { text-align: center; }
            .historia-texto p:first-of-type::first-letter { float: none; padding: 0; font-size: inherit; line-height: inherit; color: inherit; }
            .historia-img-container::after { right: 20px; top: 20px; width: 90%; }
            .pilares-grid { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
        }
        
        @media (max-width: 768px) {
            .hero-sobre {
                height: auto; min-height: 70vh; padding-top: 130px; padding-bottom: 60px; justify-content: flex-start;
            }
            .hero-sobre h1 { font-size: 42px; margin-bottom: 20px; }
            .historia-texto h2 { font-size: 36px; }
            .citacao-texto { font-size: 26px; }
        }
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
            <a href="sobre_nos.php" style="color: var(--cor-dourado) !important;">A Nossa Essência</a>
            <a href="blog.php">Revista</a>
            <a href="contactos.php">Contactos</a>
            <a href="login.php" class="nav-item-mobile">👤 A Minha Conta</a>
        </nav>
        <div class="icones-nav">
            <a href="login.php" class="icon-conta-desktop">👤 Conta</a>
            <a href="carrinho.php" style="margin-left: 15px;">🛒 (0)</a>
            <div class="menu-toggle" id="menuBtn" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </header>

    <section class="hero-sobre">
        <h1 class="animar">A Nossa <span class="hero-dourado">Essência</span></h1>
        <p class="animar delay-1">Onde a sabedoria de milénios encontra a precisão do futuro.</p>
    </section>

    <section class="historia">
        <div class="historia-texto animar delay-1">
            <span class="historia-tag">A Nossa Gênese</span>
            <h2>O equilíbrio perfeito para o seu corpo.</h2>
            <p>A AcuSport nasceu de uma inquietação profunda: porque é que a suplementação moderna ignora o equilíbrio interno do organismo? Durante anos, o mercado focou-se apenas em ingredientes isolados, esquecendo a complexidade e a harmonia do corpo humano.</p>
            <p>Foi então que decidimos voltar às raízes. Mergulhámos nos princípios milenares da Medicina Tradicional Chinesa (MTC), um sistema médico com mais de 2500 anos de eficácia comprovada na regulação das energias vitais e na recuperação física.</p>
            <p>Unimos essas fórmulas ancestrais aos mais rigorosos padrões de extração e testagem laboratorial europeia. O resultado? Suplementação de alta performance, 100% natural, desenhada não apenas para atenuar sintomas, mas para tratar a origem do desgaste.</p>
        </div>
        <div class="historia-img-container animar delay-2">
            <img src="https://images.unsplash.com/photo-1617897903246-719242758050?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ingredientes Naturais MTC" class="historia-img">
        </div>
    </section>

    <section class="citacao-seccao">
        <p class="citacao-texto">"Não procuramos atalhos químicos. Acreditamos que a verdadeira vitalidade nasce quando damos ao corpo a pureza exata que ele reconhece e absorve."</p>
        <p class="citacao-autor">— Visão AcuSport</p>
    </section>

    <section class="pilares">
        <div class="pilares-header animar">
            <h2>Os Nossos Pilares</h2>
            <p>O que nos separa do mercado tradicional de suplementos e nos torna na escolha de confiança de quem valoriza a saúde real.</p>
        </div>
        <div class="pilares-grid">
            <div class="pilar-card animar delay-1">
                <div class="pilar-numero">01</div>
                <h3 class="pilar-titulo">Pureza Absoluta</h3>
                <p class="pilar-texto">Rejeitamos químicos, excipientes desnecessários e elementos sintéticos. As nossas fórmulas são compostas apenas pelos extratos de plantas mais puros e concentrados.</p>
            </div>
            <div class="pilar-card animar delay-2">
                <div class="pilar-numero">02</div>
                <h3 class="pilar-titulo">Ciência & Testagem</h3>
                <p class="pilar-texto">A MTC dá-nos a sabedoria, a ciência dá-nos a prova. Todos os lotes são testados em laboratórios independentes para garantir concentrações exatas de princípios ativos.</p>
            </div>
            <div class="pilar-card animar delay-1">
                <div class="pilar-numero">03</div>
                <h3 class="pilar-titulo">Absorção Bio-lógica</h3>
                <p class="pilar-texto">Não importa o que ingere, mas sim o que o seu corpo consegue absorver. Formulamos os nossos produtos para uma biodisponibilidade máxima, respeitando a flora digestiva.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo">
        </div>
        <p class="footer-texto">A sabedoria milenar, com a ciência de hoje. Excelência em Medicina Tradicional Chinesa e Suplementação.</p>
        <div class="footer-links">
            <a href="politica_de_privacidade.php">Privacidade</a>
            <a href="termos-condicoes.php">Termos</a>
            <a href="contactos.php">Apoio ao Cliente</a>
        </div>
    </footer>

    <script>
        // Efeito de Navbar ao fazer Scroll
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        // --- LÓGICA DO MENU HAMBÚRGUER ---
        function toggleMenu() { 
            document.getElementById('mobileNav').classList.toggle('active'); 
        }

        // FECHAR MENU AO CLICAR FORA
        window.addEventListener('click', function(e) {
            const nav = document.getElementById('mobileNav');
            const btn = document.getElementById('menuBtn');
            if (nav && btn && nav.classList.contains('active') && !nav.contains(e.target) && !btn.contains(e.target)) {
                nav.classList.remove('active');
            }
        });

        // Motor de Animações original
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = "1";
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animar').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>