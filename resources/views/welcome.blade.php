<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitium - Sistem Undangan</title>
    <style>
        :root {
            --primary: #795757;
            --secondary: #FFF0D1;
            --accent: #A9907E;
            --white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--white) 100%);
            min-height: 100vh;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .welcome-container {
            text-align: center;
            background: var(--white);
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        
        .logo {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .subtitle {
            font-size: 1.3rem;
            color: var(--accent);
            margin-bottom: 40px;
        }
        
        .description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 40px;
            color: #666;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: #654848;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(121, 87, 87, 0.3);
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }
        
        .feature {
            background: var(--secondary);
            padding: 20px;
            border-radius: 10px;
            text-align: left;
        }
        
        .feature h3 {
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .feature p {
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1 class="logo">Invitium</h1>
        <p class="subtitle">Sistem Pembuat Undangan Formal</p>
        <p class="description">
            Buat undangan formal dengan mudah dan profesional. Sistem otomatis untuk generate nomor surat, 
            form data yang lengkap, dan cetak undangan terpisah untuk setiap penerima.
        </p>
        
        <a href="{{ route('invitations.create') }}" class="btn">Mulai Buat Undangan</a>
        
        <div class="features">
            <div class="feature">
                <h3>Form Bertahap</h3>
                <p>Form data dengan 2 tahap yang mudah digunakan</p>
            </div>
            <div class="feature">
                <h3>Upload File</h3>
                <p>Kop surat, lampiran, dan e-signature</p>
            </div>
            <div class="feature">
                <h3>Multi Penerima</h3>
                <p>Undangan terpisah untuk setiap penerima</p>
            </div>
            <div class="feature">
                <h3>Nomor Otomatis</h3>
                <p>Generate nomor surat secara otomatis</p>
            </div>
        </div>
    </div>
</body>
</html>