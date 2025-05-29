@extends('partials.admin')

@section('content')



        <div class="container">
          <div class="page-inner">
                      <div class="page-header">
              <h3 class="fw-bold mb-3">Transactions</h3>
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
                  <a href="#">Transaction</a>
                </li>
              </ul>
            </div>
             <div class="row">
              <div class="col-md-12">
                 <div class="table-responsive">
                      <table id="myTable"
                        class="display table table-striped table-hover"
                      >
                    <thead>
                          <tr>
                            <th>Reference_id</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Receiver</th>
                            <th>Sender</th>
                            <th>Amount</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->reference_id}}</td>
                                    <td> {{$transaction->status}}</td>
                                    <td> {{$transaction->type}}</td>
                                    <td>{{$transaction->user->first_name." ". $transaction->user->last_name}}</td>
                                    <td>{{$transaction->reserveItem->name ?? $transaction->user->first_name." ". $transaction->user->last_name}}</td>
                                    <td>{{$transaction->reserveItem->amount ?? $transaction->amount}}</td>
                                    <td>
                                    <button data-bs-toggle="modal" data-bs-target="#userModal{{ $transaction['id'] }}">
                                      <i class="fas fa-eye"></i>
                                    </button>

                                       <!-- Modal -->
                                <div class="modal fade" id="userModal{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel{{ $transaction->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content p-4 rounded-4">
                                      <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Transaction Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                     
                                      <div class="modal-body"> 
                                        @if ($transaction->withdrawal_id)
                                            <h3>Withdrawal Request</h3><br>
                                            <div class="d-flex align-items-center mb-4">
                                              <div class="me-3">
                                                @if ($transaction->user->profile_picture)
                                                    <img src="{{  asset('user/image/'.$transaction->user->profile_picture)}}" alt="User Image" class="rounded-circle" width="60" height="60">
                                                    @else
                                                    <img src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="rounded-circle" width="60" height="60">
                                                @endif
                                              </div>
                                              <div>
                                                <h6 class="mb-0">{{$transaction->user->first_name." ". $transaction->user->last_name}}</h6>
                                                <small class="text-muted">{{$transaction->user->email?? " " }} </small></br>
                                              </div>
                                            </div>
                                            <div class="row text-center mb-4">
                                              <div class="col-md-2"></div>
                                              <div class="col-md-4">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                    ₦{{ number_format($transaction->amount ?? 0, 2) }}
                                                  </div>
                                                  <small class="text-muted">Amount</small>
                                                </div>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                    {{$transaction->withdrawal->bankAccount->account_number}}
                                                  </div>
                                                  <small class="text-muted">Account Number</small>
                                                </div>
                                              </div>
                                              <div class="col-md-2"></div>
                                              <div class="col-md-6 mt-2">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                  {{$transaction->withdrawal->bankAccount->bank_name}}
                                                  </div>
                                                  <small class="text-muted">Bank Name</small>
                                                </div>
                                              </div>
                                              <div class="col-md-6 mt-2">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                    {{$transaction->withdrawal->bankAccount->account_name}}
                                                  </div>
                                                  <small class="text-muted">Account Name</small>
                                                </div>
                                              </div>
                                            </div>
                                         @else
                                            <h3>Payment</h3><br>
                                            <div class="d-flex align-items-center mb-4">
                                              <div>
                                                  <h6 class="mb-0">{{$transaction->reserveItem->name}}</h6>
                                                <small class="text-muted">{{$transaction->reserveItem->email?? " " }} </small></br>
                                              </div>
                                            </div>
                                            <h3>Receiver</h3><br>
                                            <div class="d-flex align-items-center mb-4">
                                              <div>
                                                <h6 class="mb-0">{{$transaction->user->first_name." ". $transaction->user->last_name}}</h6>
                                                <small class="text-muted">{{$transaction->user->email?? " " }} </small></br>
                                              </div>
                                            </div>
                                            <div class="row text-center mb-4">
                                              <div class="col-md-2"></div>
                                              <div class="col-md-4">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                    ₦{{ number_format($transaction->reserveItem->amount ?? 0, 2) }}
                                                  </div>
                                                  <small class="text-muted">Amount Sent</small>
                                                </div>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                    ₦{{ number_format($transaction->amount ?? 0, 2) }}
                                                  </div>
                                                  <small class="text-muted">Amount Received by receiver</small>
                                                </div>
                                              </div>
                                              <div class="col-md-2"></div>
                                              <div class="col-md-3"></div>

                                               <div class="col-md-6 mt-2">
                                                <div class="border rounded p-3">
                                                  <div class="fw-bold fs-5">
                                                    {{$transaction->reserveItem->money->wishlist->title}}
                                                  </div>
                                                  <small class="text-muted">Wishlist Name</small>
                                                </div>
                                              </div>
                                            </div>
                                          @endif
                                       
                                      </div>

                                      <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                      </table>
                      
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
<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      paging: true,     // Enables pagination
      searching: true,  // Enables search box
      ordering: true    // Enables sorting on columns
    });
  });
</script>

  @endsection