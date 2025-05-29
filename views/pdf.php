<?php
use Dompdf\Dompdf;
$pengajuan = json_decode(api('pengajuan'), true);
$guest     = json_decode(api('guest'), true);
ob_start();
?>

<h2>Clusterin</h2>
<h2>Tanggal: <?= dated() ?></h2>
<br>
<h3>Laporan Pengajuan: <?= count($pengajuan['data']) ?></h3>
<table width="100%" border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Nama Lengkap</th>
        <th>Kategori</th>
        <th>Judul</th>
        <th>Catatan</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>
    <?php foreach ($pengajuan['data'] as $data): 
        $account = json_decode(api('account', 'GET', ['user_token' => $data['user_token']]), true);
    ?>
        <tr>
            <td><?= $account['data']['fullname'] ?></td>
            <td><?= $data['kategori'] ?></td>
            <td><?= $data['judul'] ?></td>
            <td><?= $data['deskripsi'] ?></td>
            <td><?= $data['status'] ?></td>
            <td><?= dated($data['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<h3>Laporan Tamu: <?= count($guest['data']) ?></h3>
<table width="100%" border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Nama Lengkap</th>
        <th>NIK</th>
        <th>Alamat Asal</th>
        <th>Alamat Tujuan</th>
        <th>Alasan</th>
        <th>Masuk</th>
        <th>Keluar</th>
        <th>Whatsapp</th>
        <th>Status</th>
    </tr>
    <?php foreach ($guest['data'] as $data): ?>
        <tr>
            <td><?= $data['fullname'] ?></td>
            <td><?= $data['nik'] ?></td>
            <td><?= $data['address'] ?></td>
            <td><?= $data['destination'] ?></td>
            <td><?= $data['reason'] ?></td>
            <td><?= $data['checkin'] ?></td>
            <td><?= $data['checkout'] ?></td>
            <td><?= $data['whatsapp'] ?></td>
            <td><?= $data['status'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("clusterin.pdf", ["Attachment" => true]);
