@extends('layouts.master')
@section('content')
<style>
.xzoom-source img, .xzoom-preview img, .xzoom-lens img {
  display: block;
  max-width: none;
  max-height: none;
  -webkit-transition: none;
  -moz-transition: none;
  -o-transition: none;
  transition: none;
}
</style>
<div id="productApp"></div>
<script src="{{asset('react/app.js')}}"></script>

<script>
    // $(document).ready(function () {
    //     if (location.href.split('/')[5] === 'singleProductDetails') {}
    // });

    // $(document).ready(function () {
    //     window.addEventListener('mouseup', function (event) {
    //         const box = document.getElementById('box1');
    //         if (event.target != box && event.target.parentNode != box) {
    //             box.style.display = 'none';
    //         }
    //     })
    // });
    $(document).ready(function () {
          document.addEventListener("contextmenu", function(e){
            if (e.target.nodeName === "IMG") {
                e.preventDefault();
            }
    }, false);
    });
    
    
</script>
@endsection
