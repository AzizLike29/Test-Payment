document.getElementById("paymentForm").addEventListener(submit, function (e) {
  const amount = document.getElementById("amount").value;
  const phone = document.getElementById("phone").value;

  if (amount < 2000) {
    e.preventDefault();
    alert("Jumlah minimal adalah Rp. 10.000");
    return;
  }

  if (!/^\d{10,13}$/.test(phone)) {
    e.preventDefault;
    alert("Nomor telepon tidak valid");
    return;
  }
});
