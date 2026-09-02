@extends('auth.master')
@section('content')
  <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">

      <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><span class="tx-info tx-normal">Create New Account</span></div>
            <br><br>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter your name" id="name">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="email" class="form-control" placeholder="Enter your email" id="email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Enter your password" id="password">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Enter your password again" id="repassword">
        </div>
        <!-- form-group -->
       <!-- form-group -->
        <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
        <button type="submit" class="btn btn-info btn-block newAccount">Sign Up</button>

        <div class="mg-t-40 tx-center">Already have an account? <a href="{{route('login')}}" class="tx-info">Sign In</a></div>
      </div><!-- login-wrapper -->
    </div>
@endsection
@section('js')
<script>
        $(document).ready(function(){
            $('.newAccount').click(function(e){
                e.preventDefault();
                var name=$('#name').val();
                var password=$('#password').val();
                var email=$('#email').val();
                var repassword=$('#repassword').val();
                if(name == ''){
                      Swal.fire({
                title: 'Error!',
                text: 'Please Enter your name',
                icon: 'error',
                confirmButtonText: 'ok'
            })
                }else if(email == ''){
                     Swal.fire({
                title: 'Error!',
                text: 'Please Enter your email',
                icon: 'error',
                confirmButtonText: 'ok'
            })
                }else if(password ==''){
                Swal.fire({
                title: 'Error!',
                text: 'Please Enter your password',
                icon: 'error',
                confirmButtonText: 'ok'
            })
                }else if(repassword ==''){
                Swal.fire({
                title: 'Error!',
                text: 'Please Enter your password again',
                icon: 'error',
                confirmButtonText: 'ok'
            })
                }else if(password!=repassword){
                    Swal.fire({
                title: 'Error!',
                text: 'password doesnt match',
                icon: 'error',
                confirmButtonText: 'ok'
            })
                }else{
                    $.ajax({
                        method:'post',
                        url:'/new_account',
                        data:{
                            name:name,
                            password:password,
                            email:email
                        },
                        headers:{
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(responce){
                            if(responce.data==0){
                                 Swal.fire({
                                   title: 'Error!',
                                  text: 'Sorry this account alredy exist',
                                 icon: 'error',
                                  confirmButtonText: 'ok'
                                    })
                            }else if(responce.data==1){
                                window.location.href='/'
                            }
                        }
                    })
                }


            });





        });

</script>
@endsection
@section('title','Register')


