@extends('layouts.admin')
@section('content')
    <div id="app">
        <div class="row">
            <div class="col-sm-9">
                <div class="row" style="margin-bottom: 2%">
                    <div class="col-sm-5">
                        <select class="form-control form-control">
                            <option>Все</option>
                            @foreach($categories as $category)
                                <option id="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3" v-for="item in items">
                        <div class="card">
                            <div class="card-block little-profile text-center">
                                <div class="pro-img"><img :src="item.photo_id" alt="user">
                                </div>
                                <h3 class="m-b-0">@{{ item.name }}</h3>
                                <p>@{{ item.category_id }}</p>
                                <a :href="'item/' + item.id"
                                   class="m-t-10 waves-effect waves-dark btn btn-primary btn-sm btn-rounded">Редактировать</a>
                                <a class="m-t-10 waves-effect waves-dark btn btn-danger btn-sm btn-rounded" v-on:click.prevent="destroyResource(item.id)">Удалить</a>
                                <div class="row text-center m-t-20">
                                    <div class="col-lg-6 col-md-6 m-t-30">
                                        <i class="m-b-0 font-light">@{{ item.price_min }} - @{{ item.price_max }}</i>
                                        <small>Цена</small>
                                    </div>
                                    <div class="col-lg-6 col-md-6 m-t-30">
                                        <i class="m-b-0 font-light" v-for="size in item.size">@{{ size.name }} </i>
                                        <small>Размеры</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Фильтры</h4>
                        <div class="table-responsive">
                            @foreach($array as $key=>$items)

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{$key}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <th scope="row">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">{{$item->name}}</span>
                                                </label>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            @endforeach
                            <p style="text-align: center"><a href="/"
                                                             class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Найти</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')

    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

        new Vue({
            el: '#app',
            data: {
                items: {},
                categories: {},
                response: {skip: 0}
            },
            mounted: function () {
                this.fetchResources();
            },

            methods: {
                fetchResources: function () {
                    this.$http.get('/item/create').then(function (response) {
                        this.items = response.body;
                    })
                },
                destroyResource: function (id) {
                    this.$http.delete('/item/' + id).then(function (response) {
                        this.fetchResources();
                        alert(response.body);
                    })
                }

            }
        });
    </script>

@endsection