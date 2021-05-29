@extends('front.layout.main')
@section('content')


<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6">
                <h4 class="mb-0 pull-left">About Us</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / About Us</p>
            </div>
        </div>
    </div>
</div>

<!-- Section -->
<section class="section page-content">
    <div class="container">
        <div class="col-lg-12 col-md-12">
            <img src="{{asset('public/frontend')}}/assets/img/photos/about_us.jpg" alt="" class="mb-5">
            <h3>About Gokulham Prasadam</h3>
            <p class="text-justify">Following the Vision and objectives of Gokuldham, Gokuldham Prasadam is founded to present the timeless message of sanatan vedic dharma in daily life.</p>
            <ul>
                <li>Annam Brahma — Food, itself is Brahma, the creator;</li>
                <li>annamnanindyat tadvratam — Do not look down upon anna</li>
                <li>annamnaparicaksita tadvratam — Do not neglect anna</li>
                <li>annambahukurvita tadvratam — Multiply anna many-fold. Ensure an abundance of food all around.</li>
            </ul>
            <p class="text-justify">In our dharma of food, anna is creation, the cycle of life is a food cycle, good food is medicine (sarvaushada), and the growing and sharing of good food, in abundance, is the highest duty.</p>
            <h4>Our mission</h4>
            <p class="text-justify">To use of the freshest ingredients and finest spice combinations, to create delicious Saatvic vegetarian cuisine that is consistent with the tenets of Vaishnav, Jain & Swaminarayan dietary requirements. We aim to serve everyone with warmth and grace and transport them to a world where flavors are exquisite and unforgettable, guaranteeing an unforgettable experience.</p>
            <h4>Incredible Food</h4>
            <p class="text-justify">Gokuldham Prasadam is one of the few places in the greater Atlanta area that can masterfully create the mouthwatering flavors and enticing aromas of a multitude of regional Indian cuisines, as well as several East African Indian delicacies. Our daily tiffin service is hugely popular as are our north Indian curries, street food snacks and south Indian delicacies.Each mouthful will draw our waves of nostalgia of trips to India and East Africa and perfectly represent the authentic flavors of Gujarati, Punjabi, Rajasthani & South Indian cuisine.</p>
            <h4>Prasadam</h4>
            <p class="text-justify">The literal meaning of the Sanskrit word <strong>“prasadam”</strong> is mercy. Offering food and subsequently receiving prasāda is central to the practice of puja. Any food that is offered either physically to the image of God or silently in prayer is considered prasāda. This is what makes our food different.</p>
            <h4>Sattvic diet</h4>
            <p class="text-justify">Sattvic diet is a diet based on foods that contain one of the three yogic qualities (guna) known as sattva. A sattvic diet is sometimes referred to as a yogic diet in modern literature.</p>
            <h4>Vaishnav Food</h4>
            <p class="text-justify">Vaishnav refers to one who is related to Lord Vishnu. As per mythology, Vaishnav food is that which is loved by God.</p>
            <p class="text-justify">Vaishnav food is considered as Satvik food. A satvik diet is based on fruits, dairy products if the cow is fed and milked in the right conditions, nuts, seeds, vegetables, legumes, whole grains etc.</p>
            <p class="text-justify">Vaishnav food is vegetarian but does not include onion and garlic. In India, in most of the states, food which is prepared for offering to gods does not have onion and garlic.</p>
            <p class="text-justify">The best diet for humans, in our opinion, is the healthiest diet that is the best for vitality and that has proven to be the best for thousands of years: the vaishnav diet. The vaishnav diet involves only eating foods offered to Krishna, who tells us exactly what He prefers in the Bhagavad Gita, an ancient philosophical scripture. Eating foods first offered to Krishna will ensure that our food is always blessed and full of spiritual potency.</p>
            <p class="text-justify">The Bhagavad Gita mentions three modes of material nature: goodness (sattva), passion (raja), and ignorance (tama). Krishna prefers foods dear to those in the mode of goodness, or sattvik foods. The three modes of material nature, or trigunas, are also used to classify the nutritional value of foods in Ayurveda.</p>
            <div class="w3-panel w3-light-grey">
                <span style="font-size:150px;line-height:0.6em;opacity:0.2">❝</span>
                <h5 style="margin-top:-40px" class="text-justify"><i>Foods dear to those in the mode of goodness increase the duration of life, purify one’s existence and give strength, health, happiness and satisfaction. Such foods are juicy, fatty, wholesome, and pleasing to the heart.</i></h5>
                <p style="margin-top: -20px;">- From Bhagavad Gita: Chapter 17, Verse 8,said by lord Krishna </p>
            </div>
            <p class="text-justify">This could include nuts, fruits, vegetables, grains, and dairy. Meat, eggs, and alcohol are avoided because they are bad for health and will diminish our life force (pran). Krishna, who is also known as “The Butter Thief” loved eating dairy products such as milk, butter, and yogurt during his childhood as a cowherd boy who helped care for cows. In fact, Krishna is the original protector of cows, a cherished animal in ancient India given the same respect as a mother.</p>
            <p class="text-justify">While fruits and vegetables remain fresh at room temperature for days, untreated meat will spoil in a matter of hours. This is why carnivorous animals have short colons that can digest food in 2 to 4 hours, while humans can easily take half a day.</p>
            <p class="text-justify">Krishna also lists some of the foods he specifically enjoys being offered. In BG 9:26</p>
            <div class="w3-panel w3-light-grey">
                <span style="font-size:150px;line-height:0.6em;opacity:0.2">❝</span>
                <h5 style="margin-top:-40px" class="text-justify"><i>If one offers Me with love and devotion a leaf, a flower, fruit or water, I will accept it.</i></h5>
                <p style="margin-top: -20px;">- From Bhagavad Gita: Chapter 9, Verse 26,said by lord Krishna </p>
            </div>
            <p class="text-justify">Basically, if Krishna wouldn’t eat it, we shouldn’t either.</p>
        </div>
    </div>

</section>

<!-- Section -->
<section class="section section-lg dark bg-dark">

    <!-- BG Image -->
    <div class="bg-image bg-parallax"><img src="{{asset('public/frontend')}}assets/img/photos/bg-croissant.jpg" alt=""></div>

    <div class="container text-center">
        <div class="col-lg-8 push-lg-2">
            <h2 class="mb-3">Would you like to Buy Food?</h2>
            <a href="{{ url('/letseat') }}" class="btn btn-primary"><span>Let’s eat</span></a>
            <a href="{{ url('/catering') }}" class="btn btn-outline-primary"><span>Let’s Cater</span></a>
        </div>
    </div>

</section>


@endsection