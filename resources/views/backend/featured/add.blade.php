@extends('backend.master')
@section('title','Add Featured Products')
@section('content')
<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="">Featured</a>
        <span class="breadcrumb-item active">Add Featured Products</span>
      </nav>

      <div class="sl-pagebody">



        <div class="row row-sm mg-t-20">
          <div class="col-xl-9">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <div class="row">
                <label class="col-sm-4 form-control-label">Select Category: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select id="category" class="form-control">
                        <option value="" selected>Please Select Product Category</option>
                        @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>

                        @endforeach
                    </select>
                </div>
              </div><!-- row -->
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Name: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text"  id="name" class="form-control" placeholder="Enter Product name">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Old Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number"  id="old_price"  class="form-control" placeholder="Enter Old Price">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">New Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number"  id="new_price"  class="form-control" placeholder="Enter New Price">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Image: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="file"  id ="img" class="form-control">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Descreption: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <textarea rows="2" id ="des" class="form-control" placeholder="Enter Project Descreption"></textarea>
                </div>
              </div>
              <div class="form-layout-footer mg-t-30">
                <button class="btn btn-info mg-r-5 addPro">Save</button>
              </div><!-- form-layout-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
          <!-- col-6 -->
        </div><!-- row -->



      </div><!-- sl-pagebody -->
    </div>
@endsection
@section('js')
   <script>
        $(document).ready(function(){
          $('.addPro').click(function(e){
            e.preventDefault();
         let category     = $('#category').val();
        let productName  = $('#name').val();
        let oldPrice     = $('#old_price').val();
        let newPrice     = $('#new_price').val();
        let des          = $('#des').val();
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
            url:'/featured/products/store',
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
          })
        });

   </script>
@endsection

