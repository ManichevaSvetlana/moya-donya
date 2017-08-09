@extends('admin-resource.template')
@section('style')
    <style>
        .container {
            margin-top: 25px;
        }

        .right {
            float: right;
        }

        .wdth-50 {
            width: 50%;
        }

        .row {
            margin-bottom: 20px;
        }

        .checkbox {
            margin: 10px 0;
        }

        body {
            font-size: 16px;
        }

        .non-visible {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="container" id="app">
        <!-- Page's name + search field -->
        <div class="row" style="margin-bottom: 3%">
            <div class="col-md-6">
                <b style="font-size: 25px">Items</b>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
        <!-- End search -->
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <!-- Sorting field -->
                    <div class="col-sm-6">
                        <div class="form-group wdth-50">
                            <select class="form-control" id="exampleSelect1">
                                <option>All</option>
                                @foreach($categories as $categoty)
                                    <option>{{$categoty->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group right wdth-50">
                            <select class="form-control" id="exampleSelect1" title="Sort by">
                                <option>Sort by price</option>
                                <option>Sort by create date</option>
                                <option>Sort by update date</option>
                            </select>
                        </div>
                    </div>
                    <!-- End sort -->
                </div>
                <div class="row">
                    <div class="">
                        <!-- Form for new Item-->
                        <form action="{{url('/item')}}" method="post" enctype="multipart/form-data" id="save-update-form" name="save-update-form">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Input name">
                            </div>
                            <div class="form-group">
                                <label for="select-category">Select category</label>
                                <select class="form-control" id="category" name="category">
                                    @foreach($categories as $categoty)
                                        <option value="{{$categoty->id}}">{{$categoty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select-brand">Select brand</label>
                                <select class="form-control" id="brand" name="brand">
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select-brand">Select fluffiness</label>
                                <select class="form-control" id="fluffiness" name="fluffiness">
                                    <option value=""></option>
                                    @foreach($fluffinesses as $fluffiness)
                                        <option value="{{$fluffiness->id}}">{{$fluffiness->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select-brand">Select images:</label>
                                <input type="file" name="photos[]" id="photos" accept="image/jpeg,image/png" multiple/>
                                <ul id="list"></ul>
                            </div>
                            <div class="form-group">
                                <label for="select-brand">Select colours:</label>
                                @foreach($colours as $colour)
                                    <input type="checkbox" name="colours[]" value="{{$colour->id}}"/>{{$colour->name}}
                                    &nbsp;&nbsp;&nbsp;
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="select-brand">Select sizes:</label>
                                <div class="row">
                                    @foreach($sizes as $size)
                                        <div style="border: dotted; padding: 5%" class="col-sm-4">
                                            <input type="checkbox" name="sizes[]" value="{{$size->id}}"/>{{$size->name}}
                                            <br>
                                            <input type="text" class="form-control" id="price" name="prices[]"
                                                   placeholder="Input price">
                                            <input type="text" class="form-control" id="quantity" name="quantity[]"
                                                   placeholder="Input quantity">
                                            <input type="text" class="form-control" id="description"
                                                   name="descriptions[]" placeholder="Input description">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success" id="save-button">Save</button>
                            <button type="submit" class="btn btn-warning non-visible" id="update-button">Update</button>
                        </form>
                        <!-- End new Item -->
                    </div>
                    @foreach($items as $item)
                        <div class="col-sm-3">
                            <img src="http://s1.iconbird.com/ico/1012/QettoIcons/w256h2561350658940jpg.png" alt=""
                                 width="100%">
                            <h4>{{ $item->name }}</h4>
                            {{$item->category->name}} <br>
                            @if($item->fluffiness)
                                {{$item->fluffiness->name}}<br>
                            @else <br>
                            @endif
                            <text style="margin-bottom: 6%">345</text>
                            <form action="{{url('/item/'.$item->id)}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-xs btn-danger right">Delete</button>
                            </form>
                            <button class="btn btn-xs btn-warning right"  onclick="showUpdateForm({{$item->id}})">Update</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-1">

            </div>
            <div class="col-sm-3">
                <b>Filters</b><br><br>
                By size: <br>
                <div style="margin-left: 10%">
                    @foreach($sizes as $size)
                        <div class="checkbox">
                            <label><input type="checkbox" value="">{{$size->name}}</label>
                        </div>
                    @endforeach()
                </div>
                By brand: <br>
                <div style="margin-left: 10%">
                    @foreach($brands as $brand)
                        <div class="checkbox">
                            <label><input type="checkbox" value="">{{$brand->name}}</label>
                        </div>
                    @endforeach()
                </div>
                By fluffiness:
                <div style="margin-left: 10%">
                    @foreach($fluffinesses as $fluffiness)
                        <div class="checkbox">
                            <label><input type="checkbox" value="">{{$fluffiness->name}}</label>
                        </div>
                    @endforeach()
                </div>
                By colour: <br>
                <div style="margin-left: 10%">
                    @foreach($colours as $colour)
                        <div class="checkbox">
                            <label><input type="checkbox" value="">{{$colour->name}}</label>
                        </div>
                    @endforeach()
                </div>
                <button class="btn btn-primary right">Ok</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
            <script>
                function showFile(e) {
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
                }

                document.getElementById('photos').addEventListener('change', showFile, false);

                function showUpdateForm(id) {
                    document.getElementById('save-button').className += ' non-visible';
                    document.getElementById('update-button').className = 'btn btn-warning';
                    document.getElementById('save-update-form').action = '/item/' + id;
                }
            </script>
@endsection