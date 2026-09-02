@extends('backend.master')
@section('title','Contact Us Messages')
@section('content')
<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <span class="breadcrumb-item active">Contact Us</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Contact Us Messages</h5>
          <p>These Messages were Sent From User To Admin</p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">

          <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                    <th>id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php($i=1)
                @foreach($data as $val)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$val->name}}</td>
                    <td><a href="mailto:{{$val->email}}">{{$val->email}}</a></td>
                    <td><a href="tel:{{$val->phone}}"></a>{{$val->phone}}</td>
                    <td>{{mb_substr($val->message,0,80)}}...</td>
                    <td><a  href="{{route('contact.us.delete',['id'=>$val->id])}}"class="btn btn-outline-danger btn-block"><i class="fa fa-trash mg-r-10"></i>Delete</a>
                        <a data-toggle="modal" data-target="#modaldemo{{$val->id}}"  class="btn btn-outline-success btn-block"><i class="fa fa-search mg-r-10"></i>View Message</a>
                    </td>
                </tr>
            <div id="modaldemo{{$val->id}}" class="modal fade">
                    <div class="modal-dialog modal-dialog-vertical-center" role="document">
                        <div class="modal-content bd-0 tx-14">
                        <div class="modal-header pd-y-20 pd-x-25">
                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body pd-25">
                            <p class="mg-b-5">{{$val->message}}</p>
                        </div>
                        <div class="modal-footer">
                         <button type="button" class="btn btn-info pd-x-20">Cancel</button>
                        </div>
                        </div>
                    </div><!-- modal-dialog -->
                    </div>
                 @endforeach


              </tbody>
            </table>
          </div>
        </div><!-- card -->

    </div>
@endsection
