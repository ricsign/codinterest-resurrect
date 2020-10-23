{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/redeem.css')}}">
    @if(session()->get('errormsg'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{session()->get('errormsg')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->get('successmsg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session()->get('successmsg')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <h2 class="title">Redeem Center</h2>
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Key</h5>
                <h6 class="card-subtitle mb-2 text-muted">10 Coins</h6>
                <p class="card-text">
                    Using keys to check the official solutions <br>
                    If you use key, the corresponding problem will not give you any rewards.
                </p>
                <a value="{{url('/protected/redeemitem/1')}}" class="card-link btn btn-primary" onclick="conf(this)">Redeem</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">10 Keys</h5>
                <h6 class="card-subtitle mb-2 text-muted">90 Coins</h6>
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
                <h5 class="card-title"><span style="color: silver">Silver Coder</span></h5>
                <h6 class="card-subtitle mb-2 text-muted">1000 Coins</h6>
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
                <h5 class="card-title"><span style="color: gold">Gold Coder</span> + 5 keys</h5>
                <h6 class="card-subtitle mb-2 text-muted">2000 Coins</h6>
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
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><span style="color: red">Red Coder</span> + 50 keys</h5>
                <h6 class="card-subtitle mb-2 text-muted">4500 Coins</h6>
                <p class="card-text">
                    The greatest honor at Codinterest. <br>
                    To certify you as one of the best coders at Codinterest. <br>
                    Your username will be shown in red color. <br>
                    Your username will be on the first page. <br>
                    Profile photo will be upgraded<br>
                    You will be sincerely invited to collaborate. <br>
                    You must be a Gold Coder first. <br>
                    <b>You can only redeem once. </b>
                </p>
                <a value="{{url('/protected/redeemitem/5')}}" class="card-link btn btn-primary" onclick="conf(this)">Redeem</a>
            </div>
        </div>
    </div>

    <script>
        // confirmation to redeem
        function conf(obj) {
            if(confirm('Are you sure to redeem this item?'))
                location = obj.getAttribute('value');
        }
    </script>
@endsection
