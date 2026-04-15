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
    <title>Finalizar Compra | AcuSport</title>
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
        body { font-family: var(--fonte-texto); color: var(--cor-texto); background-color: var(--cor-fundo); line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        /* --- HEADER SIMPLIFICADO --- */
        header {
            background: var(--cor-branco); box-shadow: 0 2px 20px rgba(0,0,0,0.03);
            padding: 25px 50px; display: flex; justify-content: center; align-items: center;
            position: sticky; top: 0; z-index: 1000;
        }
        .logo-img { height: 42px; width: auto; filter: brightness(0) invert(1); }
        .voltar-link { position: absolute; left: 50px; font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; transition: var(--transicao); display: flex; align-items: center; gap: 8px; }
        .voltar-link:hover { color: var(--cor-titulos); }

        /* --- LAYOUT DE CHECKOUT PREMIUM --- */
        .checkout-wrapper {
            max-width: 1200px; margin: 50px auto 100px auto; padding: 0 5%;
            display: flex; gap: 80px; align-items: flex-start;
        }

        /* Lado Esquerdo: Formulários (Envio e Pagamento) */
        .checkout-form { flex: 1.2; }
        
        .passo-grupo { margin-bottom: 50px; }
        .seccao-titulo { font-family: var(--fonte-titulos); font-size: 26px; color: var(--cor-titulos); margin-bottom: 25px; display: flex; align-items: center; gap: 15px; }
        .passo-numero { background: var(--cor-titulos); color: white; width: 26px; height: 26px; display: inline-flex; justify-content: center; align-items: center; border-radius: 50%; font-size: 13px; font-family: var(--fonte-texto); }

        .input-row { display: flex; gap: 20px; margin-bottom: 20px; }
        .input-grupo { position: relative; flex: 1; }
        .input-grupo input, .input-grupo select {
            width: 100%; background: var(--cor-branco); border: 1px solid #e0e0e0; border-radius: 8px;
            padding: 16px 15px 8px 15px; font-family: var(--fonte-texto); font-size: 15px; color: var(--cor-titulos);
            outline: none; transition: var(--transicao);
        }
        .input-grupo select { cursor: pointer; color: #444; appearance: none; }
        .input-grupo label {
            position: absolute; left: 16px; top: 14px; color: #999; font-size: 14px;
            pointer-events: none; transition: var(--transicao);
        }
        .input-grupo input:focus, .input-grupo select:focus { border-color: var(--cor-dourado); box-shadow: 0 0 0 4px rgba(203, 160, 82, 0.1); }
        .input-grupo input:focus ~ label, .input-grupo input:valid ~ label, .input-grupo select:valid ~ label {
            top: 6px; font-size: 10px; color: var(--cor-dourado); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* Métodos de Pagamento */
        .metodos-pagamento { display: flex; flex-direction: column; gap: 12px; }
        .metodo-opcao {
            display: flex; align-items: center; justify-content: space-between; background: var(--cor-branco);
            border: 1px solid #e0e0e0; padding: 18px 20px; border-radius: 8px; cursor: pointer; transition: var(--transicao);
        }
        .metodo-opcao:hover { border-color: var(--cor-dourado); }
        .metodo-opcao.ativo { border-color: var(--cor-dourado); border-width: 2px; background: rgba(203, 160, 82, 0.03); padding: 17px 19px; }
        .metodo-nome { display: flex; align-items: center; gap: 12px; font-weight: 500; color: var(--cor-titulos); font-size: 15px; }
        .metodo-nome input[type="radio"] { accent-color: var(--cor-dourado); transform: scale(1.2); }
        .metodo-icones span { font-size: 13px; font-weight: bold; letter-spacing: 0.5px; }

        .detalhes-cartao { background: #faf8f5; padding: 25px; border-radius: 8px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #f0eee9; display: none; }
        .detalhes-cartao.ativo { display: block; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

        .btn-pagar {
            display: block; width: 100%; background: var(--cor-titulos); color: var(--cor-branco);
            padding: 22px 0; font-size: 15px; text-transform: uppercase; letter-spacing: 2px;
            border: none; border-radius: 8px; transition: var(--transicao); font-weight: 600; cursor: pointer; margin-top: 30px;
        }
        .btn-pagar:hover { background: var(--cor-dourado); box-shadow: 0 10px 25px rgba(203, 160, 82, 0.25); transform: translateY(-2px); }
        .btn-pagar:disabled { background: #ccc; cursor: not-allowed; transform: none; box-shadow: none; }
        .seguranca-nota { text-align: center; font-size: 12px; color: #aaa; margin-top: 20px; display: flex; align-items: center; justify-content: center; gap: 6px; }

        /* Lado Direito: Resumo da Encomenda */
        .checkout-resumo { flex: 1; position: sticky; top: 100px; background: transparent; }
        
        .resumo-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 25px; }
        .resumo-titulo { font-family: var(--fonte-titulos); font-size: 26px; color: var(--cor-titulos); }
        
        .lista-produtos { margin-bottom: 30px; border-bottom: 1px solid #e5e5e5; padding: 15px 15px 15px 5px; max-height: 400px; overflow-y: auto; overflow-x: hidden; margin-left: -5px; }
        
        .lista-produtos::-webkit-scrollbar { width: 5px; }
        .lista-produtos::-webkit-scrollbar-track { background: transparent; }
        .lista-produtos::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
        
        .item-produto { display: flex; align-items: center; gap: 20px; margin-bottom: 25px; transition: var(--transicao); }
        .item-produto.removendo { opacity: 0; transform: scale(0.95); }
        
        .item-img { position: relative; width: 75px; height: 75px; background: var(--cor-branco); border-radius: 10px; border: 1px solid #eee; display: flex; justify-content: center; align-items: center; padding: 8px; flex-shrink: 0; }
        .item-img img { max-width: 100%; max-height: 100%; mix-blend-mode: multiply; }
        .item-qtd { position: absolute; top: -10px; right: -10px; background: var(--cor-texto); color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 12px; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.15); z-index: 10; }
        
        .item-info { flex: 1; }
        .item-nome { font-family: var(--fonte-titulos); font-size: 18px; color: var(--cor-titulos); margin-bottom: 2px; }
        .item-categoria { font-size: 11px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        
        .item-preco-container { text-align: right; }
        .item-preco { font-size: 16px; font-weight: 600; color: var(--cor-titulos); margin-bottom: 4px; }
        .btn-remover-item { background: none; border: none; font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: var(--transicao); padding: 0; font-family: var(--fonte-texto); font-weight: 500; }
        .btn-remover-item:hover { color: #e74c3c; text-decoration: underline; }

        .linha-resumo { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 15px; color: #666; }
        .linha-total { display: flex; justify-content: space-between; margin-top: 25px; padding-top: 25px; border-top: 1px solid #e5e5e5; font-size: 26px; font-weight: 600; color: var(--cor-titulos); font-family: var(--fonte-titulos); }

        /* --- ESTILOS DO MODAL PERSONALIZADO --- */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(17, 29, 36, 0.6); backdrop-filter: blur(4px);
            display: flex; justify-content: center; align-items: center;
            z-index: 9999; opacity: 0; visibility: hidden; transition: var(--transicao);
        }
        .modal-overlay.ativo { opacity: 1; visibility: visible; }
        
        .modal-box {
            background: var(--cor-branco); padding: 40px 50px; border-radius: 12px;
            max-width: 420px; width: 90%; text-align: center;
            transform: translateY(20px); transition: var(--transicao);
            box-shadow: 0 25px 50px rgba(0,0,0,0.1); border-top: 4px solid var(--cor-dourado);
        }
        .modal-overlay.ativo .modal-box { transform: translateY(0); }
        
        .modal-logo-img { height: 45px; width: auto; display: block; margin: 0 auto 20px auto; }
        .modal-mensagem { font-size: 16px; color: var(--cor-texto); margin-bottom: 30px; line-height: 1.5; }
        
        .btn-modal {
            background: var(--cor-titulos); color: var(--cor-branco); border: none;
            padding: 14px 35px; font-family: var(--fonte-texto); font-size: 14px; text-transform: uppercase;
            letter-spacing: 1px; font-weight: 500; border-radius: 6px; cursor: pointer; transition: var(--transicao);
        }
        .btn-modal:hover { background: var(--cor-dourado); }

        @media (max-width: 992px) {
            .checkout-wrapper { flex-direction: column-reverse; gap: 50px; }
            .checkout-resumo { position: static; width: 100%; }
        }
        @media (max-width: 600px) {
            .voltar-link { display: none; }
            .input-row { flex-direction: column; gap: 20px; }
            .modal-box { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <div id="modal-personalizado" class="modal-overlay">
        <div class="modal-box">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="modal-logo-img">
            <p id="modal-mensagem" class="modal-mensagem">Mensagem aqui</p>
            <button id="modal-btn" class="btn-modal">Continuar</button>
        </div>
    </div>

    <header>
        <a href="carrinho.php" class="voltar-link">← Voltar ao Carrinho</a>
        <a href="index.php">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="logo-img">
        </a>
    </header>

    <main class="checkout-wrapper">
        
        <div class="checkout-form">
            
            <div class="passo-grupo">
                <h2 class="seccao-titulo"><span class="passo-numero">1</span> Dados de Envio</h2>
                
                <div class="input-row">
                    <div class="input-grupo">
                        <input type="email" id="email" required>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-grupo">
                        <input type="text" id="telefone" required>
                        <label for="telefone">Telemóvel</label>
                    </div>
                </div>
                
                <div class="input-row">
                    <div class="input-grupo">
                        <input type="text" id="nome" required>
                        <label for="nome">Nome e Apelido</label>
                    </div>
                    <div class="input-grupo">
                        <input type="text" id="nif">
                        <label for="nif">NIF (Opcional)</label>
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-grupo" style="flex: 2;">
                        <input type="text" id="morada" required>
                        <label for="morada">Morada Completa</label>
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-grupo">
                        <input type="text" id="cod_postal" required>
                        <label for="cod_postal">Código Postal</label>
                    </div>
                    <div class="input-grupo">
                        <input type="text" id="cidade" required>
                        <label for="cidade">Cidade</label>
                    </div>
                    <div class="input-grupo">
                        <select id="pais" required>
                            <option value="PT" selected>Portugal</option>
                            <option value="ES">Espanha</option>
                            <option value="FR">França</option>
                        </select>
                        <label for="pais">País</label>
                    </div>
                </div>
            </div>

            <div class="passo-grupo">
                <h2 class="seccao-titulo"><span class="passo-numero">2</span> Método de Pagamento</h2>
                
                <div class="metodos-pagamento">
                    
                    <label class="metodo-opcao ativo" onclick="selecionarMetodo('cartao')">
                        <div class="metodo-nome">
                            <input type="radio" name="metodo" checked id="radio-cartao">
                            <span>Cartão de Crédito / Débito</span>
                        </div>
                        <div class="metodo-icones">
                            <span style="color: #1a1f71;">VISA</span> | <span style="color: #ff5f00;">MC</span>
                        </div>
                    </label>

                    <div class="detalhes-cartao ativo" id="form-cartao">
                        <div class="input-row" style="margin-bottom: 20px;">
                            <div class="input-grupo">
                                <input type="text" id="num_cartao" required>
                                <label for="num_cartao">Número do Cartão</label>
                            </div>
                        </div>
                        <div class="input-row" style="margin-bottom: 0;">
                            <div class="input-grupo">
                                <input type="text" id="validade" required>
                                <label for="validade">Validade (MM/AA)</label>
                            </div>
                            <div class="input-grupo">
                                <input type="text" id="cvv" required>
                                <label for="cvv">CVV</label>
                            </div>
                        </div>
                    </div>

                    <label class="metodo-opcao" onclick="selecionarMetodo('mbway')">
                        <div class="metodo-nome">
                            <input type="radio" name="metodo" id="radio-mbway">
                            <span>MB WAY</span>
                        </div>
                        <div class="metodo-icones">
                            <span style="color: #ea2027;">MB WAY</span>
                        </div>
                    </label>

                    <label class="metodo-opcao" onclick="selecionarMetodo('multibanco')">
                        <div class="metodo-nome">
                            <input type="radio" name="metodo" id="radio-multibanco">
                            <span>Referência Multibanco</span>
                        </div>
                    </label>

                </div>

                <button class="btn-pagar" id="btn-finalizar" onclick="processarPagamento()">Pagar <span id="btn-valor-total">0,00 €</span></button>
                <div class="seguranca-nota">🔒 Informação protegida por encriptação de grau militar.</div>
            </div>

        </div>

        <div class="checkout-resumo">
            <div class="resumo-header">
                <h2 class="resumo-titulo">Resumo da Encomenda</h2>
            </div>
            
            <div class="lista-produtos" id="carrinho-checkout">
                </div>

            <div class="linha-resumo">
                <span>Subtotal</span>
                <span id="valor-subtotal">0,00 €</span>
            </div>
            <div class="linha-resumo">
                <span>Portes de Envio</span>
                <span id="valor-portes" style="color: #2ecc71; font-weight: 600;">A calcular...</span>
            </div>
            
            <div class="linha-total">
                <span>Total</span>
                <span id="valor-total">0,00 €</span>
            </div>
        </div>

    </main>

    <script>
        // --- FUNÇÃO DO MODAL PERSONALIZADO ---
        function mostrarAlerta(mensagem, urlRedirecionamento = null) {
            const modal = document.getElementById('modal-personalizado');
            const msgEl = document.getElementById('modal-mensagem');
            const btn = document.getElementById('modal-btn');

            msgEl.textContent = mensagem;
            modal.classList.add('ativo');

            // Remove eventos antigos clonando o botão
            const novoBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(novoBtn, btn);

            novoBtn.addEventListener('click', () => {
                modal.classList.remove('ativo');
                if (urlRedirecionamento) {
                    window.location.href = urlRedirecionamento;
                }
            });
        }

        // Simulador dos produtos vindos do carrinho.php
        let itensNoCarrinho = [
            { id: 1, nome: "F-44 Gui Zhi Tang", categoria: "Fitoterapia", preco: 28.79, qtd: 1, img: "https://nutribio.pt/wp-content/uploads/2026/01/FI01GT44-F44-Gui-Zhi-Tang-100ml-TCM20Formula-Nutribio.webp" },
            { id: 2, nome: "F-25 B Fang Tang", categoria: "Dor Lombar", preco: 25.50, qtd: 2, img: "https://nutribio.pt/wp-content/uploads/2025/06/FI.01.GT_.25B-F25-B-Shen-Yang-Xu-Yao-Tang-Fang-Tang-100-ml-TCM-Formula-Nutribio.webp" }
        ];

        const limiarPortesGratis = 60.00; 
        const custoPortes = 4.90;

        function carregarResumo() {
            const containerProdutos = document.getElementById('carrinho-checkout');
            containerProdutos.innerHTML = '';
            let subtotal = 0;

            if (itensNoCarrinho.length === 0) {
                mostrarAlerta("O seu carrinho ficou vazio. Vamos redirecioná-lo para que possa explorar o nosso catálogo.", 'loja.php');
                return;
            }

            itensNoCarrinho.forEach((item, index) => {
                let totalItem = item.preco * item.qtd;
                subtotal += totalItem;

                const htmlItem = `
                    <div class="item-produto" id="checkout-item-${index}">
                        <div class="item-img">
                            <span class="item-qtd">${item.qtd}</span>
                            <img src="${item.img}" alt="${item.nome}">
                        </div>
                        <div class="item-info">
                            <div class="item-categoria">${item.categoria}</div>
                            <div class="item-nome">${item.nome}</div>
                        </div>
                        <div class="item-preco-container">
                            <div class="item-preco">${totalItem.toFixed(2).replace('.', ',')} €</div>
                            <button class="btn-remover-item" onclick="removerItemCheckout(${index})">Remover</button>
                        </div>
                    </div>
                `;
                containerProdutos.innerHTML += htmlItem;
            });

            let portes = subtotal >= limiarPortesGratis ? 0 : custoPortes;
            let total = subtotal + portes;

            document.getElementById('valor-subtotal').innerText = subtotal.toFixed(2).replace('.', ',') + ' €';
            
            const elementPortes = document.getElementById('valor-portes');
            if(portes === 0) {
                elementPortes.innerText = 'Grátis';
                elementPortes.style.color = '#2ecc71';
            } else {
                elementPortes.innerText = portes.toFixed(2).replace('.', ',') + ' €';
                elementPortes.style.color = '#555';
            }

            const totalFormatado = total.toFixed(2).replace('.', ',') + ' €';
            document.getElementById('valor-total').innerText = totalFormatado;
            document.getElementById('btn-valor-total').innerText = totalFormatado;
        }

        function removerItemCheckout(index) {
            const itemElement = document.getElementById(`checkout-item-${index}`);
            itemElement.classList.add('removendo'); 
            
            setTimeout(() => {
                itensNoCarrinho.splice(index, 1);
                carregarResumo();
            }, 300);
        }

        function selecionarMetodo(metodo) {
            document.querySelectorAll('.metodo-opcao').forEach(el => el.classList.remove('ativo'));
            document.getElementById('form-cartao').classList.remove('ativo');
            
            if (metodo === 'cartao') {
                document.getElementById('radio-cartao').checked = true;
                document.getElementById('radio-cartao').closest('.metodo-opcao').classList.add('ativo');
                document.getElementById('form-cartao').classList.add('ativo');
            } else {
                document.getElementById(`radio-${metodo}`).checked = true;
                document.getElementById(`radio-${metodo}`).closest('.metodo-opcao').classList.add('ativo');
            }
        }

        function processarPagamento() {
            const morada = document.getElementById('morada').value;
            const email = document.getElementById('email').value;

            if(!morada || !email) {
                mostrarAlerta("Por favor, preencha os seus dados de contacto e a morada de envio antes de prosseguir com o pagamento.");
                return;
            }

            const btn = document.getElementById('btn-finalizar');
            btn.innerHTML = 'A processar pagamento...';
            btn.disabled = true;
            btn.style.opacity = '0.8';
            
            setTimeout(() => {
                mostrarAlerta('Pagamento processado com sucesso! A sua encomenda foi registada. Obrigado pela sua confiança na AcuSport.', 'index.php');
            }, 2000);
        }

        carregarResumo();
    </script>
</body>
</html>