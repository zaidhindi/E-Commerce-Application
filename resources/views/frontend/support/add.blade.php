@extends('frontend.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_responsive.css')}}">
@endsection
@section('content')
<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title text-center">Tell us about your issue </div>
                       <form>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title"class="form-control" id="title" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description </label>
                                <textarea name="description" id="des" class="form-control"></textarea>
                            </div>

                            <button class="btn btn-primary addSupport">Submit Ticket</button>
                            </form>


					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.addSupport').click(function(e){
            e.preventDefault();
             let title= $('#title').val();
             let des = $('#des').val();
             if(title==''||des==''){
                        Swal.fire({
                        title: 'Error!',
                        text: 'Please fill title and description',
                        icon: 'error',
                        confirmButtonText: 'ok'
                        })
             }else{
                $.ajax({
                        method:'post',
                        url:'/support-tickets/store',
                        data:{
                            title:title,
                            des:des
                        },
                        headers:{
                         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                        },
                        success:function(response){
                            if(response.data==true){
                               Swal.fire({
                        title: 'Success!',
                        text: 'Your ticket sent succesfully ',
                        icon: 'success',
                        confirmButtonText: 'ok'
                        }).then((result)=>{
                            if(result.isConfirmed){
                                location.reload();
                            }
                        })
                            }
                        }
                });
             }
        })
    });
</script>
@endsection
