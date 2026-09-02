@extends('backend.master')
@section('title','Support Tickets View')
@section('content')
<div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
                <a class="breadcrumb-item" href="{{route('admin.support.ticket')}}">Support Tickets
                </a>


      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Support Ticket NO -{{$first->ticket_no}}</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
            @foreach($data as $val)
             <div class="row mg-b-20">
            <div class="col-md">
              <div class="card card-body bg-gray-200">
                <p class="card-text">name:    {{$val->user->name}}</p>
                <p class="card-text">title:   {{$val->title}}</p>
                <p class="card-text">content: {{$val->description}}</p>
              </div><!-- card -->
            </div><!-- col -->
            <!-- col -->
            <!-- col -->
          </div>
             @endforeach
             @if ($first->status==0)
             <div style="size: 70ch">
                <textarea name="" id="message" class="form-control"></textarea>
                <button class="btn btn-primary ReplyBtn">Reply</button>
                <input type="hidden" id="title" value="{{$first->title}}">
                 <input type="hidden" id="ticket_no" value="{{$first->ticket_no}}">
             </div>
             
                 
             @endif
         <!-- row -->
        </div><!-- card -->

    </div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.ReplyBtn').click(function(e){
            e.preventDefault();
             let title= $('#title').val();
             let ticket_no = $('#ticket_no').val();
             let message = $('#message').val();
             if(message==''){
                        Swal.fire({
                        title: 'Error!',
                        text: 'You cant reply with nothing you must type somthing..',
                        icon: 'error',
                        confirmButtonText: 'ok'
                        })
             }else{
                $.ajax({
                        method:'post',
                        url:'/admin/support-tickets/reply',
                        data:{
                            title:title,
                            message:message,
                            ticket_no:ticket_no,
                        },
                        headers:{
                         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                        },
                        success:function(response){
                            if(response.data==true){
                           Swal.fire({
                         title: 'Success!',
                        text: 'Your Reply done succesfyly ',
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
    });
</script>
@endsection

