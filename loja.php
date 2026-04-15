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
    <title>Catálogo de Fórmulas | AcuSport</title>
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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- HEADER ALINHADO COM INDEX --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); 
            background: rgba(255, 255, 255, 0.98); 
            backdrop-filter: blur(10px); 
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
        }
        header.scrolled { padding: 15px 50px; } /* Animação de scroll suave */
        
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        
        .nav-links { display: flex; gap: 40px; transition: 0.3s ease; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); color: var(--cor-titulos); }
        .nav-links a:hover { color: var(--cor-dourado) !important; }
        
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; color: var(--cor-titulos); }
        .icones-nav a { transition: var(--transicao); }
        .icones-nav a:hover { color: var(--cor-dourado) !important; }

        /* Estilos do Menu Mobile e Ícones */
        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); background: var(--cor-titulos); }

        /* --- ESTRUTURA DA PÁGINA --- */
        /* Margem de 120px no topo para compensar o header fixo */
        .loja-container { display: flex; max-width: 1400px; margin: 120px auto 40px auto; padding: 0 5%; gap: 50px; align-items: flex-start; }

        /* --- BARRA LATERAL --- */
        .loja-sidebar { width: 260px; flex-shrink: 0; background: var(--cor-branco); padding: 40px 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); position: sticky; top: 120px; }
        .sidebar-titulo { font-family: var(--fonte-titulos); font-size: 22px; color: var(--cor-titulos); margin-bottom: 25px; }
        .categoria-lista li { margin-bottom: 12px; }
        .categoria-lista a { font-size: 15px; color: #666; transition: var(--transicao); display: block; padding: 5px 0; }
        .categoria-lista a:hover, .categoria-lista a.ativo { color: var(--cor-titulos); font-weight: 600; padding-left: 10px; border-left: 3px solid var(--cor-dourado); }
        
        .filtro-preco { margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px; }
        .slider { -webkit-appearance: none; width: 100%; height: 4px; background: #eee; border-radius: 2px; outline: none; margin-bottom: 20px; }
        .slider::-webkit-slider-thumb { -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%; background: var(--cor-dourado); cursor: pointer; }

        /* --- ÁREA PRINCIPAL --- */
        .loja-conteudo { flex-grow: 1; width: 100%; }
        .ferramentas-loja { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px; flex-wrap: wrap; gap: 20px; }
        .ferramentas-titulo h1 { font-family: var(--fonte-titulos); font-size: 36px; color: var(--cor-titulos); line-height: 1; margin-bottom: 5px; }
        .grelha-produtos { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 30px; }
        
        @keyframes fadeUpCascata { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .produto-card { background: var(--cor-branco); padding: 30px 20px; border-radius: 12px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.02); opacity: 0; animation: fadeUpCascata 0.6s ease forwards; border: 1px solid #f9f9f9; }
        .produto-img-wrapper { height: 180px; margin-bottom: 20px; overflow: hidden; }
        .produto-img { width: 100%; height: 100%; object-fit: contain; mix-blend-mode: multiply; transition: transform 0.6s ease; }
        .produto-card:hover .produto-img { transform: scale(1.08); }

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
            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; color: var(--cor-titulos) !important; }
            .icon-conta-desktop { display: none; }

            .loja-container { flex-direction: column; margin-top: 100px; }
            .loja-sidebar { width: 100%; position: relative; top: 0; margin-bottom: 30px; box-shadow: none; border: 1px solid #eee; }
        }

        @media (max-width: 600px) {
            .grelha-produtos { grid-template-columns: 1fr; }
            .ferramentas-loja { flex-direction: column; align-items: flex-start; }
            .ferramentas-titulo h1 { font-size: 28px; }
        }

        #btnAdminConfig { position: fixed; bottom: 20px; left: 20px; width: 40px; height: 40px; background: transparent; color: var(--cor-titulos); display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 9999; opacity: 0.05; border: none; }
    </style>
</head>
<body>

    <header id="navbar">
        <a href="index.php" class="logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="logo-img">
        </a>
        <nav class="nav-links" id="mobileNav">
            <a href="index.php">Início</a>
            <a href="loja.php" style="color: var(--cor-dourado) !important;">Loja</a>
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

    <div class="loja-container">
        <aside class="loja-sidebar">
            <div class="categorias-bloco">
                <h2 class="sidebar-titulo">Categorias</h2>
                <ul class="categoria-lista">
                    <li><a href="#" class="ativo" data-cat="todos">Todas as Fórmulas</a></li>
                    <li><a href="#" data-cat="sistema-nervoso">Sistema nervoso</a></li>
                    <li><a href="#" data-cat="cerebro">Cérebro</a></li>
                    <li><a href="#" data-cat="emagrecimento">Emagrecimento</a></li>
                    <li><a href="#" data-cat="fitoterapia">Fitoterapia</a></li>
                    <li><a href="#" data-cat="fadiga">Fadiga</a></li>
                    <li><a href="#" data-cat="dor-lombar">Dor Lombar</a></li>
                    <li><a href="#" data-cat="hemorragias">Hemorragias</a></li>
                    <li><a href="#" data-cat="circulacao-sanguinea">Circulação Sanguínea</a></li>
                    <li><a href="#" data-cat="dores-articulares">Dores Articulares</a></li>
                    <li><a href="#" data-cat="asma">Asma</a></li>
                    <li><a href="#" data-cat="insonias">Insónias</a></li>
                </ul>
            </div>
            <div class="filtro-preco">
                <h2 class="sidebar-titulo" style="font-size: 18px;">Preço Máximo</h2>
                <input type="range" min="10" max="85" value="85" class="slider" id="filtroPreco">
                <div class="preco-labels"><span>10 €</span><span id="precoAtual">85 €</span></div>
            </div>
        </aside>

        <main class="loja-conteudo">
            <div class="ferramentas-loja">
                <div class="ferramentas-titulo">
                    <h1 id="tituloCategoria">Catálogo Completo</h1>
                    <span id="contadorProdutos">A carregar...</span>
                </div>
                <div class="barra-pesquisa"><input type="text" id="inputPesquisa" placeholder="Procurar fórmula..." style="padding:10px; border-radius:6px; border:1px solid #ddd;"></div>
            </div>
            <div class="grelha-produtos" id="grelhaProdutos"></div>
        </main>
    </div>

    <div id="btnAdminConfig" onclick="abrirModalLogin()"><span>⚙️</span></div>

    <div id="modalLoginAdmin" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 10000;">
        <div style="background: #fff; padding: 40px; border-radius: 12px; width: 90%; max-width: 380px; position: relative;">
            <span onclick="fecharModalLogin()" style="position: absolute; top: 15px; right: 20px; cursor: pointer;">&times;</span>
            <h2 style="font-family: var(--fonte-titulos);">Admin</h2>
            <form id="formLoginAdmin">
                <input type="text" id="adminUser" placeholder="Utilizador" required style="width:100%; margin-bottom:15px; padding:12px; border:1px solid #ddd; border-radius:6px;">
                <input type="password" id="adminPass" placeholder="Senha" required style="width:100%; margin-bottom:15px; padding:12px; border:1px solid #ddd; border-radius:6px;">
                <button type="submit" style="width:100%; padding:12px; background:#cba052; color:#fff; border:none; border-radius:6px; cursor: pointer;">Entrar</button>
            </form>
            <div id="loginErro" style="color:red; display:none; margin-top:15px; text-align:center;">Dados incorretos.</div>
        </div>
    </div>

    <script>
        const catalogo = [
            { nome: "Flexicalcium", categoria: "sistema-nervoso", preco: 30, img: "https://acusport.pt/wp-content/uploads/2020/11/2@3x-8-600x600.png" },
            { nome: "Neuro Mais", categoria: "cerebro", preco: 30, img: "https://acusport.pt/wp-content/uploads/2020/11/1@3x-8-600x600.png" },
            { nome: "Ponderal Fit 1", categoria: "emagrecimento", preco: 25, img: "https://acusport.pt/wp-content/uploads/2020/11/3@3x-8-600x600.png" },
            { nome: "Ponderal Fit 2", categoria: "emagrecimento", preco: 23, img: "https://acusport.pt/wp-content/uploads/2020/11/4@3x-8-600x600.png" },
            { nome: "F-44 Gui Zhi Tang", categoria: "fitoterapia", preco: 28.79, img: "https://nutribio.pt/wp-content/uploads/2026/01/FI01GT44-F44-Gui-Zhi-Tang-100ml-TCM20Formula-Nutribio.webp" },
            { nome: "F-47 Bai Hu Tang", categoria: "fitoterapia", preco: 28.79, img: "https://nutribio.pt/wp-content/uploads/2026/01/FI01GT47-F47-Bai-Hu-Tang-100ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-1 Si Jun Zi Tang", categoria: "fitoterapia", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/F1SIJUNZITANG-F-1-Si-Jun-Zi-Tang-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-34 A Yin Yang", categoria: "fadiga", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/FI01GT34A-F-34-A-Yin-Yang-Xue-Qi-Da-Bu-Tang-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-34 B Yin Yang", categoria: "fadiga", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/F34B-F34B-Yin-Yang-Bu-Ji-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-25 B Fang Tang", categoria: "dor-lombar", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/FI.01.GT_.25B-F25-B-Shen-Yang-Xu-Yao-Tang-Fang-Tang-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-41 B", categoria: "hemorragias", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2026/01/FI01GT41B-F-41B-Yu-Nu-Jian-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-54", categoria: "hemorragias", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2026/01/FI01GT54-F-54-Huai-Hua-San-Jia-Jian-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-134 A", categoria: "circulacao-sanguinea", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2026/01/FI01GT134A-F-134-A-Xue-Mai-Tong-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-39 B", categoria: "dores-articulares", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/56379-F39-B-Shi-Wei-Bai-Du-Tang-Jia-Jian-100-ml-TCM-Formula-Nutribio.webp" },
            { nome: "F-33 B", categoria: "asma", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/FI01GT33B-F33B-Ding-Chuan-Tang-Jia-Jian-100-ml-TCM-Formula-Nutribio-1.webp" },
            { nome: "F-31 B", categoria: "insonias", preco: 25.50, img: "https://nutribio.pt/wp-content/uploads/2025/06/FI01GT31B-F31B-Zhen-Gan-Xi-feng-Tang-100-ml-TCM-Formula-Nutribio.webp" }
        ];

        function renderizarProdutos(produtos) {
            const grelha = document.getElementById('grelhaProdutos');
            grelha.innerHTML = ""; 
            produtos.forEach((p, i) => {
                grelha.innerHTML += `
                    <div class="produto-card" style="animation-delay: ${i * 0.05}s">
                        <div class="produto-img-wrapper"><img src="${p.img}" class="produto-img"></div>
                        <span style="font-size:11px; color:#cba052; text-transform:uppercase; font-weight:600;">${p.categoria.replace('-', ' ')}</span>
                        <h3 style="font-family: var(--fonte-titulos); font-size: 18px; margin: 10px 0;">${p.nome}</h3>
                        <div style="font-weight:600; margin-bottom:15px;">${p.preco.toFixed(2)} €</div>
                        <button onclick="window.location.href='produto.php?nome=${encodeURIComponent(p.nome)}'" style="width:100%; padding:10px; background:none; border:1px solid #111d24; cursor:pointer; text-transform:uppercase; font-size:12px;">Ver Produto</button>
                    </div>`;
            });
            document.getElementById('contadorProdutos').textContent = `${produtos.length} fórmula(s)`;
        }

        // --- LÓGICA DO MENU HAMBÚRGUER ---
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

        // SCROLL DO HEADER
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        const sliderPreco = document.getElementById('filtroPreco');
        sliderPreco.addEventListener('input', function() {
            document.getElementById('precoAtual').textContent = this.value + " €";
            motorDeFiltros();
        });

        document.getElementById('inputPesquisa').addEventListener('input', motorDeFiltros);

        document.querySelectorAll('.categoria-lista a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.categoria-lista a').forEach(l => l.classList.remove('ativo'));
                this.classList.add('ativo');
                document.getElementById('tituloCategoria').textContent = this.textContent;
                motorDeFiltros();
            });
        });

        function motorDeFiltros() {
            const termo = document.getElementById('inputPesquisa').value.toLowerCase();
            const precoMax = parseInt(sliderPreco.value);
            const catAtiva = document.querySelector('.categoria-lista a.ativo').getAttribute('data-cat');
            
            const filtrados = catalogo.filter(p => {
                const matchCat = catAtiva === "todos" || p.categoria === catAtiva;
                const matchPreco = p.preco <= precoMax;
                const matchBusca = p.nome.toLowerCase().includes(termo);
                return matchCat && matchPreco && matchBusca;
            });
            renderizarProdutos(filtrados);
        }

        function abrirModalLogin() { document.getElementById('modalLoginAdmin').style.display = 'flex'; }
        function fecharModalLogin() { document.getElementById('modalLoginAdmin').style.display = 'none'; }
        
        document.getElementById('formLoginAdmin').addEventListener('submit', function(e) {
            e.preventDefault();
            if (document.getElementById('adminUser').value === 'admin' && document.getElementById('adminPass').value === 'acusport2026') {
                window.location.href = 'admin.php';
            } else { document.getElementById('loginErro').style.display = 'block'; }
        });

        renderizarProdutos(catalogo);
    </script>
</body>
</html>