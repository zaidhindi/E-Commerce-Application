@extends('auth.master')
@section('content')

  <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Update <span class="tx-info tx-normal">Password</span></div>
        <div class="tx-center mg-b-60">enter your password and confirm it</div>

        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Enter your Password">
        </div><!-- form-group -->
         <div class="form-group">
          <input type="password" class="form-control" id="repassword" placeholder="Enter your Password again">
        </div><!-- form-group -->
<br><br>
<input type="hidden" name="userID"value="{{$user->id}}">
        <button type="submit" class="btn btn-info btn-block UpdatePasswordBtn">Update Password</button>

        <div class="mg-t-60 tx-center">Not yet a member? <a href="{{route('register')}}" class="tx-info">Sign Up</a></div>
      </div><!-- login-wrapper -->
    </div>
    @endsection
    @section('title','Update Password')
    @section('js')
    <script>
        $(document).ready(function(){

    $('.UpdatePasswordBtn').click(function(e){

        e.preventDefault();
        let password = $('#password').val();
        let repassword = $('#repassword').val();
        let userID=$('#userID').val();

        if(password == '') {

            Swal.fire({
                title: 'Error!',
                text: 'Please Enter your new Password for your account',
                icon: 'error',
                confirmButtonText: 'ok'
            })


        }else if(repassword == ''){
               Swal.fire({
                title: 'Error!',
                text: 'Please enter your new Password again for your account',
                icon: 'error',
                confirmButtonText: 'ok'
            })
        }else if(repassword != password){
               Swal.fire({
                title: 'Error!',
                text: 'Passwords dont match',
                icon: 'error',
                confirmButtonText: 'ok'
            })
        }
        else{
            $.ajax({
                method:'post',
                url:'/user/update-password',
                data:{
                    password:password,
                    userID:userID,
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response){
                 if(response.data==1){
                     Swal.fire({
                   title: 'Success!',
                    text: 'password updated succefully',
                   icon: 'success',
                   confirmButtonText: 'ok'
                    })
                 window.location.href='/login'
                  }
                  console.log(response)

                }
            })
        }

    })

})
    </script>

    @endsection
