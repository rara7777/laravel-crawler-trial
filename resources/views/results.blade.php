<!DOCTYPE html>
<html>
<head>
    <title>crawler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Screenshot</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td><a href="{{ url($item->url) }}">{{ $item->title }}</a></td>
                            <td><img src="{{ $item->screenshot }}" width="300px"></td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td><a href="{{ route('crawler.details', $item->id) }}" type="button">details</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
