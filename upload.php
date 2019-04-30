<?php
    require_once 'head.php';
?>

<div class="container-table-generated hidden">

    <?php

    include_once 'classes.php';
    require_once 'lib/SimpleXLSX.php';

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 0;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($fileType == "xlsx") {
            $uploadOk = 1;
        } else {
            $uploadOk = 2;
        }
    }
    if ($uploadOk == 0) {
        ?>
            <div class="alert alert-danger" role="alert">
                Ospravedlňujeme sa, ale pristupujete k tejto stránke bez nahraného súboru. <a href="https://dzweb.sk/neoship/" class="alert-link">Kliknite sem</a> pre návrat.
            </div>
        <?php
    } else if ($uploadOk == 2) {
        ?>
            <div class="alert alert-danger" role="alert">
                Ospravedlňujeme sa, ale Váš súbor nie je typu xlsx. <a href="https://dzweb.sk/neoship/" class="alert-link">Kliknite sem</a> pre návrat.
            </div>
        <?php
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $header = array('referenčné číslo', 'príjemca-meno', 'príjemca-ulica', 'príjemca-mesto', 'príjemca-PSČ', 'príjemca-štát', 'príjemca-email', 'príjemca-tel', 'dobierka', 'mena dobierky', 'váha', 'príplatky', 'cena prepravy bez DPH', 'cena prepravy s DPH', 'cena za dobierku', 'cena za ostatné služby', 'spolu');
            $list = array($header);
            if ($xlsx = SimpleXLSX::parse('uploads/' . $_FILES["fileToUpload"]["name"])) {
                $i = 0;
                $j = 0;
                $correctfile = 1;
                foreach ($xlsx->rows()[0] as $col) {
                    if ($col != $header[$j]) {
                        $correctfile = 0;
                        break;
                    }
                    $j++;
                }
                if ($correctfile == 1) {
                    ?>
                    <div class="row">
                        <div class="col-12 text-center h4">
                            Vaša vygenerovaná tabuľka
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 text-center">
                            Váš súbor:
                            <?php
                                echo basename($_FILES["fileToUpload"]["name"]);
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <a class="btn btn-primary" href="https://dzweb.sk/neoship" role="button">Nahrať ďalší súbor</a>
                            <a class="btn btn-secondary" href="https://dzweb.sk/neoship/exportzasielkyscenami.csv" role="button" download>Exportovať do CSV</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>referenčné číslo</th>
                                <th>príjemca-meno</th>
                                <th>príjemca-ulica</th>
                                <th>príjemca-mesto</th>
                                <th>príjemca-PSČ</th>
                                <th>príjemca-štát</th>
                                <th>príjemca-email</th>
                                <th>príjemca-tel</th>
                                <th>dobierka</th>
                                <th>mena dobierky</th>
                                <th>váha</th>
                                <th>príplatky</th>
                                <th>cena prepravy bez DPH</th>
                                <th>cena prepravy s DPH</th>
                                <th>cena za dobierku</th>
                                <th>cena za ostatné služby</th>
                                <th>spolu</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php  
                    foreach ($xlsx->rows() as $row) {
                        if ($i != 0) {
                            $recipient = new Recipient($row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
                            $package = new Package($row[0], $recipient, $row[8], $row[9], $row[10], $row[11]);
                            $package->calculateShipment();
                            array_push($list, array($package->ref_number, $package->recipient->namecustomer, $package->recipient->street, $package->recipient->city, $package->recipient->postcode, $package->recipient->country,
                            $package->recipient->email, $package->recipient->telephone, $package->cash_delivery, $package->cash_delivery_currency, $package->weight, $package->fee, $package->delivery_price_without_VAT,
                            $package->delivery_price_with_VAT, $package->cash_delivery_fee, $package->price_other_services, $package->sum));
                            ?>
                    <tr>
                        <td><?php echo $package->ref_number; ?></td>
                        <td><?php echo $package->recipient->namecustomer; ?></td>
                        <td><?php echo $package->recipient->street; ?></td>
                        <td><?php echo $package->recipient->city; ?></td>
                        <td><?php echo $package->recipient->postcode; ?></td>
                        <td><?php echo $package->recipient->country; ?></td>
                        <td><?php echo $package->recipient->email; ?></td>
                        <td><?php echo $package->recipient->telephone; ?></td>
                        <td><?php echo $package->cash_delivery; ?></td>
                        <td><?php echo $package->cash_delivery_currency; ?></td>
                        <td><?php echo $package->weight; ?></td>
                        <td><?php echo $package->fee; ?></td>
                        <td><?php echo $package->delivery_price_without_VAT; ?></td>
                        <td><?php echo $package->delivery_price_with_VAT; ?></td>
                        <td><?php echo $package->cash_delivery_fee; ?></td>
                        <td><?php echo $package->price_other_services; ?></td>
                        <td><?php echo $package->sum; ?></td>
                    </tr>
                        <?php
                        }
                        $i++;
                    }
                    $fp = fopen('exportzasielkyscenami.csv', 'w');
                    fputs( $fp, "\xEF\xBB\xBF" );
                    foreach ($list as $fields) {
                        fputcsv($fp, $fields, ";");
                    }
                    fclose($fp);
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Ospravedlňujeme sa, ale Váš xlsx súbor nemá správne stĺpce. <a href="https://dzweb.sk/neoship/" class="alert-link">Kliknite sem</a> pre návrat.
                    </div>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
    //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    require_once 'foot.php';