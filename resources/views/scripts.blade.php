{{--layui--}}
<script src="{{public_path('layui/layui.js')}}"></script>
{{--bootstrap, Jquery--}}
<script src="{{url('https://code.jquery.com/jquery-3.5.1.slim.min.js')}}" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="{{url('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js')}}" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
{{--Jquery Validator--}}
<script src="{{url('http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js')}}"></script>
<script src="{{asset('scripts/jquery.validate.min.js')}}"></script>
<script src="{{asset('scripts/additional-methods.min.js')}}"></script>
<script src="{{asset('scripts/validate-methods.js')}}"></script>
{{--Animation--}}
<canvas class="fireworks" style="position:fixed;left:0;top:0;z-index:99999999;pointer-events:none;"></canvas>
<script type="text/javascript" src="{{url('https://a-oss.zmki.cn/20190502/baozatexiao.js')}}"></script>
@unless(url()->full() == url('/public/signin') || url()->full() == url('/public/signup'))
    <script type="text/javascript" color="47,135,193" opacity='0.5' zIndex="-2" count="199" src="{{url('http://cdn.bootcss.com/canvas-nest.js/1.0.1/canvas-nest.min.js')}}"></script>
@endunless
{{--Character--}}
<script src="{{url('https://eqcn.ajz.miesnfu.com/wp-content/plugins/wp-3d-pony/live2dw/lib/L2Dwidget.min.js')}}"></script>
<script>
    L2Dwidget.init({
        "model": {
            jsonPath: "https://unpkg.com/live2d-widget-model-haruto@1.0.5/assets/haruto.model.json",
            "scale": 1 },
        "display": {
            "position": "right", "width": 98, "height": 135,
            "hOffset": 0, "vOffset": -20 }, "mobile": { "show": true, "scale": 0.6, "motion": true},
        "react": { "opacityDefault": 1, "opacityOnHover": 0.8 }
    });
</script>

