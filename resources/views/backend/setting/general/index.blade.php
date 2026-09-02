@extends('backend.master')
@section('title','General Setting')
@section('content')
<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="">Setting</a>
        <span class="breadcrumb-item active">General</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">

        </div><!-- sl-page-title -->





        <div class="card pd-20 pd-sm-40 mg-t-50">

          <div class="table-responsive">
            <table class="table table-hover table-bordered table-primary mg-b-0">
              <thead>
                <tr>
                  <th>name</th>
                  <th>email</th>
                  <th>phone</th>
                  <th>Address</th>
                   <th>logo</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$data->name}}</td>
                  <td>{{$data->email}}</td>
                  <td>{{$data->phone}}</td>
                  <td>{{$data->address}}</td>
                  <td><img  style="width: 80px;height: 80px; object-fit: cover"src="{{Storage::url($data->img)}}" draggable="true" alt=""></td>
                  <td><a href="{{route('setting.general.edit')}}" class="btn btn-success active btn-block mg-b-10">Edit</a></td>

                </tr>
              </tbody>
            </table>
          </div><!-- table-responsive -->

        </div><!-- card -->


      </div><!-- sl-pagebody -->
    </div>
@endsection
