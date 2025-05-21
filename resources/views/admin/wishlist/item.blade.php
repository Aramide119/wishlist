@extends('partials.admin')

@section('content')



        <div class="container">
          <div class="page-inner">
                      <div class="page-header">
              <h3 class="fw-bold mb-3">Gift Items</h3>
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
                  <a href="#">Items</a>
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
                            <th width="5%">Item Image</th>
                            <th>Item Name</th>
                            <th>Item Link</th>
                            <th>Wishlist</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (isset($items))
                            @foreach ($items as $wishlist)
                            <tr>
                              <td>@if ($wishlist->image)
                                    <img class="img-fluid" src="{{ asset($wishlist->image) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                    @else
                                    <img class="img-fluid" src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                @endif
                              </td>
                              <td>{{ $wishlist->name }}</td>

                              <td><a href="{{ $wishlist->website_link }}" target="_blank">{{$wishlist->website_link}}</a></td>
                              <td>{{ $wishlist->wishlist->title}}</td>
                              
                              <td>
                                <div class="form-button-action">
                                  <!-- Edit Button -->
                                  <button type="button" class="btn btn-link btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#editModal{{ $wishlist->id }}">
                                    <i class="fas fa-eye"></i>
                                  </button>
                                </div>
                            
                                <!-- Modal -->
                                <div class="modal fade" id="editModal{{ $wishlist->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $wishlist->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content p-4 rounded-4">
                                      <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Wishlist Title: {{ $wishlist->wishlist->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="d-flex align-items-center mb-4">
                                          <div class="me-3">
                                            <img src="{{ $wishlist->image ? asset($wishlist->image) : asset('images/profile.jpg') }}" alt="Wishlist Image" class="rounded-circle" width="60" height="60">
                                          </div>
                                          <div>
                                            <h6 class="mb-0">{{ $wishlist->name }}</h6>
                                            <small class="text-muted">Created on {{ \Carbon\Carbon::parse($wishlist->created_at)->format('d M, Y') }}</small>
                                          </div>
                                        </div>

                                        <div class="row text-center mb-4">
                                          <div class="col-md-2">
                                            
                                          </div>
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                                ₦{{ number_format($wishlist->price?? 0, 2) }}
                                              </div>
                                              <small class="text-muted">Price</small>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">{{ $wishlist->quantity }}</div>
                                              <small class="text-muted">Quantity</small>
                                            </div>
                                          </div>
                                        </div>
                                        <h6 class="text-muted">
                                            Description
                                          </h6>
                                          <div class="border rounded p-2">
                                            <div class="text-muted small"> {{$wishlist->note }}</div>
                                          </div>
                                          <h6 class="text-muted mt-2">Reserved By</h6>
                                        @if ($wishlist->reservations)   
                                          @foreach ( $wishlist->reservations as $reservation )
                                            <div class="border rounded p-3">
                                              <strong>{{ $reservation->name}}</strong>
                                              <div class="text-muted small">{{$reservation->email }}</div>
                                              <div class="text-muted small">{{$reservation->note }}</div>
                                              <div class="text-muted small">{{$reservation->quantity }} Pieces</div>
                                            </div>
                                          @endforeach              
                                        @else
                                          <p class="text-muted text-center" >No Reservations yet in this wishlist.</p>
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
                            @endforeach
                            
                            @endif
                          
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