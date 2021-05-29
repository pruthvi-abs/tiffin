@extends('front.layout.main')
@section('content')

<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
      <div class="row">
          <div class="col-lg-6 col-md-6">
              <h4 class="mb-0 pull-left">Disclaimer</h4>
          </div>
          <div class="col-lg-6 col-md-6">
              <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Disclaimer</p>
          </div>
      </div>
    </div>
</div>
<!-- Section -->
<section class="section page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="disclaimer1">
                    <h3><i class="ti ti-file mr-4 text-primary"></i>Disclaimer</h3>
                    <hr>
                    <div id="disclaimer1_1" class="pb-5">
                        <h4>How does it work?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div id="disclaimer1_2" class="pb-5">
                        <h4>How long does it take?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
