<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<h1>Transaction Response</h1>
<pre><?php print_r($response); ?></pre>
<?= $this->endSection() ?>