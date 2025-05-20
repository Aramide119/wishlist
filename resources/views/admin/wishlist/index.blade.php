@extends('partials.admin')

@section('content')



        <div class="container">
          <div class="page-inner">
                      <div class="page-header">
              <h3 class="fw-bold mb-3">Wishlists</h3>
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
                  <a href="#">WIshlist</a>
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
                            <th width="5%">Wishlist Image</th>
                            <th>Wishlist Title</th>
                            <th>Wishlist Link</th>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (isset($wishlists))
                            @foreach ($wishlists as $wishlist)
                            <tr>
                              <td>@if ($wishlist->image)
                                    <img class="img-fluid" src="{{ asset($wishlist->image) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                    @else
                                    <img class="img-fluid" src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                @endif
                              </td>
                              <td>{{ $wishlist->title }}</td>

                              <td><a href="{{ url('/wishlist/' . $wishlist->slug)}}">{{ url('/wishlist/' . $wishlist->slug)}}</a></td>
                              <td>{{ $wishlist->user->first_name. " " . $wishlist->user->last_name}}</td>
                              <td class="px-4 py-6">{{ \Carbon\Carbon::parse($wishlist->created_at)->format('d M, Y') }}</td>                                          
                              
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
                                        <h5 class="modal-title fw-bold">Wishlist Title: {{ $wishlist->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="d-flex align-items-center mb-4">
                                          <div class="me-3">
                                            <img src="{{ $wishlist->image ? asset($wishlist->image) : asset('images/profile.jpg') }}" alt="Wishlist Image" class="rounded-circle" width="70" height="70">
                                          </div>
                                          <div>
                                            <h6 class="mb-0 mt-1">{{ $wishlist->user->first_name . ' ' . $wishlist->user->last_name }}</h6>
                                            <p class="text-muted">{{$wishlist->user->email}}</small><br>
                                            <small class="text-muted">Created on {{ \Carbon\Carbon::parse($wishlist->created_at)->format('d M, Y') }}</small>
                                            
                                          </div>
                                        </div>

                                        <div class="row text-center mb-4">
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">{{ $wishlist->items->count() }}</div>
                                              <small class="text-muted">Total Item Created</small>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                                ₦{{ number_format($wishlist->money->sum('target') ?? 0, 2) }}
                                              </div>
                                              <small class="text-muted">Total Value</small>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">{{ \Carbon\Carbon::parse($wishlist->created_at)->diffForHumans() }}</div>
                                              <small class="text-muted">Age</small>
                                            </div>
                                          </div>
                                        </div>
                                          <h6 class="text-muted">
                                            Description
                                          </h6>
                                          <div class="border rounded p-2">
                                            <div class="text-muted small"> {{$wishlist->description }}</div>
                                          </div>
                                          <h6 class="text-muted">
                                            Address
                                          </h6>
                                          <div class="border rounded p-2">
                                            <div class="text-muted small"> {{$wishlist->addressLine1 }}</div>
                                          </div>
                                        @if ($wishlist->items && $wishlist->items->count() > 0)
                                          @php
                                            $latestItem = $wishlist->items->sortByDesc('created_at')->first();
                                          @endphp
                                          <h6 class="text-muted mt-2">Latest Wishlist Item</h6>
                                          <div class="border rounded p-3">
                                            <strong>{{ $latestItem->name ?? 'Unnamed Item' }}</strong>
                                            <div class="text-muted small">Added {{ \Carbon\Carbon::parse($latestItem->created_at)->format('d M, Y') }}</div>
                                          </div>
                                        @else
                                          <p class="text-muted">No items yet in this wishlist.</p>
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