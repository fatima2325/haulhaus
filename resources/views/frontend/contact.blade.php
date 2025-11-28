
@extends('frontend.layouts.main')
@section('main-container')

   <main>

              <section class="form-container">
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                
                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                        <strong>Error!</strong> Please correct the following errors:
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>

                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" placeholder="Write your message here..." required>{{ old('message') }}</textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>

        </section>


    </main>

   @endsection



