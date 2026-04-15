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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidade | AcuSport</title>
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
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.7; display: flex; flex-direction: column; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- MOTOR DE ANIMAÇÕES --- */
        .fade-element { opacity: 0; transform: translateY(30px); transition: transform 1s cubic-bezier(0.16, 1, 0.3, 1), opacity 1s cubic-bezier(0.16, 1, 0.3, 1); }
        .anim-trigger.in-view .fade-element, .fade-element.in-view { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }

        /* --- HEADER OFICIAL --- */
        header {
            background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 15px 50px; display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 1000; transition: var(--transicao);
        }
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        
        .nav-links { display: flex; gap: 40px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); color: var(--cor-texto); }
        .nav-links a:hover { color: var(--cor-dourado); }
        
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }
        .icones-nav a { transition: var(--transicao); color: var(--cor-texto); }
        .icones-nav a:hover { color: var(--cor-dourado); }

        /* Menu Mobile */
        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); background: var(--cor-titulos); }

        /* --- CONTEÚDO LEGAL PREMIUM --- */
        .cabecalho-pagina { text-align: center; padding: 80px 20px 50px; }
        .cabecalho-pagina h1 { font-family: var(--fonte-titulos); font-size: 48px; color: var(--cor-titulos); margin-bottom: 10px; }
        .cabecalho-pagina p { font-size: 16px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 2px; font-weight: 600; }

        .container-legal {
            max-width: 850px;
            margin: 0 auto 100px auto;
            background: var(--cor-branco);
            padding: 60px 70px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.03);
            border-top: 4px solid var(--cor-dourado);
        }

        .container-legal h2 { 
            font-family: var(--fonte-titulos); 
            font-size: 24px; 
            color: var(--cor-titulos); 
            margin: 50px 0 20px 0; 
            border-bottom: 1px solid #f0f0f0; 
            padding-bottom: 15px; 
        }
        .container-legal h2:first-child { margin-top: 0; }
        .container-legal p { margin-bottom: 18px; font-size: 16px; text-align: justify; color: #666; }
        
        .destaque-info { 
            background: rgba(203, 160, 82, 0.05); 
            padding: 20px 25px; 
            border-left: 4px solid var(--cor-dourado); 
            border-radius: 0 8px 8px 0;
            margin: 30px 0; 
            font-size: 15px;
            color: var(--cor-titulos);
            line-height: 1.8;
        }
        .destaque-info a, p a { color: var(--cor-dourado); font-weight: 600; transition: var(--transicao); }
        .destaque-info a:hover, p a:hover { color: var(--cor-titulos); text-decoration: underline; }
        
        .data-revisao { display: block; margin-top: 50px; font-style: italic; font-size: 14px; color: #888; text-align: right; }

        /* --- FOOTER OFICIAL --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 80px 5% 40px; text-align: center; margin-top: auto; }
        .footer-logo { margin-bottom: 20px; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin: 0 auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- RESPONSIVO --- */
        @media (max-width: 992px) { 
            header { padding: 15px 20px; }
            .menu-toggle { display: flex; }
            .nav-links { 
                position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; 
                background: var(--cor-branco); flex-direction: column; justify-content: center; 
                box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1050; padding: 40px; margin: 0;
            }
            .nav-links.active { right: 0; }
            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; color: var(--cor-titulos) !important; }
            .icon-conta-desktop { display: none; }
        }
        @media (max-width: 768px) {
            .container-legal { padding: 40px 30px; margin: 0 20px 60px 20px; }
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

    <div class="cabecalho-pagina anim-trigger">
        <p class="fade-element">Transparência & Segurança</p>
        <h1 class="fade-element delay-1">Política de Privacidade</h1>
    </div>

    <main class="container-legal anim-trigger">
        
        <div class="fade-element delay-2">
            <p>A presente Política de Privacidade regula o tratamento de dados de carácter pessoal realizado no web site www.acusport.pt.</p>
            <p>Ao aceder e usar este website o utilizador admite ter lido e compreendido os termos e está a concordar com a utilização destes cookies no seu computador ou qualquer outro dispositivo móvel nos termos e para os objetivos abaixo referidos.</p>
            <p>A presente Política de Privacidade pode sofrer modificações sem aviso prévio (verifique a data da última revisão no final do texto).</p>
            <p>O nosso compromisso é proteger a privacidade dos clientes. Por isso, as informações que o utilizador nos confia são utilizadas, exclusivamente, para facilitar a prestação de serviços e personalizar o seu atendimento de forma que seja o mais adequado às suas necessidades.</p>

            <h2>Receção de Informações</h2>
            <p>Os dados pessoais fornecidos pelo utilizador, são importantes para que possamos identificá-lo e oferecer-lhe serviços de elevada qualidade, produtos e informações direcionados às suas características e necessidades. Essas informações são armazenadas na nossa base de dados possibilitando um melhor relacionamento com os nossos utilizadores. As informações permitem-nos somente que o serviço seja o mais adequado, facilitar as suas compras futuras e a sua navegação pelo site.</p>
            <p>Durante a sua navegação pelo site, rececionamos algumas informações sobre a navegação dos nossos utilizadores, como data da visita, endereço IP e tipo de browser.</p>
            <p>Esses dados são importantes para a melhoria das funcionalidades do site e análises estatísticas e que têm como finalidade permitir uma navegação mais segura.</p>
            <p>No processo de compra de qualquer produto, solicitaremos dados pessoais (nome, NIF, endereço, cidade, entre outros) que são necessários para identificarmos o utilizador, as informações para o correto envio e podermos finalizar o seu pedido. Em casos de compras com cartão de crédito, algumas informações poderão ser confirmadas com as entidades administradoras do sistema de cartões. A empresa AcuSport declina qualquer responsabilidade por danos diretos ou indiretos consequentes da utilização desses sites de ligação a sistemas de cartões ou de outros ligados a este.</p>

            <h2>Uso de Informações</h2>
            <p>A AcuSport não divulga ou comercializa os dados pessoais do utilizador. Entendemos que essas informações foram fornecidas por livre e espontânea vontade deste pela confiança na nossa equipa.</p>
            <p>De acordo com a Lei de Proteção de Dados Pessoais, todos os utilizadores têm direito a aceder, atualizar, retificar ou apagar os seus dados pessoais. Sempre que o quiser fazer, por favor contacte-nos.</p>

            <h2>Registo e Consentimento de Receção de Informações Promocionais</h2>
            <p>O registo do e-mail do utilizador será usado para o envio de correspondência com informações, promoções e lançamentos, aceites antecipadamente pelo utilizador. A qualquer momento, o utilizador poderá optar por não receber mais estas informações. Para isso, basta que envie um e-mail para <a href="mailto:geral@acusport.pt">geral@acusport.pt</a>.</p>
            <p>O registo não cria qualquer vínculo contratual com a empresa. Este serve para que o utilizador possa aceder aos nossos serviços especiais e obtenha um tratamento diferenciado de qualidade.</p>

            <h2>Cookies</h2>
            <p>Com o objetivo de prestar um serviço mais personalizado, o site www.acusport.pt utiliza também cookies para recolher e guardar informação. Um “cookie” é um pequeno arquivo de dados que é colocado no computador e que permite armazenar e tratar os dados referentes às transações bem como às datas e percursos anteriores no site. Utilizar a tecnologia “cookies não persistentes” permite registar os seus acessos às páginas do mesmo, e analisar a utilização do site de forma mais precisa.</p>
            <p>A utilização da tecnologia “cookies não persistentes”, não será objeto de qualquer tratamento de informação pessoal identificável, exceto com a sua autorização explícita, pois a utilização destes cookies destina-se apenas a fins estatísticos. Porém, caso pretenda o seu registo no site, os dados pessoais recolhidos serão então tratados exclusivamente para os fins por si autorizados, aquando do referido registo, e nesse caso permite-nos utilizar um “cookie persistente”, de modo a termos acesso aos dados pessoais fornecidos pelo Utilizador.</p>

            <h2>Segurança</h2>
            <p>As suas informações são armazenadas de forma segura, a fim de que sejam mantidas inacessíveis por outras pessoas. Por forma a garantir a privacidade e segurança, o utilizador não divulga a sua senha a terceiros.</p>

            <h2>Modificações ou Atualizações</h2>
            <p>Reservamo-nos no direito de alterar a nossa Política de Privacidade, caso haja necessidade, mas comprometemo-nos a divulgar, neste mesmo espaço, qualquer mudança podendo ser alterada sem aviso prévio.</p>

            <h2>Esclarecimentos</h2>
            <p>Para esclarecimentos adicionais sobre o tratamento dos seus dados, por favor contacte-nos pelo <a href="mailto:geral@acusport.pt">geral@acusport.pt</a>.</p>

            <span class="data-revisao">Última revisão: 26 de Março de 2026</span>
        </div>

    </main>

    <footer>
        <div class="footer-logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo">
        </div>
        <p class="footer-texto">© 2026 AcuSport. Excelência em Medicina Tradicional Chinesa e Suplementação Desportiva.</p>
        <div class="footer-links">
            <a href="politica_de_privacidade.php">Política de Privacidade</a>
            <a href="termos_e_condicoes.php">Termos e Condições</a>
            <a href="contactos.php">Apoio ao Cliente</a>
        </div>
    </footer>

    <script>
        // Lógica do Menu Mobile
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

        // Motor de Animações Corrigido (Evita a caixa branca!)
        document.addEventListener('DOMContentLoaded', function() {
            // Gatilho forçado de segurança: após 200ms anima o texto independentemente do scroll
            setTimeout(() => {
                document.querySelectorAll('.anim-trigger').forEach(el => {
                    el.classList.add('in-view');
                    el.querySelectorAll('.fade-element').forEach(filho => filho.classList.add('in-view'));
                });
            }, 200);

            // O observador continua ativo para as páginas em que o texto está bem lá em baixo
            const observerOptions = { root: null, rootMargin: '0px', threshold: 0.05 };
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        entry.target.querySelectorAll('.fade-element').forEach(el => el.classList.add('in-view'));
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.anim-trigger').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>