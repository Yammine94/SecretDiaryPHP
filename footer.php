
    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
      
      <script type="text/javascript">
      
        $(".toggleForms").click(function() {
            
            $('#logInForm').toggle();
            $('#error').hide();
            $('#signUpForm').toggle();
            $('#error').hide();
            
        });
          
          $('#diary').bind('input propertychange', function() {

                $.ajax({
                  method: "POST",
                  url: "http://yammine94webdev-com.stackstaging.com/8.9.php/updatedatabase.php",
                  data: { content: $("#diary").val() }
                });

        });
      
      
      </script>
      
  </body>
</html>


