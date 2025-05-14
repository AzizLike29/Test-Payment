<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Layanan Payment</title>
</head>

<body>
  <?= $this->include('partials/navbar') ?>

  <?= $this->renderSection('content') ?>

  <script src="<?= base_url('assets/js/payment.js') ?>"></script>
</body>

</html>