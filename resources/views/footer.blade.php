        </div>
<footer>
    <div class="container-fluid">
        <div class="row">
           <div class="footer">
              <div class="footer-content">
                 <p class="footer-content_para">
                   "EventVeci is a Laravel Vue.js based Event Application"
               </p>
               <div class="footer-content_contact">
                   <p class="footer-content_contact-para">Get In Contact</p>
                   <ul>
                    <li><a href="https://github.com/codesultan369" target="_blank"><i class="fab fa-github"></i></a></li>
                    <li><a href="https://www.linkedin.com/#/" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="mailto:codesultan369@gmail.com"><i class="far fa-paper-plane"></i></a>></li>
                   </ul>
               </div>
              </div>
          </div>
    </div>
    </div>
</footer>

             <script src="{{ asset('js/app.js') }}" defer></script>
                             <script src="{{asset('js/iziToast.min.js')}}" type="text/javascript"></script>

    <script>
    @if(Session::has('success'))
        iziToast.success({
        message:"{{Session::get('success')}}"
    });
    @endif
    </script>


            </body>
</html>
