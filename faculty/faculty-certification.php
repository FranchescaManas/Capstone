<?php

$certificates = certificateData($_SESSION['user_id']);

?><main class="d-flex flex-column align-items-center" style="width: 100%;">
    <div class="page-title align-self-start">
        <h2>Certificates - <?= mysqli_num_rows($certificates);?></h2>
    </div>
    <div class="page-container" >
        <!-- TODO: CHANGE THE MESSAGE DEPENDING ON THE COUNT OF CERTIFICATES -->
        <h4>Congratulations on your latest achievement 🎉</h4>
        <?php
        
        $isFirstRow = true;
        while($row = $certificates->fetch_assoc()){
            if($isFirstRow){
                ?>
                
                <div class="latest-certificate-container">
                    <div class="row">
                        <!-- certification logo -->
                        <div class="col-4 py-2">
                        <img src="data:image/jpeg;base64, <?= base64_encode($row['image'])?>" alt="" width="230px">
                            
                        </div>

                        <div class="col-7 d-flex flex-column py-4" style="margin-left:-50px !important">
                            <!-- certificate title -->
                            <h2><?= $row['title'] ?></h2>
                            <!-- certificate publisher -->
                            <p><u><?= $row['issued_by'] ?></u></p>
                            <!-- date of certification -->
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <small><?= $row['issued_date'] ?></small>
                                <button class="rounded my-auto" style="width: 100px" data-cert-id="<?= $row['certificate_id']?>" 
                                data-bs-toggle="modal" data-bs-target="#viewCertificate" id="viewCertificateBtn">View</button>
                                
                            </div>
                        </div>
                        <div class="col-1 d-flex justify-content-end align-items-start py-2" style="position:relative !important">
                            <div class="kebab-menu pt-2 pe-4" style="right: -45px !important">
                                <img src="https://img.icons8.com/?size=512&id=84119&format=png" alt="Three Dots Icon" class="kebab-icon" width="25px">
                                <ul class="kebab-options">
                                    <li>
                                        <button type="button" name="submit" class="m-0" style="background: none; color:black;" id="modifyCertificateBtn">Edit</button>
                                    </li>
                                    <form action="..\shared\forms\event-listener.php" method="post">
                                    <li>
                                        <button type="submit" name="submit" value="<?= 'delete certificate'?>">Delete</button>
                                    </li>
                                    <input type="text" hidden id="certificateID" name="certificateID" value="<?= $row['certificate_id']?>">
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <h4>Explore your certificates!</h4>
                <div class="d-flex flex-wrap">
                    <?php
                    $isFirstRow = false;
            }else{
                ?>
                
                <div class="certificate-container">
                    <div class="row d-flex justify-content-end" style="position: relative;">
                            <div class="kebab-menu pt-2 pe-1" style="right: 0 !important">
                                <img src="https://img.icons8.com/?size=512&id=84119&format=png" alt="Three Dots Icon" class="kebab-icon" width="25px">
                                <ul class="kebab-options">
                                    <li>
                                        <button type="button" name="submit" class="m-0" style="background: none; color:black;" id="modifyCertificateBtn">Edit</button>
                                    </li>
                                    <form action="..\shared\forms\event-listener.php" method="post">
                                    <li>
                                        <button type="submit" name="submit" value="<?= 'delete certificate'?>">Delete</button>
                                    </li>
                                    <input type="text" hidden id="certificateID" name="certificateID" value="<?= $row['certificate_id']?>">
                                    </form>
                                </ul>
                            </div>
                    </div>
                    <div class="row d-flex align-items-end justify-content-center px-3" style='height: 55%;'>
                        <img src="data:image/jpeg;base64, <?= base64_encode($row['image'])?>" alt="" height="85%">
                    </div>
                    <div class="row" style="height: 45%; max-height: 45%;">
                        <div class="col-7">
                            <h6><u><?= $row['issued_by'] ?></u></h6>
                            <small><?= $row['issued_date'] ?></small>
                        </div>
                        <div class="col-5 d-flex">
                                <button class="rounded py-0 align-self-end" style="max-height: 25px" data-cert-id="<?= $row['certificate_id']?>" 
                                data-bs-toggle="modal" data-bs-target="#viewCertificate" id="viewCertificateBtn">View</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
        }
        
        ?>
            <button class="certificate-container d-flex flex-column justify-content-center align-self-center p-0 mx-4"
                    data-bs-toggle="modal" data-bs-target="#uploadCertificate" id='uploadCertificateBtn'>
                   <i class="fa-solid fa-plus d-flex align-self-center"></i> <br>
                   <h5 class="d-flex align-self-center">Upload</h5>
           </button>
        </div>

    </div>
</main>

<?php
include '../shared/modals.php';
?>

<script src="../shared/js/certification.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
