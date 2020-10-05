{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/articles.css')}}">

    <h2>Codinterest Read</h2>
    <br>
    {{--carousel--}}
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('imgs/site/article_cate1.jpg')}}" class="d-block w-100" alt="Comp Sci" height="530px">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Computer Sciences</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('imgs/site/article_cate2.jpg')}}" class="d-block w-100" alt="Math" height="530px">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Mathematics</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('imgs/site/article_cate3.jpg')}}" class="d-block w-100" alt="Science" height="530px">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Sciences & Technologies</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('imgs/site/article_cate4.jpg')}}" class="d-block w-100" alt="Others" height="530px">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Assorted Topics</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <br>
    <hr>
    <br>
    {{--Popular articles--}}
    <h3>Popular Articles</h3>
    <br>
    <div class="popular-articles-container">
    </div>


    <br>
    <hr>
    <br>
    {{--cards--}}
    <h3>Categories</h3>
    <br>
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Computer Sciences</h5>
                <p class="card-text">
                    Using keys to check the official solutions <br>
                    If you use key, the corresponding problem will not give you any rewards.
                </p>
                <a value="{{url('/protected/redeemitem/1')}}" class="card-link btn btn-primary" onclick="conf(this)">Redeem</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mathematics</h5>
                <p class="card-text">
                    Using keys to check the official solutions <br>
                    If you use key, the corresponding problem will not give you any rewards.
                </p>
                <a value="{{url('/protected/redeemitem/2')}}" class="card-link btn btn-primary" onclick="conf(this)">Redeem</a>
            </div>
        </div>
    </div>
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sciences & Technologies</h5>
                <p class="card-text">
                    To certify you as one of the elite at Codinterest. <br>
                    Your username will be shown in silver color. <br>
                    Profile photo will be upgraded<br>
                    <b>You can only redeem once. </b>
                </p>
                <a value="{{url('/protected/redeemitem/3')}}" class="card-link btn btn-primary" onclick="conf(this)">Redeem</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Assorted Topics</h5>
                <p class="card-text">
                    To certify you as one of the global elites at Codinterest. <br>
                    Your username will be shown in golden color. <br>
                    Profile photo will be upgraded<br>
                    You must be a Silver Coder first. <br>
                    <b>You can only redeem once.</b>
                </p>
                <a value="{{url('/protected/redeemitem/4')}}" class="card-link btn btn-primary" onclick="conf(this)">Redeem</a>
            </div>
        </div>
    </div>


@endsection

