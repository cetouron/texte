<!DOCTYPE html>


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

<div class="page-container">




    <form action="" method="POST">
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

</body>
</html>

