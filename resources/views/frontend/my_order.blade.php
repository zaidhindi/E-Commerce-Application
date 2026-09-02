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
						<div class="cart_title">My Orders</div>
						  @if(count($data)>0)
                          @php($totalprice=0)
                          <div class="table-responsive">
                              <table class="table table-hover text-center">

                                         <thead>
                                             <tr>
                                                 <th scope="col">#</th>
                                                 <th scope="col">Product</th>
                                                 <th scope="col">Quantity</th>
                                                 <th scope="col">Price</th>
                                             </tr>
                                         </thead>

                                         <tbody>

                                                 @php($i = 1)
                                                 @foreach ($data as $val)
                                                       @php($pro = json_decode($val->product_id, true))
                                                       @for ($p = 0; $p < count($pro); $p++)
                                                    @php($quantity = json_decode($val->quantity, true))
                                                      @php($product = DB::table('products')->where('id', '=', $pro[$p])->first())
                                                                 <tr>
                                                              <td scope="row">{{ $i++ }}</td>
                                                                  <td>{{ $product->name }}</td>
                                                                  <td>{{ $quantity[$p] }}</td>
                                                               <td>
                                                                @php($totalprice+=(float)$product->new_price * (int)$quantity[$p])
                                                              ${{ (float)$product->new_price * (int)$quantity[$p] }}
                                                               </td>
                                                             </tr>

                                                      @endfor

                                                    @endforeach

                                          </tbody>

                                     </table>
                                 </div>
                          {{$data->links()}}
                         <div class="d-flex justify-content-between align-items-center mt-4 p-3 border rounded">

                            <div class="d-flex align-items-center text-success">
                                <i class="fas fa-check-circle fs-4 me-2"></i>
                                <span class="fw-bold">PAID</span>
                            </div>

                            {{-- Total Price --}}
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 me-3">Total Price:</h5>
                                <h4 class="mb-0 fw-bold">
                                    ${{ $totalprice }}
                                </h4>
                            </div>

                        </div>
                          @else
                          <div class="text-center">NO Orders You Purchesed</div>
                          @endif
						<!-- Order Total -->


					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
