document.getElementById("dateButton").addEventListener("click", function () {
    const dateInput = document.getElementById("dateInput");
    // Membuka picker tanggal
    dateInput.style.display = "block";
    dateInput.focus();
    // Menyembunyikan kembali setelah pemilihan tanggal
    dateInput.addEventListener("change", function () {
      alert(`You selected: ${dateInput.value}`);
      dateInput.style.display = "none";
    });
  });
  