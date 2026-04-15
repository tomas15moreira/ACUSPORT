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
    <title>Criar Conta | AcuSport</title>
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

        /* --- RESET BÁSICO --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; height: auto; display: block; } 

        /* --- NAVEGAÇÃO (HEADER) --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        header.scrolled { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 15px 50px; border-bottom: none; }
        
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        header:not(.scrolled) .logo-img { filter: brightness(0) invert(1); }
        
        .nav-links { display: flex; gap: 40px; margin-left: auto; padding-right: 20px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); color: var(--cor-dourado); }
        header.scrolled .nav-links a { color: var(--cor-titulos); }
        .nav-links a:hover, header:not(.scrolled) .nav-links a:hover { color: var(--cor-branco) !important; }
        header.scrolled .nav-links a:hover { color: var(--cor-dourado) !important; }
        
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }

        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); }
        header:not(.scrolled) .menu-toggle span { background: var(--cor-dourado); }
        header.scrolled .menu-toggle span { background: var(--cor-titulos); }

        /* --- LAYOUT REGISTO --- */
        .auth-container { display: flex; width: 100%; height: 100%; margin-top: 0; }

        .auth-img {
            flex: 1; position: relative;
            background: linear-gradient(rgba(17, 29, 36, 0.4), rgba(17, 29, 36, 0.7)), url('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3') center/cover;
            display: flex; flex-direction: column; justify-content: flex-end; padding: 50px; color: var(--cor-branco);
        }
        
        .auth-quote { max-width: 400px; margin-bottom: 50px; }
        .auth-quote h2 { font-family: var(--fonte-titulos); font-size: 36px; margin-bottom: 15px; line-height: 1.2; }
        .auth-quote p { font-size: 16px; font-weight: 300; opacity: 0.9; }

        .auth-form-wrapper {
            flex: 1; background: var(--cor-branco); display: flex; flex-direction: column;
            justify-content: center; align-items: center; padding: 40px; position: relative; overflow-y: auto;
        }

        .form-box { width: 100%; max-width: 400px; animation: fadeIn 0.6s ease forwards; margin-top: 50px; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header { margin-bottom: 30px; }
        .form-header h1 { font-family: var(--fonte-titulos); font-size: 32px; color: var(--cor-titulos); margin-bottom: 10px; }
        .form-header p { font-size: 15px; color: #777; }

        .input-grupo { position: relative; margin-bottom: 25px; }
        .input-grupo input {
            width: 100%; background: transparent; border: none; border-bottom: 1px solid #ddd;
            padding: 10px 0; font-family: var(--fonte-texto); font-size: 16px; color: var(--cor-titulos);
            outline: none; transition: var(--transicao);
        }
        .input-grupo label {
            position: absolute; left: 0; top: 10px; color: #999; font-size: 15px;
            pointer-events: none; transition: var(--transicao);
        }
        .input-grupo input:focus { border-bottom-color: var(--cor-dourado); }
        .input-grupo input:focus ~ label, .input-grupo input:valid ~ label {
            top: -15px; font-size: 11px; color: var(--cor-dourado); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
        }

        .btn-auth {
            display: block; width: 100%; background: var(--cor-titulos); color: var(--cor-branco);
            padding: 16px 0; font-size: 15px; text-transform: uppercase; letter-spacing: 2px;
            border: none; border-radius: 4px; transition: var(--transicao); font-weight: 500; cursor: pointer; text-align: center; margin-bottom: 20px;
        }
        .btn-auth:hover { background: var(--cor-dourado); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(203, 160, 82, 0.2); }

        .link-alternativo { text-align: center; font-size: 14px; color: #666; }
        .link-alternativo a { color: var(--cor-dourado); font-weight: 600; transition: var(--transicao); }
        .link-alternativo a:hover { color: var(--cor-titulos); text-decoration: underline; }
        
        .nota-legal { font-size: 12px; color: #aaa; text-align: center; margin-bottom: 20px; }
        .nota-legal a { color: var(--cor-dourado); }

        /* --- RESPONSIVIDADE & MENU MOBILE --- */
        @media (max-width: 992px) {
            header, header.scrolled { padding: 15px 20px; background: rgba(255, 255, 255, 0.98); border-bottom: none; }
            header:not(.scrolled) .logo-img { filter: none; } 
            
            .menu-toggle { display: flex; margin-left: auto; }
            .nav-links { 
                position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; 
                background: var(--cor-branco); flex-direction: column; justify-content: center; 
                box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1050; padding: 40px; margin: 0;
            }
            .nav-links.active { right: 0; }
            
            header:not(.scrolled) .nav-links.active a { color: var(--cor-titulos) !important; }
            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; color: var(--cor-titulos) !important; }
        }

        @media (max-width: 900px) {
            .auth-img { display: none; }
            body { overflow: auto; }
            .auth-form-wrapper { padding-top: 100px; justify-content: flex-start; }
            .form-box { margin-top: 0; }
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
            <a href="contactos.php">Contactos</a>
            <a href="login.php" class="nav-item-mobile">Iniciar Sessão</a>
        </nav>
        
        <div class="icones-nav">
            <div class="menu-toggle" id="menuBtn" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </header>

    <div class="auth-container">
        <div class="auth-img">
            <div class="auth-quote">
                <h2>Comece a sua jornada.</h2>
                <p>Junte-se à nossa comunidade e descubra o verdadeiro potencial da Medicina Tradicional Chinesa.</p>
            </div>
        </div>

        <div class="auth-form-wrapper">
            <div class="form-box">
                <div class="form-header">
                    <h1>Criar Conta</h1>
                    <p>Preencha os seus dados para se juntar à AcuSport.</p>
                </div>

                <form action="#" onsubmit="event.preventDefault(); alert('Conta criada! Bem-vindo à AcuSport.');">
                    <div class="input-grupo">
                        <input type="text" id="nome-registo" required>
                        <label for="nome-registo">Nome Completo</label>
                    </div>
                    <div class="input-grupo">
                        <input type="email" id="email-registo" required>
                        <label for="email-registo">E-mail</label>
                    </div>
                    <div class="input-grupo">
                        <input type="password" id="pass-registo" required>
                        <label for="pass-registo">Palavra-passe</label>
                    </div>
                    <div class="input-grupo">
                        <input type="password" id="pass-confirma" required>
                        <label for="pass-confirma">Confirmar Palavra-passe</label>
                    </div>
                    
                    <p class="nota-legal">Ao registar-se, concorda com os nossos <a href="termos_e_condicoes.php">Termos e Condições</a>.</p>
                    
                    <button type="submit" class="btn-auth">Registar Conta</button>
                    
                    <p class="link-alternativo">Já tem uma conta? <a href="login.php">Inicie sessão aqui</a>.</p>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
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