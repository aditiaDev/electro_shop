<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-md-6">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Data Customer Complaint</h4>

              <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                  <i class="ace-icon fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                  <i class="ace-icon fa fa-times"></i>
                </a>
              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main">
                <canvas id="myChart"></canvas>
              </div>
            </div>
          </div>
				</div>
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chart.js"></script>

<script>
  $(function () {
    var ctx = document.getElementById("myChart").getContext("2d");
    // examine example_data.json for expected response data
    var json_url = "example_data.json";

    // draw empty chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: "Customer Complaint This Year",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [],
                    spanGaps: false,
                }
            ]
        },
        options: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
        }
    });

    var json_url = "<?php echo site_url('usercomplaint/getDataGrafik') ?>";
    ajax_chart(myChart, json_url);

    // function to update our chart
    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.quantity; // or you can iterate for multiple datasets
            chart.update(); // finally update our chart
        });
    }
  });
</script>