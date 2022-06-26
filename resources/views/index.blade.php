<!DOCTYPE html>
<html>
    <head>
        <title>crawler</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>

        <div class="container">
            @include('components.msg')
            @include('components.errors')
            <div class="row">
                <form action="{{ route('crawler.crawl') }}" method="post" class="">
                    @csrf
                    <label for="url">Enter your url</label>
                    <input id="url" name="url" placeholder="https://www.uniqlo.com/tw/zh_TW" value="https://www.uniqlo.com">
                    <button type="submit">start crawling!</button>
                </form>
            </div>
        </div>
    </body>
</html>
