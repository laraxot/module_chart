<div class="container">
    <div id="{{ $graph_id }}" url="{{ $url }}" class="row">
    </div>
</div>
@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        class Graph {
            constructor(id) {
                this.id=id;
                //this.ctx = document.getElementById(id).getContext('2d');
                this.ctx=[];
                this.url = document.getElementById(id).getAttribute('url');
                this.load();
            }

            fetchData = async function() {
                const response = await fetch(this.url);
                const data = await response.json();
                return data;
            }

            load = function() {
                this.fetchData().then(config => {
                    var colsize=12/config.length;
                    for (var i = 0; i < config.length; i++) {
                        var canvas_id=this.id+'-'+i;
                        var canvas = $('<div class="col-'+colsize+'"><canvas width="200" height="200" id="'+canvas_id+'"   /></div>');
                        $('#'+this.id).append(canvas);
                        //console.log(i);
                        //var context=canvas.getContext("2d"); 
                        //new Chart(canvas, config);
                        this.ctx[i] = document.getElementById(canvas_id).getContext('2d');
                        console.log(this.ctx[i]);
                        //new Chart(canvas, config[i]);
                        new Chart(this.ctx[i], config[i]);
                    }
                    //const myChart = new Chart(this.ctx, config);
                });
            }

        }
    </script>
@endpushonce

@push('scripts')
    <script>
        new Graph('{{ $graph_id }}');
    </script>
@endpush

@push('styles')
<style>
    .div {
  display: inline-block;
}

.canvas {
  display: inline-block;
}

#canvas {
  display: inline-block;
}

#canvas1 {
  display: inline-block;
}

.cv {
  display: inline-block;
}

</style>
@endpush
