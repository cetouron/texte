<x-monsite>
    <x-slot name="title">
        Liste des avis
    </x-slot>

    <x-slot name="fil">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ps-0 fs-base">
                <li class="breadcrumb-item"><a href="#">Administration</a></li>
                <li class="breadcrumb-item"><span>Formulaire</span></li>
                <li class="breadcrumb-item active" aria-current="page">dsgdsgerdg</li>
            </ol>
        </nav>
    </x-slot>

    <div class="page-content">


        <div class="row">
            <div id="app">
                <!--   <form-index></form-index> -->
                <!--   <calendar></calendar> -->
            </div>

            <div id='calendar'></div>
        </div><!-- end row -->
    </div>

    <script src="{{ asset('monsite/assets/js/form.js') }}"></script>
    <script src="{{ asset('monsite/assets/js/wizard.js') }}"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });

    </script>
</x-monsite>
