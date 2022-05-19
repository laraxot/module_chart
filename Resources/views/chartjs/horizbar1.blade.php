<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
  <canvas id="myChart"></canvas>
</div>

<script src="{{ Theme::asset('adm_theme::dist/js/manifest.js') }}"></script>
<script src="{{ Theme::asset('adm_theme::dist/js/vendor.js') }}"></script>
<script src="{{ Theme::asset('adm_theme::dist/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/*
https://www.npmjs.com/package/chartjs-to-image
*/
/*
var myChart = new Chart(document.getElementById('chart').getContext('2d'), {
  type: 'horizontalBar',
  data: {
    labels: ['One', 'Two', 'Three', 'Four', 'Five', 'Six'],
    datasets: [{
      label: 'My data',
      data: [12, 19, 3, 5, 2, 3],
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgba(255,99,132,1)',
      borderWidth: 1
    }]
  },
  options: {
    animation: {
      onComplete: function() {
        console.log(myChart.toBase64Image());
      }
    }
  }
});
//*/

var labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];
  var mydata=[0, 10, 5, 2, 20, 30, 45];

  var filename='prova123';

  const data = {
    labels: labels,
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: mydata,
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
        animation: {
            onComplete: function() {
                axios.post('/chart/image/store', {filename:filename,content:myChart.toBase64Image()})
                    .then(res => {
                        console.log(res)
                    })
                    .catch(err => {
                        console.log(err)
                    });
            }
        }
    }
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

</script>

