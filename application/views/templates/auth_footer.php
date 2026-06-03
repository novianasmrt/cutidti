<body style="margin: 0; padding: 0;">
    <footer style="background-color: #143557; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; left: 0; width: 100vw;">
        <p style="margin: 0;">DTI Universitas Gadjah Mada <span id="year"></span></p>
    </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>

</html>