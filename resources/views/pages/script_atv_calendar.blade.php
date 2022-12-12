<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

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


    select: function(info) {
      url = 'atividade/horas?inicio='+info.startStr+'&fim='+info.endStr;
      window.location.href = url; 
    },
    navLinkDayClick: function(date, jsEvent) {
      url = 'atividade/horas?dataunica='+date.toISOString();
      window.location.href = url; 
      // console.log('day', date.toISOString());
      // console.log('coords', jsEvent.pageX, jsEvent.pageY);
    }



  });

  var eventSource = calendar.getEventSourceById('a');
  //eventSource.remove();
  calendar.setOption('locale', 'pt-br');
  calendar.render();
});

</script>