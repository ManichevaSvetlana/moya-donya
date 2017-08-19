@extends('layouts.admin')
@section('style')
    <style>
        .non-visible {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="row" id="app">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Создание/ изменение ресурса</h4>
                    <form class="form-inline">
                        <label class="sr-only" for="name">Имя</label>
                        <input v-model="newResource.name" type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="name"
                               :placeholder="updatedResource.name">
                        <button v-on:click.prevent="storeResource()" type="submit" id="store-button" class="btn btn-primary">Добавить
                        </button>
                        <button v-on:click.prevent="updateResource(updatedResource.id)" id="update-button" type="submit"
                                class="btn btn-warning non-visible">Обновить
                        </button>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Удалить</th>
                                <th>Редактировать</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="resource in resources">
                                <th scope="row">@{{ resource.id }}</th>
                                <td>@{{ resource.name }}</td>
                                <td>
                                    <button class="btn btn-danger" v-on:click.prevent="destroyResource(resource.id)">Удалить</button>
                                </td>
                                <td>
                                    <button class="btn btn-warning" v-on:click.prevent="editResource(resource)">Изменить</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                resource: '<? echo $resource ?>',
                resources: {},
                newResource: {name: ''},
                updatedResource: {id: '', name: ''}
            },
            mounted: function () {
                this.fetchResources();
            },

            methods: {
                fetchResources: function () {
                    this.$http.get('/' + this.resource + '/create').then(function (response) {
                        this.resources = response.body;
                    })
                },
                destroyResource: function (id) {
                    this.$http.delete('/' + this.resource + '/' + id).then(function (response) {
                        this.fetchResources();
                        alert(response.body);
                    })
                },
                storeResource: function () {
                    this.$http.post('/' + this.resource, this.newResource).then(function (response) {
                        this.fetchResources();
                        this.newResource = {name: ''};
                        alert(response.body);
                    })
                },
                editResource: function (resource) {
                    /**Open form for editing resource*/
                    document.getElementById('store-button').className += ' non-visible';
                    document.getElementById('update-button').className = 'btn btn-warning';
                    /**End*/
                    this.updatedResource = {id: resource.id, name: resource.name};
                },
                updateResource: function (id) {
                    this.$http.put('/' + this.resource + '/' + id, this.newResource).then(function (response) {
                        this.fetchResources();
                        alert(response.body);
                    });
                    this.newResource = {name: ''};
                    this.updatedResource = {id: '', name: ''};
                    /**Close form for editing resource*/
                    document.getElementById('update-button').className += ' non-visible';
                    document.getElementById('store-button').className = 'btn btn-primary';
                    /**End*/
                }
            }
        });
    </script>
@endsection