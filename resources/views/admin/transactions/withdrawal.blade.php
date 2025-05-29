@extends('partials.admin')

@section('content')



        <div class="container">
          <div class="page-inner">
                      <div class="page-header">
              <h3 class="fw-bold mb-3">Withdrawal Requests</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="fas fa-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="fas fa-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Tables</a>
                </li>
                <li class="separator">
                  <i class="fas fa-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Withdrawals</a>
                </li>
              </ul>
            </div>
             <div class="row">
              <div class="col-md-12">
                <ul class="nav nav-tabs" id="withdrawalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="successful-tab" data-bs-toggle="tab" data-bs-target="#successful" type="button" role="tab">Successful</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="declined-tab" data-bs-toggle="tab" data-bs-target="#declined" type="button" role="tab">Declined</button>
                </li>
              </ul>

<div class="tab-content mt-4" id="withdrawalTabsContent">
  <div class="tab-pane fade show active" id="pending" role="tabpanel">
  @include('admin.transactions.withdrawal-table', ['withdrawals' => $pending, 'tableId' => 'pendingTable'])
  </div>
  <div class="tab-pane fade" id="successful" role="tabpanel">
@include('admin.transactions.withdrawal-table', ['withdrawals' => $successful, 'tableId' => 'successfulTable'])
  </div>
  <div class="tab-pane fade" id="declined" role="tabpanel">
@include('admin.transactions.withdrawal-table', ['withdrawals' => $declined, 'tableId' => 'declinedTable'])
  </div>
</div>

              </div>
              <div class="col-md-4">
                <canvas id="userChart" width="400" height="300"></canvas>
              </div>
            </div> 
          </div>
        </div>
      </div>

    </div>

   <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="https://cdn.jsdelivr.net/npm/jquery.scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- jQuery Sparkline -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>

<!-- Chart Circle (Circles.js) -->
<script src="https://cdn.jsdelivr.net/npm/circles.js@0.0.6/circles.min.js"></script>


<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<!-- Bootstrap Notify -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@0.2.0/bootstrap-notify.min.js"></script>

<!-- jsvectormap -->
<script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if (!empty($withdrawals) && $withdrawals->count() > 0)
<script>
$(document).ready(function () {
  // Initialize the default active tab's table
  $('#pendingTable').DataTable({
    paging: true,
    searching: true,
    ordering: true
  });

  // Re-initialize DataTables when switching tabs
  $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    const targetId = $(e.target).attr('data-bs-target'); // e.g., "#successful"
    const table = $(`${targetId} table`);

    if (table.length && !$.fn.DataTable.isDataTable(table)) {
      table.DataTable({
        paging: true,
        searching: true,
        ordering: true
      });
    }
  });
});
</script>
@endif

  @endsection