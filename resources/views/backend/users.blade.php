@extends('backend.master')
@section('title','Users')
@section('content')
 <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="index.html">Users</a>
      </nav>

           @if(count($users)>0)
            <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Users Table</h6>
          <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>
                    id
                  </th>
                  <th>UserName</th>
                  <th>Email</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php($i=1)
                @foreach($users as $val)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->email}}</td>
                        <td>{{date('Y-m-d',strtotime($val->created_at))}}</td>
                        <td><button class="btn btn-danger btn-block mg-b-10 DeleBtn" deleid="{{$val->id}}">Delete</button></td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div><!-- card -->
           @else
           <div class="col-md">
    <div class="card card-body bg-gray-200">
        <p class="card-text">There is no users regiestired in system yet</p>
    </div><!-- card -->
</div>
           @endif


@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.DeleBtn').click(function(e){
            e.preventDefault();

            let id = $(this).attr('deleid');
            let btn = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'post',
                        url: '/admin/delete-user', // adjust route to match your actual delete route
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status == 1) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The user has been deleted.',
                                    icon: 'success',
                                    confirmButtonText: 'ok'
                                }).then(() => {
                                    btn.closest('tr').remove(); // remove row without reload
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong, please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'ok'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Request failed, please try again.',
                                icon: 'error',
                                confirmButtonText: 'ok'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
