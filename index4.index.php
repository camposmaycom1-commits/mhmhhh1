<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRO - Pagamento de Taxa de Despacho</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #f4f4f4; font-family: 'Open Sans', Arial, sans-serif; padding: 10px; margin: 0; }
        
        /* Topo Institucional */
        .top-bar { background-color: #FFCE00; height: 10px; width: 100%; position: fixed; top: 0; left: 0; z-index: 100; }
        
        .container { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding-top: 30px; padding-bottom: 30px; }
        
        .card { background-color: #ffffff; width: 100%; max-width: 400px; padding: 25px; border-radius: 4px; border: 1px solid #ddd; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        
        .header-logo { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { width: 130px; }

        /* Stepper de progresso (Finalizando) */
        .stepper { display: flex; justify-content: space-between; margin-bottom: 25px; }
        .step { flex: 1; text-align: center; position: relative; }
        .step::after { content: ""; height: 2px; background: #00416B; position: absolute; width: 100%; top: 10px; left: 50%; z-index: 1; }
        .step:last-child::after { display: none; }
        .circle { width: 20px; height: 20px; border-radius: 50%; background: #00416B; display: inline-block; position: relative; z-index: 2; border: 2px solid #fff; }
        /* Destaque para o passo atual */
        .step:last-child .circle { background: #FFCE00; border-color: #00416B; } 
        .step-label { display: block; font-size: 9px; color: #00416B; margin-top: 5px; font-weight: bold; text-transform: uppercase; }

        h2 { color: #00416B; font-size: 15px; margin-bottom: 20px; text-align: center; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Box de Alerta de Cobrança */
        .alert-box { 
            background-color: #fff3cd; 
            color: #856404; 
            padding: 15px; 
            border-radius: 4px; 
            font-size: 13px; 
            border: 1px solid #ffeeba; 
            margin-bottom: 20px; 
            line-height: 1.5;
            border-left: 4px solid #856404;
        }
        .alert-box strong { display: block; margin-bottom: 5px; font-size: 14px; }

        /* Tabela de Valores */
        .price-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            background: #fbfbfb; 
            border: 1px solid #eee; 
            border-radius: 4px; 
            overflow: hidden;
        }
        .price-table th, .price-table td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #eee; 
            font-size: 13px;
        }
        .price-table th { color: #666; font-weight: bold; text-transform: uppercase; font-size: 11px; }
        .price-table td { color: #333; }
        .price-table .total-row { background: #eee; font-weight: bold; font-size: 15px; color: #00416B; }
        .price-table .total-label { text-align: right; }

        /* Seção de Pagamento */
        .payment-method { 
            margin-top: 25px; 
            text-align: center; 
            border-top: 1px solid #eee; 
            padding-top: 20px;
        }
        .payment-title { font-size: 12px; color: #00416B; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; display: inline-block; border-bottom: 2px solid #FFCE00; padding-bottom: 3px; }
        
        .pix-box { 
            background: #e9f7ef; 
            border: 1px solid #c3e6cb; 
            padding: 15px; 
            border-radius: 4px; 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px;
            color: #155724;
            font-size: 13px;
            font-weight: bold;
        }
        .pix-icon { width: 25px; height: 25px; }

        /* Botão estilizado */
        .btn-pay { 
            background-color: #28a745; /* Verde para pagamento */
            color: #fff; 
            border: none; 
            width: 100%; 
            padding: 16px; 
            border-radius: 4px; 
            font-size: 14px; 
            font-weight: bold; 
            cursor: pointer; 
            text-transform: uppercase; 
            box-shadow: 0 4px 0 #1e7e34;
            transition: 0.2s;
            text-decoration: none;
            display: block;
        }
        
        .btn-pay:active { transform: translateY(2px); box-shadow: 0 2px 0 #1e7e34; }

        .footer-info { 
            margin-top: 25px; 
            font-size: 10px; 
            color: #aaa; 
            text-align: center; 
            line-height: 1.4;
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
                <div class="step"><span class="circle"></span><span class="step-label">Pagamento</span></div>
            </div>

            <h2>Pagamento de Taxa de Despacho</h2>
            
            <div class="alert-box">
                <strong> Ação Necessária para Envio</strong>
                Para efetivar o despacho imediato dos seus objetos retidos para o novo endereço cadastrado, é necessário realizar o pagamento da Taxa de Despacho Postal. Esta taxa cobre os custos operacionais de reprocessamento e reenvio.
            </div>

            <table class="price-table">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Valor (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Processamento de Reenvio (x2)</td>
                        <td>R$ 48,90</td>
                    </tr>
                    <tr>
                        <td>Taxa Administrativa (SRO)</td>
                        <td>R$ 26,76</td>
                    </tr>
                    <tr class="total-row">
                        <td class="total-label">Total a Pagar:</td>
                        <td>R$ 75,66</td>
                    </tr>
                </tbody>
            </table>

            <div class="payment-method">
                <span class="payment-title">Método de Pagamento</span>
                
                <div class="pix-box">
                    <svg class="pix-icon" viewBox="0 0 512 512" style="fill: #32BCAD;"><path d="M256 0c-141.385 0-256 114.615-256 256s114.615 256 256 256 256-114.615 256-256-114.615-256-256-256zm-74.831 236.431l-34.669 34.669-10.169-10.169-34.669 34.669 10.169 10.169 34.669-34.669-10.169-10.169 34.669-34.669 10.169 10.169-34.669 34.669 10.169 10.169zm186.831 0l-34.669 34.669-10.169-10.169-34.669 34.669 10.169 10.169 34.669-34.669-10.169-10.169 34.669-34.669 10.169 10.169-34.669 34.669 10.169 10.169zm-101.169-101.169l34.669-34.669 10.169 10.169 34.669-34.669-10.169-10.169-34.669 34.669 10.169 10.169-34.669-34.669-10.169-10.169 34.669 34.669-10.169-10.169zm0 186.831l34.669-34.669 10.169 10.169 34.669-34.669-10.169-10.169-34.669 34.669 10.169 10.169-34.669-34.669-10.169-10.169 34.669 34.669-10.169-10.169z"/></svg>
                    PAGAMENTO IMEDIATO VIA PIX
                </div>

                <a href="checkout.php" class="btn-pay">Gerar Código PIX</a>
            </div>

            <div class="footer-info">
                 Ambiente 100% Seguro. Seus dados estão protegidos.<br>
                © 2026 Correios - Todos os direitos reservados.
            </div>
        </div>
    </div>

</body>
</html>