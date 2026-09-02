@extends('backend.master')
@section('title','Support Tickets')
@section('css')
 <style>
    .unread-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: red;
    margin-left: 6px;
    animation: blink 1.2s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}
 </style>

@endsection
@section('content')
 <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
        <span class="breadcrumb-item active">Support Tickets</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>These are Users inquires please find the time to answer to their harms</h5>
        </div><!-- sl-page-title -->


        <div class="card pd-20 pd-sm-40 mg-t-50">

          <div class="table-responsive">
            <table class="table table-hover table-bordered table-primary mg-b-0">
              <thead>
                <tr>
                    <th>Ticket NO</th>
                  <th>User </th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Ticket Date</th>
                 <th>Action</th>

                </tr>
              </thead>
              <tbody>
                    @foreach ($data as $val)
                <tr>
                
                <td>{{$val->ticket_no}} @if($val->unread_count > 0)
        <span class="unread-dot" title="Unread messages"></span>
    @endif</td>
    <td>{{$val->user->name}}</td>
                <td>{{mb_substr($val->title,0,20)}}</td>
                 @if ($val->status==0)
                    <td>open</td>
                 @else
                   <td>close</td>
                 @endif
                 <td>{{Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</td>
                  @if($val->status==0)
                         <td> <a href="{{route('admin.support.ticket.view',['ticket_no'=>$val->ticket_no])}}" class="btn btn-primary">View</a>
                            <a href=""class="btn btn-primary myBtn" ticket_no="{{$val->ticket_no}}">Close</a>
                        </td>
                  @else
                  <td><a href="{{route('admin.support.ticket.view',['ticket_no'=>$val->ticket_no])}}"class="btn btn-primary">View</a></td>
                  @endif

                </tr>
                    @endforeach

              </tbody>
            </table>
          </div><!-- table-responsive -->
        </div><!-- card -->



      </div><!-- sl-pagebody -->

    </div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.myBtn').click(function(e){
            e.preventDefault();
              Swal.fire({
                        title: 'Error!',
                        text: 'Are you sure you want to Close this ticket? ',
                        icon: 'warning',
                        confirmButtonText: 'ok'
                        }).then((result)=>{
                            if(result.isConfirmed){
                             let ticket_no = $(this).attr('ticket_no');
                                        $.ajax({
                                    method:'post',
                                    url:'/admin/support-tickets/close',
                                    data:{
                                        ticket_no:ticket_no,
                                    },
                                    headers:{
                                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                                    },
                                    success:function(response){
                                        if(response.data==true){
                                    Swal.fire({
                                          showCloseButton: true,

                                    title: 'Success!',
                                    text: 'Support Ticket Closed succesfyly ',
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
                   
        })
    });
</script>
@endsection


