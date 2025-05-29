<?php
function readCcn()
{
    $file = "../.ccn";
    $data = [];
    if (!file_exists($file)) return $data;
    foreach (file($file) as $line) {
        if (trim($line) === '' || str_starts_with(trim($line), '#')) continue;
        [$key, $val] = explode('=', $line, 2) + [null, null];
        if ($key !== null) $data[trim($key)] = trim($val);
    }
    return $data;
}
function writeCcn($key, $value = "")
{
    $file = "../.ccn";
    $data = readCcn($file);
    $data[$key] = $value;
    $lines = [];
    foreach ($data as $k => $v) $lines[] = "$k=$v";
    file_put_contents($file, implode(PHP_EOL, $lines));
}
function api($endpoint, $method = 'GET', $data = null, $bearerToken = null)
{
    $readccn = readCcn();
    $url = $readccn['URL_SERVER']."/ccn/$endpoint";
    $ch = curl_init();

    // Tambahkan query string jika GET dan data tersedia
    if (strtoupper($method) === 'GET' && $data) {
        $url .= '?' . http_build_query($data);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set HTTP Method
    switch (strtoupper($method)) {
        case 'POST':
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            break;
        case 'DELETE':
        case 'DESTROY': // alias untuk DELETE
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            break;
            // default GET sudah ditangani di atas
    }

    // Header default
    $headers = ['Content-Type: application/x-www-form-urlencoded'];

    // Tambahkan Authorization jika token diberikan
    if ($bearerToken) {
        $headers[] = 'Authorization: Bearer ' . $bearerToken;
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Eksekusi
    $response = curl_exec($ch);
    return $response;
    curl_close($ch);
}

function dated($dated = null){
    if($dated == null){
        $result = date('d/m/Y H:i:s');
    }
    else{
        $date = new DateTime($dated);
        $result = $date->format('d/m/Y H:i:s');
    }
    return $result;
}

function health(array $data){
    // Pastikan array tidak kosong untuk menghindari pembagian dengan 0
    if (empty($responTimes)) {
        return 0;
    }
    
    // Hitung total semua nilai
    $total = array_sum($responTimes);
    
    // Hitung rata-rata
    $rataRata = $total / count($responTimes);
    
    return $rataRata;
}

?>