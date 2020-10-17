@extends('layouts.app')

@section('content')

    <main role="main">

        <section class="jumbotron text-center"
                 style="background-image: url('{{($item->media_type === "video")? '/assets/img/video.png': $item->url}}');">
            <div class="container p-5">
                    <img src="/assets/img/nasa.png" class="logo-nasa mt-3 mb-4">
                    <h5 class="text-white">presents:</h5>
                    <h1 class="jumbotron-heading text-white">{{$item->title}}</h1>
                    <p class="lead text-white">
                        by {{($item->copyright)? $item->copyright : 'Nasa'}}
                    </p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    <div class="col-10 offset-1">
                        <p class="text-muted">Space : {{ str_replace('00:00:00', '',$item->created_at)}}</p>
                        <p>{{$item->explanation}}</p>
                        @if($item->media_type === 'image')
                        <a href="{{$item->hdurl}}" target="_blank">view ultra HD</a>
                        @else
                            <iframe width="100%"
                                    class="yt-vid mt-5"
                                    src="{{$item->url}}"
                                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                            </iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection

@yield('footer')
