@extends('layout')
@section('title', 'Create Floor Drawing')
@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('styles')
<link href="{{ asset('css/floordrawing.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="col-12">
    <div class="controls">
        <!-- <p><button id="add" onclick="Add()">Add a rectangle</button></p> -->
        <ul class="">
            <li class="colorContainer">
                <input type="color" id="fill" value="#ffffff">
                <span class="colorContainer" id="color_val"></span>
            </li>
            <li><button onclick="ClearAll()" id="clearAll">Clear all</button></li>
            <!-- <button id="addRect" style="display: block">Add a rectangle</button> -->
            <!-- <button id="addCircle" style="display: block">Add a circle</button> -->
            <li><img onclick="AddRect()" class="shape" id="addRect" src="{{ asset('img/floordrawing/rect_icon_20x20.png') }}"></li>
            <li><img onclick="AddCircle()" class="shape" id="addCircle" src="{{ asset('img/floordrawing/circle_icon_20x20.png') }}"></li>
            <li><button onclick="SaveJSON()" id="saveJSON">Save JSON</button></li>
            <li><button onclick="LoadJSON()" id="loadJSON">Load JSON</button></li>
            <li><button onclick="UndoNew()" id="undo" disabled>Undo</button></li>
            <li><button onclick="RedoNew()" id="redo" disabled>Redo</button></li>
            <li><a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#saveJsonModal">Save JSON
                    in DB</a></li>
            <div class="modal fade" id="saveJsonModal">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title w-100 text-center">Save Json in database</h4>
                            <button class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="createDrawForm" class="ml-2" method="post">
                                <div class="form-group form-inline row m-3">
                                    <label for="floor_num" class="col-form-label">Floor Number:</label>
                                    <input type="number" name="floor_num" class="form-control col-2 ml-2" id="floor_num">
                                </div>
                                <div class="form-group form-inline row m-3">
                                    <label for="building" class="col-form-label">Building name:</label>
                                    <input type="text" name="building" class="form-control col-8 ml-2" id="building">
                                </div>
                                <div class="form-group form-inline row m-3">
                                    <label for="description" class="col-form-label">Description:</label>
                                    <textarea rows="4" cols="50" class="form-control col-12" id="description" name="description" placeholder="Enter description here... (optional)"></textarea>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <button type="button" name="description" class="btn btn-danger ml-3" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </ul>
    </div>
    <!-- <script src="js/undoredo.js"></script> -->
    <canvas id="canvas" style="border:1px solid #ccc"></canvas>
</div>
@endsection

@section('javascripts')
<script src="{{ asset('js/fabricjs/fabric.js') }}"></script>
<script src="{{ asset('js/fabricjs/myFabric.js') }}"></script>
<script>
    $('#createDrawForm').on('submit', function() {
        event.preventDefault();
        const formData = $("#createDrawForm").serializeArray();
        const drawingJsonData = JSON.stringify(canvas.toJSON(['id']));
        // let data = {
        //     "formData": {
        //         form,
        //         description,
        //     },
        //     "drawing_data": {
        //         drawingJsonData,
        //     },
        // };
        $.ajaxSetup({
            beforeSend: function(xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            },
        });
        $.ajax({

            url: '/floordrawings',
            method: 'post',
            data: {
                formData,
                drawingJsonData,
            },
            // dataType: 'json', // payload is json
            // contentType: 'application/json',
            success: function(res) {
                //window.location.href = res.url;
                //                console.log(res);
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
</script>
@endsection