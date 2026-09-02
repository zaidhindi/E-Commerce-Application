@extends('backend.master')
@section('title','Dashboard')
@section('content')
 <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Starlight</a>
        <span class="breadcrumb-item active">Dashboard</span>
      </nav>

      <div class="sl-pagebody">

        <div class="row row-sm">
          <div class="col-sm-6 col-xl-3">
            <div class="card pd-20 bg-primary">
              <div class="d-flex justify-content-between align-items-center mg-b-10">
                <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Categories</h6>
              </div><!-- card-header -->
              <div class="d-flex align-items-center justify-content-between">
                <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{$cat}}</h3>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-3 -->
          <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
            <div class="card pd-20 bg-info">
              <div class="d-flex justify-content-between align-items-center mg-b-10">
                <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Normal Products</h6>
              </div><!-- card-header -->
              <div class="d-flex align-items-center justify-content-between">
                <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{$product}}</h3>
              </div><!-- card-body -->

            </div><!-- card -->
          </div><!-- col-3 -->
          <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="card pd-20 bg-purple">
              <div class="d-flex justify-content-between align-items-center mg-b-10">
                <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Featured Prdoucts</h6>
              </div><!-- card-header -->
              <div class="d-flex align-items-center justify-content-between">
                <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{$fproduct}}</h3>
              </div><!-- card-body -->

            </div><!-- card -->
          </div><!-- col-3 -->
          <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="card pd-20 bg-sl-primary">
              <div class="d-flex justify-content-between align-items-center mg-b-10">
                <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Orders</h6>
              </div><!-- card-header -->
              <div class="d-flex align-items-center justify-content-between">
                <h3 class="mg-b-0 tx-white tx-lato tx-bold">${{$order}}</h3>
              </div><!-- card-body -->

            </div><!-- card -->
          </div><!-- col-3 -->
        </div><!-- row -->
         @if(count($sales)>0)
         <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Product Sales</h6>

          <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>
                    id
                  </th>
                  <th>Product name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @php($i=1)
                @foreach($sales as $val)
                @php($pro=json_decode($val->product_id,true))
                @for($p=0;$p<count($pro);$p++)
                @php($quantity=json_decode($val->quantity,true))
                @php($product=DB::table('products')->where('id',$pro[$p])->first())
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$quantity[$p]}}</td>
                    <td>{{$product->new_price*$quantity[$p]}}</td>
                      <td>{{date('Y-m-d',strtotime($val->created_at))}}</td>
                </tr>

                @endfor
                @endforeach

              </tbody>
            </table>
            {{$sales->links()}}
          </div>
        </div><!-- card -->
        @else
        <div class="col-md">
    <div class="card card-body bg-gray-200">
        <p class="card-text">There Are Not Sales Order Yet</p>
    </div><!-- card -->
</div>
         @endif


@endsection
