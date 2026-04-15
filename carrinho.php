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
    <title>Carrinho de Compras | AcuSport</title>
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
            --transicao: all 0.3s ease;
        }

        /* --- RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; display: flex; flex-direction: column; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- HEADER --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 15px 50px; display: flex; justify-content: space-between; align-items: center;
            background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05);
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

        /* --- ESTILOS DO CARRINHO --- */
        .carrinho-header { text-align: center; padding: 120px 20px 40px; }
        .carrinho-header h1 { font-family: var(--fonte-titulos); font-size: 42px; color: var(--cor-titulos); margin-bottom: 10px; }
        .carrinho-header p { font-size: 16px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 2px; font-weight: 500; }

        .carrinho-container { max-width: 1300px; margin: 0 auto 100px auto; padding: 0 5%; display: flex; gap: 50px; align-items: flex-start; width: 100%; }
        
        .carrinho-itens { flex: 2; }
        .item-card { background: var(--cor-branco); border-radius: 12px; padding: 25px; margin-bottom: 20px; display: flex; align-items: center; gap: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.02); border: 1px solid #eee; position: relative; transition: var(--transicao); }
        .item-card.removido { transform: scale(0.9); opacity: 0; pointer-events: none; }
        
        .item-img { width: 100px; height: 100px; background: #fdfaf3; border-radius: 8px; padding: 10px; display: flex; justify-content: center; align-items: center; overflow: hidden; }
        .item-img img { max-width: 100%; max-height: 100%; object-fit: contain; mix-blend-mode: multiply; }
        
        .item-detalhes { flex-grow: 1; }
        .item-categoria { font-size: 11px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .item-nome { font-family: var(--fonte-titulos); font-size: 22px; color: var(--cor-titulos); margin-bottom: 5px; }
        .item-preco-unitario { font-size: 15px; color: #888; }

        .quantidade-controlo { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; width: max-content; margin-top: 15px; }
        .qtd-btn { background: transparent; border: none; padding: 8px 15px; font-size: 18px; color: var(--cor-titulos); cursor: pointer; transition: var(--transicao); }
        .qtd-btn:hover { background: #f5f5f5; }
        .qtd-input { width: 40px; text-align: center; border: none; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-family: var(--fonte-texto); font-size: 16px; font-weight: 500; color: var(--cor-titulos); outline: none; }
        
        .item-total { font-size: 20px; font-weight: 600; color: var(--cor-titulos); width: 100px; text-align: right; }
        .btn-remover { position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 20px; color: #ccc; cursor: pointer; transition: var(--transicao); }
        .btn-remover:hover { color: #e74c3c; transform: scale(1.1); }

        .carrinho-resumo { flex: 1; background: var(--cor-branco); border-radius: 12px; padding: 40px 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); position: sticky; top: 120px; border-top: 4px solid var(--cor-dourado); }
        .resumo-titulo { font-family: var(--fonte-titulos); font-size: 24px; color: var(--cor-titulos); margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        
        .progresso-portes-container { margin-bottom: 30px; }
        .progresso-texto { font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500; }
        .progresso-texto span { color: var(--cor-dourado); font-weight: 600; }
        .barra-fundo { width: 100%; height: 6px; background: #eee; border-radius: 10px; overflow: hidden; }
        .barra-preenchimento { height: 100%; background: var(--cor-dourado); transition: width 0.5s ease; width: 50%; }

        .linha-resumo { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 15px; color: #666; }
        .linha-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 22px; font-weight: 600; color: var(--cor-titulos); font-family: var(--fonte-titulos); }
        
        .promo-box { display: flex; margin-top: 30px; margin-bottom: 30px; }
        .promo-box input { flex-grow: 1; border: 1px solid #ddd; border-right: none; padding: 12px 15px; border-radius: 4px 0 0 4px; font-family: var(--fonte-texto); outline: none; transition: var(--transicao); }
        .promo-box input:focus { border-color: var(--cor-dourado); }
        .promo-box button { background: var(--cor-titulos); color: var(--cor-branco); border: none; padding: 0 20px; border-radius: 0 4px 4px 0; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: var(--transicao); font-size: 13px; }
        .promo-box button:hover { background: var(--cor-dourado); }

        .btn-checkout { display: block; width: 100%; background: var(--cor-dourado); color: var(--cor-branco); padding: 18px 0; font-size: 15px; text-transform: uppercase; letter-spacing: 2px; border: none; border-radius: 4px; transition: var(--transicao); font-weight: 600; text-align: center; cursor: pointer; }
        .btn-checkout:hover { background: var(--cor-titulos); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(17, 29, 36, 0.15); }

        .pagamento-seguro { text-align: center; margin-top: 20px; font-size: 12px; color: #aaa; display: flex; align-items: center; justify-content: center; gap: 8px; }

        .carrinho-vazio { text-align: center; padding: 60px 20px; background: var(--cor-branco); border-radius: 12px; width: 100%; display: none; }
        .carrinho-vazio h2 { font-family: var(--fonte-titulos); font-size: 28px; color: var(--cor-titulos); margin-bottom: 15px; }
        .carrinho-vazio p { color: #777; margin-bottom: 30px; }
        .carrinho-vazio .btn-checkout { display: inline-block; width: max-content; padding: 15px 40px; }

        /* --- FOOTER SIMPLES --- */
        footer { background: var(--cor-titulos); color: var(--cor-branco); padding: 60px 5%; text-align: center; margin-top: auto; }
        .footer-logo { margin-bottom: 20px; }
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin: 0 auto; } 
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }
        .footer-links { margin-top: 30px; display: flex; justify-content: center; gap: 20px; }
        .footer-links a { color: var(--cor-dourado); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); }
        .footer-links a:hover { color: var(--cor-branco); }

        /* --- RESPONSIVIDADE --- */
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
            
            .carrinho-container { flex-direction: column; } 
            .carrinho-resumo { position: static; width: 100%; } 
        }
        @media (max-width: 600px) { 
            .item-card { flex-direction: column; text-align: center; position: relative; padding-top: 40px; } 
            .item-detalhes { width: 100%; display: flex; flex-direction: column; align-items: center; } 
            .item-total { width: 100%; text-align: center; margin-top: 15px; } 
            .btn-remover { top: 15px; right: 15px; } 
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
            <a href="carrinho.php" style="margin-left: 15px; color: var(--cor-dourado) !important;">🛒 (<span id="contador-header">0</span>)</a>
            <div class="menu-toggle" id="menuBtn" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </header>

    <main>
        <div class="carrinho-header">
            <p>A sua Seleção</p>
            <h1>Carrinho de Compras</h1>
        </div>

        <div class="carrinho-container">
            <div class="carrinho-vazio" id="carrinho-vazio">
                <h2>O seu carrinho está vazio.</h2>
                <p>Descubra as nossas fórmulas e inicie a sua jornada de equilíbrio.</p>
                <a href="loja.php" class="btn-checkout">Explorar Catálogo</a>
            </div>

            <div class="carrinho-itens" id="lista-itens"></div>

            <div class="carrinho-resumo" id="resumo-pedido">
                <h2 class="resumo-titulo">Resumo da Encomenda</h2>
                
                <div class="progresso-portes-container">
                    <div class="progresso-texto" id="texto-portes">Faltam <span>15,00 €</span> para Portes Grátis!</div>
                    <div class="barra-fundo">
                        <div class="barra-preenchimento" id="barra-portes"></div>
                    </div>
                </div>
                
                <div class="linha-resumo"><span>Subtotal</span><span id="valor-subtotal">0,00 €</span></div>
                <div class="linha-resumo"><span>Portes de Envio</span><span id="valor-portes">4,90 €</span></div>
                
                <div class="promo-box">
                    <input type="text" placeholder="Código Promocional">
                    <button onclick="alert('Código inválido ou expirado.')">Aplicar</button>
                </div>
                
                <div class="linha-total"><span>Total</span><span id="valor-total">0,00 €</span></div>
                
                <button class="btn-checkout" onclick="alert('Redirecionar para o Gateway de Pagamento (Stripe/Paypal/Multibanco).')">Finalizar Compra</button>
                <div class="pagamento-seguro">🔒 Pagamento 100% Seguro e Encriptado</div>
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
            <a href="termos_e_condições.php">Termos e Condições</a>
            <a href="contactos.php">Apoio ao Cliente</a>
        </div>
    </footer>

    <script>
        // Lógica do Menu Hambúrguer (Mobile)
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

        // =======================================================
        // LÓGICA DO CARRINHO (Ligado ao localStorage)
        // =======================================================
        
        // Vai buscar os itens ao localStorage. Se não existir, cria um array vazio.
        let itensNoCarrinho = JSON.parse(localStorage.getItem('acusport_carrinho')) || [];

        const limiarPortesGratis = 60.00; 
        const custoPortes = 4.90;

        function atualizarCarrinho() {
            const containerItens = document.getElementById('lista-itens');
            const estadoVazio = document.getElementById('carrinho-vazio');
            const estadoResumo = document.getElementById('resumo-pedido');
            const contadorHeader = document.getElementById('contador-header');
            
            // Grava sempre a situação atual na memória do browser
            localStorage.setItem('acusport_carrinho', JSON.stringify(itensNoCarrinho));

            if (itensNoCarrinho.length === 0) {
                containerItens.style.display = 'none';
                estadoResumo.style.display = 'none';
                estadoVazio.style.display = 'block';
                if(contadorHeader) contadorHeader.textContent = "0";
                return;
            } else {
                containerItens.style.display = 'block';
                estadoResumo.style.display = 'block';
                estadoVazio.style.display = 'none';
            }

            let totalUnidades = 0;
            itensNoCarrinho.forEach(item => totalUnidades += item.qtd);
            if(contadorHeader) contadorHeader.textContent = totalUnidades;

            containerItens.innerHTML = '';
            let subtotal = 0;

            itensNoCarrinho.forEach((item, index) => {
                let totalItem = item.preco * item.qtd;
                subtotal += totalItem;

                const htmlItem = `
                    <div class="item-card" id="item-${index}">
                        <button class="btn-remover" onclick="removerItem(${index})" title="Remover produto">✕</button>
                        <div class="item-img"><img src="${item.img}" alt="${item.nome}"></div>
                        <div class="item-detalhes">
                            <span class="item-categoria">${item.categoria}</span>
                            <h3 class="item-nome">${item.nome}</h3>
                            <div class="item-preco-unitario">${parseFloat(item.preco).toFixed(2)} € / uni</div>
                            <div class="quantidade-controlo">
                                <button class="qtd-btn" onclick="alterarQtd(${index}, -1)">−</button>
                                <input type="text" class="qtd-input" value="${item.qtd}" readonly>
                                <button class="qtd-btn" onclick="alterarQtd(${index}, 1)">+</button>
                            </div>
                        </div>
                        <div class="item-total">${totalItem.toFixed(2)} €</div>
                    </div>
                `;
                containerItens.innerHTML += htmlItem;
            });

            document.getElementById('valor-subtotal').textContent = subtotal.toFixed(2).replace('.', ',') + ' €';

            let portesAtuais = subtotal >= limiarPortesGratis ? 0 : custoPortes;
            document.getElementById('valor-portes').textContent = portesAtuais === 0 ? 'Grátis' : portesAtuais.toFixed(2).replace('.', ',') + ' €';

            let totalFinal = subtotal + portesAtuais;
            document.getElementById('valor-total').textContent = totalFinal.toFixed(2).replace('.', ',') + ' €';

            const barra = document.getElementById('barra-portes');
            const textoPortes = document.getElementById('texto-portes');
            
            let percentagem = (subtotal / limiarPortesGratis) * 100;
            if (percentagem > 100) percentagem = 100;
            barra.style.width = percentagem + '%';

            if (subtotal >= limiarPortesGratis) {
                textoPortes.innerHTML = "🎉 Parabéns! Tem <span>Portes Grátis</span> na sua encomenda.";
                barra.style.background = "#2ecc71"; 
            } else {
                let valorEmFalta = limiarPortesGratis - subtotal;
                textoPortes.innerHTML = `Faltam <span>${valorEmFalta.toFixed(2).replace('.', ',')} €</span> para Portes Grátis!`;
                barra.style.background = "var(--cor-dourado)";
            }
        }

        function alterarQtd(index, mudanca) {
            if (itensNoCarrinho[index].qtd + mudanca > 0) {
                itensNoCarrinho[index].qtd += mudanca;
                atualizarCarrinho();
            }
        }

        function removerItem(index) {
            const card = document.getElementById(`item-${index}`);
            card.classList.add('removido'); 
            setTimeout(() => {
                itensNoCarrinho.splice(index, 1);
                atualizarCarrinho();
            }, 300);
        }

        // Inicia a renderização do carrinho ao carregar a página
        atualizarCarrinho();
    </script>
</body>
</html>