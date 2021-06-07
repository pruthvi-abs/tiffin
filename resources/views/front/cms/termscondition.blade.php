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
                <div class="col-md-12">
                    <div id="disclaimer1">
                        <h3><i class="ti ti-file mr-4 text-primary"></i>Terms & Policy</h3>
                        <hr>
                        <div id="disclaimer1_1" class="pb-5 text-justify">
                            <p class="lead">Prasadam respects your privacy and does not sell, rent or loan any identifiable
                                information regarding its website visitors to any third party.</p>
                            <p class="lead">Any personal information you give to Prasadam will be held with the utmost care
                                and security in accordance with the guidelines set forth in the United State`s Data Protection
                                Act 1998 and will not be used in ways to which you have not consented. We explicitly DO NOT
                                store credit card details. These are encrypted at the time of placing your order by our payment
                                processing company and never revealed to us.</p>
                            <p class="lead">Prasadam will not collect any personal information about individuals, except
                                when specifically and knowingly provided by such individuals. Examples of such information are: 
                                <strong>Name, Postal address, E-mail address and Telephone and Fax numbers</strong>.</p>
                            <p class="lead">The personal information provided by you will only be used by Prasadam to provide
                                you with further news and information about the services and initiatives that are available from
                                Prasadam.</p>
                            {{-- <div id="disclaimer1_1" class="pb-5">
                        <h4>How does it work?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div id="disclaimer1_2" class="pb-5">
                        <h4>How long does it take?</h4>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
