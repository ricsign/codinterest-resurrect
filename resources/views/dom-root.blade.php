<script>
    $(document).ready(function(){
        // previous button
        let previousButton = $("#previous");
        previousButton.click(function (){
            @if(url()->current() != url()->previous())
                location = "{{url()->previous()}}";
            @else
                location = "{{url('/public/index')}}";
            @endif
        });
        previousButton.hover(function (){
            previousButton.attr("src","{{asset('imgs/site/previous2.png')}}");
        }, function (){
            previousButton.attr("src","{{asset('imgs/site/previous.png')}}");
        });

    });
</script>
