<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @import 'https://fonts.googleapis.com/css?family=Montserrat';
    </style>
    <script src="http://www.gstatic.com/charts/loader.js"></script>
    <script>

        function init() {
            google.load("visualization", "44", {
            packages: ["corechart","scatter"]
            });
            {
            var interval = setInterval(function () {
                if (google.visualization !== undefined && google.visualization.DataTable !== undefined
                && google.visualization.ColumnChart !== undefined) {
                clearInterval(interval);
                drawChart();
                window.status = 'ready';
                }
            }, 100);
            }
        }


      function drawChart() {
            @if(count($locations)>0)
                var data = google.visualization.arrayToDataTable([
                    ['Borne', '1','2','3','4','5'],
                    @foreach($locations as $location)
                        ["{{$location['borne']->title}} ({{$location['total']}} rép)", 

                            @foreach($location['details'] as $key => $det)
                                {{$det}},
                            @endforeach
                            {{$location['indice']}}
                        ],
                    @endforeach
                    
                    ]);
                    var view = new google.visualization.DataView(data);
                    view.setColumns([0,
                        1, {
                        calc: function (dt, row) {
                        if (dt.getValue(row, 1)){
                                return dt.getValue(row, 1).toString()+'%';
                            }
                        },
                        type: "string",
                        role: "annotation"
                        },
                        2, {
                        calc: function (dt, row) {
                        if (dt.getValue(row, 2)){
                                return dt.getValue(row, 2).toString()+'%';
                            }
                        },
                        type: "string",
                        role: "annotation"
                        },
                        3, {
                        calc: function (dt, row) {
                        if (dt.getValue(row, 3)){
                                return dt.getValue(row, 3).toString()+'%';
                            }
                        },
                        type: "string",
                        role: "annotation"
                        },
                        4, {
                        calc: function (dt, row) {
                            if (dt.getValue(row, 4)){
                                    return dt.getValue(row, 4).toString()+'%';
                            }
                        },
                        type: "string",
                        role: "annotation"
                        },
                        5, {
                        calc: function (dt, row) {
                            if (dt.getValue(row, 5)){
                                    return dt.getValue(row, 5).toString()+'%';
                            }
                        },
                        type: "string",
                        role: "annotation"
                        },
                        {
                        calc: function (dt, row) {
                            //return '0';
                        },
                        label: "Total",
                        type: "string",
                        role: "annotation"
                        },
                        // series 1
                        
                        
                    ]);
                    
                        var options = {title: '',
                                        chartArea: {
                                            width: '70%'
                                        },
                                        legend:{position:'none'},
                                        isStacked:'percent',
                                        selectionMode: 'multiple',
                                        annotations: {
                                            textStyle: {
                                                fontSize: 18,
                                                auraColor: 'none',
                                                color: '#111'
                                            }
                                        },
                                        pointSize: 15,
                                        series: {
                                            0:{color:'#66d237',targetAxisIndex:0},
                                            1:{color:'#a8d89c',targetAxisIndex:0},
                                            2:{color:'#f19088',targetAxisIndex:0},
                                            3:{color:'#ed4637',targetAxisIndex:0},
                                            4:{type: 'scatter', color:'#2583e3',pointShape: 'circle',targetAxisIndex:1,
                                            annotations: {
                                                alwaysOutside: 'true',
                                                stem: {
                                                    color: "transparent",
                                                    length: -20
                                                },
                                                textStyle: {
                                                    color: "#000000",
                                                }
                                            },
                                            enableInteractivity: false,
                                            tooltip: "none",
                                            axisTitlesPosition:'in',
                                            visibleInLegend: false }
                                            
                                        }};  
                                        
                var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
                chart.draw(view, options);
            @endif
            
            var data = google.visualization.arrayToDataTable([
                ['horaires', '1', '2','3','4','5'],
                @if(count($horaires)>0)

                @foreach($horaires as $key => $horaire)
                    ["{{$key}}" , {{$horaire[4]}},{{$horaire[3]}},{{$horaire[2]}},{{$horaire[1]}}, {{$horaire[5]}}],
                @endforeach
                @else
                    ["08:00" , 0,0,0,0,50],
                    ["09:00" , 0,0,0,0,50],
                    ["10:00" , 0,0,0,0,50],
                    ["11:00" , 0,0,0,0,50],
                    ["12:00" , 0,0,0,0,50],
                    ["13:00" , 0,0,0,0,50],
                    ["14:00" , 0,0,0,0,50],
                    ["15:00" , 0,0,0,0,50],
                    ["16:00" , 0,0,0,0,50],
                    ["#7:00" , 0,0,0,0,50],
                @endif
        ]);

  // Create and draw the visualization.
    var view = new google.visualization.DataView(data);

    view.setColumns([0,
                1, {
                calc: function (dt, row) {
                if (dt.getValue(row, 1)!=0){
                        return dt.getValue(row, 1);
                    }
                },
                type: "number",
                role: "annotation"
                },
                2, {
                calc: function (dt, row) {
                if (dt.getValue(row, 2)!=0){
                        return dt.getValue(row, 2);
                    }
                },
                type: "number",
                role: "annotation"
                },
                3, {
                calc: function (dt, row) {
                if (dt.getValue(row, 3)!=0){
                            return dt.getValue(row, 3);
                    }
                },
                type: "number",
                role: "annotation"
                },
                4, {
                calc: function (dt, row) {
                    if (dt.getValue(row, 4)!=0){
                            return dt.getValue(row, 4);
                    }
                },
                type: "number",
                role: "annotation"
                },
                5, {
                calc: function (dt, row) {
                    if (dt.getValue(row, 5)!=0){
                            /*return dt.getValue(row, 5);*/
                    }
                },
                type: "number",
                role: "annotation"
                },
                {
                calc: function (dt, row) {
                    return 0;
                },
                label: "Total",
                type: "number",
                },
                // series 1
                {
                calc: function (dt, row) {
                    return dt.getValue(row, 1) + dt.getValue(row, 2) + dt.getValue(row, 3) + dt.getValue(row, 4);
                },
                type: "number",
                role: "annotation"
                }
        ]);
    new google.visualization.ColumnChart(document.getElementById('chart')).
      draw(view,
           {title:"",
            height:500,
            chartArea: {
                width: '90%'
            },
            
            curveType: 'function',
            vAxes: [{
                title: "resps",
                minValue: 0
            }, {
                title: "INDICE",
                minValue: 0,
                textStyle: {color: '#2583e3'},
                titleTextStyle: {
                        color: '#01579b',
                        fontSize: 16,
                        fontName: 'Arial',
                        bold: false,
                        italic: true
                    }
            }],
            selectionMode: 'multiple',
            isStacked: true,
          
            hAxis: {title: "repartition horaire",minValue: 0},
            legend:{position:'none'},
            
            annotations: {
                textStyle: {
                    fontSize: 26,
                    auraColor: 'none',
                    color: '#2583e3'
                }
            },
            pointSize: 10,
            series: {
                0:{color:'#ed4637',targetAxisIndex:0 },
                1:{color:'#f19088',targetAxisIndex:0 },
                2:{color:'#a8d89c',targetAxisIndex:0 },
                3:{color:'#66d237',targetAxisIndex:0 },
                5: {

                annotations: {
                    stem: {
                        color: "transparent",
                    },
                    
                    textStyle: {
                        color: "#111",
                    }
                },
                enableInteractivity: false,
                tooltip: "none",
                visibleInLegend: false
                },
                4:{type: 'line', color:'#2583e3',pointShape: 'circle',targetAxisIndex:1 }
            }  
            
            
            }
      );
      @if($type=='week')
          var data = google.visualization.arrayToDataTable([
          ['jours', '1', '2','3','4','5'],
          @if(count($jours)>0)
            
          @foreach($jours as $key => $jour)

              ["{{$key}}" , {{$jour[4]}},{{$jour[3]}},{{$jour[2]}},{{$jour[1]}},{{$jour[5]}}],
          @endforeach
          @else
              ["08:00" , 0,0,0,0,50],
              ["09:00" , 0,0,0,0,50],
              ["10:00" , 0,0,0,0,50],
              ["11:00" , 0,0,0,0,50],
              ["12:00" , 0,0,0,0,50],
              ["13:00" , 0,0,0,0,50],
              ["14:00" , 0,0,0,0,50],
             
          @endif
          ]);

  
          // Create and draw the visualization.
              var view = new google.visualization.DataView(data);
              view.setColumns([0,
                          1, {
                          calc: function (dt, row) {
                          if (dt.getValue(row, 1)!=0){
                                  return dt.getValue(row, 1).toString()+'%';
                              }
                          },
                          type: "string",
                          role: "annotation"
                          },
                          2, {
                          calc: function (dt, row) {
                          if (dt.getValue(row, 2)!=0){
                                  return dt.getValue(row, 2).toString()+'%';
                              }
                          },
                          type: "string",
                          role: "annotation"
                          },
                          3, {
                          calc: function (dt, row) {
                          if (dt.getValue(row, 3)!=0){
                                      return dt.getValue(row, 3).toString()+'%';
                              }
                          },
                          type: "string",
                          role: "annotation"
                          },
                          4, {
                          calc: function (dt, row) {
                              if (dt.getValue(row, 4)!=0){
                                      return dt.getValue(row, 4).toString()+'%';
                              }
                          },
                          type: "string",
                          role: "annotation"
                          },
                          5, {
                          calc: function (dt, row) {
                              if (dt.getValue(row, 5)!=0){
                                      return dt.getValue(row, 5);
                              }
                          },
                          type: "number",
                          role: "annotation"
                          },
                          /*
                          {
                          calc: function (dt, row) {
                              return 0;
                          },
                          label: "Total",
                          type: "string",
                          },
                          // series 1
                          {
                          calc: function (dt, row) {
                              //return dt.getValue(row, 1) + dt.getValue(row, 2) + dt.getValue(row, 3) + dt.getValue(row, 4);
                          },
                          type: "string",
                          role: "annotation"
                          }
                          */
                  ]);
              new google.visualization.ColumnChart(document.getElementById('chart-hebdo')).
              draw(view,
                  {title:"",
                      height:500,
                      chartArea: {
                          width: '90%'
                      },
                      
                      curveType: 'function',
                      vAxes: [{
                          title: "resps",
                          minValue: 0,
                      }, {
                          title: "INDICE",
                          minValue: 0,
                          textStyle: {color: '#2583e3'},
                          titleTextStyle: {
                                    color: '#01579b',
                                    fontSize: 16,
                                    fontName: 'Arial',
                                    bold: false,
                                    italic: true
                                }
                      }],
                      
                      selectionMode: 'multiple',
                      isStacked: true,
                    
                      hAxis: {title: "",minValue: 0},
                      legend:{position:'none'},
                      
                      annotations: {
                          textStyle: {
                              fontSize: 26,
                              auraColor: 'none',
                              color: '#2583e3'
                          }
                      },
                      pointSize: 10,
                      series: {
                          0:{color:'#ed4637',targetAxisIndex:0 },
                          1:{color:'#f19088',targetAxisIndex:0 },
                          2:{color:'#a8d89c',targetAxisIndex:0 },
                          3:{color:'#66d237',targetAxisIndex:0 },
                          4:{type: 'line', color:'#2583e3',pointShape: 'circle',targetAxisIndex:1 }
                      }  
                      
                      
                      }
              );
  
        @endif
    
    
    
    
    
        @if($type=='week')
            var data = google.visualization.arrayToDataTable([
            ['jours', '1', '2','3','4','5'],
            @if(count($wks)>0)
                
            @foreach($wks as $key => $week)

                ["{{$key}}" , {{$week[4]}},{{$week[3]}},{{$week[2]}},{{$week[1]}},{{$week[5]}}],
            @endforeach
            @else
                ["08:00" , 0,0,0,0,50],
                ["09:00" , 0,0,0,0,50],
                ["10:00" , 0,0,0,0,50],
                ["11:00" , 0,0,0,0,50],
                ["12:00" , 0,0,0,0,50],
                ["13:00" , 0,0,0,0,50],
                ["14:00" , 0,0,0,0,50],
                
            @endif
            ]);

    
            // Create and draw the visualization.
                var view = new google.visualization.DataView(data);
                view.setColumns([0,
                            1, {
                            calc: function (dt, row) {
                            if (dt.getValue(row, 1)!=0){
                                    return dt.getValue(row, 1).toString()+'%';
                                }
                            },
                            type: "string",
                            role: "annotation"
                            },
                            2, {
                            calc: function (dt, row) {
                            if (dt.getValue(row, 2)!=0){
                                    return dt.getValue(row, 2).toString()+'%';
                                }
                            },
                            type: "string",
                            role: "annotation"
                            },
                            3, {
                            calc: function (dt, row) {
                            if (dt.getValue(row, 3)!=0){
                                        return dt.getValue(row, 3).toString()+'%';
                                }
                            },
                            type: "string",
                            role: "annotation"
                            },
                            4, {
                            calc: function (dt, row) {
                                if (dt.getValue(row, 4)!=0){
                                        return dt.getValue(row, 4).toString()+'%';
                                }
                            },
                            type: "string",
                            role: "annotation"
                            },
                            5, {
                            calc: function (dt, row) {
                                if (dt.getValue(row, 5)!=0){
                                        return dt.getValue(row, 5);
                                }
                            },
                            type: "number",
                            role: "annotation"
                            },
                            /*
                            {
                            calc: function (dt, row) {
                                return 0;
                            },
                            label: "Total",
                            type: "string",
                            },
                            // series 1
                            {
                            calc: function (dt, row) {
                                //return dt.getValue(row, 1) + dt.getValue(row, 2) + dt.getValue(row, 3) + dt.getValue(row, 4);
                            },
                            type: "string",
                            role: "annotation"
                            }
                            */
                    ]);
                new google.visualization.ColumnChart(document.getElementById('chart-predweek')).
                draw(view,
                    {title:"",
                        height:500,
                        chartArea: {
                            width: '90%'
                        },
                        
                        curveType: 'function',
                        vAxes: [{
                            title: "resps",
                            minValue: 0
                        }, {
                          title: "INDICE",
                          minValue: 0,
                          textStyle: {color: '#2583e3'},
                          titleTextStyle: {
                                    color: '#01579b',
                                    fontSize: 16,
                                    fontName: 'Arial',
                                    bold: false,
                                    italic: true
                                }
                      }],
                        selectionMode: 'multiple',
                        isStacked: true,
                        vAxis: {title: "",minValue: 0},
                        hAxis: {title: "",minValue: 0},
                        legend:{position:'none'},
                        
                        annotations: {
                            textStyle: {
                                fontSize: 26,
                                auraColor: 'none',
                                color: '#2583e3'
                            }
                        },
                        pointSize: 10,
                        series: {
                            0:{color:'#ed4637',targetAxisIndex:0 },
                            1:{color:'#f19088',targetAxisIndex:0 },
                            2:{color:'#a8d89c',targetAxisIndex:0 },
                            3:{color:'#66d237',targetAxisIndex:0 },
                            4:{type: 'line', color:'#2583e3',pointShape: 'circle',targetAxisIndex:1 }
                        }  
                        
                        
                        }
                );
    
            @endif
          
        }


    </script>
</head>
<style>
    body{
        font-family : 'Montserrat';
        margin: 0;
        padding: 0;
    }
    th, td , h3,h4{

       margin: 0;
    }
    .header{
        background : #e2e2e2;
        border-bottom : solid 1px #000;
    }
    .header-line{
        display: flex;
        justify-content: space-between;
        background: pink;
    }
    .header-bottom{
        color: #717172;
        font-size: 14px;
    }
</style>
<body onload="init()">
        
    <table width="100%">
        <tr >
            <td class="header">
                <table width="100%">
                    <tr>
                        <td width="50%">
                            @if($type=='day')
                            <h3>Rapport quotidien</h3>
                            @endif
                            @if($type=='week')
                            <h3>Rapport hebdomadaire</h3>
                            @endif
                        </td>
                        <td width="50%">
                            <h3 style="text-align: right">Rapport consolidé</h3>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="padding-top:14px;">
                            <h3 class="header-bottom">
                                @if($type=='day')
                                {{ strftime( " %A %d/%m/%Y", strtotime($start)) }}
                                @endif
                                @if($type=='week')
                                {{ strftime( "%d/%m/%Y", strtotime($start)) }} - {{ strftime( "%d/%m/%Y", strtotime($end)) }}
                                @endif
                            </h3>
                        </td>
                        <td width="50%" style="padding-top:14px;">
                            <h3 class="header-bottom" style="text-align: right">{{$company->title}} ({{$compagne->SelectedBornes->count()}}) {{$compagne->SelectedBornes->count()>1 ? 'Unités':'Unité'}}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="body">
            <td>
                <tr>
                    <td>{{ $compagne->question}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td>
                                    <img src="{{base_path()}}/public/img/1.png"/>
                                </td>
                                <td>
                                    @if($grouped->count()>0&&isset($grouped['1']))
                                    <p>{{intval($grouped['1']->count()/$data->count()*100)}}%</p>
                                    <p style="white-space: nowrap">{{$grouped['1']->count()}} rép.</p>
                                    @else
                                    <p>0%</p>
                                    <p>0 rép</p>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{base_path()}}/public/img/2.png"/>
                                </td>
                                <td>
                                    @if($grouped->count()>0&&isset($grouped['2']))
                                    <p>{{intval($grouped['2']->count()/$data->count()*100)}}%</p>
                                    <p style="white-space: nowrap">{{$grouped['2']->count()}} rép.</p>
                                    @else
                                    <p>0%</p>
                                    <p>0 rép</p>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{base_path()}}/public/img/3.png"/>
                                </td>
                                <td>
                                    @if($grouped->count()>0&&isset($grouped['3']))
                                    <p>{{intval($grouped['3']->count()/$data->count()*100)}}%</p>
                                    <p style="white-space: nowrap">{{$grouped['3']->count()}} rép.</p>
                                    @else
                                    <p>0%</p>
                                    <p>0 rép</p>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{base_path()}}/public/img/4.png"/>
                                </td>
                                <td>
                                    @if($grouped->count()>0&&isset($grouped['4']))
                                    <p>{{intval($grouped['4']->count()/$data->count()*100)}}%</p>
                                    <p style="white-space: nowrap">{{$grouped['4']->count()}} rép.</p>
                                    @else
                                    <p>0%</p>
                                    <p>0 rép</p>
                                    @endif
                                </td>
                                <td width="40%">
                                    <table width="100%">
                                        <tr>
                                            <td width="100%"><h4 style="text-align: right">
                                            @if($data->count()>0)
                                                Indice : {{round(((((isset($grouped['1'])?$grouped['1']->count() : 0) + (isset($grouped['2'])? $grouped['2']->count()*0.5 : 0) + (isset($grouped['3'])?$grouped['3']->count()*-0.5 : 0) - (isset($grouped['4'])?$grouped['4']->count():0))/$data->count())/2)*100+50,1)}}
                                            @else
                                                Indice : 0
                                            @endif
                                            </h4></td>
                                        </tr>
                                        <tr>
                                            <td width="100%"><h4 style="text-align: right">Réponses : {{$data->count()}}</h4></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin:10px auto">
                    <tr>
                    <td style="background:#111;color:#fff;text-align:center;padding:5px"><b><h3>Comparaison</h3></b></td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <div id="barchart_values" style="width: 1000px; height: 400px;"></div>
                            </center>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="background-color:#f9f9f9;">
                    <tr>
                        <td style="background:#111;color:#fff;text-align:center;padding:5px"><b><h3>Toutes les unités combinées - diffusion horaire</h3></b></td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                            <div id="chart"></div>
                            </center>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @if($type=='week')
            <tr>
                <td>
                    <table width="100%" style="background-color:#f9f9f9;">
                        <tr>
                            <td style="background:#111;color:#fff;text-align:center;padding:5px"><b><h3>Toutes les unités combinées - diffusion jours de semaine</h3></b></td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <div id="chart-hebdo"></div>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" style="background-color:#f9f9f9;">
                        <tr>
                            <td style="background:#111;color:#fff;text-align:center;padding:5px"><b><h3> Même question, comparaison avec les semaines précédentes</h3></b></td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <div id="chart-predweek"></div>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif
        <tr class="footer">
           
        </tr>

    </table>
    
</body>
</html>
