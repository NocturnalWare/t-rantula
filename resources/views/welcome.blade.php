@extends('layouts.master')

@section('head')
    <meta charset="UTF-8">
    <meta property="og:image" content="http://tori.website/images/painting.png" />
    <meta property="og:description" content="Buy this original reproduction on canvas! Now only $100" />
    <meta property="og:title" content="Tori Ranta - Art on Canvas" />
@stop

@section('title')
    <title>Tori Ranta - Painter</title>
@stop

@section('content')
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>
    <div id="title">
        <body id="maincontent" style="background-color:#000;max-height:100%;overflow:hidden">
            <div class="col-sm-4 col-sm-offset-4">
                <center>
                    <img id="mainimage" height="80%" width="80%" image-id="1" class="hidden-xs img-responsive" src="http://tori.website/images/painting.png">
                    <img id="mainimage2" class="hidden-sm hidden-md hidden-lg hidden-xl img-responsive" src="http://tori.website/images/painting.png">
                </center>
            </div>
            <div class="col-sm-4 col-sm-offset-4" style="color:#fff">
                <h4 style="text-align:center">
                    <div class="row">
                       I'm Tori Ranta. This is an original reproduction on canvas.
                    </div>
                    <div class="row" style="padding-top:15px;display:none">
                        Buy it now for <u>$100.00</u>
                    </div>
                </h4>
            </div>
        </div>
        </div>


<script type="text/javascript">

(function (factory) {
    if ( typeof define === 'function' && define.amd ) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS style for Browserify
        module.exports = factory;
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var toFix = ['wheel', 'mousewheel', 'DOMMouseScroll', 'MozMousePixelScroll'];
    var toBind = 'onwheel' in document || document.documentMode >= 9 ? ['wheel'] : ['mousewheel', 'DomMouseScroll', 'MozMousePixelScroll'];
    var lowestDelta, lowestDeltaXY;

    if ( $.event.fixHooks ) {
        for ( var i = toFix.length; i; ) {
            $.event.fixHooks[ toFix[--i] ] = $.event.mouseHooks;
        }
    }

    $.event.special.mousewheel = {
        setup: function() {
            if ( this.addEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.addEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = handler;
            }
        },

        teardown: function() {
            if ( this.removeEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.removeEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = null;
            }
        }
    };

    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
        },

        unmousewheel: function(fn) {
            return this.unbind("mousewheel", fn);
        }
    });


    function handler(event) {
        var orgEvent = event || window.event,
            args = [].slice.call(arguments, 1),
            delta = 0,
            deltaX = 0,
            deltaY = 0,
            absDelta = 0,
            absDeltaXY = 0,
            fn;
        event = $.event.fix(orgEvent);
        event.type = "mousewheel";

        // Old school scrollwheel delta
        if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta; }
        if ( orgEvent.detail )     { delta = orgEvent.detail * -1; }

        // New school wheel delta (wheel event)
        if ( orgEvent.deltaY ) {
            deltaY = orgEvent.deltaY * -1;
            delta  = deltaY;
        }
        if ( orgEvent.deltaX ) {
            deltaX = orgEvent.deltaX;
            delta  = deltaX * -1;
        }

        // Webkit
        if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY; }
        if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = orgEvent.wheelDeltaX * -1; }

        // Look for lowest delta to normalize the delta values
        absDelta = Math.abs(delta);
        if ( !lowestDelta || absDelta < lowestDelta ) { lowestDelta = absDelta; }
        absDeltaXY = Math.max(Math.abs(deltaY), Math.abs(deltaX));
        if ( !lowestDeltaXY || absDeltaXY < lowestDeltaXY ) { lowestDeltaXY = absDeltaXY; }

        // Get a whole value for the deltas
        fn = delta > 0 ? 'floor' : 'ceil';
        delta  = Math[fn](delta / lowestDelta);
        deltaX = Math[fn](deltaX / lowestDeltaXY);
        deltaY = Math[fn](deltaY / lowestDeltaXY);

        // Add event and delta to the front of the arguments
        args.unshift(event, delta, deltaX, deltaY);

        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

}));

$("#maincontent").on("swipeleft", function(){
    mobileImageSwitch();
});

$("#maincontent").on("swiperight", function(){
    mobileImageSwitch();
});

function mobileImageSwitch(){
    var image = $('#mainimage2').attr('src');
    if(image == 'http://tori.website/images/polar_lights.jpg'){
        $('#mainimage2').attr('src', 'http://tori.website/images/painting.png');
    }else{
        $('#mainimage2').attr('src', 'http://tori.website/images/polar_lights.jpg');
    }
}

$('#maincontent').mousewheel(function(event, delta){
    var height = $('#mainimage').attr('height').replace('%', '');
    var width = $('#mainimage').attr('width').replace('%', '');
    var delta_px = delta > 0 ? parseFloat(height)-4 : parseFloat(width)+4;

    if(height < 100 && height > 3){
        $('#mainimage').attr('width', delta_px+'%');
        $('#mainimage').attr('height', delta_px+'%');
    }else{
        $('#mainimage').attr('width', '5%');
        $('#mainimage').attr('height', '5%');
        imageSwitch();
    }
});

function imageSwitch(){
    var image = $('#mainimage').attr('src');
    if(image == 'http://tori.website/images/polar_lights.jpg'){
        $('#mainimage').attr('src', 'http://tori.website/images/painting.png');
    }else{
        $('#mainimage').attr('src', 'http://tori.website/images/polar_lights.jpg');
    }
}

// var lastScrollTop = 0;
// $(window).scroll(function(event){
//     var st = $(this).scrollTop();
//     var height = $('#mainimage').attr('height').replace('%', '');
//     var width = $('#mainimage').attr('width').replace('%', '');
//    if (st > lastScrollTop){
//        if(width < 100){
//             console.log(width);
//        }else{
//             alert('111')
//        }
//    } else {
//       // upscroll code
//        console.log('down');
//    }
//    lastScrollTop = st;
// });
</script>
@stop