@extends('backend.master')
@section('title','Edit Product')
@section('content')
  <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{route('products.view')}}">Products</a>
        <span class="breadcrumb-item active">Edit Products</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
        </div><!-- sl-page-title -->


        <div class="row row-sm mg-t-20">
          <div class="col-xl-12">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title">Edit Product</h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">Product Name: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" class="form-control" id="name" value="{{$product->name}}"placeholder="Enter Product name">
                </div>
              </div><!-- row -->
              <br>
              <div class="row">
                @php($cat=DB::table('categories')->where('id',$product->category)->first())
                <label class="col-sm-4 form-control-label">Category Name: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="" id="category" class="form-control">
                        <option value="">Select Product Category</option>
                        @foreach($category as $item)
                        <option value="{{$item->id}}" @if($cat->id==$item->id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Old Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number" class="form-control" id="old_price" value="{{$product->old_price}}" >
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">New Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number" class="form-control"  id="new_price"  value="{{$product->new_price}}" >
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Image: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <img src="{{Storage::url($product->img)}}" alt="" style="width: 60px">
               <input type="file" name="" id="img">
                </div>
              </div> <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Proudct Descreption: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                       <textarea rows="2"  id="des" class="form-control" value="{{$product->des}}" ></textarea>
                </div>
              </div>

              <div class="form-layout-footer mg-t-30">
                <input type="hidden" name="" id="id" value="{{$product->id}}">
                <button class="btn btn-info mg-r-5 editBtn">Save</button>
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

        $('.editBtn').click(function(){
            let name       = $('#name').val();
            let oldPrice   = $('#old_price').val();
            let newPrice   = $('#new_price').val();
            let category   = $('#category').val();
             let des   = $('#des').val();
             let id   = $('#id').val();

            let formData=new FormData();
            if($('#img').prop('files')[0]!=null){
                let img        = $('#img').prop('files')[0];
                 formData.append('img',img);
            }


            formData.append('name',name);
            formData.append('oldPrice',oldPrice);
            formData.append('newPrice',newPrice);
            formData.append('category',category);
            formData.append('id',id);
             formData.append('des',des);
                if(name==''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter product name',
                        icon: 'error',
                        confirmButtonText: 'ok'
                      })
                }else if(category==''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select product category',
                        icon: 'error',
                        confirmButtonText: 'ok'
                      })
                }else if(newPrice==''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter product price',
                        icon: 'error',
                        confirmButtonText: 'ok'
                      })
                }else{
                    $.ajax({
                        method:'post',
                        url:'/product/update',
                        processData:false,
                        contentType:false,
                        data:formData,
                         headers:{
                         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                        },
                        success:function(response){
                            if(response.data==1){
                                Swal.fire({
                        title: 'Success!',
                        text: 'Product updated Successfuly',
                        icon: 'success',
                        confirmButtonText: 'ok'
                      })

                            }

                        }

                    });
                }

        });

    });
</script>
@endsection
