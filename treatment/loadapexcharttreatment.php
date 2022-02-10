<?php include '../header.php'; ?>
<div id="app"></div>
<?php include '../footer.php'; ?>


	<!-- <script type="text/javascript"></script> -->
    <script type="text/babel">
    	$.ajax({
	      type: "POST",
	      url: 'treatment/facilitieschart.php',
	      success: function(data){
	      	var arrayresult = $.parseJSON(data);
	          class ApexChart extends React.Component {
		        constructor(props) {
		          super(props);

		          this.state = {
		          
		            series: [{
		              name: arrayresult[0].indicatorname,
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
					    text: "PER FACILITY",
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

		      const domContainer = document.getElementById("app");
		      ReactDOM.render(React.createElement(ApexChart), domContainer);
	      },
	      error: function(xhr, status, error){
	          alert(xhr);
	      }
	  });
</script>