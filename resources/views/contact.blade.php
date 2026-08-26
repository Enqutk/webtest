@extends('layouts.inner')

@section('title', 'Contact Us')
@section('eyebrow', 'Get in touch')
@section('page_title', 'Contact Us')
@section('description', 'Reach Veritas Afrika for civil engineering and infrastructure consultancy.')

@section('page')
<section class="hz-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="hz-form" method="POST" action="{{ route('contact.send', ['recipient' => $data['email'][0] ?? config('mail.from.address')]) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name *" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email *" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Phone *" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" placeholder="Subject *" value="{{ old('subject') }}" required>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="7" placeholder="Message *" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn-hz" type="submit">Send message <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-5">
                <div class="hz-contact-panel">
                    <h3>Contact details</h3>

                    <div class="hz-contact-item">
                        <div class="label">Email</div>
                        @forelse(($data['email'] ?? []) as $email)
                            <div><a href="mailto:{{ $email }}">{{ $email }}</a></div>
                        @empty
                            <div class="text-muted">Not configured</div>
                        @endforelse
                    </div>

                    <div class="hz-contact-item">
                        <div class="label">Phone</div>
                        @forelse(($data['phone'] ?? []) as $phone)
                            <div><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></div>
                        @empty
                            <div class="text-muted">Not configured</div>
                        @endforelse
                    </div>

                    <div class="hz-contact-item">
                        <div class="label">Address</div>
                        <div>{{ $data['address'] ?? 'Not configured' }}</div>
                    </div>

                    <div class="hz-contact-item mb-0">
                        <div class="label">Working hours</div>
                        @forelse(($data['working_days'] ?? []) as $slot)
                            @if(isset($slot['days'], $slot['from'], $slot['to']))
                                <div>{{ implode('-', $slot['days']) }}: {{ substr($slot['from'], 0, 5) }} – {{ substr($slot['to'], 0, 5) }}</div>
                            @endif
                        @empty
                            <div class="text-muted">Not configured</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!empty($data['map']))
<section class="pb-5">
    <div class="container">
        <div class="hz-map border border-hz">
            {!! $data['map'] !!}
        </div>
    </div>
</section>
@endif
@endsection
