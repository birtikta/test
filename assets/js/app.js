/**
 * ===========================================
 * 🚀 PHP Modüler Sayfa - JavaScript
 * ===========================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================
    // 1️⃣ Canlı Saat Güncelleme
    // =========================================
    const tarihBox = document.querySelector('.tarih-box');
    
    function saatGuncelle() {
        const simdi = new Date();
        const gunler = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
        const aylar = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 
                       'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
        
        const gun = gunler[simdi.getDay()];
        const ay = aylar[simdi.getMonth()];
        const tarih = `${gun}, ${simdi.getDate()} ${ay} ${simdi.getFullYear()}`;
        const saat = simdi.toLocaleTimeString('tr-TR');
        
        if (tarihBox) {
            tarihBox.textContent = `${tarih} - ${saat}`;
        }
    }
    
    // Her saniye güncelle
    setInterval(saatGuncelle, 1000);

    // =========================================
    // 2️⃣ Form Validasyonu
    // =========================================
    const iletisimForm = document.querySelector('form[action*="iletisim"], form:has(input[name="form_tipi"][value="iletisim"])');
    
    function formValidasyonu(form) {
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            const ad = form.querySelector('input[name="ad"]');
            const email = form.querySelector('input[name="email"]');
            const mesaj = form.querySelector('textarea[name="mesaj"]');
            
            let hatalar = [];
            
            if (ad && ad.value.trim().length < 2) {
                hatalar.push('Ad en az 2 karakter olmalı');
            }
            
            if (email && !isValidEmail(email.value)) {
                hatalar.push('Geçerli bir e-posta adresi girin');
            }
            
            if (mesaj && mesaj.value.trim().length < 10) {
                hatalar.push('Mesaj en az 10 karakter olmalı');
            }
            
            if (hatalar.length > 0) {
                e.preventDefault();
                alert('⚠️ Hatalar:\n\n' + hatalar.join('\n'));
            }
        });
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Tüm formları bul ve validasyon ekle
    document.querySelectorAll('form').forEach(formValidasyonu);

    // =========================================
    // 3️⃣ Hesap Makinesi Geliştirmeleri
    // =========================================
    const hesapForm = document.querySelector('form:has(input[name="sayi1"])');
    
    if (hesapForm) {
        const sayi1Input = hesapForm.querySelector('input[name="sayi1"]');
        const sayi2Input = hesapForm.querySelector('input[name="sayi2"]');
        const islemSelect = hesapForm.querySelector('select[name="islem"]');
        
        // Anlık hesaplama (opsiyonel önizleme)
        function anlikHesapla() {
            const sayi1 = parseFloat(sayi1Input?.value) || 0;
            const sayi2 = parseFloat(sayi2Input?.value) || 0;
            const islem = islemSelect?.value || '+';
            
            let sonuc;
            switch (islem) {
                case '+': sonuc = sayi1 + sayi2; break;
                case '-': sonuc = sayi1 - sayi2; break;
                case '*': sonuc = sayi1 * sayi2; break;
                case '/': sonuc = sayi2 !== 0 ? sayi1 / sayi2 : 'Hata'; break;
                default: sonuc = 0;
            }
            
            console.log(`Önizleme: ${sayi1} ${islem} ${sayi2} = ${sonuc}`);
        }
        
        // Input değişikliklerinde konsola yazdır
        [sayi1Input, sayi2Input, islemSelect].forEach(el => {
            if (el) el.addEventListener('input', anlikHesapla);
        });
    }

    // =========================================
    // 4️⃣ Sayfa Yüklenme Animasyonu
    // =========================================
    const modules = document.querySelectorAll('.module');
    
    modules.forEach((module, index) => {
        module.style.opacity = '0';
        module.style.transform = 'translateY(20px)';
        module.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            module.style.opacity = '1';
            module.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // =========================================
    // 5️⃣ Console Hoşgeldin Mesajı
    // =========================================
    console.log('%c🚀 PHP Modüler Sayfa', 'font-size: 20px; font-weight: bold; color: #000;');
    console.log('%cJavaScript yüklendi!', 'color: #666;');
});
