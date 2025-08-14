@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="page-content">

        @php
        $heroFeatures = [
            [
                'title' => 'Professionalism',
                'description' => 'Our team consists of experienced leaders recognized regionally and internationally for their expertise. We uphold the highest standards in every project.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 512 512"><path d="M96.81,372.885a46.429,46.429,0,0,0-46.38,46.37A45.537,45.537,0,0,0,51,426.5a46.372,46.372,0,0,0,91.61,0,45.537,45.537,0,0,0,.57-7.24A46.421,46.421,0,0,0,96.81,372.885Zm0,57.49a11.115,11.115,0,1,1,11.11-11.12A11.135,11.135,0,0,1,96.81,430.375Zm142.01-27.61a31.435,31.435,0,1,0,31.44,31.43A31.466,31.466,0,0,0,238.82,402.765Zm0,37.47a6.035,6.035,0,1,1,6.04-6.04A6.047,6.047,0,0,1,238.82,440.235ZM505,412.205H491.616V326.311a16.289,16.289,0,0,0-16.271-16.271H386.2a16.289,16.289,0,0,0-16.271,16.271v85.894H356.09V194.7a7,7,0,0,0-7-7H328.82V53.365a7,7,0,0,0-7-7h-27.3a7,7,0,0,0-7,7v152.57q-8.13-14.085-16.26-28.18l-10.95-18.96c-15.37-26.61-41.82-41.88-72.57-41.88H63.9a7,7,0,0,0-7,7v27.27a7,7,0,0,0,7,7H76.17v142.33H58.65a41.277,41.277,0,0,0-37.52,23.13L4.49,356.675A40.6,40.6,0,0,0,0,375.575v52.33a7,7,0,0,0,7.01,7H38.49a59.819,59.819,0,0,1-2.04-14c-.01-.55-.02-1.1-.02-1.65a60.375,60.375,0,0,1,120.75,0c0,.55-.01,1.1-.02,1.65a59.819,59.819,0,0,1-2.04,14h38.27c-.01-.24-.01-.47-.01-.71a45.44,45.44,0,0,1,90.88,0c0,.24,0,.47-.01.71h3.27v7.82a7.01,7.01,0,0,0,7,7.01h27.3a5.374,5.374,0,0,0,.7-.04h.02a5.374,5.374,0,0,0,.7.04H505a7.01,7.01,0,0,0,7-7.01v-23.52A7,7,0,0,0,505,412.205Zm-78.1-88.161h7.739V337.2H426.9Zm-42.973,2.267a2.3,2.3,0,0,1,2.268-2.267h26.7V344.2a7,7,0,0,0,7,7h21.742a7,7,0,0,0,7-7V324.044h26.7a2.3,2.3,0,0,1,2.268,2.267v85.894H383.928Zm-280.488-25.8v-5.07h96.8v34.92H190.66A26.768,26.768,0,0,1,170.68,322l-8.76-8.9a40.634,40.634,0,0,0-29.96-12.58H103.44Zm184.08-15.71-4.48-4.08-55.83-50.87h0l4.578-4.584a7,7,0,0,0-9.91-9.895l-19.5,19.531a7,7,0,1,0,9.909,9.895l5.023-5.03,0,0,70.21,63.97v26.62H214.246v-34.92h.021c4.617,0,8.373-3.14,8.373-7v-13.5c0-11.31-11-20.52-24.521-20.52H103.44V151.185a7,7,0,0,1,7-7h61.54c30.74,0,57.2,15.26,72.59,41.88l42.95,74.42Zm-184.08-16.38h94.679c4.282,0,7.763,2.93,7.763,6.52v6.49H103.44Zm211.38,167.3h-13.3V60.365h13.3Zm183.17,0H328.82V201.705h13.27v217.5a7,7,0,0,0,7,7h148.9Z"></path></svg>'
            ],
            [
                'title' => 'Client-Centric Approach',
                'description' => 'Getting our clients what they deserve" is our mission. We prioritize understanding your goals to ensure our services perfectly align with your vision.',
                'icon' => '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m490.9 465.985h-52.67a11.985 11.985 0 0 0 11.34-11.87v-33.57h-178.67v33.57a11.886 11.886 0 0 0 11.88 11.87h-201.025a5.025 5.025 0 0 0 -.54-.08 20.92 20.92 0 0 1 -18.81-20.64v-52.55h194.495v-14.01h-194.495v-168.94h268.87v12.7h14v-79.26a34.752 34.752 0 0 0 -34.72-34.72h-49.607v-20.894a7 7 0 0 0 -7-7h-114.21a7 7 0 0 0 -7 7v20.894h-49.6a34.761 34.761 0 0 0 -34.73 34.72v302.06a34.514 34.514 0 0 0 6.98 20.72h-34.283a7.008 7.008 0 0 0 -7 7v25.015a7.008 7.008 0 0 0 7 7h469.795a7.008 7.008 0 0 0 7-7v-25.01a7.008 7.008 0 0 0 -7-7.005zm-344.16-371.392h100.2v13.892h-100.2zm-63.6 27.892h227.42a20.75 20.75 0 0 1 20.72 20.72v52.56h-268.875v-52.56a20.752 20.752 0 0 1 20.73-20.72zm400.76 368.5h-455.795v-10.985h455.795zm-286.95-262.26a6.984 6.984 0 0 0 -5.2 2.31c-23.21 25.73-37.08 49.35-41.23 70.19-3.65 18.34.56 34.45 11.84 45.35 9.16 8.84 21.76 13.26 34.38 13.26 12.66 0 25.33-4.45 34.53-13.34 11.31-10.93 15.55-27.04 11.95-45.36-4.1-20.84-17.92-44.43-41.08-70.1a6.978 6.978 0 0 0 -5.195-2.31zm24.59 107.7c-12.73 12.3-36.76 12.34-49.45.08-7.85-7.59-10.56-18.84-7.83-32.54 3.29-16.55 14.55-36.37 32.69-57.62 18.07 21.19 29.28 40.96 32.53 57.49 2.685 13.7-.055 24.97-7.945 32.59zm201.33-136.95a7 7 0 0 1 7 7v15.99h-70.24v-15.99a7 7 0 0 1 7-7zm-140.09 36.99h154.91a11.894 11.894 0 0 1 11.88 11.88v33.555h-178.67v-33.56a11.894 11.894 0 0 1 11.875-11.875zm-11.88 170.08h178.67v-110.63h-178.67zm55.59-51c2.91-14.6 12.54-31.05 28.62-48.88a7.008 7.008 0 0 1 10.4 0c16.04 17.79 25.64 34.22 28.51 48.82 2.6 13.26-.52 24.95-8.78 32.94a37.217 37.217 0 0 1 -50.04.05c-8.255-7.97-11.355-19.67-8.715-32.93zm18.44 22.86c-8.63-8.34-8.68-27.35 15.38-56.35 23.97 28.92 23.86 47.93 15.2 56.3-7.885 7.61-22.745 7.63-30.585.05zm-188.945-314.43a7 7 0 0 1 7-7h25.17v-35.46a14.515 14.515 0 0 1 14.48-14.51h200.81v167.21h14.74a7.005 7.005 0 0 1 0 14.01h-46.88a7.005 7.005 0 1 1 0-14.01h14.74v-142.81a7.01 7.01 0 0 0 -7.01-7h-163.235a10.245 10.245 0 0 0 -10.24 10.23v22.34h25.15a7.005 7.005 0 0 1 0 14.01h-67.72a7 7 0 0 1 -7.005-7.01z"></path></svg>'
            ],
            [
                'title' => 'Regional Impact',
                'description' => 'We address local development challenges using effective communication grounded in local realities. We build consensus and create feedback mechanisms for continuous monitoring and evaluation.',
                'icon' => '<svg id="pbmit_21" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m464.466 169.1h-13v-22.091a6.574 6.574 0 0 0 -6.565-6.574h-184.913a6.568 6.568 0 0 0 -6.564 6.574v97.191l13.129 5.457v-13.519h171.785v24.262.087s0 .057 0 .086v44.7.086s0 .057 0 .086v44.7.086s0 .057 0 .087v44.682.086s0 .057 0 .086v44.7.086s0 .057 0 .087v13.891h-85.18v-154.057l-147.975-61.51a3.033 3.033 0 0 1 -.544-.225l-23.285-9.678v225.465h-152.298v-333.293l81.916 34.042.047.019.619.253.038.019 89.193 37.062v30.319l13.131 5.458v-40.157a6.574 6.574 0 0 0 -4.042-6.067l-35.843-14.893-6.125-87.037a9.893 9.893 0 0 0 7.672-9.63v-15.212a9.9 9.9 0 0 0 -9.885-9.884h-50.219a9.9 9.9 0 0 0 -9.884 9.884v15.212a9.9 9.9 0 0 0 9.143 9.856l-6.574 59.437-83.229-34.586a6.573 6.573 0 0 0 -9.088 6.068v349.7a6.567 6.567 0 0 0 6.565 6.565h422.409a6.572 6.572 0 0 0 6.565-6.565v-13.981h31.473v13.98a6.567 6.567 0 1 0 13.133 0v-259.8a31.645 31.645 0 0 0 -31.605-31.6zm-345.666-111.041h43.729v8.722h-43.729zm9.228 21.851h26.811l5.711 81.147-39.678-16.486zm178.025 374.021v-112.179h-77.593v112.179h-13.13v-118.743a6.56 6.56 0 0 1 6.565-6.565h90.732a6.565 6.565 0 0 1 6.564 6.565v118.743zm145.415-155.131v-31.74h31.473v31.74zm31.473 13.133v31.74h-31.473v-31.74zm-31.473-58.006v-31.743h31.473v31.739zm0 102.879h31.473v31.712h-31.473zm13-174.573a18.5 18.5 0 0 1 18.473 18.467v8.347h-31.473v-26.818zm-26.128 3.22v13.129h-171.787v-13.133zm13.13 247.938v-31.74h31.473v31.74z"></path></svg>'
            ]
        ];

        $aboutFeatures = [
            'Professionalism',
            'Client-Centric Approach',
            'Regional Impact'
        ];

        $blogPosts = [
            [
                'title' => 'The Role of Energy Storage in the Transition to Renewables',
                'excerpt' => 'When evaluating a single group or company, its dominant source of revenue is typically used&hellip;',
                'image' => './assets/images/homepage-2/blog/blog-img-01.jpg',
                'url' => 'blog-single-details.html',
                'date' => '06',
                'month' => 'Feb',
                'author' => 'Alex joy',
                'category' => 'Chemical',
                'categoryUrl' => 'blog-classic.html',
                'comments' => '3'
            ],
            [
                'title' => 'Automation & Human-Robot Collab: The New Workforce',
                'excerpt' => 'When evaluating a single group or company, its dominant source of revenue is typically used&hellip;',
                'image' => './assets/images/homepage-2/blog/blog-img-06.jpg',
                'url' => 'blog-single-details.html',
                'date' => '06',
                'month' => 'Feb',
                'author' => 'Alex joy',
                'category' => 'Engineering',
                'categoryUrl' => 'blog-classic.html',
                'comments' => '3'
            ]
        ];
        @endphp

        <!-- Hero Features Section -->
        <x-hero-features :features="$heroFeatures" />

        <!-- About Section -->
        <x-about-section 
            :features="$aboutFeatures"
            subtitle="Who We Are"
            title="Veritas Afrika Co.Ltd"
            description="Veritas Afrika Co.Ltd is a multi-disciplinary company of professional consultants specializing in a wide range of civil engineering works. We provide expert services to government, non-government, and private-sector customers."
            buttonText="Discover More"
            buttonUrl="#"
        />
        <!-- CTA Section -->
        <x-cta-section />
        
        <x-service-section :services="$services" />

    

        <!-- Video Section -->
        <x-video-section />

        <!-- Blog Section -->
        <x-blog-section 
            title="Latest News & Articles"
            subtitle="Stay Updated"
            :posts="$blogPosts"
        />

    </div>
    <!-- Page Content End -->
@endsection

