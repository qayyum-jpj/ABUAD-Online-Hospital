<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/echarts/echarts.min.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/quill/quill.min.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?= $patientRoot ?>assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="<?= $patientRoot ?>assets/js/main.js"></script>


<script>
    $(document).ready(function() {
        $('#show, #show2, #show3').hide();
        //show input text
        $('#hide').click(function() {
            $('#currentPassword').attr("type", "text");
            $(this).hide();
            $('#show').show();
        });
        $('#hide2').click(function() {
            $('#newPassword').attr("type", "text");
            $(this).hide();
            $('#show2').show();
        });
        $('#hide3').click(function() {
            $('#newPassword2').attr("type", "text");
            $(this).hide();
            $('#show3').show();
        });
        //hide input text
        $('#show').click(function() {
            $('#currentPassword').attr("type", "password");
            $(this).hide();
            $('#hide').show();
        });
        $('#show2').click(function() {
            $('#newPassword').attr("type", "password");
            $(this).hide();
            $('#hide2').show();
        });
        $('#show3').click(function() {
            $('#newPassword2').attr("type", "password");
            $(this).hide();
            $('#hide3').show();
        });

        //auto-hide alert messages
        $(".msg-alert").delay(5000).slideUp(300, function() {
            $(this).alert('close');
        });
    });

    //prevent form resubmission
    <?php if ($doNotResubmit): ?>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    <?php endif ?>

    //auto-preview selected image
    function doPreview(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.imgPreviewBox').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>
</body>

</html>