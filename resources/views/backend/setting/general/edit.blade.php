@extends('backend.master')
@section('title','Profile')
@section('content')
 <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{route('general.setting')}}">General</a>
        <a class="breadcrumb-item" href="index.html">Edit</a>
      </nav>


        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Edit your general Setting</h6>

          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Site name: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" id="name" value="{{$data->name}}" placeholder="Enter website name">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Site Email: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="email" id="email" value="{{$data->email}}" placeholder="Enter email">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Site phoen: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" id="phone" value="{{$data->phone}}">
                </div>
              </div><!-- col-4 --><!-- col-4 -->
               <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Site Address: <span class="tx-danger">*</span></label>
                  <textarea  id="address" rows="2" class="form-control">{{$data->address}}</textarea>
                </div>
              </div>
             <div class="col-lg-4">
                    <div class="form-group">
                    <label class="form-control-label">Site logo: <span class="tx-danger">*</span></label>

                     <div class="d-flex align-items-center gap-2">
                          <img
                            src="{{ Storage::url($data->img) }}"
                            draggable="true"
                            alt="Store logo"
                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">

                          <input class="form-control" type="file" id="img" value="{{ $data->img }}">
                           </div>
                      </div>
                    </div>
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
            let address=$('#address').val();
            let phone   =$('#phone').val();
            let img =$('#img').prop('files')[0];
            let formData= new FormData();
            formData.append('name',name);
            formData.append('email',email);
            formData.append('address',address);
            formData.append('phone',phone);
            formData.append('img',img);
                $.ajax({
                    method:'post',
                    processData: false,
                    contentType: false,
                    url:'/general-setting/update',
                    data:formData,
                    headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                  },
                  success:function(response){
                    if(response.data==1){
                          Swal.fire({
                            title: 'Done!',
                            text: 'Site information updated',
                         icon: 'success',
                            confirmButtonText: 'ok'
                        }).then(()=>{
                            location.reload();
                        })
                    }
                  }
                })

        });
    })

 </script>
@endsection
