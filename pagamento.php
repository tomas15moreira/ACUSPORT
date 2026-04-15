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
    <title>Pagamento Seguro | AcuSport</title>
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
            background: var(--cor-branco); box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            padding: 20px 50px; display: flex; justify-content: center; align-items: center;
            position: sticky; top: 0; z-index: 1000;
        }
        .logo-img { height: 40px; width: auto; filter: brightness(0) invert(1); }
        .voltar-link { position: absolute; left: 50px; font-size: 14px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 500; transition: var(--transicao); }
        .voltar-link:hover { color: var(--cor-titulos); }

        /* --- LAYOUT DE PAGAMENTO --- */
        .checkout-wrapper {
            max-width: 1200px; margin: 60px auto 100px auto; padding: 0 5%;
            display: flex; gap: 60px; align-items: flex-start;
        }

        /* Lado Esquerdo: Formulário */
        .checkout-form { flex: 1.5; background: var(--cor-branco); padding: 50px; border-radius: 12px; box-shadow: 0 15px 40px rgba(0,0,0,0.03); }
        .seccao-titulo { font-family: var(--fonte-titulos); font-size: 24px; color: var(--cor-titulos); margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 15px; }

        .input-row { display: flex; gap: 20px; margin-bottom: 25px; }
        .input-grupo { position: relative; flex: 1; }
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

        /* Métodos de Pagamento */
        .metodos-pagamento { display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px; }
        .metodo-opcao {
            display: flex; align-items: center; justify-content: space-between;
            border: 1px solid #ddd; padding: 15px 20px; border-radius: 8px; cursor: pointer; transition: var(--transicao);
        }
        .metodo-opcao:hover { border-color: var(--cor-dourado); background: #fdfaf3; }
        .metodo-opcao.ativo { border-color: var(--cor-dourado); border-width: 2px; background: #fdfaf3; }
        .metodo-nome { display: flex; align-items: center; gap: 10px; font-weight: 500; color: var(--cor-titulos); }
        .metodo-nome input[type="radio"] { accent-color: var(--cor-dourado); transform: scale(1.2); }
        .metodo-icones span { font-size: 14px; font-weight: bold; }

        .detalhes-cartao { background: #f9f9f9; padding: 25px; border-radius: 8px; margin-top: -5px; margin-bottom: 30px; display: none; }
        .detalhes-cartao.ativo { display: block; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .btn-pagar {
            display: block; width: 100%; background: var(--cor-titulos); color: var(--cor-branco);
            padding: 18px 0; font-size: 15px; text-transform: uppercase; letter-spacing: 2px;
            border: none; border-radius: 6px; transition: var(--transicao); font-weight: 600; cursor: pointer;
        }
        .btn-pagar:hover { background: var(--cor-dourado); box-shadow: 0 10px 20px rgba(203, 160, 82, 0.2); transform: translateY(-2px); }

        .seguranca-nota { text-align: center; font-size: 13px; color: #aaa; margin-top: 20px; display: flex; align-items: center; justify-content: center; gap: 8px; }

        /* Lado Direito: Resumo Dinâmico com Setas */
        .checkout-resumo { flex: 1; position: sticky; top: 100px; background: var(--cor-branco); padding: 40px; border-radius: 12px; border-top: 4px solid var(--cor-dourado); box-shadow: 0 15px 40px rgba(0,0,0,0.03); }
        
        /* O SELETOR DE PLANOS COM SETAS */
        .plan-selector { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .arrow-btn { background: none; border: 1px solid #eee; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: var(--transicao); font-size: 12px; color: var(--cor-titulos); }
        .arrow-btn:hover { background: var(--cor-dourado); color: white; border-color: var(--cor-dourado); }
        
        .resumo-plano-info { text-align: center; flex: 1; }
        .resumo-plano-info p { font-size: 12px; color: var(--cor-dourado); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 5px; }
        .resumo-plano-info h3 { font-family: var(--fonte-titulos); font-size: 24px; color: var(--cor-titulos); }

        .resumo-preco-grande { text-align: center; font-size: 40px; font-weight: 700; color: var(--cor-titulos); font-family: var(--fonte-titulos); margin: 20px 0; }
        .resumo-preco-grande span { font-size: 16px; font-weight: 400; color: #888; font-family: var(--fonte-texto); }
        
        .linha-resumo { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 15px; color: #666; }
        .linha-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 22px; font-weight: 600; color: var(--cor-titulos); font-family: var(--fonte-titulos); }

        .beneficios-lista { margin-top: 30px; background: #fdfaf3; padding: 20px; border-radius: 8px; min-height: 160px; }
        .beneficios-lista li { font-size: 14px; color: #666; margin-bottom: 10px; display: flex; align-items: center; gap: 10px; animation: fadeInItem 0.4s ease; }
        @keyframes fadeInItem { from { opacity: 0; transform: translateX(-5px); } to { opacity: 1; transform: translateX(0); } }
        .beneficios-lista li::before { content: '✓'; color: var(--cor-dourado); font-weight: bold; }

        @media (max-width: 992px) {
            .checkout-wrapper { flex-direction: column-reverse; }
            .checkout-resumo { position: static; width: 100%; }
        }
        @media (max-width: 600px) {
            .voltar-link { display: none; }
            .checkout-form { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <header>
        <a href="subscricao.php" class="voltar-link">← Alterar Plano</a>
        <a href="index.php">
            <img src="img/logo-acusport(1).png" alt="AcuSport Logo" class="logo-img">
        </a>
    </header>

    <main class="checkout-wrapper">
        
        <div class="checkout-form">
            <h2 class="seccao-titulo">Detalhes da Conta</h2>
            <div class="input-row">
                <div class="input-grupo">
                    <input type="text" id="nome" required value="">
                    <label for="nome">Nome Completo</label>
                </div>
            </div>
            <div class="input-row">
                <div class="input-grupo">
                    <input type="email" id="email" required value="">
                    <label for="email">E-mail</label>
                </div>
                <div class="input-grupo">
                    <input type="text" id="telefone" required>
                    <label for="telefone">Telemóvel</label>
                </div>
            </div>

            <h2 class="seccao-titulo" style="margin-top: 40px;">Método de Pagamento</h2>
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
                    <div class="input-row" style="margin-bottom: 30px;">
                        <div class="input-grupo">
                            <input type="text" id="num_cartao" required>
                            <label for="num_cartao">Número do Cartão</label>
                        </div>
                    </div>
                    <div class="input-row">
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
                </label>

                <label class="metodo-opcao" onclick="selecionarMetodo('multibanco')">
                    <div class="metodo-nome">
                        <input type="radio" name="metodo" id="radio-multibanco">
                        <span>Referência Multibanco</span>
                    </div>
                </label>
            </div>

            <button class="btn-pagar" id="btn-finalizar" onclick="processarPagamento()">Confirmar Subscrição (49,00 €)</button>
            <div class="seguranca-nota">🔒 Transação encriptada e segura</div>
        </div>

        <div class="checkout-resumo">
            <div class="plan-selector">
                <button class="arrow-btn" onclick="mudarPlano(-1)">◀</button>
                <div class="resumo-plano-info">
                    <p>Plano Selecionado</p>
                    <h3 id="plano-nome">Vitalidade</h3>
                </div>
                <button class="arrow-btn" onclick="mudarPlano(1)">▶</button>
            </div>

            <div class="resumo-preco-grande" id="plano-preco">49€<span> /mês</span></div>

            <div class="linha-resumo">
                <span>Subtotal</span>
                <span id="valor-subtotal">49,00 €</span>
            </div>
            <div class="linha-resumo">
                <span>Portes de Envio</span>
                <span style="color: #2ecc71; font-weight: 600;">Grátis</span>
            </div>
            <div class="linha-total">
                <span>Total Final</span>
                <span id="valor-total">49,00 €</span>
            </div>

            <ul class="beneficios-lista" id="lista-beneficios">
                </ul>
        </div>

    </main>

    <script>
        // Dados dos Planos
        const planos = [
            {
                nome: "Essência",
                preco: 29,
                beneficios: ["1 Fórmula à escolha mensal", "Portes de envio gratuitos", "Newsletter premium"]
            },
            {
                nome: "Vitalidade",
                preco: 49,
                beneficios: ["2 Fórmulas à escolha mensais", "Portes de envio gratuitos", "15% desconto extra", "Acesso antecipado"]
            },
            {
                nome: "Mestre",
                preco: 89,
                beneficios: ["4 Fórmulas à escolha mensais", "Portes de envio gratuitos", "Consulta de aconselhamento", "25% desconto extra"]
            }
        ];

        let indexAtual = 1; // Começa no Vitalidade

        function mudarPlano(direcao) {
            indexAtual += direcao;
            if (indexAtual < 0) indexAtual = planos.length - 1;
            if (indexAtual >= planos.length) indexAtual = 0;
            atualizarUI();
        }

        function atualizarUI() {
            const p = planos[indexAtual];
            document.getElementById('plano-nome').innerText = p.nome;
            document.getElementById('plano-preco').innerHTML = `${p.preco}€<span> /mês</span>`;
            document.getElementById('valor-subtotal').innerText = `${p.preco.toFixed(2).replace('.', ',')} €`;
            document.getElementById('valor-total').innerText = `${p.preco.toFixed(2).replace('.', ',')} €`;
            document.getElementById('btn-finalizar').innerText = `Confirmar Subscrição (${p.preco.toFixed(2).replace('.', ',')} €)`;

            const lista = document.getElementById('lista-beneficios');
            lista.innerHTML = "";
            p.beneficios.forEach(b => {
                const li = document.createElement('li');
                li.innerText = b;
                lista.appendChild(li);
            });
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
            const btn = document.getElementById('btn-finalizar');
            btn.innerHTML = 'A processar...';
            btn.disabled = true;
            setTimeout(() => {
                alert('Sucesso! A sua subscrição ao plano ' + planos[indexAtual].nome + ' foi ativada.');
                window.location.href = 'index.php';
            }, 1500);
        }

        // Inicializar benefícios
        atualizarUI();
    </script>
</body>
</html>