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
                        <input type="text" class="non-visible" :value="id" name="id" id="id">
                        <img v-if="isMain" :src="path + mainPhoto" class="img-circle"
                             width="150" v-on:click.prevent="setMainPhoto" style="cursor: pointer" id="main-img"
                             name="main-img"/>
                        <img v-if="!isMain" src="{{asset('assets/images/users/new-photo.png')}}" class="img-circle"
                             width="150" v-on:click.prevent="setMainPhoto" style="cursor: pointer" id="main-img"
                             name="main-img"/>
                        <input class="non-visible" type="file" name="mainPhoto" id="mainPhoto"
                               accept=".jpg, .jpeg, .png" v-on:change.prevent="sendMainPhoto">
                        <h4 class="card-title m-t-10">@{{ item.name }} @if(isset($item)) {{$item->name}}  @endif</h4>
                        <h6 class="card-subtitle"></h6>
                    </center>
                </form>
            </div>

            <form action="{{url('/photo')}}" class="form-group" enctype="multipart/form-data" method="post"
                  name="send-photos" id="form-photos-upload">
                {{ csrf_field() }}
                <input type="text" class="non-visible" :value="id" name="id" id="id">
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
                    <form @if(isset($item)) action="{{url('/item/'.$item->id)}}" method="post" @else action="{{url('/item')}}" method="post" @endif enctype="multipart/form-data"
                          class="form-horizontal form-material" id="save-update-form" name="save-update-form">
                        {{ csrf_field() }}
                        @if(isset($item)) {{ method_field('PUT') }} @endif
                        <div class="form-group">
                            <label class="col-md-12">Название товара</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Введите название"
                                       class="form-control form-control-line" name="name" id="name"
                                       @if(isset($item)) value="{{$item->name}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colours" class="col-sm-12">Введите описание товара:</label>
                            <div class="col-sm-12">
                                <textarea rows="3" class="form-control form-control-line" id="description"
                                          name="description"
                                          placeholder="...">@if(isset($item)) {{$item->description}}  @endif</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-sm-12">К какой категории относится товар:</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="category" name="category">
                                    @foreach($categories as $categoty)
                                        <option value="{{$categoty->id}}"
                                                @if(isset($item)) @if($item->category->id == $categoty->id) selected @endif @endif>{{$categoty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="brand" class="col-sm-12">Какой бренд товара:</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="brand" name="brand">
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}"
                                                @if(isset($item)) @if($item->brand->id == $brand->id) selected @endif @endif>{{$brand->name}}</option>
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
                                        <option value="{{$fluffiness->id}}"
                                                @if(isset($item)) @if($item->fluffiness->id == $fluffiness->id) selected @endif @endif>{{$fluffiness->name}}</option>
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
                                               id="colours" value="{{$colour->id}}"
                                               @if(isset($item)) @foreach($item->colour as $colour_) @if($colour_->id == $colour->id) checked @endif @endforeach @endif >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{$colour->name}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sizes">Определите размеры:</label>
                            <div class="col-sm-12">
                                <div class="row">
                                    @foreach($sizes as $size)
                                        <div class="non-visible">
                                            {{$isExist = false}}
                                            {{$id = 0}}
                                            @if(isset($item)) @foreach($item->size as $size_) @if($size_->id == $size->id) {{$isExist = true}} @break @endif {{$id++}} @endforeach @endif
                                        </div>

                                        <div style="border: hidden; padding: 5%" class="col-sm-6">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="sizes[]"
                                                       id="sizes" value="{{$size->id}}" @if($isExist) checked @endif>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">{{$size->name}}</span>
                                            </label>
                                            <br>
                                            <input type="text" class="form-control form-control-line" id="price"
                                                   name="prices[]" placeholder="Введите цену" @if($isExist) value="{{$item_size->where('item_id', $item->id)->where('size_id', $size->id)->pluck('price')->toArray()[0]}}" @endif>
                                            <input type="text" class="form-control form-control-line" id="quantity"
                                                   name="quantity[]"
                                                   placeholder="Введите количество" @if($isExist) value="{{$item_size->where('item_id', $item->id)->where('size_id', $size->id)->pluck('quantity')->toArray()[0]}}" @endif>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit">Сохранить</button>
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
                item: {name: ''},
                id: '<?echo $item_id ?>'
            },
            mounted: function () {
                this.fetchPhotos();
            },

            methods: {
                fetchPhotos: function () {
                    console.log(this.id);
                    this.$http.get('/photo/' + this.id).then(function (response) {
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
                    if(this.id != 0){
                        this.$http.put('/photo/' + id).then(function (response) {
                        });
                    }
                    else{
                        this.$http.delete('/photo/' + id).then(function (response) {
                        });
                    }
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




