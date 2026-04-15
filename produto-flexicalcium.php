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
    <title>Flexicalcium | Ossos & Articulações MTC | AcuSport</title>
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
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        /* --- MOTOR DE ANIMAÇÕES PREMIUM (MASK REVEAL) --- */
        .mask-wrapper { overflow: hidden; display: block; position: relative; padding-bottom: 5px; }
        .mask-text { transform: translateY(110%); opacity: 0; transition: var(--transicao-suave); display: block; }
        .anim-trigger.in-view .mask-text { transform: translateY(0); opacity: 1; }
        
        .fade-element { opacity: 0; transform: translateY(30px); transition: var(--transicao-suave); }
        .anim-trigger.in-view .fade-element, .fade-element.in-view { opacity: 1; transform: translateY(0); }

        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }

        /* --- HEADER --- */
        header {
            position: fixed; width: 100%; top: 0; z-index: 1000;
            padding: 15px 50px; display: flex; justify-content: space-between; align-items: center;
            transition: var(--transicao); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .logo-img { height: 40px; width: auto; transition: var(--transicao); }
        .nav-links { display: flex; gap: 40px; }
        .nav-links a { font-weight: 500; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transicao); position: relative; }
        .nav-links a:hover { color: var(--cor-dourado); }
        .icones-nav { display: flex; gap: 20px; font-size: 16px; font-weight: 500; align-items: center; }

        /* --- BREADCRUMBS --- */
        .breadcrumbs { padding: 120px 5% 20px 5%; font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; max-width: 1400px; margin: 0 auto; }
        .breadcrumbs a { color: var(--cor-titulos); font-weight: 500; transition: var(--transicao); }
        .breadcrumbs a:hover { color: var(--cor-dourado); }

        /* --- SECÇÃO DO PRODUTO (SPLIT SCREEN) --- */
        .produto-container { display: flex; max-width: 1400px; margin: 0 auto 100px auto; padding: 0 5%; gap: 60px; align-items: flex-start; }

        /* Lado Esquerdo: Imagem Fixa */
        .produto-galeria { flex: 1; position: sticky; top: 120px; background: var(--cor-branco); border-radius: 16px; padding: 50px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f9f9f9; }
        .produto-galeria img { width: 100%; max-width: 400px; height: auto; mix-blend-mode: multiply; transition: transform 0.6s ease; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.08)); }
        .produto-galeria:hover img { transform: scale(1.05); }

        /* Lado Direito: Informação */
        .produto-info { flex: 1.2; padding-top: 20px; }
        .produto-categoria { color: var(--cor-dourado); font-size: 12px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600; margin-bottom: 15px; }
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
        .trust-badges { display: flex; gap: 30px; margin-bottom: 50px; padding-top: 30px; border-top: 1px solid #eee; }
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
        .footer-logo img { height: 50px; filter: brightness(0) invert(1); margin-bottom: 20px; } 
        .footer-texto { opacity: 0.7; font-size: 14px; margin-top: 20px; max-width: 400px; margin: 0 auto; }

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
        @media (max-width: 768px) {
            .breadcrumbs { padding-top: 100px; }
            .produto-info h1 { font-size: 40px; }
            .trust-badges { flex-wrap: wrap; gap: 15px; }
            #toast-container { bottom: 20px; right: 20px; left: 20px; }
        }
    </style>
</head>
<body>

    <div id="toast-container"></div>

    <header id="navbar">
        <a href="index.html" class="logo">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="logo-img">
        </a>
        <nav class="nav-links">
            <a href="index.html">Início</a>
            <a href="loja.html">Loja</a>
            <a href="sobre-nos.html">A Nossa Essência</a>
        </nav>
        <div class="icones-nav">
            <a href="login.html">👤</a>
            <a href="carrinho.html" style="color: var(--cor-dourado);">🛒 (<span id="contador-header">0</span>)</a>
        </div>
    </header>

    <main>
        <div class="breadcrumbs anim-trigger">
            <div class="fade-element">
                <a href="index.html">Início</a> / <a href="loja.html">Loja</a> / <a href="#">Ossos & Articulações</a> / <span style="color: var(--cor-titulos);">Flexicalcium</span>
            </div>
        </div>

        <section class="produto-container">
            
            <div class="produto-galeria anim-trigger">
                <div class="fade-element delay-1">
                    <img src="https://acusport.pt/wp-content/uploads/2020/11/2@3x-8-600x600.png" alt="Flexicalcium Embalagem | AcuSport MTC">
                </div>
            </div>

            <div class="produto-info anim-trigger">
                <div class="mask-wrapper">
                    <span class="produto-categoria mask-text">Ossos, Articulações, Músculos e Tendões</span>
                </div>
                <div class="mask-wrapper">
                    <h1 class="mask-text delay-1">Flexicalcium</h1>
                </div>
                
                <div class="mask-wrapper">
                    <div class="produto-preco mask-text delay-2" id="preco-display">29.66 €</div>
                </div>
                
                <div class="mask-wrapper">
                    <p class="produto-descricao-curta mask-text delay-3">
                        A base do seu movimento. O <strong>Flexicalcium®</strong> é uma fórmula osteoarticular e tendino-muscular de excelência, desenvolvida segundo os rigorosos princípios da Medicina Tradicional Chinesa. Desenhado para nutrir as articulações, acelerar a recuperação de tendões fadigados e devolver a elasticidade e força natural ao seu corpo.
                    </p>
                </div>

                <div class="acoes-compra fade-element delay-4">
                    <div class="qtd-controlo">
                        <button class="qtd-btn" onclick="alterarQtd(-1)">−</button>
                        <input type="text" class="qtd-input" id="qtd-input" value="1" readonly>
                        <button class="qtd-btn" onclick="alterarQtd(1)">+</button>
                    </div>
                    <button class="btn-acao btn-adicionar" onclick="adicionarAoCarrinho()">Adicionar</button>
                    <button class="btn-acao btn-comprar-ja" onclick="window.location.href='carrinho.html'">Comprar Já</button>
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
                                Na MTC, o fígado nutre os tendões e os rins governam a estrutura óssea. O Flexicalcium® atua exatamente nestes meridianos para garantir um suporte estrutural completo. É a escolha de excelência para atletas sujeitos a alto impacto e pessoas que procuram recuperar a sua mobilidade sem depender de vias químicas sintéticas.
                                <ul>
                                    <li><span><strong>Fortalecimento ósseo</strong> e articular profundo.</span></li>
                                    <li><span>Aceleração da <strong>recuperação tendino-muscular</strong> pós-treino ou desgaste.</span></li>
                                    <li><span>Manutenção da lubrificação e elasticidade natural das articulações.</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="acordeao-item">
                        <button class="acordeao-header" onclick="toggleAcordeao(this)">
                            Modo de Utilização & Dosagem <span class="acordeao-icone">+</span>
                        </button>
                        <div class="acordeao-conteudo">
                            <div class="acordeao-inner">
                                <p style="font-weight: 500; color: var(--cor-titulos);">Como tomar:</p>
                                <p>Recomenda-se a toma conforme indicação específica do seu terapeuta de Medicina Tradicional Chinesa ou profissional de saúde acompanhante. A dosagem correta é vital para a eficácia do tratamento em Fitoterapia.</p>
                                <br>
                                <p style="font-weight: 500; color: var(--cor-titulos);">Conservação:</p>
                                <p>Guardar em local fresco e seco, protegido da luz solar direta e humidade.</p>
                            </div>
                        </div>
                    </div>

                    <div class="acordeao-item acordeao-restricoes">
                        <button class="acordeao-header" onclick="toggleAcordeao(this)">
                            Restrições & Avisos Legais <span class="acordeao-icone">+</span>
                        </button>
                        <div class="acordeao-conteudo">
                            <div class="acordeao-inner">
                                <p style="margin-bottom: 15px; color: var(--cor-titulos); font-weight: 600;">Para sua segurança, leia atentamente as seguintes restrições:</p>
                                <ul class="lista-restricoes">
                                    <li><span><strong>Dosagem:</strong> Não exceder a toma diária recomendada.</span></li>
                                    <li><span><strong>Substituição:</strong> Os suplementos alimentares não devem ser utilizados como substitutos de um regime alimentar variado e equilibrado e de um modo de vida saudável.</span></li>
                                    <li><span><strong>Crianças:</strong> Manter fora do alcance e da visão das crianças.</span></li>
                                    <li><span><strong>Gravidez/Amamentação:</strong> Não recomendado a grávidas ou lactantes sem aconselhamento clínico prévio.</span></li>
                                    <li><span><strong>Alergias:</strong> Verifique os ingredientes para evitar possíveis reações alérgicas.</span></li>
                                </ul>
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
        <p class="footer-texto">© 2026 AcuSport. Excelência em Medicina Tradicional Chinesa e Suplementação.</p>
    </footer>

    <script>
        // LÓGICA DA QUANTIDADE E PREÇO DINÂMICO
        let quantidade = 1;
        const precoBase = 29.66; // Preço original do Flexicalcium
        const inputQtd = document.getElementById('qtd-input');
        const precoDisplay = document.getElementById('preco-display');
        
        function alterarQtd(mudanca) {
            if (quantidade + mudanca > 0) {
                quantidade += mudanca;
                inputQtd.value = quantidade;
                
                // Calcula e atualiza o valor total
                const novoPreco = (precoBase * quantidade).toFixed(2);
                precoDisplay.innerText = novoPreco + ' €';
                
                // Adiciona um pequeno efeito visual de "piscar" ao preço para chamar a atenção
                precoDisplay.style.transform = 'scale(1.05)';
                precoDisplay.style.color = 'var(--cor-dourado)';
                setTimeout(() => {
                    precoDisplay.style.transform = 'scale(1)';
                    precoDisplay.style.color = 'var(--cor-titulos)';
                }, 200);
            }
        }

        // Lógica do Acordeão (Tabs)
        function toggleAcordeao(elemento) {
            const item = elemento.parentElement;
            if (item.classList.contains('ativo')) {
                item.classList.remove('ativo');
            } else {
                item.classList.add('ativo');
            }
        }

        // Lógica da Notificação Toast
        function adicionarAoCarrinho() {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            
            const qtdAtual = document.getElementById('qtd-input').value;
            
            toast.innerHTML = `
                <span class="toast-icon">✓</span>
                <div>
                    <strong>Adicionado!</strong><br>
                    <span style="font-size: 13px; color: #777;">${qtdAtual}x Flexicalcium no carrinho.</span>
                </div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('mostrar');
            }, 10);

            const contadorHeader = document.getElementById('contador-header');
            contadorHeader.innerText = parseInt(contadorHeader.innerText) + parseInt(qtdAtual);

            setTimeout(() => {
                toast.classList.remove('mostrar');
                setTimeout(() => toast.remove(), 500); 
            }, 3500);
        }

        // Motor de Animações ao Fazer Scroll
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