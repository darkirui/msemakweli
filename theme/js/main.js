//scroll and fix right and left columns
var elementPosition = $('#leftcolcontainer').offset();
var countscrollfixcontainer = $('#leftcolcontainer').length;
var rightelementPosition = $('#rightcolcontainer').offset();
var rightcountscrollfixcontainer = $('#rightcolcontainer').length;
var checkiftreatmentmenuexist = $('#treatmentmenusection').length;
var treatmentmenuposition = '';

if(checkiftreatmentmenuexist > 1){
  treatmentmenuposition = $('#treatmentmenusection').offset();
}

if(countscrollfixcontainer>0){
  var leftcolwidth = $("#leftcolcontainer").width();
}

if(rightcountscrollfixcontainer>0){
  var rightcolwidth = $("#rightcolcontainer").width();
}

var scrolldone = "";
$(window).scroll(function(){
      if(countscrollfixcontainer > 0){
          // var headerheight = $('.mobile-header').height();
          // var searchheight = $('.search-container').height();
          //alert(headerheight);
          if($(window).scrollTop() > elementPosition.top){
              $('#leftcolcontainer').addClass( "fixedcontent" );
              $('#leftcolcontainer').css( "width", leftcolwidth);
          } else {
              $('#leftcolcontainer').removeClass( "fixedcontent" );
          }  
      } 

      if(checkiftreatmentmenuexist > 0){
        if($(window).scrollTop() > elementPosition.top){
            $('#treatmentmenusection').addClass( "fixtreatmentmenu" );
            $('#leftcolcontainer').css( "width", leftcolwidth);
        } else {
            $('#treatmentmenusection').removeClass( "fixtreatmentmenu" );
        } 
      }

      if(rightcountscrollfixcontainer > 0){
          // var headerheight = $('.mobile-header').height();
          // var searchheight = $('.search-container').height();
          //alert(headerheight);
          if($(window).scrollTop() > rightelementPosition.top){
              $('#rightcolcontainer').addClass( "fixedcontent" );
              $('#rightcolcontainer').css( "width", rightcolwidth);
              $('.treatmentmenuwrap').css( "margin-top", "0px");
              $('.scrollseparator').css( "height", "120px");
          } else {
              $('#rightcolcontainer').removeClass( "fixedcontent" );
              $('.treatmentmenuwrap').css( "margin-top", "10px");
              $('.scrollseparator').css( "height", "0px");
          }  
      }  
});

$(document).on('click',".filterlink", function(e){
  e.preventDefault();
  var selectedindicator = $(this).data("id");
  var selectedelementid = $(this).attr('id');
  $('#'+ selectedelementid +' .loading').html('<div class="indicatorloader"></div>');
  $.ajax({
    type: "POST",
    url: 'treatment/filtertreatment.php',
    data: {indicator: selectedindicator},
    success: function(data){
      $('.treatmentmenuitem').removeClass("activelink");
      $('#tm'+selectedindicator).addClass( "activelink" );
      location.reload();
      //loadindicatortotal();
      // loadleftcol();
      // loadrightcol();
      //loadmainbody();
    },
    error: function(xhr, status, error){
        alert(xhr);
    }
  });
});

$(window).on('load', function() {
  var checkiftreatmentpage= $('#treatmentdatawrap').length;
  var checkifreportsummary = $('#reportssummarywrap').length;
  var checkifrightcolindicatorvalues = $('.rightcolindicatorvalues').length;
  var facilitycharts = $('#facilitycharts').length;
  if(checkiftreatmentpage > 0){
    loadindicatortotal();
    loadreportfeatures();
  }
  if(checkifreportsummary > 0){
    getselectedreport();
  }

  if(checkifrightcolindicatorvalues > 0){
    loadrightcolindicatorvalues();
  }

});

function getselectedreport(){
  $(".selectedreportreceivingcontainer").html('');
  $('.selectedreportloading').show();
  var reporttype = $('input[name="reporttype"]:checked').val();
  $.ajax({
    type: "POST",
    url: 'reports/'+reporttype+'report.php',
    data: {reporttype: reporttype},
    success: function(data){
      $(".selectedreportreceivingcontainer").html(data);
      $('.selectedreportloading').hide();
      //$(".leftloading").hide();
    },
    error: function(xhr, status, error){
        alert(xhr);
    }
  });
}

function loadleftcol(){
  $(".leftloading").show();
  $("#leftdatacontainer").html('');
  var selectedindicator = $('.activelink').data("id");
  alert(selectedindicator);
  $.ajax({
      type: "POST",
      url: 'treatment/leftcols/leftcoltxcurr.php',
      data: {indicator: selectedindicator},
      success: function(data){
        alert(data);
        $("#leftdatacontainer").html(data);
        $(".leftloading").hide();
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
    });
}

function loadrightcol(){
  var selectedindicator = $('.activelink').data("id");
  $.ajax({
      type: "POST",
      url: 'treatment/rightcols/rightcol'+selectedindicator+'.php',
      data: {indicator: selectedindicator},
      success: function(data){
        $("#rightcolcontainer").html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
    });
}

function loadmainbody(){
  $("#mainbodycontainer").html("");
  $(".mainbodyloading").show();
  var selectedindicator = $('.activelink').data("id");
  $.ajax({
    type: "POST",
    url: 'treatment/mainbody/main'+selectedindicator+'.php',
    data: {indicator: selectedindicator},
    success: function(data){
      $("#mainbodycontainer").html(data);
      loadchartsandgraphs();
    },
    error: function(xhr, status, error){
        alert(xhr);
    }
  });
}


function loadindicatortotal(){
  var selectedindicator = $('.activelink').data("id");
  $.ajax({
    type: "POST",
    url: 'treatment/indicatortotal.php',
    data: {indicator: selectedindicator,reportingperiod:'july2021'},
    success: function(data){
      var newclass = selectedindicator+'banner';
      $("#indicatortotal").html(data);
      $(".leftcoltotalclients").html(data);
      $('#indicatortotalbanner').removeClass();
      $('#indicatortotalbanner').addClass(newclass);
    },
    error: function(xhr, status, error){
        alert(xhr);
    }
  });
}

function loadchartsandgraphs(){
  var selectedindicator = $('.activelink').data("id");
  //alert(selectedindicator);
  var xaxisscale = 0;
  if(selectedindicator == 'txcurr'){
    var xaxisscale = 100;
  }
  else if(selectedindicator == 'deaths' || selectedindicator == 'tis'){
    var xaxisscale = 5;
  }
  else{
    var xaxisscale = 10;
  }
  var pyramidid = $('#pyramid').length;
  var containerwidth = $("#pyramid").width(); 
  $('#barchartfacilitydistribution').barChart({
    jsonUrl:'treatment/facilitydistribution.php',
    width: containerwidth,
    height: 700,
    marginTop: 5,
    marginRight: 30,
    marginBottom: 20,
    marginLeft: 90,
    barSpacing: 0.8,
    barWidthRate: 0.5,
    axisXScaleCount: xaxisscale,
    axisYPadding: 0,
    axisYPaddingEllipses:'…',
    autoFitAxisY:true,
    autoFitScaling: 1,
    toolTipFormat:'{%name%} - {%value%}',
    ajaxType:'GET',
    blankDataMessage:'No Data Available.'
  });

  $('#barchartdrugdistribution').barChart({
    jsonUrl:'treatment/drugdistribution.php',
    width: containerwidth,
    height: 400,
    marginTop: 5,
    marginRight: 30,
    marginBottom: 20,
    marginLeft: 70,
    barSpacing: 0.8,
    barWidthRate: 0.5,
    axisXScaleCount: 5,
    axisYPadding: 0,
    axisYPaddingEllipses:'…',
    autoFitAxisY:true,
    autoFitScaling: 1,
    toolTipFormat:'{%name%} - {%value%}',
    ajaxType:'GET',
    blankDataMessage:'No Data Available.'
  });

  $('#barchartmmddistribution').barChart({
    jsonUrl:'treatment/mmddistribution.php',
    width: containerwidth,
    height: 50,
    marginTop: 5,
    marginRight: 30,
    marginBottom: 20,
    marginLeft: 20,
    barSpacing: 0.8,
    barWidthRate: 0.5,
    axisXScaleCount: 5,
    axisYPadding: 0,
    axisYPaddingEllipses:'…',
    autoFitAxisY:true,
    autoFitScaling: 1,
    toolTipFormat:'{%name%} - {%value%}',
    ajaxType:'GET',
    blankDataMessage:'No Data Available.'
  });

    // //art trend
    // $('#linechararttrend').lineChart({
    //   jsonUrl: 'treatment/arttrend.php',
    //   width: containerwidth,
    //   height: 300,
    //   marginTop: 50,
    //   marginRight: 50, 
    //   marginButtom: 50,
    //   marginLeft: 50,
    //   axisYScaleCount: 2,
    //   toolTipFormat: '{%name%}: {%values.x%} - {%values.y%}',
    //   xAxisTimeFormat: '%Y/%m',
    //   legendWidthRate: 0.5,
    //   ajaxType: 'GET',
    //   blankDataMessage: 'No Data Available.'
    // });
  if(pyramidid>0){
    var reportingtbl = selectedindicator+'July2021';
    $.ajax({
        type: "POST",
        url: 'treatment/agegender.php',
        data: {indicator: selectedindicator},
        success: function(data){
            var result = jQuery.parseJSON(data);
            var convertdata = [];
            $.each( result, function( key, value ) {
                convertdata.push({ age: ''+value['age']+'', female: parseInt(value['female']), male: parseInt(value['male'])  });
             });

            var options = {
              height: 300,
              width: containerwidth,
              style: {
                leftBarColor: "#2F2F2F",
                rightBarColor: "#DA251C"
              }
            }
            pyramidBuilder(convertdata, '#pyramid', options);
        }
    });
  }
    $(".mainbodyloading").hide();
}


$(document).ready(function()
{

var settings = {
  url: "databases/upload.php",
  method: "POST",
  allowedTypes:"gz,zip,sql,tar.gz,tar",
  fileName: "myfile",
  multiple: true,
  onSuccess:function(files,data,xhr)
  {
    var databasename = '';
    $.each(JSON.parse(data), function(key, value) {
          databasename = key;
    });
    $.ajax({
      type: "POST",
      url: 'databases/restoredatabase.php',
      data: {databasename: databasename},
      success: function(data){
        $('.ajax-file-upload-statusbar').each(function(i, obj) {
            $content = $(this).html();
            $uploadeddb = data.slice(0,-4);
            if($content.indexOf($uploadeddb) != -1){
              $(this).find(".ajax-file-upload-green").html("Db Restored Successfully");
            }
        });
        // $('.restoringdb').hide();
        // $('.restoringsuccess').show();
        //         $('#containerselectorlbl').show();
        //         $('.imguploading').hide();
      },
      error: function(xhr, status, error){
        //alert(xhr);
        $('.restoringdb').hide();
        $('.restoringerror').show();
      }
    });
    $("#status").html("<font color='green'>Upload is success</font>");
    
  },
  onError: function(files,status,errMsg)
  {   
    $("#status").html("<font color='red'>Upload is Failed</font>");
  }
}
$("#mulitplefileuploader").uploadFile(settings);

});


//data refresh status 
// function randomQuote () {
//     $.ajax({
//       type: "POST",
//       url: 'reports/checkrefreshstatus.php',
//       success: function(data){
//         $('#currentrefreshdata').html(data);
//       },
//       error: function(xhr, status, error){
//           alert(xhr);
//       }
//     });
// }

// $(function () {
//     setInterval(randomQuote, 5000);
// });

var refeshststusrequest = showrefreshstatus();

function showrefreshstatus(){
    var refreshdatastatus = setInterval(function() {
    //var properID = CheckReload();
    var refreshstatus = '';
    $.ajax({
        type: "POST",
        url: 'reports/checkrefreshstatus.php',
        success: function(data){
          $('#currentrefreshdata').html(data);
          refreshstatus = data;
          $('.datarefreshstatus').html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i> <span id="currentrefreshdata">'+data+'</span>');
          if (data === 'All refresh completed') {
            clearInterval(refreshdatastatus);
            $('.datarefreshstatus').hide();
          }
          else{
            $('.datarefreshstatus').show();
          }
        },
        error: function(xhr, status, error){
            alert(xhr);
        }
    });

    if (refreshstatus === 'All refresh completed') {
      clearInterval(refreshdatastatus);
      $('.datarefreshstatus').hide();
    }
    else{
      $('.datarefreshstatus').show();
    }
  }, 5000);
}

$(document).on('click',".refreshdatabtn", function(e){
  var selectedelementid = $(this).attr('id');
  var groupidentifier = selectedelementid.replace('refreshdata','');
  var reportenddate = $('#enddate'+groupidentifier).val();
  var reportingspan = $('#reportspan'+groupidentifier).val();
  var reportingperiod = $('#reportingperiod'+groupidentifier).val();
  showrefreshstatus();
  $('.datarefreshstatus').show();
  $('.datarefreshstatus').html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i> <span id="currentrefreshdata">Refreshing of data started</span>');
  $.ajax({
      type: "POST",
      url: 'reports/refreshreport.php',
      data: {reportingtimespan: reportingspan,reportingperiod: reportingperiod,reportenddate: reportenddate},
      success: function(data){
          alert(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

$('input[type=radio][name=reporttype]').change(function() {
  updatedefaultreportspan();
  getselectedreport();
});

$(document).on('click',".selectreportdisplaytype", function(e){
  $(".selectedreportreceivingcontainer").html('');
  $('.selectedreportloading').show();
  var reporttype = $('input[name="reporttype"]:checked').val();
  var selectedelementid = $(this).attr('id');
  var displaytype = '';
  if(selectedelementid === 'selectdatatrends'){
    displaytype = 'trends';
      $.ajax({
    type: "POST",
    url: 'reports/report'+displaytype+'.php',
    data: {reporttype: reporttype},
    success: function(data){
      $(".selectedreportreceivingcontainer").html(data);
      $('.selectedreportloading').hide();
      if(selectedelementid === 'selectdatatrends'){
        gettrends(reporttype,'txcurr')
      }
      if(reporttype === 'week'){
        $('#spantitle').html('WEEKLY');
      }else if(reporttype === 'month'){
        $('#spantitle').html('MONTHLY');
      }
      else if(reporttype === 'quarter'){
        $('#spantitle').html('QUARTERLY');
      }
      else if(reporttype === 'year'){
        $('#spantitle').html('ANNUAL');
      }
      else{
        $('#spantitle').html('');
      }
    },
    error: function(xhr, status, error){
        alert(xhr);
    }
  });
  }
  else{
    getselectedreport();
  }
});

function loadarttrend(){
    $('#trendlinecontainer').lineChart({
      jsonUrl: 'reports/weekarttrend.php',
      "RedValue": "20.0",
      width: 800,
      marginTop: 50,
      marginRight: 50, 
      marginButtom: 50,
      marginLeft: 50,
      axisYScaleCount: 2,
      toolTipFormat: '{%name%}: {%values.x%} - {%values.y%}',
      xAxisTimeFormat: '%Y-%m-%d',
      legendWidthRate: 0.5,
      ajaxType: 'GET',
      blankDataMessage: 'No Data Available.'
    });
}

//select trend
$(document).on('click',".trendlink", function(e){
  var indicator = $(this).attr('id');
  var reporttype = $('input[name="reporttype"]:checked').val();
  gettrends(reporttype,indicator)
});

function gettrends(reporttype,indicator){
  alert(indicator);
  $('.trendloading').show();
  var selectedelementid = 'selectdatatrends';
  $('.selectedreportloading').hide();
  if(selectedelementid === 'selectdatatrends'){
    $('.trendlinecontainer').html('<div><canvas id="canvas"></canvas></div>');
    $.ajax({
      type: "POST",
      url: 'reports/trends'+reporttype+'.php',
      data: {indicator: indicator,reportingspan: reporttype},
      success: function(data){
       var arrayresult = $.parseJSON(data);
       var dataresults = arrayresult[0].data;
       var datadisplay = dataresults.join();
       var datatitle = '4 '+reporttype +'s '+indicator+' trend';
       var labeltitle = 'End of '+reporttype+' dates';
       //alert(arrayresult[0].labels);
            config = {
              type: 'line',
              data: {
                labels: arrayresult[0].days,
                datasets: [{
                  label: indicator,
                  backgroundColor: window.chartColors.red,
                  borderColor: window.chartColors.red,
                  data: arrayresult[0].data,
                  fill: false,
                }]
              },
              options: {
                maintainAspectRatio: false,
                responsive: true,
                title: {
                  display: true,
                  text: datatitle
                },
                tooltips: {
                  mode: 'index',
                  intersect: false,
                },
                hover: {
                  mode: 'nearest',
                  intersect: true
                },
                scales: {
                  xAxes: [{
                    display: true,
                    scaleLabel: {
                      display: true,
                      labelString: labeltitle
                    }
                  }],
                  yAxes: [{
                    //display: false,
                    //scaleLabel: {
                    //  display: false,
                    //  labelString: 'Value'
                    //}
                  }]
                }
              }
            };
            if($("#canvas").length){
                var ctx = document.getElementById('canvas').getContext('2d');
                window.myLine = new Chart(ctx, config);
                $('.trendloading').hide();
            }
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
    });
            //loadarttrend();
  }
}

function updatedefaultreportspan(){
  var reporttype = $('input[name="reporttype"]:checked').val();
  $.ajax({
      type: "POST",
      url: 'reports/defaulttimesspan.php',
      data: {reportingtimespan: reporttype},
      success: function(data){
          
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
}

function loadreportfeatures(){
  //females
  var displayfemales = $('#reportfemales').length;
  if(displayfemales>0){
    getreportfeature('females');
  }
  //males
  var displaymales= $('#reportmales').length;
  if(displaymales>0){
    getreportfeature('males');
  }
  //adults
  var displaymales= $('#reportadults').length;
  if(displaymales>0){
    getreportfeature('adults');
  }
  //paeds
  var displaymales= $('#reportpaeds').length;
  if(displaymales>0){
    getreportfeature('paeds');
  }
  //adolescents
  var displaymales= $('#reportadolescents').length;
  if(displaymales>0){
    getreportfeature('adolescents');
  }
  //valid vls
  var displaymales= $('#reportvalidvls').length;
  if(displaymales>0){
    getreportfeature('validvls');
  }
  //out dated vls
  var displaymales= $('#reportoutdatedvls').length;
  if(displaymales>0){
    getreportfeature('outdatedvls');
  }
  //unordered vls
  var displaymales= $('#reportunorderedvls').length;
  if(displaymales>0){
    getreportfeature('unorderedvls');
  }
  //suppressed
  var displaymales= $('#reportsuppressed').length;
  if(displaymales>0){
    getreportfeature('suppressed');
  }
  //unsuppressed
  var displaymales= $('#reportunsuppressed').length;
  if(displaymales>0){
    getreportfeature('unsuppressed');
  }
  //ovc
  var displaymales= $('#reportovc').length;
  if(displaymales>0){
    getreportfeature('ovc');
  }
}

function getreportfeature(reportitem){
  var selectedindicator = $('.activelink').data("id");
  var reportname = selectedindicator;
  $.ajax({
      type: "POST",
      url: 'reports/reportfeatures.php',
      data: {reportfeature:reportitem,reportname:reportname},
      success: function(data){
          $('#report'+reportitem).html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
}

function getreportrecords(indicator){
  $.ajax({
      type: "POST",
      url: 'reports/countreportrecords.php',
      data: {indicator:indicator},
      success: function(data){
          $('#rightcolindicatorvalues'+indicator).html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
}

function loadrightcolindicatorvalues(){
  $(".rightcolindicatorvalues").each(function() {
      var selectedelementid = $(this).attr('id');
      var indicator = selectedelementid.replace('rightcolindicatorvalues','');
      getreportrecords(indicator);
  });
}

//download button click
$(document).on('click',"#actiontxcurrdownload", function(e){
  var reportlevel = $('input[name="txcurrdownloadtype"]:checked').val();
  $.ajax({
      type: "POST",
      url: 'treatment/setdownloadparameters.php',
      data: {reportlevel:reportlevel},
      success: function(data){
         $('.linelistdownloadstatus').html('<div class="indicatorloader"></div>');
        window.open('treatment/exporttreatmentdata.php', '_blank').focus();
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

//download button click
$(document).on('click',"#actiondatimdownload", function(e){
  var indicator = $('input[class="datimdownload"]:checked').val();
  $('.linelistdownloadstatus').html('<div class="indicatorloader"></div>');
  if(indicator == 'txcurr'){
    window.open('treatment/datimtxcurrdata.php', '_blank').focus();
  }
  else if(indicator == 'txnew'){
    window.open('treatment/datimtxnewdata.php', '_blank').focus();
  }
  else if(indicator == 'txrtt'){
    window.open('treatment/datimtxrttdata.php', '_blank').focus();
  }
  else if(indicator == 'txml'){
    window.open('treatment/datimtxmldata.php', '_blank').focus();
  }
  else{
    alert("No datim data available for this component. You can utilize indicator line-list.");
  }
  $(".modal").modal('hide');
});

//filter
$(document).on('click',".filterlocation", function(e){
  var selectedelementid = $(this).attr('id');
  var selectedlocation = selectedelementid.replace('afilter','');
  $.ajax({
      type: "POST",
      url: 'filterlocations/filterlocation.php',
      data: {selectedlocation:selectedlocation},
      success: function(data){
        $("."+selectedlocation+"filtersection").html(data);
        $('.selectpicker').selectpicker({
          liveSearch: true
        });
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});


//save filter
$( "#actionfiltercounty").click(function(e) {
    e.preventDefault();
    if(($("input[name='county[]']").is(":checked"))){
      $('#countyfilterform').ajaxForm({
        beforeSubmit:function(e){
        },
        success:function(data){
          location.reload();
        },
        error:function(e){
        }
      }).submit();
    }
    else{
      $(".countyreportstatus").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Select at least one county');
    }
    
});
//select all counties
$(document).on('change',"#countyslectall", function(e){
  if($(this).is(":checked")){
    $('.countyselect').prop('checked', true);
  }else{
    $('.countyselect').prop('checked', false);
  }
});

$(document).on('change',".countyselect", function(e){
  if($('.countyselect:checked').length === $('.countyselect').length){
    $('#countyslectall').prop('checked', true);
  }
  else{
    $('#countyslectall').prop('checked', false);
  }
});


//REGIONS
//save filter
$( "#actionfilterregion").click(function(e) {
    e.preventDefault();
    if(($("input[name='region[]']").is(":checked"))){
      $('#regionfilterform').ajaxForm({
        beforeSubmit:function(e){
        },
        success:function(data){
          resetcountiesfilter();
          location.reload();
        },
        error:function(e){
        }
      }).submit();
    }
    else{
      $(".regionreportstatus").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Select at least one region');
    }  
});
//select all regions
$(document).on('change',"#regionslectall", function(e){
  if($(this).is(":checked")){
    $('.regionselect').prop('checked', true);
  }else{
    $('.regionselect').prop('checked', false);
  }
});

$(document).on('change',".regionselect", function(e){
  if($('.regionselect:checked').length === $('.regionselect').length){
    $('#regionslectall').prop('checked', true);
  }
  else{
    $('#regionslectall').prop('checked', false);
  }
});

//COUNTIES
//save filter
$( "#actionfiltercounty").click(function(e) {
    e.preventDefault();
    if(($("input[name='county[]']").is(":checked"))){
      $('#countyfilterform').ajaxForm({
        beforeSubmit:function(e){
        },
        success:function(data){
          resetsubcountiesfilter();
          location.reload();
        },
        error:function(e){
        }
      }).submit();
    }
    else{
      $(".countyreportstatus").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Select at least one county');
    }  
});
//select all countys
$(document).on('change',"#countyslectall", function(e){
  if($(this).is(":checked")){
    $('.countyselect').prop('checked', true);
  }else{
    $('.countyselect').prop('checked', false);
  }
});

$(document).on('change',".countyselect", function(e){
  if($('.countyselect:checked').length === $('.countyselect').length){
    $('#countyslectall').prop('checked', true);
  }
  else{
    $('#countyslectall').prop('checked', false);
  }
});

function resetcountiesfilter(){
  $.ajax({
      type: "POST",
      url: 'filterlocations/resetcountiesfilter.php',
      cache: false,
      dataType: 'jsonp',
      async: false,
      success: function(data){
      },
      error: function(xhr, status, error){
          //alert(xhr);
      }
  });
}

function resetsubcountiesfilter(){
  $.ajax({
      type: "POST",
      url: 'filterlocations/resetsubcountiesfilter.php',
      cache: false,
      async: false,
      success: function(data){
      },
      error: function(xhr, status, error){
          //alert(xhr);
      }
  });
}

//save reporting frequency
$( "#actionsavereportingfrequency").click(function(e) {
    e.preventDefault();
    $('#frmfilterreportingfrequency').ajaxForm({
      beforeSubmit:function(e){
      },
      success:function(data){
        location.reload();
      },
      error:function(e){
      }
    }).submit();
});


//load sign up basic details form
$(document).on('click',"#signupbasicdetails", function(e){
  $('#actionsavebasicdetails').show();
  $('#actionsavemoredetails').hide();
  // var selectedelementid = $(this).attr('id');
  // var selectedlocation = selectedelementid.replace('afilter','');
  $.ajax({
      type: "POST",
      url: 'users/basicdetails.php',
      success: function(data){
        $(".signupdetailssection").html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

$(document).on('click',"#actionsavebasicdetails", function(e){
  e.preventDefault();
  $('#frmuserbasicdetails').ajaxForm({
    beforeSubmit:function(e){
    },
    success:function(data){
        if(data === 'success'){
            $.ajax({
                type: "POST",
                url: 'users/moredetails.php',
                success: function(data){
                  $('#actionsavebasicdetails').hide();
                  $('#actionsavemoredetails').show();
                  $(".signupdetailssection").html(data);
                  $('.selectpicker').selectpicker({
                      liveSearch: true
                  });
                },
                error: function(xhr, status, error){
                    alert(xhr);
                }
            });
        }
        else{
          $('.usercreatestatus').html("User already existing. For any queries contact +254715547652.");
        }
    },
    error:function(e){
    }
  }).submit();
});

$(document).on('click',"#actionsavemoredetails", function(e){
  e.preventDefault();
  $('#frmusermoredetails').ajaxForm({
    beforeSubmit:function(e){
    },
    success:function(data){
      $('#actionsavebasicdetails').hide();
      $('#actionsavemoredetails').hide();
      $(".signupdetailssection").html("<div class='accountapprovalinfo'>Your account will be approved shortly. Once you have been approved, you will be able to do more with this system. In case of delayed response or any other feedback, please contact - +254715547652</div>");
    },
    error:function(e){
    }
  }).submit();
});

$(document).on('change',".selectoffice", function(e){
  var selectedoffice = $('input[name="office"]:checked').val();
  if(selectedoffice === 'central'){
    $('#grpfacility').hide();
    $('#grpregion').hide();
    $('#grpreasonforaccess').hide();
  }
  if(selectedoffice === 'region'){
    $('#grpfacility').hide();
    $('#grpregion').show();
    $('#grpreasonforaccess').hide();
  }
  if(selectedoffice === 'facility'){
    $('#grpfacility').show();
    $('#grpregion').hide();
    $('#grpreasonforaccess').hide();
  }
  if(selectedoffice === 'other'){
    $('#grpfacility').hide();
    $('#grpregion').hide();
    $('#grpreasonforaccess').show();
  }
});

$(document).on('click',"#actionloginuser", function(e){
  e.preventDefault();
  $('#frmuserlogin').ajaxForm({
    beforeSubmit:function(e){
    },
    success:function(data){
      if(data === "success"){
        location.reload();
      }
      else{

      }
    },
    error:function(e){
    }
  }).submit();
});

//load user privileges
$(document).on('click',".approveuser", function(e){
  var selectedelementid = $(this).attr('id');
  var selecteduser = selectedelementid.replace('approve','');
  $.ajax({
      type: "POST",
      url: 'users/approveuser.php',
      data: {userid:selecteduser},
      success: function(data){
        $(".userprivilegessection").html(data);
        $('.selectpicker').selectpicker({
          liveSearch: true
        });
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

//save user privileges
$(document).on('click',"#actionapproveuser", function(e){
  e.preventDefault();
  $('#frmuserprivileges').ajaxForm({
    beforeSubmit:function(e){
    },
    success:function(data){
      if(data === "success"){
        location.reload();
      }
      else{

      }
    },
    error:function(e){
    }
  }).submit();
});

$(document).on('click',".deleteuser", function(e){
  var selectedelementid = $(this).attr('id');
  var selecteduser = selectedelementid.replace('delete','');
  $("#deleteselecteduser").val(selecteduser);
});

$(document).on('click',"#actiondeleteuser", function(e){
  e.preventDefault();
  $('#frmdeleteuser').ajaxForm({
    beforeSubmit:function(e){
    },
    success:function(data){
      if(data === "success"){
        location.reload();
      }
      else{

      }
    },
    error:function(e){
    }
  }).submit();
});

$(document).on('click',".approveuser", function(e){
  var selectedelementid = $(this).attr('id');
  var selecteduser = selectedelementid.replace('approve','');
  $.ajax({
      type: "POST",
      url: 'users/approveuser.php',
      data: {userid:selecteduser},
      success: function(data){
        $(".userprivilegessection").html(data);
        $('.selectpicker').selectpicker({
          liveSearch: true
        });
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

$(document).on('click',"#actionlogout", function(e){
  $.ajax({
      type: "POST",
      url: 'users/userlogout.php',
      success: function(data){
        window.location.href = "";
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

//delete database dialog
//filter
$(document).on('click',".deletedb", function(e){
  var selectedelementid = $(this).attr('id');
  var selecteddb = selectedelementid.replace('delete','');
  $.ajax({
      type: "POST",
      url: 'databases/selectedeletedb.php',
      data: {databaseid:selecteddb},
      success: function(data){
        $(".dbdeletesection").html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

//delete database
$(document).on('click',"#actiondeletedatabase", function(e){
  e.preventDefault();
  $('#frmdeletedatabase').ajaxForm({
    beforeSubmit:function(e){
    },
    success:function(data){
      if(data === "success"){
        location.reload();
      }
      else{

      }
    },
    error:function(e){
    }
  }).submit();
});

$(document).on('click',".showdb", function(e){
  var selectedelementid = $(this).attr('id');
  var selecteddb = selectedelementid.replace('show','');
  $.ajax({
      type: "POST",
      url: 'databases/showselecteddb.php',
      data: {databaseid:selecteddb},
      success: function(data){
        $(".dbshowsection").html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});

//select database tables
$(document).on('change',"#selectdatabase", function(){
  var databasename = $('#selectdatabase option:selected').text();
  $.ajax({
      type: "POST",
      url: 'queries/selecttables.php',
      data: {databasename:databasename},
      success: function(data){
        $("#querytablelist").html(data);
      },
      error: function(xhr, status, error){
          alert(xhr);
      }
  });
});


//select table
$(document).on('change',".selectdatabasetable", function(e){
  if($(this).is(":checked")){
    var tablename = $(this).val();
    editor.doc.replaceSelection('select * from '+tablename);
  }else{
    //$('.countyselect').prop('checked', false);
  }
});

//download datim report
$(document).on('click',"#actioncoviddownload", function(e){
  window.open('treatment/coviddata.php', '_blank').focus();
  $(".modal").modal('hide');
});

