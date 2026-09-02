@extends('frontend.master')
@section('title','Cart')
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
						<div class="cart_title">Shopping Cart</div>
                        @php($count=0)
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

										<div class="cart_item_quantity cart_info_col">
											<div class="cart_item_title">Quantity</div>
											<div class="cart_item_text">{{$val->quantity}}</div>
										</div>
										<div class="cart_item_price cart_info_col">
											<div class="cart_item_title">Price</div>
											<div class="cart_item_text">${{$val->new_price}}</div>
										</div>
										<div class="cart_item_total cart_info_col">
											<div class="cart_item_title">Total</div>
											<div class="cart_item_text">${{$val->new_price*$val->quantity}}</div>
                                            @php($count+=$val->new_price*$val->quantity)
										</div>
                                        <div class="cart_item_price cart_info_col">
											<div class="cart_item_text"><button class="btn btn-danger Dele" productID="{{$val->id}}">Delete</button></div>
										</div>
									</div>
								</li>
							</ul>
						</div>
                          @endforeach


						<!-- Order Total -->
						<div class="order_total">
							<div class="order_total_content text-md-right">
								<div class="order_total_title">Order Total:</div>
								<div class="order_total_amount">${{$count}}</div>
							</div>
						</div>

						<div class="cart_buttons">
							<button type="button" class="button cart_button_clear" count="{{$count}}">Empty Cart</button>
							<a href="{{route('pay.now')}}" class="button cart_button_checkout">Check out</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.Dele').click(function(e){
                e.preventDefault();
                let productid= $(this).attr('productID');
             Swal.fire({
                   title: 'Confirm!',
                   text: 'Do you want to Delete this product from cart ?',
                   icon: 'warning',
                   confirmButtonText: 'yes'
                 }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            method:'get',
                            url:'/cart-delete/'+productid,
                            success:function(response){
                                Swal.fire({
                             title: 'Done!',
                              text: 'product Deleted Succefuly',
                              icon: 'success',
                             confirmButtonText: 'yes'
                                })
                                location.reload();
                            }
                        })
                    }
                 })
        });
         $('.cart_button_clear').click(function(e){
                e.preventDefault();
                   let count= $(this).attr('count');
                   if(count=='0'){
                    Swal.fire({
                   title: 'Error!',
                   text: 'cart is already empty',
                   icon: 'error',
                   confirmButtonText: 'ok'
                 })
                   }else{
                    Swal.fire({
                   title: 'Confirm!',
                   text: 'Do you want to empty Cart ?',
                   icon: 'warning',
                   confirmButtonText: 'yes'
                 }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            method:'get',
                            url:'/cart-empty',
                            success:function(response){
                                Swal.fire({
                             title: 'Done!',
                              text: 'your Cart is empty now',
                              icon: 'success',
                             confirmButtonText: 'yes'
                                })
                                location.reload();
                            }
                        })
                    }
                 })
                   }


        });
    })
</script>
@endsection
