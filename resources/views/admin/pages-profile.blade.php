@extends('layouts.admin')
@section('content')
    <div class="row" id="app">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-block">
                    <center class="m-t-30"><img src="{{asset('assets/images/users/new-photo.png')}}" class="img-circle"
                                                width="150"/>
                        <h4 class="card-title m-t-10"></h4>
                        <h6 class="card-subtitle">Accoubts Manager Amix corp</h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i>
                                    <font class="font-medium">254</font></a></div>
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i>
                                    <font class="font-medium">54</font></a></div>
                        </div>
                    </center>
                </div>
            </div>
            <form action="{{url('/photo/set')}}" class="form-group" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <label for="select-brand">Загрузите изображения:</label><br>
                <label class="custom-file">
                    <input type="file" class="custom-file-input" name="photos[]" id="photos"
                           accept="image/jpeg,image/png" multiple>
                    <input type="text" id="lol" name="lol">
                    <span class="custom-file-control"></span>
                </label>

                <button type="submit">Ok</button>
                <ul id="list"></ul>
            </form>
            <!-- Form for sending images without ajax/vue.js
            <form class="form-group" action="/photo/set" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" class="custom-file-input" name="photo[]" id="photo"
                       accept="image/jpeg,image/png" multiple>
                <input type="submit" class="submit button">Lol
            </form>
            -->
        </div>
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-block">
                    <form action="{{url('/item')}}" method="post" enctype="multipart/form-data"
                          class="form-horizontal form-material" id="save-update-form" name="save-update-form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">Название товара</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Введите название"
                                       class="form-control form-control-line">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category" class="col-sm-12">К какой категории относится товар:</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="category" name="category">
                                    @foreach($categories as $categoty)
                                        <option value="{{$categoty->id}}">{{$categoty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="brand" class="col-sm-12">Какой бренд товара:</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="brand" name="brand">
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fluffiness" class="col-sm-12">Степень пышности:</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="fluffiness" name="fluffiness">
                                    <option value=""></option>
                                    @foreach($fluffinesses as $fluffiness)
                                        <option value="{{$fluffiness->id}}">{{$fluffiness->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colours" class="col-sm-12">Цвета, которые относятся к товару:</label>
                            <div class="col-sm-12">
                                @foreach($colours as $colour)
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="colours[]"
                                               id="colours" value="{{$colour->id}}">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{$colour->name}}</span>
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sizes">Определите размеры:</label>
                            <div class="col-sm-12">
                                <div class="row">
                                    @foreach($sizes as $size)
                                        <div style="border: hidden; padding: 5%" class="col-sm-6">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="sizes[]"
                                                       id="sizes" value="{{$size->id}}">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">{{$size->name}}</span>
                                            </label>
                                            <br>
                                            <input type="text" class="form-control form-control-line" id="price"
                                                   name="prices[]" placeholder="Введите цену">
                                            <input type="text" class="form-control form-control-line" id="quantity"
                                                   name="quantity[]"
                                                   placeholder="Введите количество">
                                            <textarea rows="3" class="form-control form-control-line" id="description"
                                                      name="descriptions[]"
                                                      placeholder="Введите описание товара"></textarea>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button v-on:click.prevent="test()"> HEEY</button>
        <!-- Column -->
    </div>
@endsection

@section('script')

    <script>
        function showFile(e) {
            alert('hmmm');
            var files = e.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) continue;
                var fr = new FileReader();
                fr.onload = (function (theFile) {
                    return function (e) {
                        var li = document.createElement('li');
                        li.innerHTML = "<img src='" + e.target.result + "' height='100px'/>";
                        document.getElementById('list').insertBefore(li, null);
                    };
                })(f);

                fr.readAsDataURL(f);
            }

            document.getElementById('lol').value = files;
            console.log('lol value:');
            console.log(document.getElementById('lol').value);
            console.log('------------------------------------');
        }
        document.getElementById('photos').addEventListener('change', showFile, false);



   /*     Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

        new Vue({
            el: '#app',
            data: {
                item: {name: 'Название товара'},
                sender: {photos: ''}
            },
            methods: {
                setPhotos: function(){

                },
                test: function () {
                    this.$http.post('/photo/get').then(function (response) {
                        console.log('Gettiong from the server');
                        console.log(response.body);
                        console.log('End getting from the server');
                    });
                }
            }
        }); */


    </script>
@endsection




