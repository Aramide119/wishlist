<div class="table-responsive">
                      <table id="{{ $tableId }}"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>Reference Id</th>
        <th>User</th>
        <th>Amount (NGN)</th>
        <th>Status</th>
        <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                             @forelse ($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-4 py-6">{{$withdrawal->reference}}</td>
                                <td class="px-4 py-6">{{$withdrawal->user->first_name. " ". $withdrawal->user->last_name}}</td>
                                <td class="px-4 py-6">₦{{ number_format($withdrawal->amount, 2)}}</td>
                                <td>
                                  
                                  <button class="badge bg-success"  data-bs-toggle="modal" data-bs-target="#editModal{{ $withdrawal['id'] }}">{{$withdrawal->status}}</button>

                                        <!-- Modal -->
                                    <div class="modal fade" id="editModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $withdrawal->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content p-4 rounded-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Update Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('admin.withdraw-status', $withdrawal->id)}}" method="POST">
                                            @csrf
                                        <div class="modal-body">
                                            
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="pending">Pending</option>
                                                    <option value="successful">Success</option>
                                                    <option value="declined">Decline</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-success">Save</button>

                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                        </form>

                                        </div>
                                    </div>
                                    </div>

                                </td>
                              <td>

                                    <!-- Trigger button -->
                                    <button data-bs-toggle="modal" data-bs-target="#userModal{{ $withdrawal['id'] }}">
                                      <i class="fas fa-eye"></i>
                                    </button>

                                     <!-- Modal -->
                                <div class="modal fade" id="userModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel{{ $withdrawal->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content p-4 rounded-4">
                                      <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Withdrawal Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="d-flex align-items-center mb-4">
                                          <div class="me-3">
                                            @if ($withdrawal->user->profile_picture)
                                                <img src="{{  asset('user/image/'.$withdrawal->user->profile_picture)}}" alt="User Image" class="rounded-circle" width="60" height="60">
                                                @else
                                                <img src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="rounded-circle" width="60" height="60">
                                            @endif
                                          </div>
                                          <div>
                                            <h6 class="mb-0">{{ $withdrawal->user->first_name. " ". $withdrawal->user->last_name }} </h6>
                                            <small class="text-muted">{{$withdrawal->user->email}}</small></br>
                                            <small class="text-muted">Created on {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M, Y') }}</small>
                                          </div>
                                        </div>

                                        <div class="row text-center mb-4">
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                                ₦{{ number_format($withdrawal->amount ?? 0, 2) }}
                                              </div>
                                              <small class="text-muted">Amount</small>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                                {{$withdrawal->bankAccount->account_number}}
                                              </div>
                                              <small class="text-muted">Account Number</small>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                               {{$withdrawal->bankAccount->bank_name}}
                                              </div>
                                              <small class="text-muted">Bank Name</small>
                                            </div>
                                          </div>
                                          <div class="col-md-1">
                                            
                                          </div>
                                          <div class="col-md-6 mt-2">
                                            <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                                {{$withdrawal->bankAccount->account_name}}
                                              </div>
                                              <small class="text-muted">Account Name</small>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mt-2">
                                             <div class="border rounded p-3">
                                              <div class="fw-bold fs-5">
                                                ₦{{ number_format($withdrawal->user->wallet_balance ?? 0, 2) }}
                                              </div>
                                              <small class="text-muted">User Balance</small>
                                            </div>
                                          </div>
                                        </div>
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
        <tr>
          <td colspan="5" class="text-center">No withdrawals found.</td>
        </tr>
      @endforelse
                         </tbody>
                      </table>
                      
                    </div>
              