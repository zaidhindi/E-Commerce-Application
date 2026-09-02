@extends('frontend.master')
@section('title','Wishlist')
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
						<div class="cart_title">Wishlist</div>
                        @foreach($data as $val)
						<div class="cart_items">
							<ul class="cart_list">
								<li class="cart_item clearfix">
									<div class="cart_item_image"><img src="{{Storage::url($val->img)}}" alt=""></div>
									<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_title">Name</div>
											<div class="cart_item_text">{{$val->name}}</div>
										</div>
										<div class="cart_item_price cart_info_col">
											<div class="cart_item_title">Price</div>
											<div class="cart_item_text">{{$val->new_price}}</div>
										</div>
                                        @if (Auth::check())
                                           @php($cart=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_id',$val->id)->first())
                                        @else
                                            @php($cart=DB::table('carts')->where('user_ip',$_SERVER['REMOTE_ADDR'])->where('product_id',$val->id)->first())
                                        @endif
                                        @if($cart==null)
                                        <div class="cart_item_total cart_info_col">
											<div class="cart_item_text"><button class="btn btn-info btn-block mg-b-10 cartbtn"  productid="{{$val->id}}">Add to Cart</button></div>
										</div>
                                        @endif
										<div class="cart_item_total cart_info_col">
											<div class="cart_item_text"><button class="btn btn-danger delepro" productid="{{$val->id}}">Delete</button></div>
										</div>
									</div>
								</li>
							</ul>
						</div>
                        @endforeach
                            {{$data->links()}}
						<!-- Order Total -->


						<div class="cart_buttons">
							<button type="button" class="button cart_button_checkout">Empty wishlist</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
<script src="js/cart_custom.js"></script>
<script>
    $(document).ready(function(){
        $('.delepro').click(function(){
           let product_id=$(this).attr('productid');
           Swal.fire({
                   title: 'Confirm!',
                    text: 'Sure you want to delete this product from your favoirate ?',
                    icon: 'warning',
                 confirmButtonText: 'ok'
              }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        method:'get',
                        url:'/wishlist-delete/'+product_id+'',
                        success:function(response){
                            if(response.data==1){
                               Swal.fire({
                               title: 'Done!',
                                text: 'Deleted Successfuly',
                                icon: 'success',
                             confirmButtonText: 'ok'
                          }).then(()=>{
                            location.reload();
                          });
                            }
                        }
                    })
                }
              })
        });
          $('.cartbtn').click(function(){
           let product_id=$(this).attr('productid');
           Swal.fire({
                   title: 'Confirm!',
                    text: 'do you want to add this product to cart ?',
                    icon: 'warning',
                 confirmButtonText: 'ok'
              }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        method:'post',
                         url:'/add-cart',
                         data:{
                        'product_id':product_id,
                        'quantity':1
                         },
                          headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                     },
                        success:function(response){
                            if(response.data==1){
                               Swal.fire({
                               title: 'Done!',
                                text: 'Added Successfuly',
                                icon: 'success',
                             confirmButtonText: 'ok'
                          }).then(()=>{
                            location.reload();
                          });
                            }
                        }
                    })
                }
              })
        });
    })

</script>
@endsection
