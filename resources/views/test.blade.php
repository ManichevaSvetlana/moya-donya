@extends('admin-resource.template')
@section('content')
    <form enctype="multipart/form-data" action="{{route('save')}}" method="POST">
        <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
        {{ csrf_field() }}
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <!-- Название элемента input определяет имя в массиве $_FILES -->
        Отправить этот файл: <input name="photo" type="file" />
        <input type="submit" value="Send File" />
    </form>

    <form action="/save-file" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>


    <form action="handler.php">
        Select image:
        <input type="file" id="files" name="files[]"  multiple />
        <ul id="list"></ul>
    </form>

    <script>
        function showFile(e) {
            var files = e.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) continue;
                var fr = new FileReader();
                fr.onload = (function(theFile) {
                    return function(e) {
                        var li = document.createElement('li');
                        li.innerHTML = "<img src='" + e.target.result + "' />";
                        document.getElementById('list').insertBefore(li, null);
                    };
                })(f);

                fr.readAsDataURL(f);
            }
        }

        document.getElementById('files').addEventListener('change', showFile, false);

    </script>
@endsection