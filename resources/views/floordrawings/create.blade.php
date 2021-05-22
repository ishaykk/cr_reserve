@extends('layout')
@section('title', 'Create Floor Drawing')
@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
<link href="{{ asset('css/floordrawing.css') }}" rel="stylesheet">
@endsection
@section('headjs')
<script src="{{ asset('js/fabricjs/fabric.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
@endsection
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-10">
            <ul class="canvasControls">
                <li class="colorContainer">
                    <input type="color" id="fill" value="#ffffff">
                    <span class="colorContainer" id="color_val"></span>
                </li>
                <li><button onclick="ClearAll()" id="clearAll">Clear all</button></li>
                <li><img onclick="AddRect()" class="shape" id="addRect" src="{{ asset('img/floordrawing/rect_icon_20x20.png') }}"></li>
                <li><img onclick="AddCircle()" class="shape" id="addCircle" src="{{ asset('img/floordrawing/circle_icon_20x20.png') }}"></li>
                <li><button id="saveJSON">Save JSON</button></li>
                <li><button onclick="LoadJSON()" id="loadJSON">Load JSON</button></li>
                <li><button onclick="undo()" id="undo" disabled>Undo</button></li>
                <li><button onclick="redo()" id="redo" disabled>Redo</button></li>
                <li><a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#saveJsonModal">Save JSON
                        in DB</a></li>
                <li><a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addRoomModal">Add Room Indicator</a></li>
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
                                        <label for="floor_id" class="col-form-label">Floor Number:</label>
                                        <select class="form-select ml-2" id="floor_id" name="floor_id" aria-label="Default select example">
                                            @foreach($floors as $floor)
                                                <option value="{{ $floor->id }}">{{ $floor->floor_id }}</option>
                                            @endforeach
                                        </select>
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
                <div class="modal fade" id="addRoomModal">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title w-100 text-center">Add Room Indicator</h4>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="addRoomsForm" onSubmit="return handleAddRoom()">
                                    <div class="form-group form-inline justify-content-center">
                                        <label for="room_id" class="col-form-label">Room Number:</label>
                                        <select class="form-select ml-2" id="room_id" aria-label="Default select example">
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->room_id }}">{{ $room->room_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-sm btn-primary" type="submit">Add Room Indicator</button>
                                        <button type="button" name="description" class="btn btn-sm btn-danger ml-3" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
            <canvas id="canvas"></canvas>
        </div>
        <div id="contextmenu-output"></div>
        <div class="col-2">
            <ul class="list-group-sm" id="roomControl">
                <h6 class="text-center">Room Indicator Tester</h6>
                <li class="list-group-item" id="roomItem1">
                    <div class="custom-control custom-control-right custom-switch">
                        <input type="checkbox" class="custom-control-input indicator" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Room 880</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script src="{{ asset('js/fabricjs/myFabric.js') }}"></script>
<script>
    let objX = 100;
    $('#createDrawForm').on('submit', function() {
        event.preventDefault();
        const formData = $("#createDrawForm").serializeArray();
        console.log(formData);
        const drawingJsonData = JSON.stringify(canvas.toJSON(['id', 'room_id']), null, 2);
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
                console.log(res);
                $('#saveJsonModal').modal('hide');
            },
            error: function(res) {
                console.log(res);
            }
        });
    });
    function handleAddRoom() {
        event.preventDefault();
        const room_id = $('#room_id').val();
        if (!room_id) {
            alert("Empty room_id value!");
            return;
        }
        console.log("room id = ", room_id);
        const indicator = new fabric.Circle({
            room_id: room_id,
            left: objX,
            top: 50,
            radius: 15,
            fill: '#000000',
            objectCaching: false,
            stroke: '#FF0000',
            strokeWidth: 1,
            cornerStyle: 'circle',
            cornerSize: 4,
            hasControls: true,
            //type: 'indicator',
        });
        objX += 45;
        const text = new fabric.IText(room_id, {
            fontSize: 20,
            fontFamily: 'Tahoma',
            //originX: indicator.x, //'center',
            //originY: indicator.y + 10,
            left: indicator.left,
            top: indicator.top + 35,
        });
        // const group = new fabric.Group([indicator, text], {
        //     left: 150,
        //     top: 100,
        //     angle: 0
        // });
        canvas.add(text);
        canvas.add(indicator);
        canvas.setActiveObject(indicator);
        $('#addRoomModal').modal('hide');
    }
    setInterval(() => {
        let occupiedRooms;
        $.ajax({
            url:"/api/rooms/",
            type: "GET",
            data: {
            },
            success: function (res) {
                //$(".display").html(data);
                //occupiedRoom = data;
                occupiedRoom = JSON.parse(JSON.stringify(res));
                //console.log(Object.values(data).includes(509));
                changeState(occupiedRoom);
            },
            error: function(res) {
                console.log(res);
            }
        })
    }, 5000);

    function changeState(data) {
        console.log("data = ", data);
        //console.log("typeof room_id = ", typeof(data[0]));
        canvas.getObjects().forEach(function(obj) {
            if(obj.room_id) {
                if(Object.values(data).includes(Number(obj.room_id)))
                    obj.set('fill', '#FF0000');
                else
                    obj.set('fill', '#00FF00');
                canvas.renderAll();
            }
        });
    }
</script>
@endsection