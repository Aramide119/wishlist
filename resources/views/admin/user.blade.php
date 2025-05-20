@extends('partials.admin')

@section('content')



        <div class="container">
          <div class="page-inner">
                      <div class="page-header">
              <h3 class="fw-bold mb-3">Users</h3>
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
                  <a href="#">User</a>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered On</th>
                            <th style="width: 10%">Image</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (isset($users))
                            @foreach ($users as $user)
                            <tr>
                              <td>{{ $user['name']}}</td>
                              <td>{{ $user['email'] }}</td>
                              <td class="px-4 py-6">  {{ \Carbon\Carbon::parse($user['created_at'])->format('d M, Y') }}</td>                                          
                              <td>@if ($user['profile_picture'])
                                    <img class="img-fluid" src="{{ asset('user/image/'.$user['profile_picture']) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                    @else
                                    <img class="img-fluid" src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                @endif
                              </td>
                              <td>

                                    <!-- Trigger button -->
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#userModal{{ $user['id'] }}">
                                      View Details
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="userModal{{ $user['id'] }}" tabindex="-1">
                                      <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content p-4 rounded-4">
                                          <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>

                                          <h4>User Details</h4>
                                          <p class="text-muted">Detailed information about this user account</p>

                                          <div class="d-flex align-items-center mb-4">
                                            <div class="me-3">
                                            <img src="{{ asset('user/image/'.$user['profile_picture'] ?? 'images/profile.jpg') }}" class="rounded-circle" width="60" height="60">
                                          </div>
                                            <div class="ms-3">
                                              <h5>{{ $user['name'] }}</h5>
                                              <small class="text-muted">{{ $user['email'] }}</small><br>
                                              <span class="badge bg-success mt-1">
                                                {{ $user['is_verified'] ? 'Verified' : 'Unverified' }}
                                              </span>
                                            </div>
                                          </div>

                                          <div class="row text-center mb-4">
                                            <div class="col-md-4">
                                              <div class="border rounded p-3">
                                                <div class="fw-bold fs-5">{{ $user['wishlist_count'] }}</div>
                                                <small class="text-muted">Wishlists created</small>
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="border rounded p-3">
                                                <div class="fw-bold fs-5">{{ $user['created_at']->format('M d, Y') }}</div>
                                                <small class="text-muted">Join Date</small>
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="border rounded p-3">
                                                <div class="fw-bold fs-5">{{ $user['account_age'] }}</div>
                                                <small class="text-muted">Account age</small>
                                              </div>
                                            </div>
                                          </div>

                                          <h5 class="mb-3">Latest Wishlist</h5>
                                          @if($user['latest_wishlist'])
                                            <div class="border rounded p-3 d-flex justify-content-between align-items-center">
                                              <div>
                                                <strong>{{ $user['latest_wishlist']['name'] }}</strong>
                                                <div class="text-muted small">{{ $user['latest_wishlist']['created_at'] }}</div>
                                              </div>
                                              {{-- <span class="badge bg-primary">{{ $user['latest_wishlist']['type'] }}</span> --}}
                                            </div>
                                          @else
                                            <p class="text-muted">No wishlist yet.</p>
                                          @endif
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