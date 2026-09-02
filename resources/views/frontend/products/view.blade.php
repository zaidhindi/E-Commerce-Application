@extends('frontend.master')
@section('title',$data->name)
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/product_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/product_responsive.css')}}">
@endsection
@section('content')
<div class="single_product">
		<div class="container">
			<div class="row">


				<!-- Selected Image -->
				<div class="col-lg-7 order-lg-2 order-1">
					<div class="image_selected"><img src="{{asset(Storage::url($data->img))}}" alt=""></div>
				</div>

				<!-- Description -->
				<div class="col-lg-5 order-3">
					<div class="product_description">
						<div class="product_category">{{$category->name}}</div>
						<div class="product_name">{{$data->name}}</div>
						<div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
						<div class="product_text"><p>{{$data->des}}</p></div>
						<div class="order_info d-flex flex-row">
							<form action="#">
								<div class="clearfix" style="z-index: 1000;">

									<!-- Product Quantity -->
									<div class="product_quantity clearfix">
										<span>Quantity: </span>
										<input id="quantity_input" type="text" pattern="[0-9]*" value="1">
										<div class="quantity_buttons">
											<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
											<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
										</div>
									</div>

									<!-- Product Color -->
									<ul class="product_color">
										<li>
											<span>Color: </span>
											<div class="color_mark_container"><div id="selected_color" class="color_mark"></div></div>
											<div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>

											<ul class="color_list">
												<li><div class="color_mark" style="background: #999999;"></div></li>
												<li><div class="color_mark" style="background: #b19c83;"></div></li>
												<li><div class="color_mark" style="background: #000000;"></div></li>
											</ul>
										</li>
									</ul>

								</div>

								<div class="product_price">${{$data->new_price}}</div>
                                @if($data->old_price!='')
                                  <span style="color: red;text-decoration:line-through ;">${{$data->old_price}}</span>
                                @endif
								<div class="button_container">
									<button type="button" class="button cart_button" productid={{$data->id}}>Add to Cart</button>
									<div class="product_fav"><i class="fas fa-heart"></i></div>
								</div>

							</form>
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
       $('.cart_button').click(function(e){
            e.preventDefault();
            let product =$(this).attr('productid');
            let quantity =$('#quantity_input').val();
            $.ajax({
                method:'post',
                url:'/add-cart',
                data:{
                   'product_id':product,
                   'quantity':quantity
                },
                headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                     },
               success:function(response){
                if(response.data==1){
                    Swal.fire({
                title: 'Success!',
                text: 'Product Added to cart',
                icon: 'success',
                confirmButtonText: 'ok'
              })
               location.reload();
                }
                if(response.data==0){
                    Swal.fire({
                title: 'Errro!',
                text: 'Product Alredy in Cart!!',
                icon: 'error',
                confirmButtonText: 'ok'
              })
                }
               }
            });
       });
    });
</script>
@endsection
