@extends('layouts.frontbase')

@section('content')


    <div class="space bg-smoke">
        <div class="container">
            <div class="title-area text-center">
                <h2 class="sec-title">Directly call us and let us know how we can serve you.</h2>
            </div>
            <div class="row gy-4 justify-content-center">

                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid">
                        <div class="about-contact-icon">
                            <img src="assets/img/icon/call.svg" alt="">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="box-title">Phone Number</h6>
                            <p class="about-contact-details-text"><a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></p>
                            <p class="about-contact-details-text"><a href="tel:{{ $setting->phone1 }}">{{ $setting->phone1 }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid">
                        <div class="about-contact-icon">
                            <img src="assets/img/icon/mail.svg" alt="">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="box-title">Email Address</h6>
                            <p class="about-contact-details-text"><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid style2">
                        <div class="about-contact-icon">
                            <img src="assets/img/icon/location-dot2.svg" alt="">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="box-title">Our Address</h6>
                            <p class="about-contact-details-text">{{ $setting->address }}</p>
                            {{-- <p class="about-contact-details-text">Rwanda</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="space-extra2-top space-extra2-bottom" data-bg-src="assets/img/bg/contact.jpg">
        <div class="container">
            <div class="row flex-row-reverse justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="video-box1">
                        <a href="https://youtube.com/shorts/ks01kSxAmi4" class="play-btn style2 popup-video"><i class="fa-sharp fa-solid fa-play"></i></a>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div>
                    <form id="booking-form" class="contact-form2" action="{{ route('bookNow') }}" method="POST" data-whatsapp="{{ $whatsappNumber }}">
                            @csrf
                
                        <h5 class="sec-title mb-30 text-capitalize">
                            Complete the form to book your stay. It is saved for the hotel and opens WhatsApp with the same details so nothing is missed.
                        </h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="row">

                            <!-- Select Room -->
                            <div class="form-group col-12">
                                <select name="room_id" id="room_id" class="form-select nice-select">
                                    <option value="" selected>Select A Room</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>{{ $room->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Other Services -->
                            <div class="form-group col-12">
                                <select name="facility_id" id="facility_id" class="form-select nice-select">
                                    <option value="" selected>Other Services</option>
                                    @foreach ($facilities as $facility)
                                        <option value="{{ $facility->id }}" @selected(old('facility_id') == $facility->id)>{{ $facility->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <label for="date_in">Check-in</label>
                                <input type="date" class="form-control" name="date_in" id="date_in" value="{{ old('date_in') }}">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <label for="date_out">Check-out</label>
                                <input type="date" class="form-control" name="date_out" id="date_out" value="{{ old('date_out') }}">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="number" class="form-control" name="nights" id="nights" min="1" max="365" value="{{ old('nights') }}" placeholder="Nights">
                                <img src="assets/img/icon/night.svg" alt="">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="number" class="form-control" name="guests" id="guests" min="1" max="100" value="{{ old('guests') }}" placeholder="Guests">
                                <img src="assets/img/icon/user.svg" alt="">
                            </div>
                            <!-- Additional Request -->
                            <div class="form-group col-12">
                                <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder="Any Additional Request?">{{ old('message') }}</textarea>
                                <img src="assets/img/icon/chat.svg" alt="">
                            </div>

                            <!-- Full Name -->
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" name="names" id="guest_name" value="{{ old('names') }}" placeholder="Your Full Name" required>
                                <img src="assets/img/icon/user.svg" alt="">
                            </div>

                            <!-- Email & Phone on same line -->
                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="email" class="form-control" name="email" id="guest_email" value="{{ old('email') }}" placeholder="Your Email">
                                <img src="assets/img/icon/mail.svg" alt="">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="tel" class="form-control" name="phone" id="guest_phone" value="{{ old('phone') }}" placeholder="Your Phone (WhatsApp)" required>
                                <img src="assets/img/icon/phone.svg" alt="">
                            </div>
                            <!-- Submit Button -->
                            <div class="form-btn col-12 mt-24">
                                <button type="submit" class="th-btn style3">
                                    Book on WhatsApp <img src="assets/img/icon/plane.svg" alt="">
                                </button>
                            </div>
                        </div>

                        <p class="form-messages mb-0 mt-3">Your request is stored for the hotel, and WhatsApp opens in a new tab with these details.</p>
                    </form>

                    <script>
                        document.getElementById('booking-form').addEventListener('submit', function (event) {
                            var form = event.currentTarget;
                            var names = form.names.value.trim();
                            var phone = form.phone.value.trim();
                            var dateIn = form.date_in.value;
                            var dateOut = form.date_out.value;

                            if (!names || !phone) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Missing details',
                                    text: 'Please enter your name and phone number so the booking can be confirmed.',
                                    confirmButtonColor: '#d33'
                                });
                                return;
                            }

                            if (dateIn && dateOut && dateOut < dateIn) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Check the dates',
                                    text: 'Check-out cannot be earlier than check-in.',
                                    confirmButtonColor: '#d33'
                                });
                                return;
                            }

                            var selectedLabel = function (select) {
                                if (!select || !select.value) {
                                    return 'Not specified';
                                }
                                return select.options[select.selectedIndex].text.trim();
                            };

                            var nights = form.nights.value.trim();
                            if (!nights && dateIn && dateOut) {
                                var start = new Date(dateIn);
                                var end = new Date(dateOut);
                                var diff = Math.round((end - start) / 86400000);
                                if (diff > 0) {
                                    nights = String(diff);
                                }
                            }

                            var message = [
                                'Hello Kivu Peace View Hotel, I would like to book a stay.',
                                '',
                                'Name: ' + names,
                                'Phone: ' + phone,
                                'Email: ' + (form.email.value.trim() || 'Not specified'),
                                'Room: ' + selectedLabel(form.room_id),
                                'Service: ' + selectedLabel(form.facility_id),
                                'Check-in: ' + (dateIn || 'Not specified'),
                                'Check-out: ' + (dateOut || 'Not specified'),
                                'Nights: ' + (nights || 'Not specified'),
                                'Guests: ' + (form.guests.value.trim() || 'Not specified'),
                                'Request: ' + (form.message.value.trim() || 'None')
                            ].join('\n');

                            var url = 'https://wa.me/' + form.dataset.whatsapp + '?text=' + encodeURIComponent(message);
                            window.open(url, '_blank', 'noopener,noreferrer');
                        });
                    </script>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection