@extends('layout')
@section('title', 'Edit Room')
@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('headjs')
<script src="{{ asset('js/fabricjs/fabric.js') }}"></script>
@endsection
@section('content')
<div class="row m-1 m-md-5 d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><strong>Edit floor {{ $floors->floor_id }}</strong></div>
            <div class="card-body">
                <ul class="errors text-danger">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('floors.update', $floors->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="floordrawing_id"><strong>Select Floor Drawing: </strong></label>
                            <select class="form-select ml-2" id="floordrawing_id" name="floordrawing_id" aria-label="Default select example">
                                <option value="0">No Drawing</option>    
                            @foreach($drawings as $draw)
                                <option value="{{ $draw->id }}">Floor: {{ $draw->floor->floor_id }}, Building: {{ $draw->building }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>     
                </form>
            </div>
        </div>
        <div class="mt-3">
            <h3>Floor Plan preview:</h3>
            <canvas id="canvas" width="300" height="300"></canvas>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script>
    const canvas = new fabric.Canvas('canvas', {}); 
    $('#floordrawing_id').change(function () {
        const selectionIndex = $(this).val();
        canvas.clear();
        const drawingId = parseInt(selectionIndex);
        if(drawingId != 0) { // check if selection is valid (not first option)
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
                    console.log('Got response from server with canvas data');
                    canvas.setWidth(window.innerWidth) ;  
                    canvas.setHeight(window.innerHeight);
                    canvas.loadFromJSON(res, () => {
                        canvas.forEachObject(function(obj) {
                            obj.selectable = false;
                            obj.evented = false;
                            obj.hasControls = false;         
                        });
                        canvas.renderAll();
                    });
                },
                error: function(res) {
                    console.log('Got Error response from server:')
                    console.log(res);
                }
            });
        }
    });
</script>
@endsection