@extends('partials.admin')

@section('content')



        <div class="container">
          <div class="page-inner">
            <div class="row">
              <div class="col-md-5">
                <div class="card"> 
                    <div class="card-header">
                        <h2 class="text-center">Edit Profile</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('edit.settings')}}" method="POST"> 
                          @csrf
                           @if(session('message'))
                            <div class="alert alert-success" role="alert">
                                <strong class="font-bold ">Success!</strong>
                                <span class="block sm:inline">{{ session('message') }}</span>
                                <span onclick="this.parentElement.style.display='none';"
                                      class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-green-700">
                                    &times;
                                </span>
                            </div>
                          @endif
                          <div class="form-group">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" value="{{$admin->email}}" readonly>
                          </div>
                          <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" class="form-control" name="password">
                          </div>
                          <div class="form-group">
                              <button class="btn btn-secondary" type="submit">
                                Save
                              </button>
                          </div>
                          
                      </form>
                    </div>
                    
                </div>
                    
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

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap Notify -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@0.2.0/bootstrap-notify.min.js"></script>

<!-- jsvectormap -->
<script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @endsection