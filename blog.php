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
    <title>Revista AcuSport | Sabedoria & Saúde</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            --transicao-suave: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* --- RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.7; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; } 

        /* --- ANIMAÇÕES MASK --- */
        .mask-wrapper { overflow: hidden; display: block; position: relative; }
        .mask-text { transform: translateY(110%); opacity: 0; transition: var(--transicao-suave); display: block; }
        .in-view .mask-text { transform: translateY(0); opacity: 1; }
        .delay-1 { transition-delay: 0.1s; }

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

        .nav-links { display: flex; gap: 40px; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .nav-links a:hover { color: var(--cor-dourado) !important; }
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }

        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); }
        
        header:not(.scrolled) .menu-toggle span { background: var(--cor-branco); }
        header.scrolled .menu-toggle span { background: var(--cor-titulos); }

        /* --- SECÇÃO HERO --- */
        .blog-hero {
            height: 70vh;
            display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;
            background: linear-gradient(rgba(17, 29, 36, 0.6), rgba(17, 29, 36, 0.8)), url('https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            background-attachment: fixed;
            color: var(--cor-branco);
            padding: 0 20px;
        }
        .blog-hero h1 { font-family: var(--fonte-titulos); font-size: 55px; margin-bottom: 10px; }
        .blog-hero p { font-size: 20px; font-weight: 300; color: #ddd; }

        /* --- FILTROS E ARTIGOS --- */
        .blog-filtros { display: flex; justify-content: center; gap: 30px; margin: 60px 0 50px; flex-wrap: wrap; }
        .filtro-btn {
            background: none; border: none; font-family: var(--fonte-texto); font-size: 14px; text-transform: uppercase;
            letter-spacing: 2px; color: #888; cursor: pointer; padding-bottom: 5px; position: relative; font-weight: 500; transition: var(--transicao);
        }
        .filtro-btn.ativo, .filtro-btn:hover { color: var(--cor-titulos); }
        .filtro-btn::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: var(--cor-dourado); transition: var(--transicao); }
        .filtro-btn.ativo::after, .filtro-btn:hover::after { width: 100%; }

        .container-blog { max-width: 1300px; margin: 0 auto 100px auto; padding: 0 5%; }

        .artigo-destaque {
            display: flex; background: var(--cor-branco); border-radius: 16px; overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.04); margin-bottom: 60px; transition: var(--transicao);
            border: 1px solid #eee;
        }
        .artigo-destaque:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(0,0,0,0.08); }
        .destaque-img { flex: 1.2; overflow: hidden; position: relative; min-height: 400px; }
        .destaque-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
        .artigo-destaque:hover .destaque-img img { transform: scale(1.05); }
        
        .destaque-conteudo { flex: 1; padding: 60px 50px; display: flex; flex-direction: column; justify-content: center; }
        .meta-info { display: flex; align-items: center; gap: 15px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; font-weight: 600; }
        .meta-tag { color: var(--cor-dourado); }
        .meta-tempo { color: #aaa; display: flex; align-items: center; gap: 5px; }
        
        .destaque-conteudo h2 { font-family: var(--fonte-titulos); font-size: 38px; color: var(--cor-titulos); margin-bottom: 20px; line-height: 1.2; }
        .destaque-conteudo p { font-size: 16px; color: #666; margin-bottom: 30px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .btn-ler-mais { font-family: var(--fonte-titulos); font-size: 18px; color: var(--cor-titulos); font-style: italic; display: inline-block; position: relative; align-self: flex-start; }
        .btn-ler-mais::after { content: '→'; position: absolute; right: -25px; transition: var(--transicao); }
        .btn-ler-mais:hover::after { right: -30px; color: var(--cor-dourado); }

        .grelha-artigos { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
        .artigo-card { cursor: pointer; }
        .card-img-wrapper { border-radius: 12px; overflow: hidden; margin-bottom: 25px; position: relative; aspect-ratio: 4/3; }
        .card-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .artigo-card:hover .card-img-wrapper img { transform: scale(1.08); }
        .tag-flutuante { position: absolute; top: 15px; left: 15px; background: var(--cor-branco); padding: 5px 15px; border-radius: 30px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; color: var(--cor-titulos); z-index: 2; }

        .artigo-card h3 { font-family: var(--fonte-titulos); font-size: 24px; color: var(--cor-titulos); line-height: 1.3; margin-bottom: 10px; transition: var(--transicao); }
        .artigo-card:hover h3 { color: var(--cor-dourado); }
        .artigo-card p { font-size: 15px; color: #777; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 15px; font-size: 13px; color: #aaa; }

        /* --- FOOTER SIMPLES --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 80px 5% 40px; text-align: center; }
        .footer-logo { margin-bottom: 20px; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin: 0 auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- RESPONSIVIDADE --- */
        @media (max-width: 992px) {
            header, header.scrolled { padding: 15px 20px; }
            .menu-toggle { display: flex; margin-left: 15px; }
            
            .nav-links { 
                position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; 
                background: var(--cor-branco); flex-direction: column; justify-content: center; 
                box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1050; padding: 40px;
            }
            .nav-links.active { right: 0; }
            header:not(.scrolled) .nav-links.active a { color: var(--cor-titulos); }

            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; }
            .icon-conta-desktop { display: none; }

            .artigo-destaque { flex-direction: column; }
            .destaque-conteudo { padding: 40px 30px; }
            .destaque-conteudo h2 { font-size: 28px; }
        }

        @media (max-width: 768px) {
            .blog-hero h1 { font-size: 40px; }
            .grelha-artigos { grid-template-columns: 1fr; }
            .blog-filtros { gap: 15px; margin: 40px 0 30px; }
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
            <a href="sobre_nos.php">A Nossa Essência</a>
            <a href="blog.php" style="color: var(--cor-dourado) !important;">Revista</a>
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

    <section class="blog-hero" id="hero-trigger">
        <div class="mask-wrapper">
            <h1 class="mask-text">Revista AcuSport</h1>
        </div>
        <div class="mask-wrapper">
            <p class="mask-text delay-1">A ciência da performance, a sabedoria da recuperação.</p>
        </div>
    </section>

    <div class="blog-filtros">
        <button class="filtro-btn ativo">Todos os Artigos</button>
        <button class="filtro-btn">MTC</button>
        <button class="filtro-btn">Desporto & Performance</button>
        <button class="filtro-btn">Nutrição Funcional</button>
        <button class="filtro-btn">Bem-Estar</button>
    </div>

    <main class="container-blog">
        <article class="artigo-destaque">
            <div class="destaque-img">
                <img src="https://images.unsplash.com/photo-1594882645126-14020914d58d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Atleta">
            </div>
            <div class="destaque-conteudo">
                <div class="meta-info">
                    <span class="meta-tag">Desporto & Performance</span>
                    <span class="meta-tempo">⏱ 8 min de leitura</span>
                </div>
                <h2>O Segredo da Medicina Chinesa para a Recuperação Muscular Extrema.</h2>
                <p>Muitos atletas focam-se apenas no pré-treino, esquecendo que o músculo cresce e recupera na fase de descanso. Descubra como as fórmulas milenares aceleram a regeneração celular, limpam o ácido lático e preparam o seu corpo para o próximo desafio sem recorrer a químicos sintéticos.</p>
                <a href="#" class="btn-ler-mais">Ler Artigo Completo</a>
            </div>
        </article>

        <div class="grelha-artigos">
            <article class="artigo-card">
                <div class="card-img-wrapper">
                    <span class="tag-flutuante">MTC</span>
                    <img src="https://images.unsplash.com/photo-1606335543042-57c525922933?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Qi">
                </div>
                <h3>O que é o Qi? Entenda a sua Energia Vital e como a otimizar.</h3>
                <p>Na base de toda a Medicina Tradicional Chinesa está o conceito de Qi. Saiba como identificar bloqueios de energia no seu dia a dia.</p>
                <div class="card-footer"><span>22 Março 2026</span><span>⏱ 5 min</span></div>
            </article>

            <article class="artigo-card">
                <div class="card-img-wrapper">
                    <span class="tag-flutuante">Bem-Estar</span>
                    <img src="https://images.unsplash.com/photo-1511295742362-92c96b124e52?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Insónia">
                </div>
                <h3>5 Fórmulas Naturais para Combater a Insónia e a Ansiedade.</h3>
                <p>O stress moderno destrói a qualidade do sono. Conheça as combinações fitoterápicas que acalmam o sistema nervoso de forma não aditiva.</p>
                <div class="card-footer"><span>18 Março 2026</span><span>⏱ 6 min</span></div>
            </article>

            <article class="artigo-card">
                <div class="card-img-wrapper">
                    <span class="tag-flutuante">Nutrição Funcional</span>
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Nutrição">
                </div>
                <h3>Nutrição Desportiva: Mitos, Verdades e Absorção Celular.</h3>
                <p>Não importa o que ingere, mas sim o que o seu corpo absorve. Desconstruímos os maiores mitos da indústria da suplementação comercial.</p>
                <div class="card-footer"><span>10 Março 2026</span><span>⏱ 7 min</span></div>
            </article>

            <article class="artigo-card">
                <div class="card-img-wrapper">
                    <span class="tag-flutuante">Desporto & Performance</span>
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Lombar">
                </div>
                <h3>Como Tratar a Dor Lombar sem Recorrer a Anti-Inflamatórios.</h3>
                <p>Atletas de força sofrem frequentemente de dores na lombar. Descubra a fórmula F-25 B e a sua ação direta nas articulações e tendões.</p>
                <div class="card-footer"><span>05 Março 2026</span><span>⏱ 4 min</span></div>
            </article>

            <article class="artigo-card">
                <div class="card-img-wrapper">
                    <span class="tag-flutuante">MTC</span>
                    <img src="https://images.unsplash.com/photo-1512069772995-ec65ed45afd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Extratos">
                </div>
                <h3>A Diferença entre Extratos Sintéticos e Plantas Puras.</h3>
                <p>Porque é que a AcuSport recusa ingredientes criados em laboratório em favor de extratos vegetais? A resposta está na biodisponibilidade.</p>
                <div class="card-footer"><span>28 Fevereiro 2026</span><span>⏱ 5 min</span></div>
            </article>

            <article class="artigo-card">
                <div class="card-img-wrapper">
                    <span class="tag-flutuante">Bem-Estar</span>
                    <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Mind">
                </div>
                <h3>A Ligação Cérebro-Intestino: O Foco Nasce no Estômago.</h3>
                <p>Sente névoa mental e quebra de foco a meio do dia? O problema pode não estar no cansaço, mas sim na sua digestão.</p>
                <div class="card-footer"><span>15 Fevereiro 2026</span><span>⏱ 6 min</span></div>
            </article>
        </div>
    </main>

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
        // --- AQUI ESTÁ A ATUALIZAÇÃO DO LOCALSTORAGE PARA O CARRINHO ---
        document.addEventListener('DOMContentLoaded', function() {
            const carrinhoAtual = JSON.parse(localStorage.getItem('acusport_carrinho')) || [];
            const totalItens = carrinhoAtual.reduce((acc, item) => acc + item.qtd, 0);
            const contadorHeader = document.getElementById('contador-header');
            if(contadorHeader) contadorHeader.innerText = totalItens;

            // Trigger das animações
            const hero = document.getElementById('hero-trigger');
            if(hero) setTimeout(() => { hero.classList.add('in-view'); }, 100);
        });

        // Scroll Header 
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        // LÓGICA DO MENU HAMBÚRGUER
        function toggleMenu() { 
            document.getElementById('mobileNav').classList.toggle('active'); 
        }

        // FECHAR MENU AO CLICAR FORA
        window.addEventListener('click', function(e) {
            const nav = document.getElementById('mobileNav');
            const btn = document.getElementById('menuBtn');
            if (nav.classList.contains('active') && !nav.contains(e.target) && !btn.contains(e.target)) {
                nav.classList.remove('active');
            }
        });
    </script>
</body>
</html>