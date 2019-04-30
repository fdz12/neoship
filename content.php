<?php 
    include_once ('classes.php');
    require_once 'lib/SimpleXLSX.php';
?>

<div class="blocks">
    <div class="block hidden">
        <div class="row">
            <div class="col-12 text-center">
                <img src="img/package.png" alt="zasielka">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center my-3 h4">
                Zobrazenie cien prepravy pre zásielky
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-secondary" role="alert">
                    Vkladajte, prosím, iba súbory z Excelu (.xlsx) a uistite sa, aby tabuľka mala správne
                    <a href="#" data-toggle="tooltip" title="referenčné číslo, príjemca-meno, príjemca-ulica, príjemca-mesto, príjemca-PSČ, príjemca-štát, príjemca-email, príjemca-tel, dobierka, mena dobierky, váha, príplatky">stĺpce</a>.
                </div>
                <div class="alert alert-danger hiddenc" role="alert" id="error_form">
                </div>
            </div>
        </div>
        <form action="upload.php" enctype="multipart/form-data" method="POST" id="uploadfile">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" aria-describedby="inputGroupFileAddon04">
                    <label class="custom-file-label" for="inputGroupFile04">Nie je vybratý súbor</label>
                </div>
                <div class="input-group-append">
                    <input class="btn btn-primary" type="submit" name="submit" id="inputGroupFileAddon04" value="Vypočítať ceny">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12 text-center my-4 font-italic">
                Vyrobil Denis Žuffa pre <a href="https://github.com/neoship/homework">zadanie</a> spoločnosti <a href="https://info.neoship.sk/">Neoship</a>
            </div>
        </div>
    </div>
</div>


