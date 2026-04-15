<?php 
$user = 'root';
$pass = '';
$dbname = 'acusport_db';

$mensagem = "";

try {
    $dbh = new PDO('mysql:host=localhost;dbname=' . $dbname, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $categoria = $_POST['categoria'];
        $preco = $_POST['preco'];
        $descricao = $_POST['descricao'];
        
        // --- LÓGICA DE UPLOAD DE IMAGEM ---
        $imagem_url = "";
        if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] === 0) {
            $diretorio_destino = "img/produtos/";
            
            // Cria a pasta se não existir
            if (!is_dir($diretorio_destino)) {
                mkdir($diretorio_destino, 0777, true);
            }

            $nome_ficheiro = time() . "_" . basename($_FILES['foto_produto']['name']);
            $caminho_completo = $diretorio_destino . $nome_ficheiro;

            if (move_uploaded_file($_FILES['foto_produto']['tmp_name'], $caminho_completo)) {
                $imagem_url = $caminho_completo;
            }
        }

        $sql = "INSERT INTO produtos (nome, categoria, preco, imagem_url, descricao) 
                VALUES (:nome, :categoria, :preco, :imagem, :descricao)";
        
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':categoria' => $categoria,
            ':preco' => $preco,
            ':imagem' => $imagem_url,
            ':descricao' => $descricao
        ]);
        
        $mensagem = "<div class='alerta-sucesso'>✅ Produto e imagem guardados com sucesso!</div>";
    }
} catch (PDOException $e) {
    die('Erro na ligação: ' . $e->getMessage());
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
    <title>Painel Administrativo | AcuSport</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cor-fundo: #fdfaf3;
            --cor-titulos: #111d24;
            --cor-dourado: #cba052;
            --cor-branco: #ffffff;
            --fonte-titulos: 'Playfair Display', serif;
            --fonte-texto: 'Jost', sans-serif;
        }

        body { font-family: var(--fonte-texto); background-color: var(--cor-fundo); color: var(--cor-titulos); margin: 0; padding: 40px; }

        .admin-header { max-width: 800px; margin: 0 auto 30px auto; display: flex; justify-content: space-between; align-items: center; }
        .btn-voltar { text-decoration: none; color: var(--cor-titulos); font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s ease; }
        .btn-voltar:hover { color: var(--cor-dourado); }

        .admin-container { max-width: 800px; margin: 0 auto; background: var(--cor-branco); padding: 50px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }

        .form-group { margin-bottom: 25px; }
        label { display: block; font-size: 12px; text-transform: uppercase; font-weight: 600; margin-bottom: 8px; color: var(--cor-dourado); letter-spacing: 1px; }

        input, select, textarea { width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 8px; font-family: var(--fonte-texto); font-size: 15px; background: #fafafa; outline: none; transition: 0.3s; }
        
        /* --- ESTILO ÁREA DRAG & DROP --- */
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
        }
        .upload-area:hover, .upload-area.dragover { border-color: var(--cor-dourado); background: #fff; }
        .upload-area p { margin: 0; font-size: 14px; color: #888; }
        .upload-area b { color: var(--cor-titulos); }
        #preview-img { max-width: 150px; margin-top: 15px; display: none; border-radius: 5px; margin-left: auto; margin-right: auto; }
        #foto_produto { display: none; } /* Esconde o input real */

        button { background: var(--cor-titulos); color: white; border: none; padding: 18px; border-radius: 8px; cursor: pointer; width: 100%; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; transition: 0.3s; margin-top: 10px; }
        button:hover { background: var(--cor-dourado); transform: translateY(-3px); }

        .alerta-sucesso { background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 30px; font-weight: 500; text-align: center; }
    </style>
</head>
<body>

    <div class="admin-header">
        <a href="loja.php" class="btn-voltar">Voltar à Loja</a>
        <div style="font-weight: 600; font-size: 12px; color: #bbb; text-transform: uppercase;">Modo Administrador</div>
    </div>

    <div class="admin-container">
        <h1>Gestão de Inventário</h1>
        <?php echo $mensagem; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nome da Fórmula</label>
                <input type="text" name="nome" placeholder="Ex: Neuro Mais" required>
            </div>
            
            <div class="form-group">
                <label>Categoria MTC</label>
                <select name="categoria">
                    <option value="sistema-nervoso">Sistema Nervoso</option>
                    <option value="cerebro">Cérebro</option>
                    <option value="emagrecimento">Emagrecimento</option>
                    <option value="fitoterapia">Fitoterapia</option>
                    <option value="fadiga">Fadiga</option>
                    <option value="dor-lombar">Dor Lombar</option>
                    <option value="hemorragias">Hemorragias</option>
                    <option value="circulacao-sanguinea">Circulação Sanguínea</option>
                    <option value="dores-articulares">Dores Articulares</option>
                    <option value="asma">Asma</option>
                    <option value="insonias">Insónias</option>
                </select>
            </div>

            <div class="form-group">
                <label>Preço de Venda (€)</label>
                <input type="number" step="0.01" name="preco" placeholder="29.90" required>
            </div>

            <div class="form-group">
                <label>Imagem do Produto</label>
                <div class="upload-area" id="drop-zone" onclick="document.getElementById('foto_produto').click()">
                    <p id="upload-msg"><b>Clique para selecionar</b> ou arraste a foto para aqui</p>
                    <img id="preview-img" src="#" alt="Pré-visualização">
                    <input type="file" name="foto_produto" id="foto_produto" accept="image/*" required>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição Detalhada</label>
                <textarea name="descricao" rows="5" placeholder="Indicações, benefícios..."></textarea>
            </div>

            <button type="submit">Publicar na Loja</button>
        </form>
    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('foto_produto');
        const previewImg = document.getElementById('preview-img');
        const uploadMsg = document.getElementById('upload-msg');

        // Previne comportamentos padrão do navegador ao arrastar
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        // Efeitos visuais ao arrastar
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        // Quando larga o ficheiro
        dropZone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                handleFiles(files[0]);
            }
        });

        // Quando seleciona via clique
        fileInput.addEventListener('change', function() {
            if (this.files.length) handleFiles(this.files[0]);
        });

        function handleFiles(file) {
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                uploadMsg.innerHTML = `Ficheiro selecionado: <b>${file.name}</b>`;
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>