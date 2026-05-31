<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Gestion Stock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow: hidden;
        }

        /* Background decoration */
        .bg-decoration {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.06;
        }

        .bg-circle-1 {
            width: 600px; height: 600px;
            background: #2563eb;
            top: -200px; right: -100px;
        }

        .bg-circle-2 {
            width: 400px; height: 400px;
            background: #7c3aed;
            bottom: -100px; left: -100px;
        }

        .bg-dots {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image: radial-gradient(circle, #2563eb 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.04;
            pointer-events: none;
        }

        /* Layout */
        .login-container {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 24px;
            gap: 0;
        }

        /* Left panel */
        .login-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 60px;
            max-width: 520px;
            margin: 0 auto;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 14px rgba(37,99,235,.3);
        }

        .logo-name {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.4px;
        }

        .login-heading {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.6px;
            margin-bottom: 8px;
        }

        .login-sub {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        /* Card */
        .login-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 8px 32px rgba(0,0,0,.08), 0 2px 8px rgba(0,0,0,.04);
        }

        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 13px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            transition: all 0.15s;
            outline: none;
        }

        .form-input:focus {
            background: white;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .form-input::placeholder { color: #cbd5e1; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 16px 0 20px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.12s;
        }
        .forgot-link:hover { opacity: 0.7; }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: white;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 14px rgba(37,99,235,.3);
            letter-spacing: 0.01em;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            box-shadow: 0 6px 20px rgba(37,99,235,.4);
            transform: translateY(-1px);
        }

        .btn-login:active { transform: translateY(0); }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 12.5px;
            color: #dc2626;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .status-box {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 12.5px;
            color: #059669;
            margin-bottom: 16px;
        }

        /* Demo accounts */
        .demo-section {
            margin-top: 20px;
        }

        .demo-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .demo-label::before,
        .demo-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .demo-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            padding: 8px 10px;
            cursor: pointer;
            transition: all 0.12s;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }

        .demo-btn:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .demo-email {
            font-size: 11.5px;
            color: #0f172a;
            font-weight: 500;
            display: block;
            margin-bottom: 2px;
        }

        .demo-role {
            font-size: 10.5px;
            color: #2563eb;
            background: #eff6ff;
            padding: 1px 5px;
            border-radius: 3px;
            display: inline-block;
        }

        /* Right panel illustration */
        .login-right {
            flex: 1;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        @media (min-width: 1024px) {
            .login-right { display: flex; }
            .login-left { margin: 0; }
        }

        .illustration-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 28px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 16px 48px rgba(0,0,0,.1);
        }

        .illus-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .illus-title {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
        }

        .illus-badge {
            font-size: 11px;
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            border-radius: 99px;
            padding: 2px 8px;
            font-weight: 500;
        }

        .illus-stats {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .illus-stat {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 10px;
            text-align: center;
        }

        .illus-stat-val {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.4px;
        }

        .illus-stat-lbl {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .illus-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 12.5px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
        }

        .illus-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .illus-row-name { color: #374151; font-weight: 500; flex: 1; padding: 0 10px; }
        .illus-row-val  { color: #2563eb; font-weight: 600; font-size: 12px; }

        .feature-list {
            margin-top: 32px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .feature-icon {
            width: 32px; height: 32px;
            background: #eff6ff;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 13.5px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .feature-desc {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="bg-decoration">
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
</div>
<div class="bg-dots"></div>

<div class="login-container">

    {{-- ── LEFT PANEL ── --}}
    <div class="login-left">

        <div class="login-logo">
            <div class="logo-icon">📦</div>
            <span class="logo-name">Gestion Stock</span>
        </div>

        <h1 class="login-heading">Bon retour 👋</h1>
        <p class="login-sub">
            Connectez-vous pour accéder à votre<br>
            tableau de bord de gestion.
        </p>

        <div class="login-card">

            @if($errors->any())
            <div class="error-box">
                <span>⚠</span>
                <div>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            </div>
            @endif

            @if (session('status'))
            <div class="status-box">✓ &nbsp;{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Adresse email</label>
                    <input type="email" id="email" name="email"
                           class="form-input"
                           value="{{ old('email') }}"
                           placeholder="vous@entreprise.com"
                           required autofocus autocomplete="email">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password"
                           class="form-input"
                           placeholder="••••••••"
                           required autocomplete="current-password">
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Se connecter →
                </button>
            </form>

            <div class="demo-section">
                <div class="demo-label">Comptes de démonstration</div>
                <div class="demo-grid">
                    <button class="demo-btn" onclick="fillLogin('admin@demo.com')">
                        <span class="demo-email">admin@demo.com</span>
                        <span class="demo-role">Administrateur</span>
                    </button>
                    <button class="demo-btn" onclick="fillLogin('gestionnaire@demo.com')">
                        <span class="demo-email">gestionnaire@demo.com</span>
                        <span class="demo-role">Gestionnaire</span>
                    </button>
                    <button class="demo-btn" onclick="fillLogin('caissier@demo.com')">
                        <span class="demo-email">caissier@demo.com</span>
                        <span class="demo-role">Caissier</span>
                    </button>
                    <button class="demo-btn" onclick="fillLogin('magasinier@demo.com')">
                        <span class="demo-email">magasinier@demo.com</span>
                        <span class="demo-role">Magasinier</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="login-right">

        <div class="illustration-card">
            <div class="illus-header">
                <span class="illus-title">📊 Aperçu du système</span>
                <span class="illus-badge">En direct</span>
            </div>

            <div class="illus-stats">
                <div class="illus-stat">
                    <div class="illus-stat-val">247</div>
                    <div class="illus-stat-lbl">Produits</div>
                </div>
                <div class="illus-stat">
                    <div class="illus-stat-val" style="color:#2563eb;">38</div>
                    <div class="illus-stat-lbl">Clients</div>
                </div>
                <div class="illus-stat">
                    <div class="illus-stat-val" style="color:#059669;">12</div>
                    <div class="illus-stat-lbl">Commandes</div>
                </div>
            </div>

            <div class="illus-row">
                <div class="illus-dot" style="background:#2563eb;"></div>
                <span class="illus-row-name">Eau minérale 500ml</span>
                <span class="illus-row-val">50 cartons</span>
            </div>
            <div class="illus-row">
                <div class="illus-dot" style="background:#059669;"></div>
                <span class="illus-row-name">Riz parfumé 5kg</span>
                <span class="illus-row-val">80 sacs</span>
            </div>
            <div class="illus-row">
                <div class="illus-dot" style="background:#d97706;"></div>
                <span class="illus-row-name">Huile de palme 1L</span>
                <span class="illus-row-val" style="color:#dc2626;">⚠ 5 litres</span>
            </div>
            <div class="illus-row">
                <div class="illus-dot" style="background:#7c3aed;"></div>
                <span class="illus-row-name">Savon Omo 250g</span>
                <span class="illus-row-val">100 pièces</span>
            </div>
        </div>

        <div class="feature-list" style="max-width:380px; width:100%;">
            <div class="feature-item">
                <div class="feature-icon">📦</div>
                <div>
                    <div class="feature-title">Gestion des stocks en temps réel</div>
                    <div class="feature-desc">Suivez vos entrées, sorties et alertes de rupture automatiquement.</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🧾</div>
                <div>
                    <div class="feature-title">Facturation & impressions PDF</div>
                    <div class="feature-desc">Générez vos factures, bons et reçus en un clic.</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📊</div>
                <div>
                    <div class="feature-title">Rapports & statistiques</div>
                    <div class="feature-desc">Analysez vos achats et ventes par jour, par mois ou par année.</div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function fillLogin(email) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = 'password';
}
</script>
</body>
</html>
