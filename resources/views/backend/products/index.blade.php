@extends('backend.master')
@section('content')

     <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="index.html">Products</a>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Products Table</h6>

          <div class="table-responsive">
            <table class="table mg-b-0 text-center">
              <thead>
                <tr>
                  <th>
                    ID
                  </th>
                  <th>Name</th>
                  <th>Category</th>
                   <th>Old Price</th>
                  <th>New Price</th>
                  <th>Product Image</th>
                  <th>Descreption</th>
                   <th>action</th>
                </tr>
              </thead>
              <tbody>
               @foreach($products as $val)
               @php($cat=DB::table('categories')->where('id',$val->category)->first())
               <tr>
                  <td>{{$val->id}}</td>
                  <td>{{$val->name}}</td>
                  <td>{{$cat->name}}</td>
                   <td>${{$val->old_price}}</td>
                    <td>${{$val->new_price}}</td>

                     <td> <a href="{{Storage::url($val->img)}}" target="_blank"><img src="{{Storage::url($val->img)}}" alt="" style="width: 60px"></a></td>
                    <td>{{$val->des}}</td>
                     <td>
                         <a href="{{route('product.edit',['id'=>$val->id])}}" class="btn btn-outline-success btn-block mg-b-10">Edit</a>
                    <button class="btn btn-outline-danger btn-block mg-b-10 productDelete" proid="{{$val->id}}">Delete</button>
                     </td>
               </tr>
               @endforeach
              </tbody>
            </table>
          </div>
        </div><!-- card -->



    </div>
@endsection
@section('title','Products')
@section('js')
<script>
    $(document).ready(function(){
        $('.productDelete').click(function(e){
            let id=$(this).attr('proid');
            Swal.fire({
               title: 'Warning!',
               text: 'Do you want to delete this Product',
               icon: 'warning',
               confirmButtonText: 'yes'
             }).then((result)=>{
                if(result.isConfirmed){
                     $.ajax({
                        method:'post',
                        url:'/proudct/delete',
                        data:{
                            id:id,
                        },
                        headers:{
                         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                        },
                        success:function(response){
                            if(response.data==1){
                                 window.location.reload();

                            }
                        }
                });
                }
             })

        });

    });

</script>
@endsection

