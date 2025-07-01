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
  <h3>Daftar Konsumen</h3>
  <hr>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>No.</th>
          <th>Username</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($user)): ?>
          <?php foreach ($user as $index => $item): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= esc($item['username']) ?></td>
              <td><?= esc($item['email']) ?></td>
            </tr>
          <?php endforeach ?>
        <?php else: ?>
          <tr>
            <td colspan="3">Belum ada konsumen terdaftar.</td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
