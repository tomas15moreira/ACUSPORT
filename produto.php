<?php 
$user = 'root';
$pass = '';
$dbname = 'acusport_db';

try {
    // Forçamos o charset para não haver problemas de acentos nos textos que vêm da BD
    $dbh = new PDO('mysql:host=localhost;dbname=' . $dbname . ';charset=utf8mb4', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Capturar o nome que vem do link da loja
    $nome_url = isset($_GET['nome']) ? $_GET['nome'] : '';

    // 2. Ir à base de dados buscar as informações desse produto específico
    $stmt = $dbh->prepare("SELECT * FROM produtos WHERE nome = :nome LIMIT 1");
    $stmt->bindParam(':nome', $nome_url);
    $stmt->execute();
    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Se o produto não existir na BD, volta para a loja para não dar erro
    if (!$p) {
        header("Location: loja.php");
        exit();
    }
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
    <title><?php echo htmlspecialchars($p['nome']); ?> | AcuSport MTC</title>
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
            --transicao-suave: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* --- RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; overflow-x: hidden; display: flex; flex-direction: column; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- MOTOR DE ANIMAÇÕES PREMIUM --- */
        .mask-wrapper { overflow: hidden; display: block; position: relative; padding-bottom: 5px; }
        .mask-text { transform: translateY(110%); opacity: 0; transition: var(--transicao-suave); display: block; }
        .anim-trigger.in-view .mask-text { transform: translateY(0); opacity: 1; }
        
        .fade-element { opacity: 0; transform: translateY(30px); transition: var(--transicao-suave); }
        .anim-trigger.in-view .fade-element, .fade-element.in-view { opacity: 1; transform: translateY(0); }

        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }

        /* --- HEADER OFICIAL --- */
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

        .nav-item-mobile { display: none; }
        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; order: 3; margin-left: 15px; }
        .menu-toggle span { width: 22px; height: 2px; border-radius: 2px; transition: var(--transicao); background: var(--cor-titulos); }

        /* --- BREADCRUMBS --- */
        .breadcrumbs { padding: 120px 5% 20px 5%; font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; max-width: 1400px; margin: 0 auto; width: 100%; }
        .breadcrumbs a { color: var(--cor-titulos); font-weight: 500; transition: var(--transicao); }
        .breadcrumbs a:hover { color: var(--cor-dourado); }

        /* --- SECÇÃO DO PRODUTO (SPLIT SCREEN) --- */
        .produto-container { display: flex; max-width: 1400px; margin: 0 auto 100px auto; padding: 0 5%; gap: 60px; align-items: flex-start; width: 100%; }

        /* Lado Esquerdo: Imagem Fixa */
        .produto-galeria { flex: 1; position: sticky; top: 120px; background: var(--cor-branco); border-radius: 16px; padding: 50px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f9f9f9; }
        .produto-galeria img { width: 100%; max-width: 400px; height: auto; mix-blend-mode: multiply; transition: transform 0.6s ease; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.08)); margin: 0 auto; }
        .produto-galeria:hover img { transform: scale(1.05); }

        /* Lado Direito: Informação */
        .produto-info { flex: 1.2; padding-top: 20px; }
        .produto-categoria { color: var(--cor-dourado); font-size: 12px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600; margin-bottom: 15px; display: block; }
        .produto-info h1 { font-family: var(--fonte-titulos); font-size: 52px; color: var(--cor-titulos); line-height: 1.1; margin-bottom: 15px; }
        .produto-preco { font-size: 28px; font-weight: 600; color: var(--cor-titulos); margin-bottom: 30px; font-family: var(--fonte-titulos); transition: var(--transicao); }
        
        .produto-descricao-curta { font-size: 17px; color: #666; margin-bottom: 40px; text-align: justify; }

        /* --- AÇÕES DE COMPRA MELHORADAS --- */
        .acoes-compra { display: flex; gap: 15px; margin-bottom: 40px; align-items: stretch; flex-wrap: wrap; }
        
        .qtd-controlo { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; background: var(--cor-branco); height: 50px; }
        .qtd-btn { background: transparent; border: none; padding: 0 15px; font-size: 20px; color: var(--cor-titulos); cursor: pointer; transition: var(--transicao); height: 100%; }
        .qtd-btn:hover { background: #f5f5f5; }
        .qtd-input { width: 40px; text-align: center; border: none; font-family: var(--fonte-texto); font-size: 16px; font-weight: 600; color: var(--cor-titulos); outline: none; background: transparent; }

        .btn-acao {
            flex-grow: 1; display: flex; align-items: center; justify-content: center; height: 50px;
            font-size: 14px; text-transform: uppercase; letter-spacing: 1px;
            border-radius: 6px; transition: var(--transicao); font-weight: 600; cursor: pointer;
        }
        
        .btn-adicionar { background: transparent; color: var(--cor-dourado); border: 2px solid var(--cor-dourado); }
        .btn-adicionar:hover { background: var(--cor-dourado); color: var(--cor-branco); transform: translateY(-2px); }
        
        .btn-comprar-ja { background: var(--cor-titulos); color: var(--cor-branco); border: 2px solid var(--cor-titulos); }
        .btn-comprar-ja:hover { background: var(--cor-dourado); border-color: var(--cor-dourado); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(203, 160, 82, 0.2); }

        /* Badges de Confiança */
        .trust-badges { display: flex; gap: 30px; margin-bottom: 50px; padding-top: 30px; border-top: 1px solid #eee; flex-wrap: wrap; }
        .badge-item { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--cor-titulos); font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        .badge-item span { font-size: 20px; }

        /* --- ACORDEÃO PREMIUM (Tabs de Informação) --- */
        .acordeao-container { border-top: 1px solid #eee; }
        .acordeao-item { border-bottom: 1px solid #eee; transition: var(--transicao); }
        .acordeao-header { 
            width: 100%; text-align: left; background: transparent; border: none; 
            padding: 25px 0; font-family: var(--fonte-titulos); font-size: 20px; color: var(--cor-titulos); 
            cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: var(--transicao);
        }
        .acordeao-header:hover { color: var(--cor-dourado); }
        .acordeao-icone { font-size: 24px; font-weight: 300; transition: transform 0.4s ease; color: #ccc; }
        
        .acordeao-conteudo { max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .acordeao-inner { padding-bottom: 30px; font-size: 15px; color: #666; text-align: justify; }
        .acordeao-inner ul { padding-left: 20px; margin-top: 15px; }
        .acordeao-inner li { margin-bottom: 10px; list-style-type: disc; color: var(--cor-dourado); }
        .acordeao-inner li span { color: #666; }
        
        /* Classe ativa para o Acordeão */
        .acordeao-item.ativo .acordeao-header { color: var(--cor-dourado); }
        .acordeao-item.ativo .acordeao-conteudo { max-height: 800px; }
        .acordeao-item.ativo .acordeao-icone { transform: rotate(45deg); color: var(--cor-dourado); }

        /* Estilo específico para o item de Restrições */
        .acordeao-restricoes .acordeao-inner { color: #e74c3c; background: rgba(231, 76, 60, 0.03); padding: 20px; border-radius: 8px; margin-bottom: 25px; }
        .acordeao-restricoes li { color: #e74c3c; }
        .acordeao-restricoes li span { color: #c0392b; font-weight: 500; }

        /* --- FOOTER SIMPLES --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 80px 5% 40px; text-align: center; margin-top: auto; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin-bottom: 20px; margin-left: auto; margin-right: auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- SISTEMA DE NOTIFICAÇÃO (TOAST) --- */
        #toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
        .toast {
            background: var(--cor-branco); color: var(--cor-titulos); padding: 16px 25px; border-radius: 8px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1); border-left: 4px solid var(--cor-dourado);
            font-family: var(--fonte-texto); font-weight: 500; font-size: 15px; display: flex; align-items: center; gap: 12px;
            transform: translateX(120%); opacity: 0; transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .toast.mostrar { transform: translateX(0); opacity: 1; }
        .toast-icon { color: var(--cor-dourado); font-size: 18px; font-weight: bold; }

        /* --- RESPONSIVO --- */
        @media (max-width: 1024px) {
            .produto-container { flex-direction: column; gap: 40px; }
            .produto-galeria { position: static; width: 100%; }
        }
        @media (max-width: 992px) {
            header { padding: 15px 20px; }
            .menu-toggle { display: flex; }
            .nav-links { position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: var(--cor-branco); flex-direction: column; justify-content: center; box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1050; padding: 40px; margin: 0;}
            .nav-links.active { right: 0; }
            .nav-item-mobile { display: block; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; color: var(--cor-titulos) !important; }
            .icon-conta-desktop { display: none; }
        }
        @media (max-width: 768px) {
            .breadcrumbs { padding-top: 100px; }
            .produto-info h1 { font-size: 40px; }
            #toast-container { bottom: 20px; right: 20px; left: 20px; }
        }
    </style>
</head>
<body>

    <div id="toast-container"></div>

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
            <a href="carrinho.php" style="margin-left: 15px; color: var(--cor-dourado) !important;">🛒 (<span id="contador-header">0</span>)</a>
            <div class="menu-toggle" id="menuBtn" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </header>

    <main>
        <div class="breadcrumbs anim-trigger">
            <div class="fade-element">
                <a href="index.php">Início</a> / <a href="loja.php">Loja</a> / <a href="#"><?php echo htmlspecialchars($p['categoria']); ?></a> / <span style="color: var(--cor-titulos);"><?php echo htmlspecialchars($p['nome']); ?></span>
            </div>
        </div>

        <section class="produto-container">
            
            <div class="produto-galeria anim-trigger">
                <div class="fade-element delay-1">
                    <img src="<?php echo htmlspecialchars(!empty($p['imagem_url']) ? $p['imagem_url'] : (!empty($p['imagem']) ? $p['imagem'] : 'https://via.placeholder.com/600')); ?>" alt="<?php echo htmlspecialchars($p['nome']); ?>">
                </div>
            </div>

            <div class="produto-info anim-trigger">
                <div class="mask-wrapper">
                    <span class="produto-categoria mask-text"><?php echo htmlspecialchars(str_replace('-', ' ', $p['categoria'])); ?></span>
                </div>
                <div class="mask-wrapper">
                    <h1 class="mask-text delay-1"><?php echo htmlspecialchars($p['nome']); ?></h1>
                </div>
                
                <div class="mask-wrapper">
                    <div class="produto-preco mask-text delay-2" id="preco-display"><?php echo number_format($p['preco'], 2); ?> €</div>
                </div>
                
                <div class="mask-wrapper">
                    <p class="produto-descricao-curta mask-text delay-3">
                        <?php echo htmlspecialchars(!empty($p['descricao']) ? $p['descricao'] : (!empty($p['descricao_curta']) ? $p['descricao_curta'] : '')); ?>
                    </p>
                </div>

                <div class="acoes-compra fade-element delay-4">
                    <div class="qtd-controlo">
                        <button class="qtd-btn" onclick="alterarQtd(-1)">−</button>
                        <input type="text" class="qtd-input" id="qtd-input" value="1" readonly>
                        <button class="qtd-btn" onclick="alterarQtd(1)">+</button>
                    </div>
                    <button class="btn-acao btn-adicionar" onclick="adicionarAoCarrinho()">Adicionar</button>
                    <button class="btn-acao btn-comprar-ja" onclick="comprarJa()">Comprar Já</button>
                </div>

                <div class="trust-badges fade-element delay-4">
                    <div class="badge-item"><span>🌿</span> 100% Natural</div>
                    <div class="badge-item"><span>🔬</span> Rigor Clínico</div>
                    <div class="badge-item"><span>☯️</span> Fórmula MTC</div>
                </div>

                <div class="acordeao-container fade-element delay-4">
                    
                    <div class="acordeao-item">
                        <button class="acordeao-header" onclick="toggleAcordeao(this)">
                            Descrição e Benefícios MTC <span class="acordeao-icone">+</span>
                        </button>
                        <div class="acordeao-conteudo">
                            <div class="acordeao-inner">
                                <?php echo !empty($p['descricao_longa']) ? $p['descricao_longa'] : 'Informação detalhada ainda não inserida pelo terapeuta.'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="acordeao-item">
                        <button class="acordeao-header" onclick="toggleAcordeao(this)">
                            Modo de Utilização & Dosagem <span class="acordeao-icone">+</span>
                        </button>
                        <div class="acordeao-conteudo">
                            <div class="acordeao-inner">
                                <?php echo !empty($p['dosagem']) ? $p['dosagem'] : '<p style="font-weight: 500; color: var(--cor-titulos);">Como tomar:</p><p>Recomenda-se a toma conforme indicação específica do seu terapeuta de Medicina Tradicional Chinesa.</p>'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="acordeao-item acordeao-restricoes">
                        <button class="acordeao-header" onclick="toggleAcordeao(this)">
                            Restrições & Avisos Legais <span class="acordeao-icone">+</span>
                        </button>
                        <div class="acordeao-conteudo">
                            <div class="acordeao-inner">
                                <?php if (!empty($p['restricoes'])): ?>
                                    <?php echo $p['restricoes']; ?>
                                <?php else: ?>
                                    <p style="margin-bottom: 15px; color: var(--cor-titulos); font-weight: 600;">Para sua segurança, leia atentamente as seguintes restrições padrão:</p>
                                    <ul class="lista-restricoes">
                                        <li><span><strong>Dosagem:</strong> Não exceder a toma diária recomendada.</span></li>
                                        <li><span><strong>Substituição:</strong> Os suplementos alimentares não devem ser utilizados como substitutos de um regime alimentar variado e equilibrado.</span></li>
                                        <li><span><strong>Crianças e Grávidas:</strong> Manter fora do alcance das crianças. Não recomendado a grávidas sem aconselhamento clínico.</span></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo">
        </div>
        <p class="footer-texto">© 2026 AcuSport. Excelência em Medicina Tradicional Chinesa e Suplementação Desportiva.</p>
        <div class="footer-links">
            <a href="politica_de_privacidade.php">Privacidade</a>
            <a href="termos_e_condições.php">Termos e Condições</a>
            <a href="contactos.php">Apoio ao Cliente</a>
        </div>
    </footer>

    <script>
        // LÓGICA DA QUANTIDADE E PREÇO DINÂMICO
        let quantidade = 1;
        const precoBase = <?php echo (float)$p['preco']; ?>; 
        const inputQtd = document.getElementById('qtd-input');
        const precoDisplay = document.getElementById('preco-display');
        
        // Atualiza a quantidade visual no header ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            atualizarContadorHeader();
        });

        function atualizarContadorHeader() {
            const carrinhoAtual = JSON.parse(localStorage.getItem('acusport_carrinho')) || [];
            const totalItens = carrinhoAtual.reduce((acc, item) => acc + item.qtd, 0);
            const contadorHeader = document.getElementById('contador-header');
            if(contadorHeader) contadorHeader.innerText = totalItens;
        }
        
        function alterarQtd(mudanca) {
            if (quantidade + mudanca > 0) {
                quantidade += mudanca;
                inputQtd.value = quantidade;
                
                const novoPreco = (precoBase * quantidade).toFixed(2);
                precoDisplay.innerText = novoPreco + ' €';
                
                precoDisplay.style.transform = 'scale(1.05)';
                precoDisplay.style.color = 'var(--cor-dourado)';
                setTimeout(() => {
                    precoDisplay.style.transform = 'scale(1)';
                    precoDisplay.style.color = 'var(--cor-titulos)';
                }, 200);
            }
        }

        // Lógica do Acordeão
        function toggleAcordeao(elemento) {
            const item = elemento.parentElement;
            if (item.classList.contains('ativo')) {
                item.classList.remove('ativo');
            } else {
                item.classList.add('ativo');
            }
        }

        // LÓGICA DE ADICIONAR AO CARRINHO (LocalStorage)
        function adicionarAoCarrinho() {
            const qtdAtual = parseInt(document.getElementById('qtd-input').value);
            
            // Dados do Produto vindos do PHP
            const produto = {
                id: "<?php echo addslashes($p['nome']); ?>", 
                nome: "<?php echo addslashes(htmlspecialchars($p['nome'])); ?>",
                categoria: "<?php echo addslashes(htmlspecialchars(str_replace('-', ' ', $p['categoria']))); ?>",
                preco: precoBase,
                img: "<?php echo addslashes(!empty($p['imagem_url']) ? $p['imagem_url'] : (!empty($p['imagem']) ? $p['imagem'] : 'https://via.placeholder.com/600')); ?>",
                qtd: qtdAtual
            };

            // Vai buscar o carrinho à memória do browser (se estiver vazio, cria uma lista nova)
            let carrinho = JSON.parse(localStorage.getItem('acusport_carrinho')) || [];
            
            // Verifica se o produto já existe no carrinho
            let itemExistente = carrinho.find(item => item.id === produto.id);
            if (itemExistente) {
                itemExistente.qtd += produto.qtd; // Apenas soma a quantidade
            } else {
                carrinho.push(produto); // Adiciona produto novo
            }

            // Grava novamente na memória do browser
            localStorage.setItem('acusport_carrinho', JSON.stringify(carrinho));

            // Feedback Visual (Toast)
            mostrarToast(qtdAtual, produto.nome);
            
            // Atualiza logo a bolinha do header
            atualizarContadorHeader();
        }

        function comprarJa() {
            adicionarAoCarrinho();
            window.location.href = 'carrinho.php';
        }

        function mostrarToast(qtd, nome) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            
            toast.innerHTML = `
                <span class="toast-icon">✓</span>
                <div>
                    <strong>Adicionado!</strong><br>
                    <span style="font-size: 13px; color: #777;">${qtd}x ${nome} no carrinho.</span>
                </div>
            `;
            
            container.appendChild(toast);
            setTimeout(() => { toast.classList.add('mostrar'); }, 10);

            setTimeout(() => {
                toast.classList.remove('mostrar');
                setTimeout(() => toast.remove(), 500); 
            }, 3500);
        }

        // Scroll e Menu Mobile
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        function toggleMenu() { document.getElementById('mobileNav').classList.toggle('active'); }

        window.addEventListener('click', function(e) {
            const nav = document.getElementById('mobileNav');
            const btn = document.getElementById('menuBtn');
            if (nav && btn && nav.classList.contains('active') && !nav.contains(e.target) && !btn.contains(e.target)) {
                nav.classList.remove('active');
            }
        });

        // Motor de Animações
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        entry.target.querySelectorAll('.fade-element').forEach(el => el.classList.add('in-view'));
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.anim-trigger').forEach(el => { observer.observe(el); });
            
            setTimeout(() => {
                document.querySelectorAll('main .anim-trigger').forEach(el => {
                    el.classList.add('in-view');
                    el.querySelectorAll('.fade-element').forEach(filho => filho.classList.add('in-view'));
                });
            }, 50);
        });
    </script>
</body>
</html>