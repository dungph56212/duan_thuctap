<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      By <b>Team 9</b> 
    </div>
    <strong>Website bán sách</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./assets/plugins/jszip/jszip.min.js"></script>
<script src="./assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="./assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./assets/dist/js/demo.js"></script>

<!-- Comment Management Scripts -->
<style>
/* Comment Management Sidebar Styling */
.nav-item .nav-link .fas.fa-comments {
    color: #17a2b8;
}

.nav-treeview .nav-item .nav-link:hover {
    background-color: #495057;
}

#pending-comments-badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>

<script>
$(document).ready(function() {
    // Load pending comments count for badge
    loadPendingCommentsCount();
    
    // Refresh count every 5 minutes
    setInterval(loadPendingCommentsCount, 300000);
});

function loadPendingCommentsCount() {
    $.ajax({
        url: '<?= BASE_URL_ADMIN ?>?act=get-pending-comments-count',
        method: 'GET',
        success: function(response) {
            if (response.success && response.count > 0) {
                $('#pending-comments-badge').text(response.count).show();
            } else {
                $('#pending-comments-badge').hide();
            }
        },
        error: function() {
            console.log('Error loading pending comments count');
        }
    });
}
</script>

<!-- Page specific script -->