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
                <table>
                    <tr>
                        <td>
                            <a href="{{ $item->url }}">{{ $item->title }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ $item->description }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ $item->body }}
                        </td>
                        <td>
                            <img src="{{ $item->screenshot }}" width="500px">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
