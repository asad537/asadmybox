function loadScript(url) {
    let isLoaded = document.querySelectorAll('.dynamic-script');
    if (isLoaded.length > 0)
    {
        console.log("not loading the script");
        return;
    }
    let myScript = document.createElement('script');
    myScript.src = url;
    myScript.className = 'dynamic-script';
    document.body.appendChild(myScript);
    console.log("load the script");
   }
   var searchInput = document.getElementById('search_input_two');

   searchInput.addEventListener('focus', function(e){
    loadScript('https://www.google.com/recaptcha/api.js');
   });
