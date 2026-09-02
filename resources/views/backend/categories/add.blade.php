@extends('backend.master')
@section('content')
   <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <span class="breadcrumb-item active">Add Category</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Add your category and order</h5>
        </div><!-- sl-page-title -->



        <div class="row row-sm mg-t-20">
          <div class="col-xl-12">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">

              <div class="row">
                <label class="col-sm-4 form-control-label">Category: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" class="form-control" id="name"placeholder="Enter Catergory name">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Category Number: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number" class="form-control" id="order" placeholder="Enter Category number">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Category Image: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="file" class="form-control" id="img">
                </div>
              </div>
              <div class="form-layout-footer mg-t-30">
                <button class="btn btn-info mg-r-5" id="newCat">Save</button>
              </div><!-- form-layout-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->

        </div><!-- row -->




    </div>
@endsection
@section('title','add category')
@section('js')
<script>
    $(document).ready(function(){
        $('#newCat').click(function(e){
            e.preventDefault();
            let name         =$('#name').val();
            let order        =$('#order').val();
            let img          = $('#img').prop('files')[0];
        let formData= new FormData();
        formData.append('name',name);
        formData.append('order',order);
        formData.append('img',img);


            if(name==''){
                Swal.fire({
                title: 'Error!',
                text: 'Please enter Categroy name',
             icon: 'error',
                confirmButtonText: 'ok'
            })
            }else if(img==null){
                Swal.fire({
                title: 'Error!',
                text: 'Please enter Categroy Image',
             icon: 'error',
                confirmButtonText: 'ok'
            })
            }else{
                $.ajax({
                 method:'post',
                 url:'/add/category/store',
                  contentType:false,
                  processData:false,
                 data:formData,
                 headers: {
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                 },
                 success:function(response){
                    if(response.data==0){
                        Swal.fire({
                       title: 'Error!',
                        text: 'there is alredy category with this name',
                        icon: 'error',
                       confirmButtonText: 'ok'
                          } )
                    }else if(response.data==1){
                        Swal.fire({
                       title: 'Success!',
                        text: 'Category Added successfuly ',
                        icon: 'success',
                       confirmButtonText: 'ok'
                          } ).then((result) => {
    if(result.isConfirmed){  // ✅ isConfirmed not confirmed
        window.location.reload();
    }
})
                    }
                 }
                })
            }

        });

    })
</script>
@endsection

