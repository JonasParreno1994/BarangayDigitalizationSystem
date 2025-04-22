<footer id="footer" class="footer accent-background">

    

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Team MISO</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="">OneByte Software</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


<!-- Vendor JS Files -->
<script src="{{ asset('/Impact/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('/Impact/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{asset ('/Impact/assets/js/main.js') }}"></script>
  <script src="{{asset ('/Impact/sweetalert2@11.js') }}"></script>
  <script>
  function showSweetAlert() {
    Swal.fire({
      icon: 'info',
      title: 'Please Login',
      text: 'You need to log in to access this feature.',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ route('login') }}";
      }
    });
  }
  </script>
  
</body>

</html>