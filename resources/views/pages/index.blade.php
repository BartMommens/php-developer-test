@extends('layouts.app')

@section('content')

    <main role="main">

        <section class="jumbotron text-center" style="background-image: url('{{$pod->url}}');background-size: cover;">
            <div class="container p-5">
                <a href="{{route('detail',['id' => $pod->id])}}" class="head-link">
                    <img src="/assets/img/nasa.png" class="logo-nasa mt-3 mb-4">
                    <h5 class="text-white">Astronomy picture of the day:</h5>
                    <h1 class="jumbotron-heading text-white">{{$pod->title}}</h1>
                    <p class="lead text-white">
                        by {{$pod->copyright}}
                    </p>
                </a>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    @foreach($pictures as $picture)
                        <div class="col-md-6 col-lg-4">
                            <div class="card mb-4 box-shadow">
                                <div class="crop-img">
                                    @if($picture->media_type === 'image')
                                        <img class="card-img-top" src="{{$picture->url}}" alt="{{$picture->title}}">
                                    @else
                                        <img class="card-img-top" src="/assets/img/video.png" alt="{{$picture->title}}">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{$picture->title}}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{route('detail',['id' => $picture->id])}}" class="btn btn-sm btn-outline-secondary">
                                            @if($picture->media_type === 'image')
                                                View
                                            @else
                                                Watch
                                            @endif
                                            </a>
                                            @if((empty($likes[$picture->id]['user_liked'])))
                                                <button type="button" class="btn btn-sm btn-outline-secondary like-me" id="pic_{{$picture->id}}" data-id="{{$picture->id}}">
                                                    like
                                                </button>
                                            @endif
                                        </div>
                                        <small class="text-muted"><span id="like_{{$picture->id}}">{{$likes[$picture->id]['count']}}</span> likes</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row flex justify-content-center mt-4">
                    @if(!empty($pictures->links()))

                        <nav aria-label="Page navigation example">
                            {{$pictures->links()}}
                        </nav>
                    @endif
                </div>
            </div>
        </div>

    </main>

@endsection

@yield('footer')

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(function() {
            $('.like-me').on('click', function (e){
                e.preventDefault();
                like($(this).attr('id'), $(this).attr('data-id'));
            })
        });

        function like($elm, $id){
            console.log($elm);
            console.log($id)
            $.ajax({
                url: "/like",
                type:"POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    picture_id: $id
                },
                success: function(response){
                    if(response.state === 'success') {
                        console.log(response.likes);
                        $("#like_"+$id).html(response.likes);
                        $("#"+$elm).remove();
                    }
                },
            });
        }
    </script>
@endsection
