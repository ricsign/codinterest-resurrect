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
    <h3>Articles Recommendation</h3>
    <br>
    <div class="articles-container">
        <div class="list-group popular">
            <a href="javascript:" class="list-group-item list-group-item-action bg-primary">
                <div class="d-flex w-100 justify-content-between">
                    <h4 style="text-align: center;margin: auto;padding: 50px;color: white;">Popular</h4>
                </div>
            </a>
            @foreach($topfivepopular as $article)
                <a href="{{url('/public/getsinglearticle/'.$article->aid)}}" class="list-group-item list-group-item-action">
                    <img src="{{asset('imgs/articles/aid'.$article->aid.'.jpg')}}" alt="" style="height:100%; width: 100%; margin-bottom: 20px">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$article->atit}}</h5>
                        @switch($article->catid)
                            @case(1)
                                <small>Computer Science</small>
                                @break
                            @case(2)
                                <small>Mathematics</small>
                                @break
                            @case(3)
                                <small>Sciences & Technologies</small>
                                @break
                            @case(4)
                                <small>Assorted Topics</small>
                                @break
                        @endswitch
                    </div>
                    <br>
                    <div>{{$article->aintro}}...</div>
                    <br>
                    <div>
                        <img src="{{asset('imgs/site/views.png')}}" alt="Views: " width="14px"> &nbsp;
                        <span class="badge badge-pill badge-primary">{{$article->aviews}}</span>
                    </div>
                    <div>
                        <img src="{{asset('imgs/site/comments.png')}}" alt="Comments: " width="14px"> &nbsp;
                        <span class="badge badge-pill badge-primary">{{$article->acomments}}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="list-group new">
            <a href="javascript:" class="list-group-item list-group-item-action bg-success">
                <div class="d-flex w-100 justify-content-between">
                    <h4 style="text-align: center;margin: auto;padding: 50px;color: white;">Recent</h4>
                </div>
            </a>
            @foreach($topfivenew as $article)
                <a href="{{url('/public/getsinglearticle/'.$article->aid)}}" class="list-group-item list-group-item-action">
                    <img src="{{asset('imgs/articles/aid'.$article->aid.'.jpg')}}" height="200px" alt="" style="width: 100%; margin-bottom: 20px">
                    <div class="d-flex w-100 justify-content-between">
                        <br>
                        <h5 class="mb-1">{{$article->atit}}</h5>
                        @switch($article->catid)
                            @case(1)
                            <small>Computer Science</small>
                            @break
                            @case(2)
                            <small>Mathematics</small>
                            @break
                            @case(3)
                            <small>Sciences & Technologies</small>
                            @break
                            @case(4)
                            <small>Assorted Topics</small>
                            @break
                        @endswitch
                    </div>
                    <br>
                    <div>{{$article->aintro}}...</div>
                    <br>
                    <div>
                        <img src="{{asset('imgs/site/views.png')}}" alt="Views: " width="14px"> &nbsp;
                        <span class="badge badge-pill badge-primary">{{$article->aviews}}</span>
                    </div>
                    <div>
                        <img src="{{asset('imgs/site/comments.png')}}" alt="Comments: " width="14px"> &nbsp;
                        <span class="badge badge-pill badge-primary">{{$article->acomments}}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


    <br>
    <hr>
    <br>
    {{--categories--}}

    <h3>Categories</h3>
    <br>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this"><b>All Articles</b></li>
            <li><b>Computer Sciences</b></li>
            <li><b>Mathematics</b></li>
            <li><b>Sciences & Technologies</b></li>
            <li><b>Assorted Topics</b></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Article ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Views</th>
                        <th scope="col">Comments</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($populararticles as $article)
                        <tr>
                            <th scope="row">{{$article->aid}}</th>
                            <td><a href="{{url('/public/getsinglearticle/'.$article->aid)}}">{{$article->atit}}</a></td>
                            <td>
                                @switch($article->catid)
                                    @case(1)
                                        Computer Science
                                    @break
                                    @case(2)
                                        Mathematics
                                    @break
                                    @case(3)
                                        Sciences & Technologies
                                    @break
                                    @case(4)
                                        Assorted Topics
                                    @break
                                @endswitch
                            </td>
                            <td>{{$article->aviews}}</td>
                            <td>{{$article->acomments}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <div class="pagination justify-content-center">{{$populararticles->links()}}</div>
            </div>

            {{--iterate all categories--}}
            @for($i=1; $i<5; $i++)
                <div class="layui-tab-item">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Article ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Views</th>
                            <th scope="col">Comments</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allpopular->where('catid',$i) as $article)
                            <tr>
                                <th scope="row">{{$article->aid}}</th>
                                <td><a href="{{url('/public/getsinglearticle/'.$article->aid)}}">{{$article->atit}}</a></td>
                                <td>{{$article->aviews}}</td>
                                <td>{{$article->acomments}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endfor
        </div>
    </div>

    {{--JS--}}
    <script>
        // default load layui
        layui.use('element', function(){
            let element = layui.element;
        });
    </script>

@endsection

