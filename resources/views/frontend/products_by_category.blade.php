@extends('frontend.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_responsive.css')}}">
@endsection
@section('content')
<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('/images/shop_background.jpg')}}"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">{{$selectedcat->name}}</h2>
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

						<div class="product_grid">
							<div class="product_grid_border"></div>
                            @foreach($data as $val)
                            <div class="product_item is_new">
								<div class="product_border"></div>
								<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{Storage::url($val->img)}}" alt=""></div>
								<div class="product_content">
									<div class="product_price">${{$val->new_price}}
                                        <span style="color: red;text-decoration: line-through">${{$val->old_price}}</span>
                                    </div>

									<div class="product_name"><div><a href="{{route('product.view',['id'=>$val->id])}}" tabindex="0">{{$val->name}}</a></div></div>
								</div>
								<div class="product_fav"><i class="fas fa-heart"></i></div>

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



	<!-- Brands -->

@endsection
@section('title','Products By Category')
