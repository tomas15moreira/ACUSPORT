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
    <title>Contactos | AcuSport</title>
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
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.7; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- HEADER DINÂMICO --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        header.scrolled { 
            background: rgba(255, 255, 255, 0.98); 
            backdrop-filter: blur(10px); 
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
            padding: 15px 50px; 
            border-bottom: none; 
        }
        
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        header:not(.scrolled) .logo-img { filter: brightness(0) invert(1); }
        header:not(.scrolled) .nav-links a, header:not(.scrolled) .icones-nav { color: var(--cor-branco); }
        header.scrolled .nav-links a, header.scrolled .icones-nav { color: var(--cor-titulos); }

        .nav-links { display: flex; gap: 40px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .nav-links a:hover { color: var(--cor-dourado) !important; }
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }

        /* Menu Mobile */
        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); }
        
        header:not(.scrolled) .menu-toggle span { background: var(--cor-branco); }
        header.scrolled .menu-toggle span { background: var(--cor-titulos); }

        /* --- CABEÇALHO DA PÁGINA --- */
        .cabecalho-pagina { text-align: center; padding: 180px 20px 60px; background-color: var(--cor-titulos); color: var(--cor-branco); }
        .cabecalho-pagina h1 { font-family: var(--fonte-titulos); font-size: 50px; margin-bottom: 10px; }
        .cabecalho-pagina p { font-size: 16px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 3px; font-weight: 500; }

        /* --- SECÇÃO CONTACTOS --- */
        .container-contactos {
            max-width: 1200px; margin: -60px auto 100px auto; padding: 0 5%;
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px;
            position: relative; z-index: 10;
        }

        /* Informações e Mapa */
        .info-bloco { background: var(--cor-branco); padding: 50px 40px; border-radius: 12px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); }
        .info-bloco h2 { font-family: var(--fonte-titulos); font-size: 32px; color: var(--cor-titulos); margin-bottom: 35px; }
        
        .info-item { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 30px; }
        .info-icone { font-size: 24px; color: var(--cor-dourado); line-height: 1; }
        .info-texto h3 { font-family: var(--fonte-titulos); font-size: 20px; color: var(--cor-titulos); margin-bottom: 5px; }
        .info-texto p { font-size: 15px; color: #666; }
        
        .mapa-container { width: 100%; height: 280px; border-radius: 8px; overflow: hidden; margin-top: 40px; }
        .mapa-container iframe { width: 100%; height: 100%; border: none; filter: grayscale(100%); transition: var(--transicao); opacity: 0.8; }
        .mapa-container iframe:hover { filter: grayscale(0%); opacity: 1; }

        /* Formulário */
        .form-bloco { background: var(--cor-branco); padding: 50px 40px; border-radius: 12px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); }
        .form-bloco h2 { font-family: var(--fonte-titulos); font-size: 32px; color: var(--cor-titulos); margin-bottom: 10px; }
        .form-bloco > p { font-size: 15px; color: #777; margin-bottom: 40px; }

        .input-grupo { position: relative; margin-bottom: 35px; }
        .input-grupo input, .input-grupo textarea {
            width: 100%; background: transparent; border: none; border-bottom: 1px solid #eee;
            padding: 12px 0; font-family: var(--fonte-texto); font-size: 16px; color: var(--cor-titulos);
            outline: none; transition: var(--transicao);
        }
        .input-grupo textarea { resize: vertical; min-height: 120px; }
        
        .input-grupo label {
            position: absolute; left: 0; top: 12px; color: #bbb; font-size: 16px;
            pointer-events: none; transition: var(--transicao);
        }
        .input-grupo input:focus, .input-grupo textarea:focus { border-bottom-color: var(--cor-dourado); }
        
        .input-grupo input:focus ~ label, .input-grupo input:valid ~ label,
        .input-grupo textarea:focus ~ label, .input-grupo textarea:valid ~ label {
            top: -20px; font-size: 12px; color: var(--cor-dourado); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
        }

        .btn-enviar {
            display: inline-block; width: 100%; background: var(--cor-titulos); color: var(--cor-branco);
            padding: 18px 40px; font-size: 14px; text-transform: uppercase; letter-spacing: 2px;
            border: none; border-radius: 4px; transition: var(--transicao); font-weight: 600; cursor: pointer; margin-top: 10px;
        }
        .btn-enviar:hover { background: var(--cor-dourado); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(203, 160, 82, 0.2); }

        /* --- FOOTER --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 80px 5% 40px; text-align: center; border-top: 1px solid rgba(255,255,255,0.05); }
        .footer-logo { margin-bottom: 20px; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin: 0 auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; max-width: 400px; margin: 0 auto; }
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

            .container-contactos { grid-template-columns: 1fr; margin-top: 20px; gap: 40px; }
            .cabecalho-pagina { padding: 150px 20px 100px; }
        }
        @media (max-width: 768px) {
            .cabecalho-pagina h1 { font-size: 38px; }
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
            <a href="blog.php">Revista</a>
            <a href="contactos.php" style="color: var(--cor-dourado) !important;">Contactos</a>
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

    <div class="cabecalho-pagina">
        <p>Apoio Personalizado</p>
        <h1>Fale Connosco</h1>
    </div>

    <main class="container-contactos">
        
        <div class="info-bloco">
            <h2>Canais Diretos</h2>
            
            <div class="info-item">
                <div class="info-icone">📍</div>
                <div class="info-texto">
                    <h3>Sede & Expedição</h3>
                    <p>Rua da Portela nº 10<br>3370-073 Friúmes, Penacova<br>Portugal</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icone">✉️</div>
                <div class="info-texto">
                    <h3>E-mail</h3>
                    <p><a href="mailto:geral@acusport.pt">geral@acusport.pt</a></p>
                    <p style="font-size: 13px; margin-top: 5px; color: #999;">Resposta média em menos de 24h.</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icone">📞</div>
                <div class="info-texto">
                    <h3>Atendimento Telefónico</h3>
                    <p>+351 900 000 000</p>
                    <p style="font-size: 13px; margin-top: 5px; color: #999;">Dias úteis das 09h às 18h.</p>
                </div>
            </div>

            <div class="mapa-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3043.614605151522!2d-8.2140889!3d40.2842427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22f18f971c261b%3A0x8670155b1f464010!2sFri%C3%BAmes!5e0!3m2!1spt-PT!2spt!4v1700000000000!5m2!1spt-PT!2spt" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="form-bloco">
            <h2>Mensagem Privada</h2>
            <p>Dúvidas sobre fórmulas ou aconselhamento técnico? Escreva-nos e um especialista entrará em contacto.</p>
            
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Mensagem enviada com sucesso!');">
                
                <div class="input-grupo">
                    <input type="text" id="nome" required>
                    <label for="nome">Nome Completo</label>
                </div>

                <div class="input-grupo">
                    <input type="email" id="email" required>
                    <label for="email">Endereço de E-mail</label>
                </div>

                <div class="input-grupo">
                    <input type="text" id="assunto" required>
                    <label for="assunto">Assunto</label>
                </div>

                <div class="input-grupo">
                    <textarea id="mensagem" required></textarea>
                    <label for="mensagem">Como podemos ajudar?</label>
                </div>

                <button type="submit" class="btn-enviar">Enviar Mensagem</button>
            </form>
        </div>

    </main>

    <footer>
        <div class="footer-logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo">
        </div>
        <p class="footer-texto">Excelência em Medicina Tradicional Chinesa e Suplementação Desportiva. © 2026 AcuSport.</p>
        <div class="footer-links">
            <a href="politica_de_privacidade.php">Privacidade</a>
            <a href="termos-condicoes.php">Termos</a>
            <a href="index.php">Início</a>
        </div>
    </footer>

    <script>
        // --- AQUI ESTÁ A ATUALIZAÇÃO DO LOCALSTORAGE PARA O CARRINHO ---
        document.addEventListener('DOMContentLoaded', function() {
            const carrinhoAtual = JSON.parse(localStorage.getItem('acusport_carrinho')) || [];
            const totalItens = carrinhoAtual.reduce((acc, item) => acc + item.qtd, 0);
            const contadorHeader = document.getElementById('contador-header');
            if(contadorHeader) contadorHeader.innerText = totalItens;
        });

        // Efeito de Navbar ao fazer Scroll
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
            if (nav && btn && nav.classList.contains('active') && !nav.contains(e.target) && !btn.contains(e.target)) {
                nav.classList.remove('active');
            }
        });
    </script>
</body>
</html>