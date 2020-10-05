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

        // allow user to scroll once the sidebar passes height limit
        let sidebar = $('#sidebar')[0];
        if(sidebar.style.height > $(window).height()){
            sidebar.style.overflow = "scroll";
        }
        else{
            sidebar.style.overflow = "auto";
        }
    });

    // sidebar
    function toggleSideBar(){
        let sidebar = $('#sidebar');
        let main = $('.main')[0];

        // close sidebar
        if(sidebar.hasClass('show')){
            sidebar.removeClass('show');
            sidebar.addClass('hide');
            document.body.style.marginLeft = "auto";
            document.body.style.backgroundColor = "#f6f6f6";
        }
        // open sidebar
        else{
            sidebar.removeClass('hide');
            sidebar.addClass('show');
            document.body.style.marginLeft = "220px";
            document.body.style.backgroundColor = "rgba(0,0,0,0.3)";
        }
    }
</script>
