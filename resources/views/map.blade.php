@extends('layout')
@section('title', 'Book a room')
@section('content')
<div class="row">
        <div class="row">
            <div class="row">

                <object id="svg1" data="{{ asset('img/svg/test-floor.svg') }}" type="image/svg+xml"></object>
            <button onclick="myFunction()">Click me</button>
        </div>
</div>
<script>
function myFunction(){
    var c = document.getElementById("svg1").contentDocument;
    var rect = c.getElementById("c1");
    var rect2 = c.getElementById("c2");
    rect.setAttribute("fill", "green");
    rect2.setAttribute("fill", "green");
   
}
</script>
@endsection