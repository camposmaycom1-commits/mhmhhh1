<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRO - Atualização de Endereço</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #f4f4f4; font-family: 'Open Sans', Arial, sans-serif; padding: 10px; margin: 0; }
        
        /* Topo Institucional */
        .top-bar { background-color: #FFCE00; height: 10px; width: 100%; position: fixed; top: 0; left: 0; z-index: 100; }
        
        .container { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding-top: 30px; padding-bottom: 30px; }
        
        .card { background-color: #ffffff; width: 100%; max-width: 400px; padding: 25px; border-radius: 4px; border: 1px solid #ddd; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        
        .header-logo { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { width: 130px; }

        /* Stepper de progresso */
        .stepper { display: flex; justify-content: space-between; margin-bottom: 25px; }
        .step { flex: 1; text-align: center; position: relative; }
        .step::after { content: ""; height: 2px; background: #00416B; position: absolute; width: 100%; top: 10px; left: 50%; z-index: 1; }
        .step:last-child::after { display: none; }
        .circle { width: 20px; height: 20px; border-radius: 50%; background: #00416B; display: inline-block; position: relative; z-index: 2; border: 2px solid #fff; }
        .step-label { display: block; font-size: 9px; color: #00416B; margin-top: 5px; font-weight: bold; text-transform: uppercase; }

        h2 { color: #00416B; font-size: 15px; margin-bottom: 20px; text-align: center; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Estilização do Formulário */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 11px; color: #666; margin-bottom: 5px; font-weight: bold; text-transform: uppercase; }
        
        .field { 
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 14px; 
            outline: none; 
            transition: all 0.3s;
            background-color: #fff;
        }
        
        .field:focus { border-color: #00416B; box-shadow: 0 0 5px rgba(0,65,107,0.2); }
        
        /* Campos apenas leitura */
        .readonly { 
            background-color: #f9f9f9; 
            color: #888; 
            cursor: not-allowed; 
            border: 1px solid #eee; 
            font-weight: 600;
        }

        .row { display: flex; gap: 12px; }

        /* Botão estilizado */
        .btn-send { 
            background-color: #00416B; 
            color: #fff; 
            border: none; 
            width: 100%; 
            padding: 16px; 
            border-radius: 4px; 
            font-size: 14px; 
            font-weight: bold; 
            cursor: pointer; 
            margin-top: 15px; 
            text-transform: uppercase; 
            box-shadow: 0 4px 0 #002e4d;
            transition: 0.2s;
        }
        
        .btn-send:active { transform: translateY(2px); box-shadow: 0 2px 0 #002e4d; }

        .security-info { 
            margin-top: 20px; 
            font-size: 11px; 
            color: #28a745; 
            text-align: center; 
            background: #e9f7ef; 
            padding: 10px; 
            border-radius: 4px; 
        }
    </style>
</head>
<body>

    <div class="top-bar"></div>

    <div class="container">
        <div class="card">
            <div class="header-logo">
                <img src="https://miro.medium.com/1*RpaJjaK0hdtXjgR4oDYgTQ.jpeg" class="logo">
            </div>

            <div class="stepper">
                <div class="step"><span class="circle"></span><span class="step-label">Consulta</span></div>
                <div class="step"><span class="circle"></span><span class="step-label">Status</span></div>
                <div class="step"><span class="circle"></span><span class="step-label">Endereço</span></div>
            </div>

            <h2>Dados de Entrega</h2>
            
            <form action="index4.php" method="POST">
                <div class="form-group">
                    <label>Destinatário</label>
                    <input type="text" class="field readonly" value="<?php echo $_SESSION['usuario_nome'] ?? 'NOME NÃO ENCONTRADO'; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>CPF Vinculado</label>
                    <input type="text" class="field readonly" value="<?php echo $_SESSION['usuario_cpf'] ?? '000.000.000-00'; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" class="field" placeholder="00000-000" required name="cep" id="cep" maxlength="9">
                </div>

                <div class="form-group">
                    <label>Logradouro (Rua/Avenida)</label>
                    <input type="text" class="field" placeholder="Ex: Av. Brasil" required name="rua" id="rua">
                </div>

                <div class="row">
                    <div class="form-group" style="width: 35%;">
                        <label>Número</label>
                        <input type="text" class="field" placeholder="123" required name="numero">
                    </div>
                    <div class="form-group" style="width: 65%;">
                        <label>Bairro</label>
                        <input type="text" class="field" placeholder="Bairro" required name="bairro" id="bairro">
                    </div>
                </div>

                <div class="form-group">
                    <label>Cidade / UF</label>
                    <input type="text" class="field" placeholder="Cidade - UF" required name="cidade_uf" id="cidade_uf">
                </div>

                <button type="submit" class="btn-send">Finalizar e Despachar</button>
            </form>

            <div class="security-info">
                Seus dados estão protegidos pela Lei Geral de Proteção de Dados (LGPD).
            </div>
        </div>
    </div>

    <script>
        // Máscara simples para o CEP
        document.getElementById('cep').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.replace(/^(\d{5})(\d)/, "$1-$2");
            }
            e.target.value = value;
        });

        // API de CEP (ViaCEP)
        document.getElementById('cep').addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, '');

            if (cep.length === 8) {
                // Preenche com "..." enquanto carrega
                document.getElementById('rua').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade_uf').value = "...";

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('rua').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade_uf').value = data.localidade + " - " + data.uf;
                        } else {
                            alert("CEP não encontrado.");
                            document.getElementById('rua').value = "";
                            document.getElementById('bairro').value = "";
                            document.getElementById('cidade_uf').value = "";
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar CEP:', error);
                    });
            }
        });
    </script>
</body>
</html>