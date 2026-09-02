@extends('frontend.master')
@section('title','Products')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_responsive.css')}}">
@endsection
@section('content')

	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('/images/shop_background.jpg')}}"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">All Products</h2>
		</div>
	</div>

	<!-- Shop -->

	<div class="shop">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">

					<!-- Shop Sidebar -->
					<div class="shop_sidebar">
						<div class="sidebar_section">
							<div class="sidebar_title">Categories</div>
							<ul class="sidebar_categories">
                                @foreach($cat as $val)
                                <li><a href="{{route('products.by.category',['id'=>$val->id])}}">{{$val->name}}</a></li>
                                @endforeach

							</ul>
						</div>
					</div>

				</div>

				<div class="col-lg-9">

					<!-- Shop Content -->

					<div class="shop_content">
						<div class="shop_bar clearfix">
							<div class="shop_product_count"><span>{{$data->count()}}</span> products found</div>
							<div class="shop_sorting">
							</div>
						</div>

						<div class="product_grid">
							<div class="product_grid_border"></div>

							<!-- Product Item -->
                            @foreach($data as $item)
                            <div class="product_item is_new">
								<div class="product_border"></div>
								<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{Storage::url($item->img)}}" alt=""></div>
								<div class="product_content">
									<div class="product_price">${{$item->new_price}} <span style="color: red;text-decoration: line-through">${{$item->old_price}} </span></div>
									<div class="product_name"><div><a href="{{route('product.view',['id'=>$item->id])}}">{{$item->name}}</a></div></div>
								</div>
								<div class="product_fav" productid="{{$item->id}}"><i class="fas fa-heart"></i></div>
								<ul class="product_marks">
									<li class="product_mark product_discount">-33</li>

									<li class="product_mark product_new">new</li>
								</ul>
							</div>
                            @endforeach


						</div>

						<!-- Shop Page Navigation -->
                        {{$data->links()}}

					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- Recently Viewed -->

<div class="viewed">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="viewed_title_container">
						<h3 class="viewed_title">Recently Viewed</h3>
						<div class="viewed_nav_container">
							<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
							<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
						</div>
					</div>
                          @if($view->isEmpty())
                            <div class="no_products_message text-center">
                            <p>You haven't see any products yet.</p>
                             </div>
                          @else
                          <div class="viewed_slider_container">
						<div class="owl-carousel owl-theme viewed_slider">

							@foreach($view as $val)
                            @php($product=DB::table('products')->where('id',$val->product_id)->first())
                              <div class="owl-item">
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="{{Storage::url($product->img)}}" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">{{$product->new_price}}@if($product->old_price!=null)<span>{{$product->old_price}}</span>     @endif</div>
										<div class="viewed_name"><a href="{{route('product.view',['id'=>$product->id])}}">{{$product->name}}</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>
                            @endforeach


						</div>
					</div>
                          @endif

				</div>
			</div>
		</div>
	</div>

	<!-- Brands -->

	<!-- Newsletter -->

	<div class="newsletter">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
						<div class="newsletter_title_container">
							<div class="newsletter_icon"><img src="images/send.png" alt=""></div>
							<div class="newsletter_title">Sign up for Newsletter</div>
							<div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
						</div>
						<div class="newsletter_content clearfix">
							<form action="#" class="newsletter_form">
								<input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
								<button class="newsletter_button">Subscribe</button>
							</form>
							<div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
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

        $('.product_fav').click(function(e){
            let product=$(this).attr('productid');
            $.ajax({
                method:'get',
                url:'/add-wishlist/'+product,
                success:function(response){
                    if(response.data==0){
                         Swal.fire({
                   title: 'Done!',
                   text: 'this product is alredy in Favorite',
                   icon: 'warning',
                   confirmButtonText: 'ok'
                 })
                    }
                    if(response.data==1){
                         Swal.fire({
                   title: 'Done!',
                   text: 'product Added Successfully to Favorite ',
                   icon: 'success',
                   confirmButtonText: 'ok'
                 })
                    }
                }
            })
        });
    })
</script>
@endsection
