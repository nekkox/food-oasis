@extends('frontend.layouts.master')

@section('content')
<!--=============================
    BANNER START
==============================-->
@include('frontend.home.components.slider')
<!--=============================
    BANNER END
==============================-->


<!--=============================
    WHY CHOOSE START
==============================-->
@include('frontend.home.components.why-choose')
<!--=============================
    WHY CHOOSE END
==============================-->


<!--=============================
    OFFER ITEM START
==============================-->
@include('frontend.home.components.offer-item')

<!-- CART POPUP START -->
@include('frontend.home.components.cart-popup')
<!-- CART POPUP END -->

<!--=============================
    OFFER ITEM END
==============================-->


<!--=============================
    MENU ITEM START
==============================-->
@include('frontend.home.components.menu-item')
<!--=============================
    MENU ITEM END
==============================-->


<!--=============================
    ADD SLIDER START
==============================-->
@include( 'frontend.home.components.add-slider')
<!--=============================
    ADD SLIDER END
==============================-->


<!--=============================
    TEAM START
==============================-->
@include( 'frontend.home.components.team-start')
<!--=============================
    TEAM END
==============================-->


<!--=============================
    DOWNLOAD APP START
==============================-->
@include('frontend.home.components.app-start')
<!--=============================
    DOWNLOAD APP END
==============================-->


<!--=============================
   TESTIMONIAL  START
==============================-->
@include('frontend.home.components.testimonial-start')
<!--=============================
    TESTIMONIAL END
==============================-->


<!--=============================
    COUNTER START
==============================-->
@include('frontend.home.components.counter-start')
<!--=============================
    COUNTER END
==============================-->


<!--=============================
    BLOG 2 START
==============================-->
@include('frontend.home.components.blog-2-start')
<!--=============================
    BLOG 2 END
==============================-->

@endsection

