@extends('backend.master')
@section('content')
  <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <span class="breadcrumb-item active">Categories</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">

        </div><!-- sl-page-title -->


        <div class="card pd-20 pd-sm-40 mg-t-50">
          <h6 class="card-body-title">Categories Table</h6>

          <div class="table-responsive">
            <table class="table table-hover table-bordered table-primary mg-b-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>name</th>
                  <th>order</th>
                   <th>image</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $val)
                <tr>
                   <td>{{$val->id}}</td>
                  <td>{{$val->name}}</td>
                  <td>{{$val->order}}</td>
                     <td> <a href="{{Storage::url($val->img)}}" target="_blank"><img src="{{Storage::url($val->img)}}" alt="" style="width: 60px"></a></td>
                  <td>
                    <a href="{{route('category.edit',['id'=>$val->id])}}" class="btn btn-outline-success btn-block mg-b-10">Edit</a>
                    <button class="btn btn-outline-danger btn-block mg-b-10 delCate" cateID="{{$val->id}}">Delete</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-responsive -->
          {{$data->links()}}
        </div><!-- card -->




    </div>
@endsection
@section('title','Categories')
@section('js')
<script>
    $(document).ready(function(){
        $('.delCate').click(function(e){
            let id=$(this).attr('cateID');
            Swal.fire({
               title: 'Warning!',
               text: 'Do you want to delete this category',
               icon: 'warning',
               confirmButtonText: 'yes'
             }).then((result)=>{
                if(result.isConfirmed){
                     $.ajax({
                        method:'post',
                        url:'/category/delete',
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

