@extends('front.layout.main')
@section('content')


<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6">
                <h4 class="mb-0 pull-left">Thank You</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Thank You</p>
            </div>
        </div>
    </div>
</div>

<!-- Section -->
<section class="section page-content">
    <div class="container">
        <div class="col-lg-12 col-md-12">
          <h3 class="pt-5 pb-5">
             Thanks for contacting us we will be in touch with you shortly.
           </h3>
        </div>
    </div>

</section>


@endsection
