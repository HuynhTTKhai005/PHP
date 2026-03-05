@extends('layouts.sincay')

@section('content')
    <!-- Pháº§n Header vá»›i tiÃªu Ä‘á» -->
    <section class="titles text-center text-white"
        style="background:   url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">LiÃªn há»‡ Sincay</h2>
        </div>
    </section>

    <!-- Pháº§n chÃ­nh vá»›i map vÃ  form liÃªn há»‡ -->
    <section class="spicy-contact-section">
        <div class="container">
            <!-- Google Maps -->
            <div class="spicy-map-container">
                <div class="spicy-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29804.32622626954!2d106.64019445!3d10.7750359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ea144839ef1%3A0x798819bdcd0522b0!2zQ2FvIMSQ4bqzbmcgQ8O0bmcgTmdo4buHIFRow7RuZyBUaW4gVFAuSENN!5e1!3m2!1svi!2s!4v1765330404359!5m2!1svi!2s"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

             
           
            <!-- ThÃ´ng tin liÃªn há»‡ -->
            <div class="spicy-info-container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="spicy-info-box">
                            <div class="spicy-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="spicy-info-title">Äá»‹a Äiá»ƒm</h4>
                                <p class="spicy-info-text">
                                    123 ÄÆ°á»ng áº¨m Thá»±c, Quáº­n 1<br>
                                    ThÃ nh phá»‘ Há»“ ChÃ­ Minh, Viá»‡t Nam
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="spicy-info-box">
                            <div class="spicy-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="spicy-info-title">Gá»i Cho ChÃºng TÃ´i</h4>
                                <p class="spicy-info-text">
                                    (+84) 81 234 5678<br>
                                    (+84) 84 273 9991
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="spicy-info-box">
                            <div class="spicy-info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="spicy-info-title">Giá» Má»Ÿ Cá»­a</h4>
                                <p class="spicy-info-text">
                                    Thá»© 2 - Thá»© 6: 9:00 - 22:00<br>
                                    Thá»© 7 & CN: 9:00 - 23:00
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

