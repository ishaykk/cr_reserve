@extends('layout')
@section('title', 'FloorDrawing #'.$drawing->id)
@section('headjs')
<script src="{{ asset('js/fabricjs/fabric.js') }}"></script>
@endsection
@section('content')
<div class="row m-5">
    <div class='col-10'>
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
        <!-- <div class="card">
            <div class="card-header"><strong>Drawing #{{ $drawing->id }}</strong></div>
            <div class="card-body"> -->
                <canvas id="canvas" width="100" height="100"></canvas>
            <!-- </div>
        </div> -->
    </div>
    <div class="col-2 float-left">
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
@endsection
@section('javascripts')
<script>
    const canvas = new fabric.Canvas('canvas', {});  
    canvas.setWidth(window.innerWidth) ;  
    canvas.setHeight(window.innerHeight);
    const drawingData = {!! $drawing->drawing_data !!};
    const rooms = {!! $rooms !!};
    let isThereIndicators = false;

    canvas.loadFromJSON(drawingData, () => {
        roomIndicators = []
        canvas.forEachObject(function(obj) {
            obj.selectable = false;
            obj.evented = false;
            obj.hasControls = false;
            if(obj.room_id) {
                roomIndicators.push(obj.room_id);
                
            }
        });
        canvas.renderAll();
        fillControls(roomIndicators);
    });

    

    // zoom 
    canvas.on('mouse:wheel', function (opt) {
        var delta = opt.e.deltaY;
        var zoom = canvas.getZoom();
        zoom *= 0.999 ** delta;
        if (zoom > 20) zoom = 20;
        if (zoom < 0.01) zoom = 0.01;
        canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
        opt.e.preventDefault();
        opt.e.stopPropagation();
    });

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

    // change indicators and checkboxes mode according to their state in database
    function changeState(data) {
        console.log("data = ", data);
        //console.log("typeof room_id = ", typeof(data[0]));
        canvas.getObjects().forEach(function(obj) {
            if(obj.room_id) {
                if(Object.values(data).includes(Number(obj.room_id))) {
                    obj.set('fill', '#FF0000');
                    $('#roomItem'+obj.room_id).children().children().prop('checked', true);
                }
                else {
                    obj.set('fill', '#00FF00');
                    $('#roomItem'+obj.room_id).children().children().prop('checked', false)
                }
                canvas.renderAll();
            }
        });
    }
    function fillControls(data) {
        const rooms = {!! $rooms !!}; // rooms id and occupied status sent from controller
        const test = '506';
        console.log(rooms[test]);
        let num = parseInt($('#roomItem1').prop("id").match(/\d+/g));
        data.slice(1).forEach(function(entry) {
            $('#roomItem1').clone().prop('id', 'roomItem' + entry).appendTo('#roomControl');
            $('#roomItem'+ entry).children().children().attr({'id': 'customSwitch' + entry, 'for': 'customSwitch' + entry});
            //$('#roomItem'+num).children().children().('label').html('Room ' + data);
            $('#roomItem'+entry).find('label').html('Room ' + entry);
       });
       // change original element attr and text
       $('#roomItem1').children().children().attr({'id': 'customSwitch' + data[0], 'for': 'customSwitch' + data[0]});
       $('#roomItem1').find('label').text('Room ' + data[0]);
       $('#roomItem1').attr('id', 'roomItem' + data[0]);
    }

    $('.indicator').change(function(e) {
        if(e.originalEvent) { // user-triggered event
            const checkboxId = $(this).attr('id');
            console.log('user changed: ' + checkboxId.substr(-3));
            const checkboxStatus = ($(this).is(':checked')) ? 1 : 0;
            console.log('checkbox status: ' + checkboxStatus);
            $.ajax({
                url:"/api/roomState/" + checkboxId.substr(-3) + "/" + checkboxStatus,
                type: "GET",
                data: {
                },
                success: function (res) {
                    console.log(res);
                },
                error: function(res) {
                    console.log(res);
                }
            });
        }
    });
    
</script>
@endsection