<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('storage/' .application('fav')) }}">

<!-- Bootstrap Rating css -->
<link href="{{ asset('libs/bootstrap-rating/bootstrap-rating.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('libs/%40chenfengyuan/datepicker/datepicker.min.css') }}">

<link href="{{ asset('libs/bootstrap-rating/bootstrap-rating.css') }}" rel="stylesheet" type="text/css" />
<!-- Bootstrap Css -->
<link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<!-- Dynamic theme overrides (uses server settings, loaded after app.min.css so it can override compiled rules) -->
<link href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) ?? time() }}" rel="stylesheet" type="text/css" />
<style>
    :root {
        /* Fallbacks provided if settings are not set */
        --app-bg: {{  '#ffffff' }};
        --primary-color: {{ get_settings('primary_color') ?? '#377dff' }};
        --secondary-color: {{ get_settings('secondary_color') ?? '#6c757d' }};
        --primary-contrast: {{ get_settings('secondary_color') ?? '#ffffff' }};
    }

    /* Common overrides that mirror variables used in the app stylesheet */
    body {
        /* background-color: var(--app-bg) !important; */
    }

    .btn-primary,
    .btn-primary:focus,
    .btn-primary:hover {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: var(--primary-contrast) !important;
    }

    .navbar,
    .topbar {
        background-color: var(--primary-color) !important;
    }

    .btn-secondary,
    .btn-secondary:focus,
    .btn-secondary:hover {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
        color: #fff !important;
    }

    /* Sidebar overrides (map to selectors from app.min.css) */
    body[data-sidebar="dark"] .navbar-brand-box,
    .vertical-menu {
        background-color: var(--primary-color) !important;
        color: var(--primary-contrast) !important;
    }

    #sidebar-menu ul li a {
        color: rgba(255,255,255,0.9) !important;
    }

    #sidebar-menu ul li a:hover,
    #sidebar-menu ul li a.active,
    #sidebar-menu ul li a:focus {
        background-color: rgba(0,0,0,0.08) !important;
        color: var(--primary-contrast) !important;
    }

    #sidebar-menu ul li .badge {
        background-color: var(--secondary-color) !important;
        color: #fff !important;
    }

    /* Sub-menu background subtle tint */
    #sidebar-menu ul li ul.sub-menu {
        background-color: rgba(255,255,255,0.03) !important;
    }

    /* small utility for color chips used in admin UI */
    .color-chip {
        display:inline-block;
        width:22px;
        height:22px;
        border-radius:3px;
        vertical-align:middle;
        margin-right:6px;
        border:1px solid rgba(0,0,0,0.05);
    }

    /* Website/public-facing overrides */
    .home-btn .btn-primary,
    .auth-link .btn-primary,
    .auth-link .btn-primary.btn-rounded,
    .card .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: var(--primary-contrast) !important;
    }

    .card,
    .wel-hero,
    .auth-card {
        background-color: rgba(255,255,255,0.02);
        border: 1px solid rgba(0,0,0,0.04);
    }

    a,
    a:hover {
        color: var(--primary-color) !important;
    }
</style>

<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/notiflix.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">

<link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('libs/fullcalendar/core/main.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/fullcalendar/daygrid/main.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/fullcalendar/bootstrap/main.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/fullcalendar/timegrid/main.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('libs/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />


 <!-- DataTables -->
<link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/summernote-bs4.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/summernote-bs4.min.js') }}"></script>


@yield('styles')
@livewireStyles

<style>
    .la-ball-spin,
    .la-ball-spin>div {
        position: relative;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .la-ball-spin {
        display: block;
        font-size: 0;
        color: #fff;
    }

    .la-ball-spin.la-dark {
        color: #333;
    }

    .la-ball-spin>div {
        display: inline-block;
        float: none;
        background-color: currentColor;
        border: 0 solid currentColor;
    }

    .la-ball-spin {
        width: 32px;
        height: 32px;
    }

    .la-ball-spin>div {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 8px;
        height: 8px;
        margin-top: -4px;
        margin-left: -4px;
        border-radius: 100%;
        -webkit-animation: ball-spin 1s infinite ease-in-out;
        -moz-animation: ball-spin 1s infinite ease-in-out;
        -o-animation: ball-spin 1s infinite ease-in-out;
        animation: ball-spin 1s infinite ease-in-out;
    }

    .la-ball-spin>div:nth-child(1) {
        top: 5%;
        left: 50%;
        -webkit-animation-delay: -1.125s;
        -moz-animation-delay: -1.125s;
        -o-animation-delay: -1.125s;
        animation-delay: -1.125s;
    }

    .la-ball-spin>div:nth-child(2) {
        top: 18.1801948466%;
        left: 81.8198051534%;
        -webkit-animation-delay: -1.25s;
        -moz-animation-delay: -1.25s;
        -o-animation-delay: -1.25s;
        animation-delay: -1.25s;
    }

    .la-ball-spin>div:nth-child(3) {
        top: 50%;
        left: 95%;
        -webkit-animation-delay: -1.375s;
        -moz-animation-delay: -1.375s;
        -o-animation-delay: -1.375s;
        animation-delay: -1.375s;
    }

    .la-ball-spin>div:nth-child(4) {
        top: 81.8198051534%;
        left: 81.8198051534%;
        -webkit-animation-delay: -1.5s;
        -moz-animation-delay: -1.5s;
        -o-animation-delay: -1.5s;
        animation-delay: -1.5s;
    }

    .la-ball-spin>div:nth-child(5) {
        top: 94.9999999966%;
        left: 50.0000000005%;
        -webkit-animation-delay: -1.625s;
        -moz-animation-delay: -1.625s;
        -o-animation-delay: -1.625s;
        animation-delay: -1.625s;
    }

    .la-ball-spin>div:nth-child(6) {
        top: 81.8198046966%;
        left: 18.1801949248%;
        -webkit-animation-delay: -1.75s;
        -moz-animation-delay: -1.75s;
        -o-animation-delay: -1.75s;
        animation-delay: -1.75s;
    }

    .la-ball-spin>div:nth-child(7) {
        top: 49.9999750815%;
        left: 5.0000051215%;
        -webkit-animation-delay: -1.875s;
        -moz-animation-delay: -1.875s;
        -o-animation-delay: -1.875s;
        animation-delay: -1.875s;
    }

    .la-ball-spin>div:nth-child(8) {
        top: 18.179464974%;
        left: 18.1803700518%;
        -webkit-animation-delay: -2s;
        -moz-animation-delay: -2s;
        -o-animation-delay: -2s;
        animation-delay: -2s;
    }

    .la-ball-spin.la-sm {
        width: 16px;
        height: 16px;
    }

    .la-ball-spin.la-sm>div {
        width: 4px;
        height: 4px;
        margin-top: -2px;
        margin-left: -2px;
    }

    .la-ball-spin.la-2x {
        width: 64px;
        height: 64px;
    }

    .la-ball-spin.la-2x>div {
        width: 16px;
        height: 16px;
        margin-top: -8px;
        margin-left: -8px;
    }

    .la-ball-spin.la-3x {
        width: 96px;
        height: 96px;
    }

    .la-ball-spin.la-3x>div {
        width: 24px;
        height: 24px;
        margin-top: -12px;
        margin-left: -12px;
    }

    caption {
        padding-top: 8px;
        padding-bottom: 8px;
        color: #999;
        text-align: left
    }

    /*
    * Animation
    */
    @-webkit-keyframes ball-spin {

        0%,
        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        20% {
            opacity: 1;
        }

        80% {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }
    }

    @-moz-keyframes ball-spin {

        0%,
        100% {
            opacity: 1;
            -moz-transform: scale(1);
            transform: scale(1);
        }

        20% {
            opacity: 1;
        }

        80% {
            opacity: 0;
            -moz-transform: scale(0);
            transform: scale(0);
        }
    }

    @-o-keyframes ball-spin {

        0%,
        100% {
            opacity: 1;
            -o-transform: scale(1);
            transform: scale(1);
        }

        20% {
            opacity: 1;
        }

        80% {
            opacity: 0;
            -o-transform: scale(0);
            transform: scale(0);
        }
    }

    @keyframes ball-spin {

        0%,
        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }

        20% {
            opacity: 1;
        }

        80% {
            opacity: 0;
            -webkit-transform: scale(0);
            -moz-transform: scale(0);
            -o-transform: scale(0);
            transform: scale(0);
        }
    }

    .spinner-mid {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #000;
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 9999;
        width: 100%;
        height: 100%;
        opacity: .75;
    }

    .parent {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }

    @media screen and (max-width: 480px) {
         .parent {
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    }

    .img-responsive {
        width: 80px;
        height: 80px
    }

    input[type=number] {
        -moz-appearance: textfield
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }



    .details ul {
        list-style: none;
        font-weight: 500;
        font-size: 12px;
        border-right: 1px solid #000000;
        border-radius: 2px; 
        padding: 5px 20px; 
        margin-top: 3px;
        height: 110px
    }

    .details ul li {
        padding: 2px 0
    }

    .details ul li b {
        padding-left: 10px;
        text-align: right
    }

    .resultd {
        position: relative;
        overflow: hidden;
        margin: 0 auto;
        padding: 6px;
        font-size: 11px;
        color: #2f393c !important;
        font-family: 'Cerebri Sans' !important;
        display: none
    }

    .resultd .table-wrapper {
       
        margin-bottom: 12px; 
        -webkit-box-shadow: 0 -3px 1px #f3f3f3; 
        box-shadow: 0 -3px 1px #f3f3f3;
    }

    .resultd td.comment {
        text-align: justify !important;
        font-weight: normal;
        white-space: normal !important;
        vertical-align: top !important;
        color: #000000 !important;
        font-size: 12px
    }

    .resultd .comment dt {
        color: #000000 !important
    }

    .table-condensed>tbody>tr>td,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>td,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>thead>tr>th {
        padding: 2px;
        border: 1px solid #000;
    }

    .cogd table td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 30px;
        min-width: 30px;
        vertical-align: middle;
        text-align: center;
        color: #000;
        font-weight: 500
    }

    .resultd .cogd table td.coms {
        width: 50%;
        min-width: 50%;
        white-space: normal
    }

    .resultd .cogd table th.rotate-45 {
        height: 150px;
        position: relative;
        padding: 10px;
        font-size: 10px;
        line-height: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    .resultd .cogd table th.rotate-45>div {
        -ms-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -webkit-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        transform: rotate(270deg);
        position: absolute;
        bottom: 7px;
        width: 100%;
        height: 30px
    }

    .padding-right-10 {
        padding-right: 10px
    }

    .padding-left-0 {
        padding-left: 0 !important
    }

    .resultd .s-acad-perf>span {
        border-bottom: 1px solid #000
    }

    .resultd .s-acad-perf>span:last-child {
        border-bottom: 0
    }

    .resultd .t-score:after,
    .resultd .s-remark:after,
    .resultd .c-pos:after {
        content: attr(data-description);
        font-size: 17px;
        font-weight: 500;
        display: block;
        line-height: .1;
        margin: 5px 0;
        color: #356d9e
    }

    .resultd .s-remark[data-description="Passed"]:after {
        font-weight: 500;
        color: #4CAF50 !important;
        font-size: 20px;
        text-transform: uppercase
    }

    .resultd .s-remark[data-description="Failed"]:after {
        font-weight: 500;
        color: #F44336 !important;
        font-size: 20px;
        text-transform: uppercase
    }

    .resultd .t-score,
    .resultd .s-remark,
    .resultd .c-pos {
        margin: 5px;
        padding: 5px 10px;
        display: block;
        font-weight: 500;
        background: #fcfcfc
    }

       .card-scratch{
         width: 300px;
         height: 60px;
         position: relative;
         overflow: hidden;
         display: flex;
         align-items: center;
         justify-content: space-around;
         box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.2);
         margin: 5px;
         border-top: 1px solid #000000;
         border-bottom: 1px solid #000000;
         border-style: dotted;
         border-radius: 2px
        }   

        .demo-bg {
            opacity: 0.07;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: auto;
        } 
        
      .base, #scratch {
        cursor: default;
        height: 60px;
        width: 300px;
          position: absolute;
          top: 0;
          left: 0;
          cursor: grabbing;
      }
      .base {
        line-height: 60px;
        text-align: center;
      }
      #scratch {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0); 
        -webkit-touch-callout: none;
        -webkit-user-select: none;
      }

    .demo-content {
        position: relative;
        text-align: center
    }

    .pin-card{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .blink {
        animation: blinker 1.5s linear infinite;
        font-family: sans-serif;
        font-weight: bold;
    }
    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .onoffswitch3
    {
        position: relative; 
        -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    }

    .onoffswitch3-checkbox {
        display: none;
    }

    .onoffswitch3-label {
        display: block; overflow: hidden; cursor: pointer;
        border: 0px solid #999999; border-radius: 0px;
    }

    .onoffswitch3-inner {
        display: block; width: 200%; margin-left: -100%;
        -moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
        -o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
    }

    .onoffswitch3-inner > span {
        display: block; float: left; position: relative; width: 50%; height: 30px; padding: 0; line-height: 30px;
        font-size: 14px; color: white; font-family: 'Montserrat', sans-serif; font-weight: bold;
        -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
    }

    .onoffswitch3-inner .onoffswitch3-active {
        padding-left: 10px;
        background-color: #EEEEEE; color: #FFFFFF;
    }

    .onoffswitch3-inner .onoffswitch3-inactive {
        width: 100px;
        padding-left: 16px;
        background-color: #EEEEEE; color: #FFFFFF;
        text-align: right;
    }

    .onoffswitch3-switch {
        display: block; width: 50%; margin: 0px; text-align: center; 
        border: 0px solid #999999;border-radius: 0px; 
        position: absolute; top: 0; bottom: 0;
    }
    .onoffswitch3-active .onoffswitch3-switch {
        background: #27A1CA; left: 0;
        width: 160px;
    }
    .onoffswitch3-inactive{
        background: #A1A1A1; right: 0;
        width: 20px;
    }
    .onoffswitch3-checkbox:checked + .onoffswitch3-label .onoffswitch3-inner {
        margin-left: 0;
    }

    .scroll-text{
        color: #000;
    }

    figure {
        max-width:1024px;
        max-width:64rem;
        width:100%;
        height:auto;
        margin:20px 0 0;
        margin:1.25rem 0 0;
    }
    figcaption {
        display:block;
        font-size:16px;
        font-size:1rem;
    }
    video {
        width:100%;
        height:auto;
    }

    /* controls */
    .controls, .controls li {
        padding:0;
        margin:0;
    }
    .controls {
        display:none;
        list-style-type:none;
        overflow:hidden;
        background:transparent;
    }
    .controls li {
        float:left;
        width:10%;
        margin-left:0.3%;
    }
    .controls li:first-child {
        margin-left:0;
    }
    .controls .progress {
        width:38%;
        cursor:pointer;
    }
    .controls button {
        width:100%;
        text-align:center;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    .controls progress {
        display:block;
        width:100%;
        height:20px;
        height:1.25rem;
        margin-top:2px;
        margin-top:0.125rem;
        border:1px solid #aaa;
        overflow:hidden;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
    }
    .controls progress span {
        width:0%;
        height:100%;
        display:inline-block;
        background-color:#2a84cd;	
    }

    /* fullscreen */
    html:-ms-fullscreen {
        width:100%;
    }
    :-webkit-full-screen {
        background-color:transparent;
    }
    /* hide controls on fullscreen with WebKit */
    figure[data-fullscreen=true] video::-webkit-media-controls {
        display:none !important;
    }
    figure[data-fullscreen=true] {
        max-width:100%;
        width:100%;
        margin:0;
        padding:0;
    }
    figure[data-fullscreen=true] video {
        height:auto;
    }
    figure[data-fullscreen=true] figcaption {
        display:none;
    }
    figure[data-fullscreen=true] .controls {
        position:absolute;
        bottom:2%;
        width:100%;
        z-index:2147483647;
    }
    figure[data-fullscreen=true] .controls li {
        width:5%;
    }
    figure[data-fullscreen=true] .controls .progress {
        width:68%;
    }

    .box {
        background-color: #F7FF00;
        color: black;
        padding: 20px;
        margin: 20px;
        display: inline-block;
        vertical-align: middle;
    }
    .rotateX {
        margin: 0 0 0 200px;
        font-size: 18px;
        transform: rotateX(180deg);
    }

    .rotateY {
        margin: 0 0 0 200px;
        font-size: 18px;
        transform: rotateY(3.14rad);
    }

    .rotateZ {
        margin: 0 0 0 200px;
        font-size: 18px;
        transform: rotateZ(-180deg);
    }

    .rotate {
    -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        writing-mode: lr-tb;
    }
</style>