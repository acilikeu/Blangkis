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

  .modal-body img {
    margin: 10px 0;
    border-radius: 8px;
  }

  .modal-body strong {
    color: #3E2F1C;
  }

  .modal-body hr {
    border-top: 1px dashed #ccc;
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
    .modal-body {
      font-size: 14px;
    }
  }
</style>

<div class="produk-wrapper">
  <h3>Riwayat Transaksi <strong><?= esc($username) ?></strong></h3>
  <hr>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>No.</th>
          <th>Username</th>
          <th>Waktu</th>
          <th>Total Bayar</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($buy)): ?>
          <?php foreach ($buy as $index => $item): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= esc($item['username']) ?><small class="text-muted">#<?= esc($item['id']) ?></small></td>
              <td><?= esc($item['created_at']) ?></td>
              <td><?= 'Rp ' . number_format($item['total_harga'], 0, ',', '.') ?></td>
              <td><?= esc($item['alamat']) ?></td>
              <td>
                <?php
                if ($item['status'] == 'Selesai') {
                  echo '<span class="text-success">✅ Selesai</span>';
                } elseif ($item['status'] == 'Dikirim') {
                  echo '<span class="text-info">🚚 Dikirim</span>';
                } elseif ($item['status'] == 'Pesanan Diproses') {
                  echo '<span class="text-warning">⏳ Diproses</span>';
                } else {
                  echo '<span class="text-danger">❗ Status Tidak Diketahui</span>';
                }
                ?>
              </td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                    Detail
                  </button>
                  <a href="<?= base_url('invoice/' . $item['id']) ?>" target="_blank" class="btn btn-outline-dark btn-sm">
                    Cetak Nota
                  </a>
                  <?php if ($role == 'admin' && $item['status'] == 'Pesanan Diproses'): ?>
                    <a href="<?= base_url('transaksi/kirim/' . $item['id']) ?>" class="btn btn-info btn-sm">
                      Dikirim
                    </a>
                  <?php endif; ?>
                  <?php if ($role != 'admin' && $item['status'] == 'Dikirim'): ?>
                    <a href="<?= base_url('transaksi/selesai/' . $item['id']) ?>" class="btn btn-warning btn-sm">
                      Diterima
                    </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>

            <!-- Modal Detail -->
            <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi #<?= $item['id'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <?php foreach ($product[$item['id']] as $index2 => $item2): ?>
                      <div>
                        <strong><?= $index2 + 1 ?>. <?= esc($item2['nama']) ?></strong><br>
                        <?php if (!empty($item2['foto']) && file_exists('img/' . $item2['foto'])): ?>
                          <img src="<?= base_url("img/" . $item2['foto']) ?>" width="100px">
                        <?php endif; ?><br>
                        Harga: <?= 'Rp ' . number_format($item2['harga'], 0, ',', '.') ?><br>
                        Jumlah: <?= $item2['jumlah'] ?> pcs<br>
                        Subtotal: <?= 'Rp ' . number_format($item2['subtotal_harga'], 0, ',', '.') ?>
                      </div>
                      <hr>
                    <?php endforeach ?>
                    <strong>Ongkir:</strong> <?= 'Rp ' . number_format($item['ongkir'], 0, ',', '.') ?>
                    <!-- Upload / Lihat Bukti Transfer -->
                    <div class="mt-3">
                      <?php if ($item['status'] != 1 && $role != 'admin'): ?>
                        <form action="<?= base_url('transaksi/upload-bukti/' . $item['id']) ?>" method="post" enctype="multipart/form-data" class="d-inline">
                          <input type="file" name="bukti" accept="image/*,.pdf" required class="form-control form-control-sm mb-2">
                          <button type="submit" class="btn btn-warning btn-sm">Upload Bukti</button>
                        </form>
                      <?php endif; ?>

                      <?php if (!empty($item['bukti_transfer'])): ?>
                        <a href="<?= base_url('uploads/bukti/' . $item['bukti_transfer']) ?>" target="_blank" class="btn btn-outline-info btn-sm mt-2">Lihat Bukti</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Modal -->
          <?php endforeach ?>
        <?php else: ?>
          <tr>
            <td colspan="7">Belum ada transaksi.</td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>