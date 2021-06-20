@extends('layout')
@section('title', 'Floors Plan')
@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('headjs')
<script src="{{ asset('js/fabricjs/fabric.js') }}"></script>
@endsection
@section('content')
<div class="row m-1 d-flex justify-content-center">
    <div class="col-md-12">
        <div class="errors text-danger">
        @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </div>
    <div class="form-group">
        <div class="form-inline">
            <label for="floor_select"><strong>Select Floor: </strong></label>
                <select class="form-select ml-2" id="floor_select" name="floor_select" aria-label="Default select example">
                    <option value="">Select Floor</option>    
                    @foreach($floors as $floor)
                    <option value="{{ $floor->floordrawing_id }}">{{ $floor->floor_id }}</option>
                    @endforeach
                </select>
        </div>
    </div>
        <div class="mt-1 d-flex justify-content-center">
            <canvas id="canvas" width="300" height="300"></canvas>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script>
    const canvas = new fabric.Canvas('canvas', {}); 
    
    function resize() {
        canvas.setWidth(window.innerWidth - 55);
        canvas.setHeight(window.innerHeight - 120);
        //canvas.zoomToPoint({x: canvas.getWidth(), y: canvas.getHeight()}, 1);
        //canvas.renderAll();
    }
    $('#floor_select').change(function () {
        canvas.setZoom(0.9);
        //console.log('selection changed to option #' + $(this).val());
        let selectIndex = $(this).val();
        canvas.clear();
        if(selectIndex) { // check if selection is valid (not first option)
            let drawingId = parseInt(selectIndex);
            $.ajaxSetup({
                beforeSend: function(xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    }
                },
            });
            $.ajax({
                url: '/floordrawings/getDrawing/',
                method: 'post',
                data: {
                    drawingId,   
                },
                success: function(res) {
                    //console.log(res);
                    resize();
                    canvas.loadFromJSON(res, () => {
                        canvas.forEachObject(function(obj) {
                            obj.selectable = false;
                            obj.evented = false;
                            obj.hasControls = false;
                            obj.left += 200; 
                            obj.top += 100;        
                        });
                        canvas.renderAll();
                        $('#canvas').css('border', '2px solid black');
                    });
                },
                error: function(res) {
                    console.log(res);
                }
            });
        }
        else {
            $('#canvas').css('border', '');
            canvas.setWidth(0);  
            canvas.setHeight(0);
        }
    });
    canvas.on('mouse:wheel', function(opt) {
        var delta = opt.e.deltaY;
        var zoom = canvas.getZoom();
        zoom *= 0.999 ** delta;
        if (zoom > 20) zoom = 20;
        if (zoom < 0.01) zoom = 0.01;
        canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
        opt.e.preventDefault();
        opt.e.stopPropagation();
    });
</script>
@endsection