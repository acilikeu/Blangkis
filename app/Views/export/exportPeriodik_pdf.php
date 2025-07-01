<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan Periodik</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Laporan Penjualan Periodik</h2>
    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Username</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaksi as $row): ?>
                <?php if (isset($detail[$row['id']])): ?>
                    <?php foreach ($detail[$row['id']] as $d): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $d['nama_produk'] ?></td>
                            <td><?= $d['jumlah'] ?> pcs</td>
                            <td><?= 'Rp ' . number_format($row['total_harga'], 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    </table>
    <hr>
    <h4 style="text-align:right; margin-top:20px;">Total Pendapatan:
        <?= 'Rp ' . number_format($totalPendapatan, 0, ',', '.') ?>
    </h4>
</body>

</html>