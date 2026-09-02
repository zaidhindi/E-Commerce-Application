@extends('frontend.master')
@section('css')
<link rel="stylesheet" type="text/css" href="styles/contact_styles.css">
<link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">
@endsection
@section('title','Contact Us')
@section('content')
<div class="contact_info">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="images/contact_1.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Phone</div>
								<div class="contact_info_text"><span style="size: 33ch">+962</span>{{$site->phone}}</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="images/contact_2.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Email</div>
								<div class="contact_info_text">{{$site->email}}</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="images/contact_3.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Address</div>
								<div class="contact_info_text">{{$site->address}}</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Contact Form -->

	<div class="contact_form">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_form_container">
						<div class="contact_form_title">Get in Touch</div>

						<form action="{{route('contact.us.submit')}}" method="post"id="contact_form">
                            @csrf
							<div class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
								<input type="text" name="name" value="{{old('name')}}"id="contact_form_name" class="contact_form_name input_field" placeholder="Your name">
                                @error('name')
                                   <span style="color: red">{{$message}}</span>
                                @enderror
								<input type="text" name="email" value="{{old('email')}}" id="contact_form_email" class="contact_form_email input_field" placeholder="Your email" >
                                 @error('email')
                                   <span style="color: red">{{$message}}</span>
                                @enderror
								<input type="text"  name="phone" value="{{old('phone')}}"id="contact_form_phone" class="contact_form_phone input_field" placeholder="Your phone number">
                                 @error('phone')
                                   <span style="color: red">{{$message}}</span>
                                @enderror
							</div>
							<div class="contact_form_text">
								<textarea id="contact_form_message"value="{{old('message')}}" class="text_field contact_form_message" name="message" rows="4" placeholder="Message"></textarea>
                                 @error('message')
                                   <span style="color: red">{{$message}}</span>
                                @enderror
							</div>
							<div class="contact_form_button">
								<button type="submit" class="button contact_submit_button">Send Message</button>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
		<div class="panel"></div>
	</div>
@endsection

@section('js')
<script src="js/contact_custom.js"></script>
@endsection()
