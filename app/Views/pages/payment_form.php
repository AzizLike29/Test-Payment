<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center">
      Pembayaran Virtual Account
    </h2>
    <form id="paymentForm" action="<?= base_url('payment/createVA') ?>" method="POST">
      <!-- Nama -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded" required>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded" required>
      </div>

      <!-- Phone -->
      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" id="phone" name="phone" class="mt-1 p-2 w-full border rounded" required>
      </div>

      <!-- Amount -->
      <div class="mb-4">
        <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (IDR)</label>
        <input type="number" id="amount" name="amount" class="mt-1 p-2 w-full border rounded" required>
      </div>

      <!-- Bank -->
      <div class="mb-4">
        <label for="bank" class="block text-sm font-medium text-gray-700">Bank</label>
        <select id="bank" name="bank" class="mt-1 p-2 w-full border rounded-md">
          <option selected disabled value="">--Pilih Bank--</option>
          <option value="BCA">BCA</option>
          <option value="BNI">BNI</option>
          <option value="BRI">BRI</option>
          <option value="Mandiri">Mandiri</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Buat Pembayaran</button>
    </form>
  </div>
</div>
<?= $this->endSection() ?>