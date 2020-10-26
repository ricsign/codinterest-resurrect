{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/contribute.css')}}">

    <h2 class="title">Contribute Center</h2>
    <br>
    {{--contribution card--}}
    <div class="card-group">
        <div class="card">
            <img src="{{asset('imgs/site/contribute1.jpg')}}" class="card-img-top" alt="Contribute 1" height="43%">
            <div class="card-body">
                <h5 class="card-title">Contribute A Problem</h5>
                <p class="card-text">
                    Contribute a problem that you think it's intriguing, challenging or special. <br>
                    We highly appreciate your contribution. <br>
                    <span style="color:red">You will receive 500 ~ 1500 Coins upon a single approval</span> <br>
                </p>
                <button class="btn btn-primary" onclick="contribution(1)">Contribute</button>
            </div>
        </div>

        {{--contribution card--}}
        <div class="card">
            <img src="{{asset('imgs/site/contribute2.jpg')}}" class="card-img-top" alt="Contribute 2" height="43%">
            <div class="card-body">
                <h5 class="card-title">Contribute An Article</h5>
                <p class="card-text">
                    Contribute an article that you think it's great for users. It can be math, computer science or other
                    subjects.<br>
                    We highly appreciate your contribution. <br>
                    <span style="color:red">You will receive 300 ~ 1800 Coins upon a single approval</span> <br>
                </p>
                <button class="btn btn-primary" onclick="contribution(2)">Contribute</button>
                <br>
            </div>
        </div>

        {{--contribution card--}}
        <div class="card">
            <img src="{{asset('imgs/site/contribute3.jpg')}}" class="card-img-top" alt="Contribute 3" height="43%">
            <div class="card-body">
                <h5 class="card-title">Contribute A Section</h5>
                <p class="card-text">
                    Contribute a section such as testcases, solutions, website improvement or etc.<br>
                    We highly appreciate your contribution. <br>
                    <span style="color:red">You will receive 100 ~ 1500 Coins upon a single approval</span> <br>
                </p>
                <button class="btn btn-primary" onclick="contribution(3)">Contribute</button>
            </div>
        </div>
    </div>
    <br>
    <small>P.S. If you want to upload a file(s) or image(s), please send it/them to my email at <a
            href="mailto:qq1955293190@gmail.com">qq1955293190@gmail.com</a></small>
    <br><br>
    <div id="contribute">
    </div>

    <script>
        // pop up the contribution form
        function contribution(type) {
            let target_top = $("#contribute").offset().top;
            // type 1: problem, type 2: article, type 3: section
            if (type === 1) {
                $('#contribute').html('<iframe src="https://docs.google.com/forms/d/e/1FAIpQLScAMxz22YAOAu7mGVNibD72heIZX7S3VOGnSn4xwqerSJ3tIA/viewform?embedded=true" width="100%" height="1895" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>');
                $("html,body").animate({scrollTop: target_top}, 1000);
            } else if (type === 2) {
                $('#contribute').html('<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSd41De7h-8o4XoskRpxH9BwA_BoJzmhnKoG5gj-dOvngzq7Zw/viewform?embedded=true" width="100%" height="1420" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>');
                $("html,body").animate({scrollTop: target_top}, 1000);
            } else if (type === 3) {
                $('#contribute').html('<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf7-sacLEENm9FI1LGMhzP7-r4crZhS9DgeCTTzrSiaor7E4Q/viewform?embedded=true" width="100%" height="1164" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>');
                $("html,body").animate({scrollTop: target_top}, 1000);
            }
        }
    </script>

@endsection
