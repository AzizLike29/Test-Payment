<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto mt-10 px-4">
  <h2 class="text-2xl font-bold mb-6 text-gray-700">Data Produk</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-3 text-left">Nama Produk</th>
          <th class="px-4 py-3 text-left">Harga</th>
          <th class="px-4 py-3 text-left">Tanggal Dibuat</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="px-4 py-3"><?= esc($product['product_name']) ?></td>
              <td class="px-4 py-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
              <td class="px-4 py-3"><?= $product['created_at'] ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3" class="px-4 py-4 text-center text-gray-500">Tidak ada data produk.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>