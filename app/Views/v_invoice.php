<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            color: #8B4513;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Invoice #<?= $transaksi['id'] ?></h2>
    <p><strong>Tanggal:</strong> <?= $transaksi['created_at'] ?></p>
    <p><strong>Nama:</strong> <?= $transaksi['username'] ?></p>
    <p><strong>Alamat:</strong> <?= $transaksi['alamat'] ?></p>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $item): ?>
                <tr>
                    <td><?= $item['nama'] ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($item['subtotal_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><strong>Ongkir:</strong> Rp <?= number_format($transaksi['ongkir'], 0, ',', '.') ?></p>
    <p><strong>Total:</strong> Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></p>
</body>

</html>