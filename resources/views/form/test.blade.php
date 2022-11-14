<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Basic Table - Table">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">

    <title>{{ $title ?? 'Administration' }}</title>
    <link href="{{ asset('monsite/assets/css/app.css') }}" rel="stylesheet">

</head>
<!-- Possible Body Attributes
    * data-theme-header-fixed = 'true'       - For fixed Header
    * data-theme-header-fixed = 'false'      - For static Header
    * data-theme-sidebar-fixed = 'true'      - For fixed Left Navigation
    * data-theme-sidebar-fixed = 'false'     - For static Left Navigation
    * data-theme-sidebar-shrinked = 'true'   - For shrinking Left Navigation
    * data-theme-footer-fixed = 'true'       - For fixed Footer
    * data-theme-footer-fixed = 'false'      - For static Footer
    * data-theme-mode = 'dark-mode'          - For Dark Mode
-->

<body>
<!-- apply javascript before page content be loaded -->
<script>
    'use strict';
    var defaultConfig = {
        fixedLeftSidebar: true,
        fixedHeader: false,
        fixedFooter: false,
        isShrinked: false,
        themeColor: 'app-theme-facebook',
        themeMode: 'default-mode'
    };
    var globalConfigs = JSON.parse(localStorage.getItem('ABCADMIN_CONFIG')) || defaultConfig;
    var appThemeMode = globalConfigs.themeMode;
    var isShrinked = globalConfigs.isShrinked;
    var body = document.getElementsByTagName("body")[0];
    body.setAttribute("data-theme-mode", appThemeMode);
    body.setAttribute("data-theme-sidebar-shrinked", isShrinked)
</script>
<div class="page-container">


    <x-slot name="fil">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ps-0 fs-base">
                <li class="breadcrumb-item"><a href="#">Administration</a></li>
                <li class="breadcrumb-item"><span>Formulaire</span></li>
                <li class="breadcrumb-item active" aria-current="page">Injkhvjhdex</li>
            </ol>
        </nav>
    </x-slot>

    <form action="{{ route('form.envoie') }}" method="POST">
        @csrf
        <textarea id="text" name="text"></textarea>
        <button >Modifier</button>

        <input type="radio" name="type" id="contact_email" value="flixi"/>
        <label for="contact_email">Flixi</label>
        <input type="radio" name="type" id="contact_email" value="noplp"/>
        <label for="contact_email">NOPLP</label>
    </form>



    @if(isset($text_sortie))
        <p>
            <input type="button" value="Copier" class="js-copy" data-target="#tocopy">
            <span id="tocopy">{!! $text_sortie !!}</span>
        </p>
    @endif



    @if(isset($strs))
        @foreach($strs as $s)
            {{$s}}
            <br>
        @endforeach
    @endif

    <script>
        function click() {
            console.log('ok');
            console.log(document.getElementById('text').value);
        }

        var btncopy = document.querySelector('.js-copy');
        if(btncopy) {
            btncopy.addEventListener('click', docopy);
        }

        function docopy() {
            var range = document.createRange();
            var target = this.dataset.target;
            var fromElement = document.querySelector(target);
            var selection = window.getSelection();

            range.selectNode(fromElement);
            selection.removeAllRanges();
            selection.addRange(range);

            try {
                var result = document.execCommand('copy');
                if (result) {
                    // La copie a réussi
                    //  alert('Copié !');
                }
            }
            catch(err) {
                // Une erreur est surevnue lors de la tentative de copie
                //   alert(err);
            }

            selection = window.getSelection();

            if (typeof selection.removeRange === 'function') {
                selection.removeRange(range);
            } else if (typeof selection.removeAllRanges === 'function') {
                selection.removeAllRanges();
            }
        }
    </script>


    <!-- end page-content -->

</div>
<!-- end page-container -->

<!-- end right-sidebar -->
<script src="{{ asset('monsite/assets/js/vendor~app~dashboard_analytics~dashboard_ecommerce~demo_add_product~demo_calendar~demo_datatable~dem~699a60a5.js') }}"></script>
<script src="{{ asset('monsite/assets/js/vendor~app~demo_form_wizard.js') }}"></script>
<script src="{{ asset('monsite/assets/js/app.js') }}"></script>
</body>
</html>

