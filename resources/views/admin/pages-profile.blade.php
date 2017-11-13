@extends('layouts.admin')
@section('style')
    <style>
        .non-visible {
            display: none;
        }

        .img-list {
            width: 100px;
        }
    </style>
@endsection
@section('content')
    <div class="row" id="app">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <form action="{{url('/photo')}}" class="card-block" id="form-main-photo-upload" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <center class="m-t-30">
                        <img v-if="isMain" :src="path + mainPhoto" class="img-circle"
                             width="150" v-on:click.prevent="setMainPhoto" style="cursor: pointer" id="main-img"
                             name="main-img"/>
                        <img v-if="!isMain" src="{{asset('assets/images/users/new-photo.png')}}" class="img-circle"
                             width="150" v-on:click.prevent="setMainPhoto" style="cursor: pointer" id="main-img"
                             name="main-img"/>
                        <input class="non-visible" type="file" name="mainPhoto" id="mainPhoto"
                               accept=".jpg, .jpeg, .png" v-on:change.prevent="sendMainPhoto">
                        <h4 class="card-title m-t-10">@{{ item.name }}</h4>
                        <h6 class="card-subtitle"></h6>
                    </center>
                </form>
            </div>

            <form action="{{url('/photo')}}" class="form-group" enctype="multipart/form-data" method="post"
                  name="send-photos" id="form-photos-upload">
                {{ csrf_field() }}
                <label for="select-brand">Загрузите изображения:</label><br>
                <label class="custom-file">
                    <input type="file" class="custom-file-input" name="photos[]" id="photos"
                           accept="image/jpeg,image/png" multiple v-on:change.prevent="sendPhoto">
                    <span class="custom-file-control"></span>
                </label>
                <table class="table">
                    <tbody>
                    <tr v-for="photo in photos" v-if="!photo.is_main">
                        <td><img :src='path + photo.photo' class="img-list card"></td>
                        <td>
                            <button class="btn btn-danger" v-on:click.prevent="destroyPhoto(photo.id)">Удалить</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>

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
                                       class="form-control form-control-line" v-model="item.name" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colours" class="col-sm-12">Введите описание товара:</label>
                            <div class="col-sm-12">
                                <textarea rows="3" class="form-control form-control-line" id="description"
                                          name="description" placeholder="..."></textarea>
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
        <!-- Column -->
    </div>
@endsection

@section('script')


    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

        new Vue({
            el: '#app',
            data: {
                path: '<?echo asset('')?>',
                photos: {},
                mainPhoto: '',
                isMain: false,
                item: {name: ''}
            },
            mounted: function () {
                this.fetchPhotos();
            },

            methods: {
                fetchPhotos: function () {
                    this.$http.get('/photo').then(function (response) {
                        this.photos = response.body.photos;
                        n = Object.keys(response.body.mainPhoto);
                        n = parseInt(n[0]);
                        if (response.body.mainPhoto[n].photo != null) {
                            this.isMain = true;
                            this.mainPhoto = response.body.mainPhoto[n].photo;
                        }
                    })
                },
                sendPhoto: function () {
                    $('#form-photos-upload').submit();
                },
                destroyPhoto: function (id) {
                    this.$http.delete('/photo/' + id).then(function (response) {
                    });
                    this.fetchPhotos();
                },
                setMainPhoto: function () {
                    $('#mainPhoto').click();
                },
                sendMainPhoto: function () {
                    $('#form-main-photo-upload').submit();
                }
            }
        });
    </script>


@endsection




