@extends('backend.master')
@section('title','Profile')
@section('content')
 <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="index.html">Profile</a>
      </nav>


        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">information about <span style="color: greenyellow">{{Auth::user()->name}} </span>account --you can edit</h6>

          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Name: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" id="name" value="{{Auth::user()->name}}" placeholder="Enter name">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="email" id="email" value="{{Auth::user()->email}}" placeholder="Enter email">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="password" id="password">
                </div>
              </div><!-- col-4 --><!-- col-4 -->
            </div><!-- row -->

            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5 saveBtn">Save</button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div><!-- card -->

@endsection
@section('js')
 <script>
    $(document).ready(function(){
        $('.saveBtn').click(function(e){
            e.preventDefault();
            let name    =$('#name').val();
            let email   =$('#email').val();
            let password=$('#password').val();
            if(name==''){
                Swal.fire({
               title: 'Error!',
              text: 'Please enter your name',
                icon: 'error',
                confirmButtonText: 'ok'
                    })
            }else if(email==''){
                     Swal.fire({
               title: 'Error!',
              text: 'Please enter your email',
                icon: 'error',
                confirmButtonText: 'ok'
                    })
            }else {
                $.ajax({
                    method:'post',
                    url:'/admin/update-account',
                    data:{
                        name:name,
                        email:email,
                        password:password
                    },
                    headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                  },
                  success:function(response){
                    if(response.data==1){
                         Swal.fire({
                         title: 'Done!',
                         text: 'your account information is updated',
                         icon: 'success',
                           confirmButtonText: 'ok'
                    }).then(()=>{
                        location.reload();
                    })
                    }
                     if(response.data==0){
                         Swal.fire({
                         title: 'error!',
                         text: 'Somthing went error Sorry ! ',
                         icon: 'error',
                           confirmButtonText: 'ok'
                    })
                     }
                  }
                })
            }
        });
    })

 </script>
@endsection
