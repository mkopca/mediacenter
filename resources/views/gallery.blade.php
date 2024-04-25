<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="{{ asset('js/vendor/jquery.swipebox.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/vendor/swipebox.min.css') }}">
    <style>
        .grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-container {
            width: 400px;
            height: 300px;
            overflow: hidden;
            padding-bottom: 30px;
            margin: 20px;
            position: relative;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <script type="text/javascript">
        ;( function( $ ) {
            $( '.swipebox' ).swipebox();
        } )( jQuery );
    </script>
</head>
<body>
    <h2>Image Gallery</h2>
    <form action="/gallery" method="get">
        <label for="tag">Filtruj podľa štítku:</label>
        <input type="text" id="tag" name="tag" value="{{ request('tag') }}">
        <input type="submit" value="Search">
    </form>
    <div class="grid">
    @foreach($images as $image)
        <div class="image-container">
            <a rel="gallery-1" href="{{ $image->full_url }}" class="swipebox" title="{{ $image->tag }}">
                <img src="{{ Storage::url('images/'.$image->filename) }}" alt="{{ $image->filename }}">
            </a>
            <form action="{{ route('image.update', $image->id) }}" method="post">
                @csrf
                @method('PUT')
                <input type="text" id="tag" name="tag" value="{{ $image->tag }}">
                <input type="submit" value="Update Tag">
            </form>
        </div>
    @endforeach
    </div>
</body>
</html>
