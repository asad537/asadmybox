@include('frontend/header')
  



    
       <section class="page-title-area breadcrumb-spacing cp-bg-14">
       
       
        </section>
    
<section class="cp-contact-area pt-20 pb-20">

       <div class="container" style="width: 900px;">
    <div class="row" style="align-items:center;">
      <div class="col-md-4">
        <div class="">
          <div class=""><img alt="thankyou" style="width:250px;" src="{{url('thankyou.jpeg')}}" /></div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="">
          <div class="">
      <h1 style="color: #86C442 !important;font-size: 24px;">Thanks for contacting us. Our sales representative will contact you soon!</h1>
      <p style="margin-top: 15px; font-size: 16px;">Redirecting to home page in <span id="countdown">10</span> seconds...</p>
          </div>
       
        </div>
      </div>
    </div>
  </div>
        </section>
 
 


 

@include('frontend/footer')

<script>
    let countdown = 10;
    const countdownElement = document.getElementById('countdown');
    
    const timer = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;
        
        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = '{{ url("/") }}';
        }
    }, 1000);
</script>

