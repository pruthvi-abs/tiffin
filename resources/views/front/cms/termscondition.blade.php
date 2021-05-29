@extends('front.layout.main')
@section('content')

<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
      <div class="row">
          <div class="col-lg-6 col-md-6">
              <h4 class="mb-0 pull-left">Terms & Condition</h4>
          </div>
          <div class="col-lg-6 col-md-6">
              <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Terms & Condition</p>
          </div>
      </div>
    </div>
</div>

<section class="section page-content">

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!-- Side Navigation -->
                <nav id="side-navigation" class="stick-to-content pt-4" data-local-scroll="">
                    <ul class="nav nav-vertical">
                        <li class="nav-item">
                            <a href="#faq1" class="nav-link">General</a>
                            <ul>
                                <li class="nav-item"><a href="#faq1_1" class="nav-link">How does it work?</a></li>
                                <li class="nav-item"><a href="#faq1_2" class="nav-link">How long does it take?</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#faq2" class="nav-link">Delivery</a>
                            <ul>
                                <li class="nav-item"><a href="#faq2_1" class="nav-link">How does it work?</a></li>
                                <li class="nav-item"><a href="#faq2_2" class="nav-link">How long does it take?</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#faq3" class="nav-link">Payments</a>
                            <ul>
                                <li class="nav-item"><a href="#faq3_1" class="nav-link">How does it work?</a></li>
                                <li class="nav-item"><a href="#faq3_2" class="nav-link">How long does it take?</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-8 push-md-1">
                <div id="faq1">
                    <h3><i class="ti ti-file mr-4 text-primary"></i>General info</h3>
                    <hr>
                    <div id="faq1_1" class="pb-5">
                        <h4>How does it work?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div id="faq1_2" class="pb-5">
                        <h4>How long does it take?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
                <div id="faq2">
                    <h3><i class="ti ti-package mr-4 text-primary"></i>Delivery</h3>
                    <hr>
                    <div id="faq2_1" class="pb-5">
                        <h4>How does it work?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div id="faq2_2" class="pb-5">
                        <h4>How long does it take?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
                <div id="faq3">
                    <h3><i class="ti ti-wallet mr-4 text-primary"></i>Payments</h3>
                    <hr>
                    <div id="faq3_1" class="pb-5">
                        <h4>How does it work?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div id="faq3_2" class="pb-5">
                        <h4>How long does it take?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
