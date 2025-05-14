<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
    <?php if ($status == 'success'): ?>
      <h2 class="text-2xl font-bold mb-4 text-green-600 text-center">Pembayaran Berhasil Dibuat</h2>
      <p><strong>Nomor Virtual Account:</strong> <?= $va_number ?></p>
      <p><strong>Bank:</strong> <?= $bank ?></p>
      <p><strong>Jumlah:</strong> Rp <?= number_format((float)$amount, 0, ',', '.') ?></p>
      <p class="mt-4">Silahkan lakukan pembayaran melalui ATM, mobile banking, atau internet banking</p>
    <?php else: ?>
      <h2 class="text-2xl font-bold mb-4 text-red-600 text-center">Pembayaran Gagal</h2>
      <p><strong>Error:</strong> <?= esc($message) ?></p>
    <?php endif; ?>
    <div class="mt-6 text-center">
      <a href="<?= base_url('payment') ?>" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Kembali</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>