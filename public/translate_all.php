<?php
// =========================================================
// BULK TRANSLATE ALL CONTENT TO ENGLISH
// Jalankan di: https://domain.com/translate_all.php
// =========================================================

$host = 'localhost';
$db = 'u250369146_badan_tanah3';
$user = 'u250369146_btanah3';
$pass = 'Bcr215oke';

// Fungsi translate pake Kimi API
function translateText($text) {
    if (empty($text)) return $text;
    
    $apiKey = 'sk-Vg6wBvLrvbPaXNSd8qJ9roC73OAiZdcxJDpYdKp6OVg1wSN5';
    $url = 'https://api.moonshot.cn/v1/chat/completions';
    
    $data = [
        'model' => 'kimi-k2.5',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a professional translator. Translate the following Indonesian text to English. Keep the meaning, tone, and structure intact. Only return the translated text, nothing else.'
            ],
            [
                'role' => 'user',
                'content' => $text
            ]
        ],
        'temperature' => 0.3,
        'max_tokens' => 4096
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? $text;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>🌍 BULK TRANSLATE ALL CONTENT</h1>";
    echo "<pre>";
    
    // =========================================================
    // 1. TRANSLATE HALAMAN (Tentang, Pemanfaatan, Publikasi)
    // =========================================================
    echo "\n📄 TRANSLATING HALAMAN...\n";
    $stmt = $pdo->query("SELECT id, judul, isi, visi, misi FROM halaman");
    $halaman = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($halaman as $h) {
        echo "  - Halaman ID {$h['id']}: {$h['judul']}\n";
        
        if (empty($h['judul_en'])) {
            $judul_en = translateText($h['judul']);
            $isi_en = translateText($h['isi']);
            $visi_en = !empty($h['visi']) ? translateText($h['visi']) : null;
            $misi_en = !empty($h['misi']) ? translateText($h['misi']) : null;
            
            $update = $pdo->prepare("UPDATE halaman SET judul_en = ?, isi_en = ?, visi_en = ?, misi_en = ? WHERE id = ?");
            $update->execute([$judul_en, $isi_en, $visi_en, $misi_en, $h['id']]);
            echo "    ✅ Translated\n";
        } else {
            echo "    ⏭️ Already translated\n";
        }
    }
    
    // =========================================================
    // 2. TRANSLATE BERITA
    // =========================================================
    echo "\n📰 TRANSLATING BERITA...\n";
    $stmt = $pdo->query("SELECT id, judul, ringkasan, konten FROM berita");
    $berita = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($berita as $b) {
        echo "  - Berita ID {$b['id']}: {$b['judul']}\n";
        
        if (empty($b['judul_en'])) {
            $judul_en = translateText($b['judul']);
            $ringkasan_en = !empty($b['ringkasan']) ? translateText($b['ringkasan']) : null;
            $konten_en = translateText($b['konten']);
            
            $update = $pdo->prepare("UPDATE berita SET judul_en = ?, ringkasan_en = ?, konten_en = ? WHERE id = ?");
            $update->execute([$judul_en, $ringkasan_en, $konten_en, $b['id']]);
            echo "    ✅ Translated\n";
        } else {
            echo "    ⏭️ Already translated\n";
        }
    }
    
    // =========================================================
    // 3. TRANSLATE ASET
    // =========================================================
    echo "\n🏠 TRANSLATING ASET...\n";
    $stmt = $pdo->query("SELECT id, nama_lokasi, deskripsi FROM aset_tanah");
    $aset = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($aset as $a) {
        echo "  - Aset ID {$a['id']}: {$a['nama_lokasi']}\n";
        
        if (empty($a['nama_lokasi_en'])) {
            $nama_en = translateText($a['nama_lokasi']);
            $deskripsi_en = !empty($a['deskripsi']) ? translateText($a['deskripsi']) : null;
            
            $update = $pdo->prepare("UPDATE aset_tanah SET nama_lokasi_en = ?, deskripsi_en = ? WHERE id = ?");
            $update->execute([$nama_en, $deskripsi_en, $a['id']]);
            echo "    ✅ Translated\n";
        } else {
            echo "    ⏭️ Already translated\n";
        }
    }
    
    // =========================================================
    // 4. TRANSLATE FAQ
    // =========================================================
    echo "\n❓ TRANSLATING FAQ...\n";
    $stmt = $pdo->query("SHOW COLUMNS FROM faqs LIKE 'pertanyaan_en'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query("SELECT id, pertanyaan, jawaban FROM faqs");
        $faq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($faq as $f) {
            echo "  - FAQ ID {$f['id']}: {$f['pertanyaan']}\n";
            
            if (empty($f['pertanyaan_en'])) {
                $pertanyaan_en = translateText($f['pertanyaan']);
                $jawaban_en = translateText($f['jawaban']);
                
                $update = $pdo->prepare("UPDATE faqs SET pertanyaan_en = ?, jawaban_en = ? WHERE id = ?");
                $update->execute([$pertanyaan_en, $jawaban_en, $f['id']]);
                echo "    ✅ Translated\n";
            } else {
                echo "    ⏭️ Already translated\n";
            }
        }
    } else {
        echo "  ⚠️ Kolom pertanyaan_en belum ada di tabel faqs, skip\n";
    }
    
    // =========================================================
    // 5. TRANSLATE KARIER
    // =========================================================
    echo "\n💼 TRANSLATING KARIER...\n";
    $stmt = $pdo->query("SHOW COLUMNS FROM kariers LIKE 'judul_en'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query("SELECT id, judul, deskripsi FROM kariers");
        $karier = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($karier as $k) {
            echo "  - Karier ID {$k['id']}: {$k['judul']}\n";
            
            if (empty($k['judul_en'])) {
                $judul_en = translateText($k['judul']);
                $deskripsi_en = translateText($k['deskripsi']);
                
                $update = $pdo->prepare("UPDATE kariers SET judul_en = ?, deskripsi_en = ? WHERE id = ?");
                $update->execute([$judul_en, $deskripsi_en, $k['id']]);
                echo "    ✅ Translated\n";
            } else {
                echo "    ⏭️ Already translated\n";
            }
        }
    } else {
        echo "  ⚠️ Kolom judul_en belum ada di tabel kariers, skip\n";
    }
    
    echo "\n\n✅ SEMUA DATA BERHASIL DITRANSLATE!\n";
    echo "🔗 Sekarang cek website dan klik tombol EN.\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo "</pre>";
?>