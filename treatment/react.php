<?php include '../header.php'; ?>
<?php
	$currentreportingyear = date('Y');
	$lastreportingmonth = date("m") - 1;
	$lastreportingmonthname = date("F", mktime(null, null, null, $lastreportingmonth));
	$lastreportingperiodyear = '';
	if($lastreportingmonth == 0){
		$lastreportingperiodyear = $currentreportingyear - 1;
	}else{
		$lastreportingperiodyear = $currentreportingyear;
	}
	$lastreportingperiod = $lastreportingmonthname.$lastreportingperiodyear;
	$reportingtable = 'patient'.$indicator;
	$dataresults = $obj->countreportactiverecords($reportingtable,'month',$lastreportingperiod);
?>
<div class="treatmentbanner" id="indicatortotalbanner">
	<div class="contentwrap">
		<div class="treatmentbannercontentwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv">
						<div class="indicatortotal">
							<div class="titleintroduction">Sample Chart</div>
							<div class="contenttitle">
								Let's See
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'treatmentmenu.php'; ?>
<div class="maincontentsection">
	<div class="contentwrap">
		<div class="maincontentsectionwrap treatmentdatawrap" id="treatmentdatawrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv leftcontent" id="leftcolcontainer">
						<div class="leftcoltotalclients"></div>
						<div class="leftloading"><img src="theme/images/shimmerloading.gif" width="200px;"></div>
						<div class="leftdatacontainer" id="leftdatacontainer"></div>
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv mainbody">
						<div class="facilitycharts" id="facilitycharts">
							<div id="app"></div>
						</div>
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv rightcontent" id="rightcolcontainer">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../footer.php'; ?>

	<!-- <script type="text/javascript"></script> -->
    <script type="text/babel">
    	$.ajax({
	      type: "POST",
	      cache: false,
	      url: 'treatment/facilitieschart.php',
	      success: function(data){
	      	var arrayresult = $.parseJSON(data);
	          class ApexChart extends React.Component {
		        constructor(props) {
		          super(props);

		          this.state = {
		          
		            series: [{
		              name: arrayresult[0].selectedindicator,
		              data: arrayresult[0].facilityresults
		            }],
		            options: {
		              chart: {
		                type: 'bar'
		              },
		              plotOptions: {
		                bar: {
		                  borderRadius: 2,
		                  horizontal: true,
		                }
		              },
		              dataLabels: {
		                enabled: true,
		                style: {
			                fontSize: "8px",
			                fontWeight: "normal"
			              }
		              },
		              xaxis: {
		                categories: arrayresult[0].facilityname,
		                labels: {
				            style: {
				                fontSize: '9px'
				            }
				       }
		              },
		              yaxis: {
		                labels: {
				            style: {
				                fontSize: '8px'
				            }
				       }
		              },
		              colors: ["#DA251C"],
		              grid: {
					    show: true,
					    strokeDashArray: 0,
					    position: 'back',
					    xaxis: {
					        lines: {
					            show: true
					        }
					    },   
					    yaxis: {
					        lines: {
					            show: true
					        }
					    },  
					    row: {
					        colors: undefined,
					        opacity: 0.5
					    },  
					    column: {
					        colors: undefined,
					        opacity: 0.5
					    },  
					    padding: {
					        top: 0,
					        right: 0,
					        bottom: 0,
					        left: 0
					    },  
					 },
					 title: {
					    text: arrayresult[0].selectedindicator+" PER FACILITY",
					    align: 'left',
					    margin: 10,
					    offsetX: 0,
					    offsetY: 0,
					    floating: false,
					    style: {
					      fontSize:  '14px',
					      fontWeight:  'bold',
					      fontFamily:  undefined,
					      color:  '#263238'
					    },
					  }
		            },
		          
		          
		          };
		        }

		      

		        render() {
		          return (
		            <div>
		              <div id="chart">
		                <ReactApexChart options={this.state.options} series={this.state.series} type="bar" height={700} />
		              </div>
		              <div id="html-dist"></div>
		            </div>
		          );
		        }
		      }

		      const domContainer = document.querySelector('#app');
		      ReactDOM.render(React.createElement(ApexChart), domContainer);
	      },
	      error: function(xhr, status, error){
	          alert(xhr);
	      }
	  });

	  var options = {
          series: [{
          data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
            'United States', 'China', 'Germany'
          ],
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>