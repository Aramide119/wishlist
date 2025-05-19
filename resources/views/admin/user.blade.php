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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Registered On</th>
                            <th style="width: 10%">Image</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (isset($users))
                            @foreach ($users as $user)
                            <tr>
                              <td>{{ $user->first_name }}</td>
                              <td>{{ $user->last_name }}</td>
                              <td>{{ $user->email }}</td>
                              <td class="px-4 py-6">{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>                                          
                              <td>@if ($user->profile_picture)
                                    <img class="img-fluid" src="{{ asset('user/image/'.$user->profile_picture) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                    @else
                                    <img class="img-fluid" src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                @endif
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