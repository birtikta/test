<?php
// ============================================
// PHP ÖZELLİKLERİ OLAN BASİT MODÜLER SAYFA
// Test commit - Branch Protection Test
// ============================================

session_start();

//api key silindi. 3

// Ziyaretçi sayacı (session bazlı)
if (!isset($_SESSION['ziyaret_sayisi'])) {
    $_SESSION['ziyaret_sayisi'] = 1;
} else {
    $_SESSION['ziyaret_sayisi']++;
}

// Form işleme
$mesaj = '';
$hesap_sonuc = '';

// İletişim formu işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_tipi'])) {
    if ($_POST['form_tipi'] === 'iletisim') {
        $ad = htmlspecialchars($_POST['ad'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $mesaj_icerik = htmlspecialchars($_POST['mesaj'] ?? '');
        
        if (!empty($ad) && !empty($email) && !empty($mesaj_icerik)) {
            $mesaj = "✅ Teşekkürler $ad! Mesajınız alındı.";
        } else {
            $mesaj = "❌ Lütfen tüm alanları doldurun.";
        }
    }
    
    // Hesap makinesi işleme
    if ($_POST['form_tipi'] === 'hesap') {
        $sayi1 = floatval($_POST['sayi1'] ?? 0);
        $sayi2 = floatval($_POST['sayi2'] ?? 0);
        $islem = $_POST['islem'] ?? '+';
        
        switch ($islem) {
            case '+': $hesap_sonuc = $sayi1 + $sayi2; break;
            case '-': $hesap_sonuc = $sayi1 - $sayi2; break;
            case '*': $hesap_sonuc = $sayi1 * $sayi2; break;
            case '/': $hesap_sonuc = $sayi2 != 0 ? $sayi1 / $sayi2 : 'Sıfıra bölünemez!'; break;
        }
        $hesap_sonuc = "Sonuç: $sayi1 $islem $sayi2 = $hesap_sonuc";
    }
}

// Türkçe tarih fonksiyonu
function turkce_tarih() {
    $gunler = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
    $aylar = ['', 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 
              'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
    
    $gun = $gunler[date('w')];
    $ay = $aylar[date('n')];
    
    return $gun . ', ' . date('d') . ' ' . $ay . ' ' . date('Y') . ' - ' . date('H:i:s');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Modüler Sayfa</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: #ffffff;
            min-height: 100vh; 
            padding: 20px;
        }
        .container { max-width: 1000px; margin: 0 auto; }
        h1 { text-align: center; color: #000000; margin-bottom: 30px; }
        .modules { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .module { 
            background: #f9f9f9; 
            border-radius: 15px; 
            padding: 25px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }
        .module h2 { 
            color: #000000; 
            margin-bottom: 15px; 
            padding-bottom: 10px; 
            border-bottom: 2px solid #eee; 
        }
        .tarih-box { 
            background: #000000; 
            color: white; 
            padding: 20px; 
            border-radius: 10px; 
            text-align: center; 
            font-size: 1.2em;
        }
        .ziyaret { 
            background: #f5f5f5; 
            padding: 15px; 
            border-radius: 10px; 
            text-align: center; 
            margin-top: 15px;
        }
        .ziyaret span { font-size: 2em; color: #000000; font-weight: bold; }
        form { display: flex; flex-direction: column; gap: 10px; }
        input, textarea, select, button { 
            padding: 12px; 
            border: 2px solid #eee; 
            border-radius: 8px; 
            font-size: 1em;
        }
        input:focus, textarea:focus, select:focus { border-color: #000000; outline: none; }
        button { 
            background: #000000; 
            color: white; 
            border: none; 
            cursor: pointer; 
            font-weight: bold;
            transition: transform 0.2s;
        }
        button:hover { transform: scale(1.02); background: #333; }
        .alert { padding: 15px; border-radius: 8px; margin-top: 15px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .hesap-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .hesap-row input { flex: 2; min-width: 80px; }
        .hesap-row select { flex: 1; min-width: 60px; }
        .sonuc { 
            background: #000000; 
            color: white; 
            padding: 15px; 
            border-radius: 8px; 
            text-align: center; 
            font-size: 1.2em;
            margin-top: 15px;
        }
        .info-list { list-style: none; }
        .info-list li { 
            padding: 10px; 
            border-bottom: 1px solid #eee; 
            display: flex; 
            justify-content: space-between;
        }
        .info-list li:last-child { border-bottom: none; }
        .info-list .label { color: #666; }
        .info-list .value { color: #000000; font-weight: bold; }
    </style>
</head>
<body>
    <script src="assets/js/app.js" defer></script>
    <div class="container">
        <h1>🚀 PHP Modüler Sayfa</h1>
        
        <div class="modules">
            <!-- MODÜL 1: TARİH & SAAT -->
            <div class="module">
                <h2>📅 Tarih & Saat</h2>
                <div class="tarih-box">
                    <?php echo turkce_tarih(); ?>
                </div>
                <div class="ziyaret">
                    <p>Bu oturumda sayfa</p>
                    <span><?php echo $_SESSION['ziyaret_sayisi']; ?></span>
                    <p>kez görüntülendi</p>
                </div>
            </div>
            
            <!-- MODÜL 2: İLETİŞİM FORMU -->
            <div class="module">
                <h2>📧 İletişim Formu</h2>
                <form method="POST">
                    <input type="hidden" name="form_tipi" value="iletisim">
                    <input type="text" name="ad" placeholder="Adınız" value="<?php echo $_POST['ad'] ?? ''; ?>">
                    <input type="email" name="email" placeholder="E-posta adresiniz" value="<?php echo $_POST['email'] ?? ''; ?>">
                    <textarea name="mesaj" rows="3" placeholder="Mesajınız"><?php echo $_POST['mesaj'] ?? ''; ?></textarea>
                    <button type="submit">Gönder</button>
                </form>
                <?php if ($mesaj): ?>
                    <div class="alert <?php echo strpos($mesaj, '✅') !== false ? 'alert-success' : 'alert-error'; ?>">
                        <?php echo $mesaj; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- MODÜL 3: HESAP MAKİNESİ -->
            <div class="module">
                <h2>🔢 Hesap Makinesi</h2>
                <form method="POST">
                    <input type="hidden" name="form_tipi" value="hesap">
                    <div class="hesap-row">
                        <input type="number" name="sayi1" placeholder="Sayı 1" step="any" value="<?php echo $_POST['sayi1'] ?? ''; ?>">
                        <select name="islem">
                            <option value="+" <?php echo ($_POST['islem'] ?? '') === '+' ? 'selected' : ''; ?>>+</option>
                            <option value="-" <?php echo ($_POST['islem'] ?? '') === '-' ? 'selected' : ''; ?>>-</option>
                            <option value="*" <?php echo ($_POST['islem'] ?? '') === '*' ? 'selected' : ''; ?>>×</option>
                            <option value="/" <?php echo ($_POST['islem'] ?? '') === '/' ? 'selected' : ''; ?>>÷</option>
                        </select>
                        <input type="number" name="sayi2" placeholder="Sayı 2" step="any" value="<?php echo $_POST['sayi2'] ?? ''; ?>">
                    </div>
                    <button type="submit">Hesapla</button>
                </form>
                <?php if ($hesap_sonuc): ?>
                    <div class="sonuc"><?php echo $hesap_sonuc; ?></div>
                <?php endif; ?>
            </div>
            
            <!-- MODÜL 4: SUNUCU BİLGİLERİ -->
            <div class="module">
                <h2>💻 Sistem Bilgileri</h2>
                <ul class="info-list">
                    <li>
                        <span class="label">PHP Sürümü</span>
                        <span class="value"><?php echo phpversion(); ?></span>
                    </li>
                    <li>
                        <span class="label">Sunucu</span>
                        <span class="value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Bilinmiyor'; ?></span>
                    </li>
                    <li>
                        <span class="label">IP Adresiniz</span>
                        <span class="value"><?php echo $_SERVER['REMOTE_ADDR'] ?? 'Bilinmiyor'; ?></span>
                    </li>
                    <li>
                        <span class="label">Tarayıcı</span>
                        <span class="value"><?php 
                            $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
                            if (strpos($ua, 'Chrome') !== false) echo 'Chrome';
                            elseif (strpos($ua, 'Firefox') !== false) echo 'Firefox';
                            elseif (strpos($ua, 'Safari') !== false) echo 'Safari';
                            elseif (strpos($ua, 'Edge') !== false) echo 'Edge';
                            else echo 'Diğer';
                        ?></span>
                    </li>
                    <li>
                        <span class="label">İşletim Sistemi</span>
                        <span class="value"><?php echo php_uname('s'); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>