<script>
  if( document.readyState !== 'loading' ) {
        myInitCode();
} else {
    document.addEventListener('DOMContentLoaded', function () {
        myInitCode();
    });
}




function myInitCode(){
  var data_inicial = new Date();
  if($('#data_voltar_calend').val()){
    data_inicial = $('#data_voltar_calend').val();
  }

    var calendarEl = document.getElementById('fullCalendar');     
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        center: '',
        left: 'title',   
        right: 'prevYear,prev,next,nextYear today'
      },
      buttonText: {
          today: "Hoje"
      },
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      selectable: true,
      weekends: false,
      height: "auto",

      initialDate: data_inicial,
      events: [
        {
            title: 'Titulo',
            start: '2021-03-03',
              end: '2021-03-04',
              url: '', 
            color: '#257e4a'
          }
          

     ],
    


    });

    var eventSource = calendar.getEventSourceById('a');
    calendar.setOption('locale', 'pt-br');
    calendar.render();
  }

  setTimeout(function(){ 
  }, 500); 


</script>