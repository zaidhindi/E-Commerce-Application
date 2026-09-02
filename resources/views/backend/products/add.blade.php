@extends('backend.master')
@section('title','Add Product')
@section('content')
<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="">Products</a>
        <span class="breadcrumb-item active">Add Product</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
        </div><!-- sl-page-title -->



        <div class="row row-sm mg-t-20">
          <div class="col-xl-12">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title">Add your Product to specific category</h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">Product Category: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select name="" id="category" class="form-control">
                    <option value="" selected>please select Category for Product</option>
                    @foreach($categories as $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div><!-- row -->
              <br>
              <div class="row">
                <label class="col-sm-4 form-control-label">Product name: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" class="form-control" id ="ProductName" placeholder="Enter Product name">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Old Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number" class="form-control"  id ="oldPrice" placeholder="Enter Old Price">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">New Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number" class="form-control" id ="newPrice" placeholder="Enter New Price">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Image: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="file" class="form-control" id ="img">
                </div>
              </div>
              <div class="form-layout-footer mg-t-30">
                <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Proudct Descreption: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                       <textarea rows="2"  id="des" class="form-control" placeholder="Enter Product Descreption"></textarea>
                </div>
              </div>
                <button class="btn btn-info mg-r-5 addPro">Add Product</button>
              </div><!-- form-layout-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->

        </div><!-- row -->



      </div><!-- sl-pagebody -->

    </div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
    $('.addPro').click(function(e){
        let category     = $('#category').val();
        let productName  = $('#ProductName').val();
        let oldPrice     = $('#oldPrice').val();
        let newPrice     = $('#newPrice').val();
        let des     = $('#des').val();
        let img          = $('#img').prop('files')[0];
        let formData= new FormData();
        formData.append('category',category);
        formData.append('productName',productName);
        formData.append('oldPrice',oldPrice);
        formData.append('newPrice',newPrice);
        formData.append('img',img);
         formData.append('des',des);
     if(category==''){
             Swal.fire({
                title: 'Error!',
                text: 'Please Select Product Category',
                 icon: 'error',
                 confirmButtonText: 'ok'
            })
     }else if(productName==''){
         Swal.fire({
                title: 'Error!',
                text: 'Please Enter Product Name',
                 icon: 'error',
                 confirmButtonText: 'ok'
            })
     }else if(newPrice==''){
        Swal.fire({
                title: 'Error!',
                text: 'Please Enter Product Price',
                 icon: 'error',
                 confirmButtonText: 'ok'
            })
     }else if(!img){
         Swal.fire({
                title: 'Error!',
                text: 'Please Enter Product image',
                 icon: 'error',
                 confirmButtonText: 'ok'
            })
     }else if(des==''){
              Swal.fire({
                title: 'Error!',
                text: 'Please Enter Product Descreption',
                 icon: 'error',
                 confirmButtonText: 'ok'
            })
     }else{
        $.ajax({
            method:'post',
            url:'/products/store',
            contentType:false,
            processData:false,
            data:formData,
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                if(response.data==1){
                     Swal.fire({
                title: 'Success!',
                text: 'Product saved success ',
                 icon: 'success',
                 confirmButtonText: 'ok'
            })
                }

            }
        })
     }



    });

    });
</script>
@endsection
