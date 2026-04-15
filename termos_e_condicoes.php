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
    <title>Termos e Condições | AcuSport</title>
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

        /* Formatação de Secções Numeradas */
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
        .container-legal strong { color: var(--cor-titulos); font-weight: 600; }
        
        .container-legal ul { margin-bottom: 25px; padding-left: 20px; }
        .container-legal li { margin-bottom: 10px; font-size: 16px; text-align: justify; color: #666; list-style-type: none; position: relative; }
        .container-legal li::before { content: "•"; color: var(--cor-dourado); position: absolute; left: -20px; font-weight: bold; font-size: 18px; line-height: 1.5; }
        
        /* Destaque para moradas e e-mails melhorado */
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
        <p class="fade-element">Regras & Compromissos</p>
        <h1 class="fade-element delay-1">Termos e Condições</h1>
    </div>

    <main class="container-legal anim-trigger">
        
        <div class="fade-element delay-2">
            <h2>1. Âmbito e Objeto das Condições Gerais da Loja</h2>
            <p>As presentes Condições Gerais destinam-se, com o formulário de encomenda, e os demais elementos referidos nas mesmas, a regular os termos e as condições por que se regerá a prestação do Serviço Loja Online AcuSport, com sede em rua portela da fonte, Miro Friúmes.</p>
            <p>O Serviço consiste na disponibilização, através do endereço www.acusport.pt de acesso à Loja Online que, além de fornecer informação relativa a um conjunto de produtos e/ou serviços, permite ao Utilizador, por via eletrónica, encomendar os produtos nela divulgados, nos termos e condições aqui descritos.</p>
            <p>A encomenda de produtos deve ser feita por Utilizadores com idade igual ou superior a 18 (dezoito) anos. Os elementos e informações transmitidos pelo Utilizador gozarão de plenos efeitos jurídicos, reconhecendo o Utilizador as aquisições eletrónicas, não podendo este alegar a falta de assinatura para incumprimento das obrigações assumidas.</p>

            <h2>2. Informação de Produto e Conteúdos</h2>
            <p>A AcuSport fará todos os possíveis para que a informação apresentada não contenha erros tipográficos, sendo que serão rapidamente corrigidos sempre que estes ocorram. Caso adquira um produto que tenha características diferentes às apresentadas online, tem o direito de proceder à resolução do contrato de compra nos termos legais aplicáveis (direito de livre resolução – ver ponto 7).</p>
            <p>A AcuSport fará todos os possíveis para enviar a totalidade dos produtos encomendados, mas é possível que, em determinados casos e devido a causas dificilmente controláveis pela AcuSport, como erros humanos ou incidências nos sistemas informáticos, não seja possível disponibilizar algum dos produtos pedidos pelo Utilizador. Caso algum produto não esteja disponível depois de ter realizado a encomenda, será avisado, por correio eletrónico ou através de telefone. Nesse momento ser-lhe-á apresentada a possibilidade de anular a encomenda com o respetivo reembolso, caso já tenha efetuado o respetivo pagamento.</p>
            <p>Todas as informações sobre preço, produtos, especificações, ações promocionais e serviços poderão ser alteradas a qualquer momento pela AcuSport.</p>

            <h2>3. Responsabilidades</h2>
            <p><strong>3.1</strong> Todos os produtos e serviços comercializados na Loja AcuSport estão de acordo com a Lei Portuguesa.</p>
            <p><strong>3.2</strong> A Loja possui os adequados níveis de segurança, contudo a AcuSport não será responsável por quaisquer prejuízos sofridos pelo Utilizador e/ou por terceiros, em virtude de atrasos, interrupções, erros e suspensões de comunicações que tenham origem em fatores fora do seu controlo, nomeadamente, quaisquer deficiências ou falhas provocadas pela rede de comunicações ou serviços de comunicações prestados por terceiros, pelo sistema informático, pelos modems, pelo software de ligação ou eventuais vírus informáticos ou decorrentes do descarregamento (“download”) através do serviço de ficheiros infetados ou contendo vírus ou outras propriedades que possam afetar o equipamento do Utilizador. Se por algum motivo de erro de acesso ao sítio eletrónico da Loja Online AcuSport houver impossibilidade de prestação de serviço, a AcuSport não será responsável por eventuais prejuízos.</p>
            <p><strong>3.3</strong> As consultas de dados e informação efetuadas no âmbito deste Serviço, presumem-se efetuadas pelo Utilizador, declinando a AcuSport qualquer responsabilidade decorrente a utilização abusiva ou fraudulenta das informações obtidas.</p>
            <p><strong>3.4</strong> A AcuSport não será responsável por quaisquer perdas ou danos causados por utilizações abusivas do Serviço que lhe não sejam diretamente imputáveis a título de dolo ou culpa grave.</p>
            <p><strong>3.5</strong> A AcuSport não é responsável pelos prejuízos ou danos decorrentes do incumprimento ou cumprimento defeituoso do Serviço quando tal não lhe seja direta ou indiretamente imputável a título de dolo ou culpa grave, não se responsabilizando designadamente por:</p>
            <ul>
                <li>Erros, omissões ou outras imprecisões relativos às informações disponibilizadas através do Serviço;</li>
                <li>Danos causados por culpa do Utilizador ou de terceiros, incluindo as violações da propriedade intelectual;</li>
                <li>Pelo incumprimento ou cumprimento defeituoso que resulte do cumprimento de decisões judiciais ou de autoridades administrativas ou</li>
                <li>Pelo incumprimento ou cumprimento defeituoso que resulte da ocorrência de situações de força maior, ou seja, situações de natureza extraordinária ou imprevisível, exteriores à AcuSport e que pela mesma não possam ser controladas, tais como incêndios, cortes de energia, explosões, guerras, tumultos, insurreições civis, decisões governamentais, greves, terramotos, inundações ou outros cataclismos naturais ou outras situações não controláveis pela AcuSport que impeçam ou prejudiquem o cumprimento das obrigações assumidas.</li>
            </ul>
            <p><strong>3.6</strong> A AcuSport não garante que:</p>
            <ul>
                <li>O Serviço seja fornecido de forma ininterrupta, seja seguro, sem erros ou funcione de forma infinita;</li>
                <li>A qualidade de qualquer produto, serviço, informação ou qualquer outro material comprado ou obtido através do Serviço preencha quaisquer expectativas do Utilizador em relação ao mesmo;</li>
                <li>Qualquer material obtido de qualquer forma através da utilização do Serviço é utilizado por conta e risco do Utilizador, sendo este o único responsável por qualquer dano causado ao seu sistema e equipamento informático ou por qualquer perda de dados que resultem dessa operação;</li>
                <li>Nenhum conselho ou informação, quer oral quer escrita, obtida pelo Utilizador de ou através do Serviço criará qualquer garantia que não esteja expressa nestas Condições Gerais.</li>
            </ul>
            <p><strong>3.7</strong> O Utilizador aceita que a AcuSport não pode de forma nenhuma ser responsabilizada por qualquer dano, incluindo, mas não limitado a, danos por perdas de lucros, dados, conteúdos, ou quaisquer outras perdas (mesmo que tenha sido previamente avisado pelo Utilizador sobre a possibilidade da ocorrência desses danos), resultantes:</p>
            <ul>
                <li>Do uso ou impossibilidade de uso do Serviço;</li>
                <li>Da dificuldade de obtenção de qualquer substituto de bens/serviços;</li>
                <li>Do acesso ou modificação não autorizado a bases de dados pessoais.</li>
            </ul>

            <h2>4. Obrigações do Consumidor</h2>
            <p><strong>4.1.</strong> O utilizador compromete-se a:</p>
            <ul>
                <li>Facultar dados pessoais e moradas corretas;</li>
                <li>Não utilizar identidades falsas;</li>
                <li>Respeitar os limites de encomendas impostos.</li>
            </ul>
            <p><strong>4.2.</strong> Caso algum dos dados esteja incorreto, ou seja, insuficiente, e por esse motivo haja um atraso ou impossibilidade no processamento da encomenda, ou eventual não entrega, a responsabilidade é do Utilizador, sendo que a AcuSport declina qualquer responsabilidade. No caso de o consumidor violar alguma destas obrigações, a AcuSport reserva-se no direito de eliminar futuras compras, bloquear o acesso à loja, cancelar o fornecimento de quaisquer outros serviços disponibilizados em simultâneo pela AcuSport ao mesmo Utilizador; e, ainda, não permitir o acesso futuro do Utilizador a algum ou quaisquer serviços disponibilizados pela AcuSport.</p>
            <p><strong>4.3.</strong> É expressamente vedada a utilização dos produtos e serviços adquiridos para fins comerciais, designadamente para efeitos de revenda de bens.</p>

            <h2>5. Privacidade e Proteção de Dados Pessoais</h2>
            <p><strong>5.1.</strong> A AcuSport garante a confidencialidade de todos os dados fornecidos pelos Utilizadores.</p>
            <p><strong>5.2.</strong> Os dados pessoais identificados no formulário de encomenda como sendo de fornecimento obrigatório são indispensáveis à prestação do Serviço pela AcuSport. A omissão ou inexatidão dos dados fornecidos pelo Utilizador são da sua única e inteira responsabilidade e podem dar lugar à recusa de prestação do Serviço pela AcuSport.</p>
            <p><strong>5.3.</strong> Os dados pessoais do Utilizador serão processados e armazenados informaticamente e destinam-se a ser utilizados pela AcuSport no âmbito da relação contratual e/ou comercial com o Utilizador única e exclusivamente para faturação, a mesma encontra-se ao abrigo do RGPD.</p>
            <p><strong>5.4.</strong> Nos termos da legislação aplicável, é garantido ao Utilizador, sem encargos adicionais, o direito de acesso, retificação e atualização dos seus dados pessoais, diretamente ou mediante pedido por escrito, bem como o direito de oposição à utilização dos mesmos para as finalidades previstas no número anterior, devendo para o efeito contactar a entidade responsável pelo tratamento dos dados pessoais: AcuSport.</p>
            <p><strong>5.5.</strong> A Internet é uma rede aberta, pelo que os dados pessoais do Utilizador, demais informações pessoais e todo o conteúdo alojado no Serviço poderão circular na rede sem condições de segurança, correndo, inclusive, o risco de serem acessíveis e utilizados por terceiros não autorizados para o efeito, não podendo a AcuSport ser responsabilizada por esse acesso e/ou utilização.</p>

            <h2>6. Cancelamento de Encomendas</h2>
            <p><strong>6.1 A pedido do Utilizador</strong><br>O Utilizador poderá efetuar o cancelamento da sua encomenda solicitando-o à AcuSport através do número de telefone ou e-mail referindo o número da encomenda, o qual será aceite desde que a mesma ainda não tenha sido processada. Após o seu processamento, a AcuSport tentará efetuar a entrega da mesma, mas o Utilizador tem a opção de não a aceitar. Para o efeito de cancelamento o Utilizador deverá indicar os seguintes dados à AcuSport: a) Número da encomenda; b) NIF com que efetuou a encomenda e morada de entrega.</p>
            <p><strong>6.2 Por decisão da AcuSport</strong><br>A AcuSport reserva-se no direito de não processar encomendas, quando verificar alguma inconsistência nos dados pessoais apresentados ou observar má conduta por parte do comprador. A AcuSport reserva-se no direito de não efetuar o processamento de qualquer encomenda ou reembolso, no caso de se verificarem erros nos valores e/ou características dos produtos, quando estes decorrerem de problemas técnicos ou erros alheios à AcuSport.</p>

            <h2>7. Devolução (Direito de Resolução)</h2>
            <p><strong>7.1.</strong> O Utilizador, no caso de ser consumidor, pode exercer o direito de resolução sem que lhe seja exigida qualquer indemnização, no prazo de 14 (catorze) dias a contar do dia em que o consumidor adquira a posse física do bem.</p>
            <p>Para exercer este direito, o Utilizador poderá usar a minuta indicada abaixo, devendo indicar todos os seus dados de identificação, o serviço subscrito que pretende resolver e a data de subscrição. A comunicação deverá ser feita, por carta, através da devolução do bem adquirido, ou por outro meio adequado e suscetível de prova dentro do prazo acima definido. O consumidor deve no prazo de 14 (catorze) dias a contar da data da comunicação da resolução devolver os bens à AcuSport nas devidas condições de utilização.</p>
            <p>Minuta para formulário de livre resolução deve ser solicitada através do email: <a href="mailto:geral@acusport.pt">geral@acusport.pt</a>.</p>
            <p>A embalagem deve ser devolvida completa, tal como foi entregue e acompanhada de toda a documentação recebida, nomeadamente, os seguintes documentos: fatura de venda e o documento que comprova a receção do produto. A embalagem e os documentos indicados deverão ser enviados para a seguinte morada, salientando que os respetivos custos serão da responsabilidade do comprador:</p>
            
            <div class="destaque-info">
                <strong>AcuSport - Centro de Devoluções</strong><br>
                Miro<br>
                Rua da Portela nº 10, 3370-073 Friúmes Penacova
            </div>

            <p><strong>7.2.</strong> Após receção da devolução na AcuSport será devolvido ao Utilizador o valor correspondente ao valor pago pela encomenda (valor da fatura de venda) sem o custo dos portes. Caso tenha utilizado um código de desconto promocional, esse valor não será restituído, ou seja, o reembolso será apenas pelo valor efetivamente pago.</p>
            <p><strong>7.3.</strong> O método de reembolso do valor a devolver depende do método de pagamento utilizado na respetiva encomenda. No caso de pagamentos com entidade e referência, estes são creditados nas respetivas contas após ter sido facultado o NIB. Nos restantes casos, quando é fornecida informação do NIB, o reembolso é feito para a conta bancária indicada. Caso contrário, o reembolso é realizado por cheque para a morada de faturação. O reembolso é efetuado até 30 dias após a receção da vontade de livre resolução e da receção da devolução do bem.</p>
            <p><strong>7.4.</strong> Na falta de qualquer dos componentes do artigo vendido ou, caso qualquer deles não se encontre em excelente estado de conservação, não haverá lugar a qualquer reembolso do preço ou dos portes, sendo o produto reenviado novamente para a morada de expedição inicial com custo acrescido dos portes.</p>

            <h2>8. Defeito de fabrico</h2>
            <p><strong>8.1.</strong> Em caso de “defeito de fabrico”, ou seja, quando são detetadas avarias nos artigos com garantia, o Utilizador deverá devolver o artigo, juntamente com uma cópia da fatura e o formulário “Pedido de Troca /Devolução do artigo” preenchido, no prazo máximo de 30 dias consecutivos a contar da data da fatura, para a morada indicada no ponto 7.1. Se o Utilizador optar por outras formas de devolução, os respetivos custos com portes de envio serão da sua responsabilidade.</p>
            <p><strong>8.2.</strong> Para que a troca do produto possa ser efetuada, deverá assegurar que a embalagem se encontra completa (caixa, manual de instruções, certificado de garantia, terminal e acessórios) contendo todos os componentes que o constituem, em excelente estado de conservação.</p>
            <p><strong>8.3.</strong> Na falta de qualquer um dos elementos referidos anteriormente, ou caso algum dos componentes não se encontre em excelente estado de conservação, não haverá lugar a qualquer troca, sendo o produto reenviado novamente ao Utilizador.</p>

            <h2>9. Garantia</h2>
            <p><strong>9.1.</strong> Todos os artigos disponíveis na Loja estão devidamente certificados pelas entidades internacionais competentes.</p>
            <p><strong>9.2.</strong> Os artigos possuem um período de validade definido pelo fabricante, que nos termos legais é, no mínimo, de 2 (dois) anos.</p>
            <p><strong>9.3.</strong> São considerados fora das condições de validade os equipamentos que tenham ultrapassado o período definido pelo fabricante ou apresentem defeitos causados por desgaste anormal, instalação imprópria, intempéries, descargas elétricas, negligência ou acidentes, mau manuseamento, infiltração de humidade/líquidos, utilização de acessórios não originais e intervenções técnicas por pessoal não autorizado.</p>
            <p><strong>9.4.</strong> Se o artigo apresentar alguma anomalia, o Utilizador poderá dirigir-se com o mesmo, e respetivo comprovativo de compra, à morada da AcuSport. Se o Utilizador optar por outras formas de devolução, os respetivos custos com portes de envio serão da sua responsabilidade. O Utilizador deve solicitar sempre o talão à entidade transportadora que comprove o envio da encomenda.</p>

            <h2>10. Propriedade Intelectual</h2>
            <p><strong>10.1.</strong> A Loja é um site registado e o Serviço prestado pelo próprio site é da responsabilidade da AcuSport.</p>
            <p><strong>10.2.</strong> O Utilizador reconhece que o Serviço contém informação confidencial e está protegido pelos direitos de autor e conexos, propriedade industrial e demais legislação aplicável.</p>
            <p><strong>10.3.</strong> O Utilizador reconhece que qualquer conteúdo que conste na publicidade, destaque, promoção ou menção de qualquer patrocinador ou anunciante está protegido pelas leis relativas a direitos de autor e direitos conexos, pelas leis relativas a propriedade industrial e outras leis de proteção de propriedade, pelo que qualquer utilização desses conteúdos apenas poderá ocorrer ao abrigo de autorização expressa dos respetivos titulares.</p>
            <p><strong>10.4.</strong> O Utilizador compromete-se a respeitar na íntegra os direitos a que se refere o número anterior, designadamente abstendo-se de praticar quaisquer atos que possam violar a lei ou os referidos direitos, tais como a reprodução, a comercialização, a transmissão ou a colocação à disposição do público desses conteúdos ou quaisquer outros atos não autorizados que tenham por objeto os mesmos conteúdos.</p>
            
            <h2>11. Condições de Segurança do Serviço</h2>
            <p><strong>11.1.</strong> O Utilizador compromete-se a observar todas as disposições legais aplicáveis, nomeadamente, a não praticar ou a fomentar a prática de atos ilícitos ou ofensivos dos bons costumes, tais como o envio indiscriminado de comunicações não solicitadas (spamming) em violação do disposto na legislação aplicável ao tratamento de dados pessoais e às comunicações publicitárias através de aparelhos de chamada automática, devendo ainda observar as regras de utilização do Serviço, sob pena de a AcuSport Portugal suspender ou desativar o Serviço nos termos previstos no ponto 12.</p>
            <p><strong>11.2.</strong> O Utilizador expressamente reconhece e aceita que a Rede IP constitui uma rede pública de comunicações eletrónicas suscetível de utilização por vários utilizadores, e como tal, sujeita a sobrecargas informáticas, pelo que a AcuSport não garante a prestação do Serviço sem interrupções, perda de informação ou atrasos.</p>
            <p><strong>11.3.</strong> A AcuSport não garante igualmente a prestação do Serviço em situações de sobrecarga imprevisível dos sistemas em que o mesmo se suporta ou de força maior (situações de natureza extraordinária ou imprevisível, exteriores à AcuSport e que pela mesma não possam ser controladas).</p>
            <p><strong>11.4.</strong> Em caso de interrupção da prestação do Serviço por razões de sobrecarga imprevisível dos sistemas em que o mesmo se suporta, a AcuSport compromete-se a regularizar o seu funcionamento com a maior brevidade possível.</p>

            <h2>12. Suspensão e Desativação do Serviço Loja</h2>
            <p><strong>12.1.</strong> Independentemente de qualquer comunicação prévia ou posterior, a AcuSport pode, em qualquer altura, e de acordo com o seu critério exclusivo, descontinuar a disponibilização do Serviço e ou parte do Serviço a um ou todos os Utilizadores.</p>
            <p><strong>12.2.</strong> A AcuSport reserva-se ainda o direito de suspender ou fazer cessar imediatamente o acesso ao Serviço, nos seguintes casos:</p>
            <ul>
                <li>Quando o Utilizador não observe as condições de utilização referidas no ponto 4 e outras referidas nas Condições Gerais;</li>
                <li>Quando a AcuSport cesse o acesso à Loja, mediante comunicação prévia com uma antecedência de 15 dias sobre a data de cessação.</li>
            </ul>
            <p><strong>12.3.</strong> A suspensão ou a cessação do Serviço pela AcuSport, nos termos dos números anteriores, não importa o direito do Utilizador ou terceiros a qualquer indemnização ou outra compensação, não podendo a AcuSport ser responsabilizada ou de alguma forma onerada, por qualquer consequência resultante da suspensão, anulação, cancelamento do Serviço.</p>
            <p><strong>12.4.</strong> Nas situações acima descritas, a AcuSport comunicará ao Utilizador, previamente por forma a que este possa, querendo, salvaguardar o conteúdo da sua área de visualização de encomendas no prazo de 3 (três) dias úteis a contar do envio do e-mail ou disponibilização da informação na página principal do Serviço.</p>

            <h2>13. Comunicações</h2>
            <p><strong>13.1.</strong> Sem prejuízo de outras formas de comunicação previstas nas presentes Condições Gerais, as notificações efetuadas ao Utilizador que se relacionem com o Serviço, incluindo eventuais alterações às presentes Condições Gerais, poderão ser efetuadas para o endereço de correio eletrónico do Utilizador, por SMS ou contacto telefónico.</p>
            <p><strong>13.2.</strong> O Utilizador aceita receber toda e qualquer comunicação e/ou notificação relacionada com a Loja Online, para a morada, telefone de contacto e ou endereço de correio eletrónico <a href="mailto:geral@acusport.pt">geral@acusport.pt</a> indicados no processo de encomenda. Em qualquer momento, pode solicitar o não recebimento destas comunicações e/ou notificações através do Formulário de Contacto ou através da opção da opção “Não receber a Newsletter” inscrita em cada correspondência.</p>

            <h2>14. Configurações Técnicas</h2>
            <p><strong>14.1.</strong> Sem prejuízo do disposto no número seguinte, a AcuSport poderá alterar o Serviço e/ou as condições técnicas de prestação do mesmo, bem como as respetivas regras de utilização, devendo divulgar ao Utilizador tais alterações com uma antecedência mínima de 15 (quinze) dias.</p>
            <p><strong>14.2.</strong> A versão em cada momento em vigor das presentes Condições Gerais e dos seus anexos encontra-se disponível na plataforma online da marca.</p>

            <h2>15. Melhorias de Sistema</h2>
            <p><strong>15.1.</strong> Sempre que a AcuSport entenda necessário ou conveniente otimizar a experiência de navegação e/ou melhorar as condições de conectividade, a mesma poderá reformular remotamente as configurações de rede.</p>
            <p><strong>15.2.</strong> Sem prejuízo do disposto nos números seguintes, e atento o carácter inovador do Serviço e as evoluções tecnológicas a que poderá estar sujeito, a AcuSport poderá alterar as configurações técnicas do mesmo sempre que tal se revele conveniente para o adaptar a eventuais desenvolvimentos tecnológicos.</p>
            <p><strong>15.3.</strong> A AcuSport não garante, no entanto, ao Utilizador a realização de quaisquer upgrades ou melhorias permanentes no Serviço.</p>
            <p><strong>15.4.</strong> Algumas upgrades ou novas funcionalidades do Serviço poderão estar disponíveis apenas contra pagamento do Utilizador e/ou subscrição, pelo mesmo, de Condições Específicas de utilização.</p>

            <h2>16. Reclamações</h2>
            <p><strong>16.1.</strong> O Utilizador pode submeter quaisquer conflitos contratuais, aos mecanismos de arbitragem e mediação que se encontrem ou venham a ser legalmente constituídos, bem como reclamar junto da AcuSport de atos e omissões que violem as disposições legais aplicáveis à aquisição de bens.</p>
            <p><strong>16.2.</strong> A reclamação deverá ser apresentada no prazo máximo de 15 (quinze) dias, contados a partir do conhecimento dos factos pelo Utilizador, sendo registada nos sistemas de informação da AcuSport que deverá decidir a reclamação e notificar o interessado no prazo máximo de 15 (quinze) dias, a contar da data da sua receção.</p>

            <h2>17. Lei Aplicável</h2>
            <p>O presente Contrato rege-se, em todos os seus trâmites, pela lei e jurisdição portuguesa.</p>
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