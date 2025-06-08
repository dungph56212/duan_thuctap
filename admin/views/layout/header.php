
<!DOCTYPE html>
<html lang="en">
<header>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IPM</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="./assets/plugins/toastr/toastr.min.css">
</header>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<script>
// Global function to update alert count
function updateInventoryAlertBadge() {
    fetch('<?= BASE_URL_ADMIN ?>?act=ajax-get-alerts')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.count > 0) {
                document.getElementById('alert-badge').style.display = 'inline';
                document.getElementById('alert-badge').textContent = data.count;
            } else {
                document.getElementById('alert-badge').style.display = 'none';
            }
        })
        .catch(error => {
            console.log('Error fetching alerts:', error);
        });
}

// Update alert count on page load
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('alert-badge')) {
        updateInventoryAlertBadge();
        // Update every 2 minutes
        setInterval(updateInventoryAlertBadge, 120000);
    }
});
</script>
  