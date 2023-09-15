<?php
if(isset($_GET['page'])){
    $role = $_GET['page'];

    if($role === 'students'){
        $role = 'student';
        $file = '../import-template/Student Template 1.xlsx';
        $filename = "Student Template";
    }else if($role === 'faculty'){
        $role = 'faculty';
        $file = '../import-template/Faculty Template 1.xlsx';
        $filename = "Faculty Template";

    }
}


?>
<head>
<style>
        #imagePreview {
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 100%; /* Set a fixed height for the container */
            max-width: 100%; /* Set a maximum width to fit the container */
            overflow: hidden; /* Hide any overflow if the image is larger */
            background-color: #f0f0f0; /* Optional: Set a background color for the container */
        }

        #imagePreview img {
            width: auto; /* Auto width to maintain aspect ratio */
            height: 100%; /* Stretch the image to fill the container vertically */
        }
    </style>
</head>
<div class="modal fade" id="import<?=$role?>" tabindex="-1" aria-labelledby="importFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <div class="d-flex flex-column justify-content-start">
                    <h5 class="modal-title" id="importFormLabel">Import Data</h5>
                    <p>Kindly upload the <?=$role?> data into the provided template.</p>
                    <a href="<?= $file?>"><?= $filename?></a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="../shared/import.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="role" value="<?= $role?>">
                    <input type="file" name="excel_file" accept=".xls, .xlsx">
                    <button type="submit" name="submit" class="red-btn small-btn rounded">Save</button>
                    <button type="button" class="red-btn small-btn rounded" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
            <div class="modal-footer flex-end">
            </div>
        </div>
    </div>
</div>

<div class="modal fade certificateModal" id="<?=$action?>Certificate" tabindex="-1" aria-labelledby="certificateFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="height: 50% !important">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <div class="d-flex flex-column justify-content-start">
                    <h5 class="modal-title" id="certificateFormLabel">Upload Certification</h5>
                    <p class="certificate-action">Kindly upload a clear photo of your certification.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="../shared/forms/event-listener.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-8">
                            <div id="imagePreview"></div>
                            <label for="imageInput" style="cursor: pointer;" class='certificate-action'>Choose Image</label>
                            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;" />
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" Placeholder="Name">
                            <label for="name">Title:</label>
                            <input type="text" name="title" id="title" placeholder="Title of Certificate">
                            <label for="name">Issued By:</label>
                            <input type="text" name="provider" id="provider" placeholder="Provider of Certificate">
                            <label for="name">Date Certified:</label>
                            <input type="date" name="dateCertified" id="dateCertified">
                            <div class="d-flex flex-row justify-content-end certificate-action">
                                    <input type="text" hidden id="userID" name="userID" value="<?= $_SESSION['user_id']?>">
                                    <input type="text" hidden id="certID" name="certID">
                                    

                                    <button type="submit" id="certificate-btn" name="submit" class="w-50">Save</button>
                                    <button type="button" class="w-50 ms-2">Cavel</button>

                            </div>
                        </div>
                    </div>

                </form>
                
            </div>
            <div class="modal-footer flex-end">
            </div>
        </div>
    </div>
</div>

<script>
    var userID = <?= $_SESSION['user_id']?>;
</script>