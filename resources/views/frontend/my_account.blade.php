@extends('frontend.master')
@section('title','Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_responsive.css')}}">
<style>
    .profile-form{
        width: 60%;
        margin: 2rem auto;
    }
</style>
@endsection
@section('content')
<div class="container">
<form class="profile-form">
    <h3>My Profile</h3>
    <div class="mb-3">
    <label for="name" class="form-label">UserName</label>
    <input type="text" style="color: black" class="form-control" id="name" value="{{$user->name}}">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" style="color: black" class="form-control" id="email" aria-describedby="emailHelp" value="{{$user->email}}">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password">
  </div>

  <button type="submit" class="btn btn-primary update-profile">Save</button>
</form>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function(){
      $('.update-profile').click(function(e){
        e.preventDefault();
        let name =$('#name').val();
        let email  =$('#email').val();
        let password  =$('#password').val();
        if(name==''){
               Swal.fire({
                title: 'Error!',
                text: 'Please enter yourname',
                icon: 'error',
                confirmButtonText: 'ok'
                })
        }else if(email==''){
             Swal.fire({
                title: 'Error!',
                text: 'Please enter your email',
                icon: 'error',
                confirmButtonText: 'ok'
                })
        }else{
             $.ajax({
                        method:'post',
                         url:'/update-profile',
                         data:{
                           name:name,
                           email:email,
                           password:password
                         },
                          headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                     },
                        success:function(response){
                            if(response.data==1){
                               Swal.fire({
                                title: 'Success!',
                                text: 'Your Profile Data updated Successfuly',
                                icon: 'success',
                                confirmButtonText: 'ok'
                                })
                            } else if(response.data==0){
                                 Swal.fire({
                                title: 'Error!',
                                text: 'Something went error please try again',
                                icon: 'error',
                                confirmButtonText: 'ok'
                                })
                            }
                        }
                    })
        }
      })
    });
    </script>
@endsection
