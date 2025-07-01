<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    h3 {
        font-weight: 600;
        color: #8B4513;
    }

    .table th {
        background-color: #8B4513;
        color: white;
        text-align: center;
    }

    .table td,
    .table th {
        vertical-align: middle;
        text-align: center;
    }

    .produk-wrapper {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-top: 10px;
        margin-bottom: 50px;
    }
</style>

<div class="produk-wrapper">
    <h3>Laporan Penjualan</h3>

    <form method="get" action="<?= base_url('laporan') ?>" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="date" name="start" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="date" name="end" class="form-control" required>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>ID Transaksi</th>
                <th>Username</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($buy as $row): ?>
                <?php
                $idTransaksi = $row['id'];
                $username = $row['username'];
                $created_at = $row['created_at'];
                $total = $row['total_harga'];
                ?>
                <?php if (isset($detail[$idTransaksi])): ?>
                    <?php foreach ($detail[$idTransaksi] as $item): ?>
                        <tr>
                            <td><?= $idTransaksi ?></td>
                            <td><?= esc($username) ?></td>
                            <td><?= esc($item['nama_produk']) ?></td>
                            <td><?= $item['jumlah'] ?> pcs</td>
                            <td><?= 'Rp ' . number_format($total, 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y', strtotime($created_at)) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php
    $totalPendapatan = 0;
    foreach ($buy as $row) {
        $totalPendapatan += $row['total_harga'];
    }
    ?>

    <div class="mt-3 fw-bold fs-5">
        Total Pendapatan: <?= 'Rp ' . number_format($totalPendapatan, 0, ',', '.') ?>
    </div>

    <a href="<?= base_url('admin/export-periodik/pdf') ?>" class="btn btn-danger btn-sm mt-2">Export PDF</a>
    <a href="<?= base_url('admin/export-periodik/excel') ?>" class="btn btn-success btn-sm mt-2">Export Excel</a>
</div>

<?= $this->endSection() ?>