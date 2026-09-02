@extends('auth.master')
@section('content')

  <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Reset <span class="tx-info tx-normal">Password</span></div>
        <div class="tx-center mg-b-60">enter your eamil so we can send you a reset password link</div>

        <div class="form-group">
          <input type="email" class="form-control" id="email" placeholder="Enter your eamil">
        </div><!-- form-group -->
<br><br>
        <button type="submit" class="btn btn-info btn-block loginBtn">Sign In</button>

        <div class="mg-t-60 tx-center">Not yet a member? <a href="{{route('register')}}" class="tx-info">Sign Up</a></div>
      </div><!-- login-wrapper -->
    </div>
    @endsection
    @section('title','Frogot Password')
    @section('js')
    <script>
        $(document).ready(function(){

    $('.loginBtn').click(function(e){

        e.preventDefault();
        let email = $('#email').val();

        if(email == '') {

            Swal.fire({
                title: 'Error!',
                text: 'Please Enter your eamil',
                icon: 'error',
                confirmButtonText: 'Cool'
            })


        }else{
            $.ajax({
                method:'post',
                url:'/user/reset-password',
                data:{
                    email:email,
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response){
                  if(response.data==0){
                     Swal.fire({
                   title: 'Error!',
                    text: 'wrong email',
                   icon: 'error',
                   confirmButtonText: 'ok'
            })

                  }else{
                     Swal.fire({
                title: 'Success!',
                text: 'Reset password sent to your email',
                icon: 'success',
                confirmButtonText: 'ok'
            })

                  }
                  console.log(response)

                }
            })
        }

    })

})
    </script>

    @endsection
