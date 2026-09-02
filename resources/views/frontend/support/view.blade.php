@extends('frontend.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_responsive.css')}}">
<style>
    .ticket-wrapper{max-width:800px;margin:40px auto;padding:0 15px;}
    .ticket-header{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);padding:20px 25px;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;}
    .ticket-header h4{margin:0;font-weight:600;}
    .ticket-no{color:#888;font-size:14px;}
    .status-badge{padding:6px 16px;border-radius:20px;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;}
    .status-0{background:#fff3cd;color:#856404;}
    .status-1{background:#d4edda;color:#155724;}
    .messages-box{background:#f7f8fa;border-radius:12px;padding:25px;display:flex;flex-direction:column;gap:16px;}
    .msg{max-width:75%;padding:14px 18px;border-radius:14px;position:relative;}
    .msg-user{background:#4a6cf7;color:#fff;align-self:flex-end;border-bottom-right-radius:4px;}
    .msg-admin{background:#fff;color:#333;align-self:flex-start;border-bottom-right-radius:14px;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,.08);}
    .msg-title{font-size:12px;opacity:.75;margin-bottom:4px;font-weight:600;}
    .msg-desc{font-size:15px;line-height:1.5;margin:0;}
    .msg-meta{display:flex;justify-content:flex-end;align-items:center;gap:6px;margin-top:8px;font-size:11px;opacity:.75;}
    .msg-admin .msg-meta{justify-content:flex-start;}
    .seen-icon{font-size:14px;}
    .reply-box{margin-top:20px;background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);padding:20px;}
    .reply-box textarea{resize:none;}
    .closed-notice{
    margin-top:20px;
    background:#f8d7da;
    color:#721c24;
    border-radius:12px;
    padding:16px 20px;
    text-align:center;
    font-size:14px;
    font-weight:500;
}
    @media(max-width:576px){.msg{max-width:90%;}}
</style>
@endsection
@section('content')
<div class="ticket-wrapper">

    @php
        $first = $data->first() ?? $data[0] ?? null;
        $statusLabels = [0 => 'In Progress', 1 => 'Closed'];
        $statusValue = $first->status ?? 0;
    @endphp

    <div class="ticket-header">
        <div>
            <h4>{{ $first->title ?? 'Support Ticket' }}</h4>
            <span class="ticket-no">Ticket #{{ $first->ticket_no ?? '' }}</span>
            <input type="hidden" value="{{ $first->ticket_no}}" id="ticket_no">
        </div>
        <span class="status-badge status-{{ $statusValue }}">
            {{ $statusLabels[$statusValue] ?? 'Unknown' }}
        </span>
    </div>

    <div class="messages-box">
        @forelse($data as $msg)
            <div class="msg {{ $msg->sender === 'admin' ? 'msg-admin' : 'msg-user' }}">
                <p class="msg-desc" style="color: black">{{ $msg->description }}</p>
                <div class="msg-meta">
                    <span>{{ \Carbon\Carbon::parse($msg->created_at)->format('M d, Y - h:i A') }}</span>
                    @if($msg->sender === 'user')
                        <span class="seen-icon" title="{{ $msg->read ? 'Seen' : 'Not seen yet' }}">
                            {!! $msg->read ? '✓✓' : '✓' !!}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No messages found for this ticket.</p>
        @endforelse
    </div>
    @if($statusValue==0)
     <div class="reply-box">
        <form>
            @csrf
            <div class="mb-2">
                <textarea class="form-control" id="message" rows="3" placeholder="Type your reply..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary SendR">Send Reply</button>
        </form>
    </div>
    @else
     <div class="closed-notice">
        <i class="fa fa-lock"></i>
        This ticket is closed. You can no longer reply.
    </div>
     @endif


</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.SendR').click(function(e){
            e.preventDefault();
             let message= $('#message').val();
             let ticket_no=$('#ticket_no').val();
             if(message==''){
                        Swal.fire({
                        title: 'Error!',
                        text: 'Please fill Reply messge',
                        icon: 'error',
                        confirmButtonText: 'ok'
                        })
             }else{
                $.ajax({
                        method:'post',
                        url:'/support-tickets/update',
                        data:{
                            message:message,
                            ticket_no:ticket_no
                        },
                        headers:{
                         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                        },
                        success:function(response){
                            if(response.status==true){
                                        let bubble = `
                            <div class="msg msg-user">
                                <p class="msg-desc" style="color:black">${response.message}</p>
                                <div class="msg-meta">
                                    <span>${response.created_at}</span>
                                    <span class="seen-icon" title="Not seen yet">✓</span>
                                </div>
                            </div>
                        `;
                        $('.messages-box').append(bubble);
                        $('#message').val(''); // clear textarea
                        $('.messages-box').scrollTop($('.messages-box')[0].scrollHeight);
                            }
                        }
                });
             }
        })
    });
</script>
@endsection
