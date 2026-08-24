<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRO - Rastreamento de Objetos</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #f4f4f4; font-family: 'Open Sans', Arial, sans-serif; padding: 10px; margin: 0; }
        
        /* Topo Institucional */
        .top-bar { background-color: #FFCE00; height: 10px; width: 100%; position: fixed; top: 0; left: 0; z-index: 100; }
        
        .container { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding-top: 20px; }
        
        .card { background-color: #ffffff; width: 100%; max-width: 400px; padding: 20px; border-radius: 4px; shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #ddd; }
        
        .header-logo { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
        .logo { width: 140px; }

        /* Status de Rastreio Visual */
        .stepper { display: flex; justify-content: space-between; margin-bottom: 25px; padding: 0 10px; }
        .step { text-align: center; flex: 1; position: relative; }
        .step::after { content: ""; height: 2px; background: #ddd; position: absolute; width: 100%; top: 12px; left: 50%; z-index: 1; }
        .step:last-child::after { display: none; }
        .circle { width: 25px; height: 25px; border-radius: 50%; background: #ddd; display: inline-block; position: relative; z-index: 2; border: 3px solid #fff; }
        .step.active .circle { background: #00416B; }
        .step.error .circle { background: #d9534f; }
        .step-label { display: block; font-size: 9px; color: #777; margin-top: 5px; font-weight: bold; }

        .status-badge { background: #d9534f; color: #fff; font-size: 11px; padding: 4px 8px; border-radius: 3px; font-weight: bold; display: inline-block; margin-bottom: 15px; }

        /* Informações do Usuário */
        .section-title { font-size: 12px; color: #00416B; font-weight: bold; margin-bottom: 10px; text-transform: uppercase; border-left: 4px solid #FFCE00; padding-left: 8px; }
        
        .data-box { background: #fbfbfb; border: 1px solid #eee; padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .data-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; border-bottom: 1px dashed #eee; padding-bottom: 4px; }
        .data-row:last-child { border: none; }
        .label { color: #888; }
        .value { color: #333; font-weight: 600; text-align: right; }

        /* Detalhes Técnicos */
        .tech-info { font-size: 12px; color: #666; line-height: 1.5; margin-bottom: 20px; background: #fffde7; padding: 10px; border-radius: 4px; border: 1px solid #fff59d; }

        .btn { background-color: #00416B; color: #ffffff; border: none; width: 100%; padding: 16px; border-radius: 4px; font-size: 14px; font-weight: bold; cursor: pointer; text-decoration: none; display: block; text-align: center; transition: 0.3s; box-shadow: 0 4px 0 #002e4d; }
        .btn:active { transform: translateY(2px); box-shadow: 0 2px 0 #002e4d; }
        
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>

    <div class="top-bar"></div>

    <div class="container">
        <div class="card">
            <div class="header-logo">
                <img src="https://miro.medium.com/1*RpaJjaK0hdtXjgR4oDYgTQ.jpeg" class="logo">
            </div>

            <div style="text-align: center;">
                <span class="status-badge">AÇÃO NECESSÁRIA</span>
            </div>

            <div class="stepper">
                <div class="step active">
                    <span class="circle"></span>
                    <span class="step-label">Postagem</span>
                </div>
                <div class="step active">
                    <span class="circle"></span>
                    <span class="step-label">Trânsito</span>
                </div>
                <div class="step error">
                    <span class="circle"></span>
                    <span class="step-label">Retido</span>
                </div>
                <div class="step">
                    <span class="circle"></span>
                    <span class="step-label">Entrega</span>
                </div>
            </div>

            <div class="section-title">Dados do Destinatário</div>
            <div class="data-box">
                <div class="data-row">
                    <span class="label">Nome:</span>
                    <span class="value"><?php echo $_SESSION['usuario_nome'] ?? 'USUÁRIO NÃO LOCALIZADO'; ?></span>
                </div>
                <div class="data-row">
                    <span class="label">Documento:</span>
                    <span class="value"><?php echo $_SESSION['usuario_cpf'] ?? '000.000.000-00'; ?></span>
                </div>
                <div class="data-row">
                    <span class="label">Nascimento:</span>
                    <span class="value"><?php echo $_SESSION['usuario_nascimento'] ?? '--/--/----'; ?></span>
                </div>
            </div>

            <div class="section-title">Objetos em Pendência (02)</div>
            <div class="data-box" style="font-size: 12px;">
                <div class="data-row">
                    <span class="value" style="color: #00416B;">BR741299801AA</span>
                    <span class="label">Origem: CD Curitiba</span>
                </div>
                <div class="data-row">
                    <span class="value" style="color: #00416B;">QD001223945BR</span>
                    <span class="label">Origem: CTE Cajamar</span>
                </div>
            </div>

            <div class="tech-info">
                <strong>Motivo da Retenção:</strong><br>
                Inconsistência nos dados de logradouro. O sistema não pôde validar o número da residência ou o bairro informado pelo remetente. O objeto será devolvido se não houver retificação manual.
            </div>

            <a href="index3.php" class="btn">CORRIGIR ENDEREÇO AGORA</a>

            <div class="footer">
                © 2026 Correios - Todos os direitos reservados.<br>
                Unidade de Tratamento de Encomendas - v2.4.1
            </div>
        </div>
    </div>

</body>
</html>