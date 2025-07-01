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

    .modal-body .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .modal-body label {
        font-weight: 500;
    }

    .modal-body img {
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #8B4513;
        border: none;
    }

    .btn-primary:hover {
        background-color: #D2B48C;
        color: #000;
    }

    .btn-success {
        background-color: #2e7d32;
        border: none;
    }

    .btn-success:hover {
        background-color: #7cd17c;
        color: #000;
    }

    .btn-danger {
        background-color: #a94442;
        border: none;
    }

    .btn-danger:hover {
        background-color: #e55f5f;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #a6a6a6;
        color: black;
    }

    .btn-group-action {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .action-bar {
        padding: 0 30px;
        margin-top: 1rem;
    }

    .produk-wrapper {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-top: 10px;
        margin-bottom: 50px;
    }

    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .action-bar .btn {
            width: 100%;
        }
    }
</style>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->getFlashData('failed')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session('role') == 'admin'): ?>
    <div class="action-bar d-flex gap-2 mb-4 px-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
        <a href="<?= base_url('produk/download') ?>" class="btn btn-success">Download Data</a>
    </div>
<?php endif ?>

<div class="produk-wrapper">
    <h3>Produk BLANGKIS</h3><hr>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $index => $produk): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($produk['nama']) ?></td>
                        <td><?= 'Rp ' . number_format($produk['harga'], 0, ',', '.') ?></td>
                        <td><?= esc($produk['jumlah']) ?></td>
                        <td>
                            <?php if ($produk['foto'] && file_exists(FCPATH . 'img/' . $produk['foto'])): ?>
                                <img src="<?= base_url("img/" . $produk['foto']) ?>" width="100px">
                            <?php endif ?>
                        </td>
                        <td class="btn-group-action">
                            <?php if (session('role') == 'admin'): ?>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">Ubah</button>
                                <a href="<?= base_url('produk/delete/' . $produk['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini ?')">Hapus</a>
                            <?php else: ?>
                                <form method="post" action="<?= base_url('keranjang/add') ?>" class="text-center">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $produk['id'] ?>">
                                    <input type="hidden" name="nama" value="<?= $produk['nama'] ?>">
                                    <input type="hidden" name="harga" value="<?= $produk['harga'] ?>">
                                    <input type="hidden" name="foto" value="<?= $produk['foto'] ?>">
                                    <button type="submit" class="btn btn-warning">Beli</button>
                                </form>
                            <?php endif ?>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal-<?= $produk['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="<?= base_url('produk/edit/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" value="<?= esc($produk['nama']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="text" name="harga" class="form-control" value="<?= esc($produk['harga']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="text" name="jumlah" class="form-control" value="<?= esc($produk['jumlah']) ?>" required>
                                        </div>
                                        <?php if ($produk['foto']): ?>
                                            <img src="<?= base_url("img/" . $produk['foto']) ?>" width="100px">
                                        <?php endif ?>
                                        <div class="form-check mt-2 mb-2">
                                            <input class="form-check-input" type="checkbox" name="check" id="check<?= $produk['id'] ?>" value="1">
                                            <label class="form-check-label" for="check<?= $produk['id'] ?>">Ceklis jika ingin mengganti foto</label>
                                        </div>
                                        <div class="form-group">
                                            <label>Foto</label>
                                            <input type="file" class="form-control" name="foto">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Modal -->
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('produk') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" class="form-control" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>