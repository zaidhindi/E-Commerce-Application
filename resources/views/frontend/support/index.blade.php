@extends('frontend.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_responsive.css')}}">

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
<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Support tickets</div>
                                 <a href="{{route('user.support.ticket.add')}}" class="btn btn-primary">New ticket</a><br><br>

                            @if(count($data)>0)
                                  <div class="table-responsive"><br>
                              <table class="table table-hover text-center">

                                         <thead>
                                             <tr>
                                                 <th scope="col">Ticket NO</th>
                                                 <th scope="col">Title</th>
                                                 <th scope="col">Status</th>
                                                 <th scope="col">Date</th>
                                                 <th scope="col">Action</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                            @foreach($data as $val)
                                            <tr>
                                            <td>{{$val->ticket_no}}@if($val->unread_count > 0)
        <span class="unread-dot" title="Unread messages"><br>new</span>
    @endif</td>
                                             <td>{{$val->title}}</td>
                                             <td>@if($val->status==0) open @else close @endif</td>
                                                <td>{{ \Carbon\Carbon::parse($val->created_at)->diffForHumans() }}</td>                                            <td>
                                                <a href="{{route('support.view',['id'=>$val->id])}}" class="btn btn-primary">view</a>
                                                @if($val->status==0)
                                              <button class="btn btn-danger BtnClose" ticket_no="{{$val->ticket_no}}">Close</button>
                                                @endif
                                            </td>
                                            </tr>
                                            @endforeach


                                          </tbody>

                                     </table>
                                 </div>
                            @else
                            <div class="text-center">there is no Support ticket</div>
                            @endif

						<!-- Order Total -->


					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.BtnClose').click(function(e){
            e.preventDefault();
              Swal.fire({
                        title: 'Close Ticket!',
                        text: 'Are you sure you want to Close this ticket? ',
                        icon: 'warning',
                        confirmButtonText: 'ok'
                        }).then((result)=>{
                            if(result.isConfirmed){
                             let ticket_no = $(this).attr('ticket_no');
                                        $.ajax({
                                    method:'post',
                                    url:'/user/support-tickets/close',
                                    data:{
                                        ticket_no:ticket_no,
                                    },
                                    headers:{
                                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                                    },
                                    success:function(response){
                                        if(response.data>1){
                                    Swal.fire({
                                          showCloseButton: true,

                                    title: 'Success!',
                                    text: 'Support Ticket Closed succesfyly ',
                                    icon: 'success',
                                    confirmButtonText: 'ok',
                                    denyButtonText:'no',
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