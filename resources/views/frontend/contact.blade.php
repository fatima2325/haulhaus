
@extends('frontend.layouts.main')
@section('main-container')

   <main>

              <section class="form-container">
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="#">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" placeholder="Write your message here..." required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>

        </section>


    </main>

   @endsection



