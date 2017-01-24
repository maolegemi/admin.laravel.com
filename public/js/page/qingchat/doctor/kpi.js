define(['chartjs', 'datatables'], function(chart, datatables) {
    return {
        init: function() {
                makeLine();
                kpiObj = {
                    table: '',
                    searchInit: function() {

                    },
                    tableInit: function() {
                        {
                            this.table = $('#qingchat-doctor-kpi-table').DataTable({
                                info: false,
                                responsive: true,
                                serverSide: true,
                                processing: true,
                                bSort: true,
                                searchable: false,
                                searching: false,
                                ordering: false,
                                order: [],
                                paging: false,
                                pageLength: 20,
                                bLengthChange: false,
                                ajax: {
                                    url: "",
                                    data: function(d) {
                                        d.Stat_Time = $('#qingchat-doctor-kpi-form input[name="Stat_Time"]').val();
                                    }
                                },
                                columns: [{
                                    "data": "Stat_Time",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Doctor_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_NewDoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_DoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Online_ChatNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_ChatNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "Online_AnswerNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "TowHourAnswerNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "First_AnswerDoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "TwoWeek_AnswerDoctorNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "ChangeToFans_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "ChatToApp_Num",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_AppNum",
                                    "sClass": "text-center"
                                }, {
                                    "data": "LeiJi_ToFansNum",
                                    "sClass": "text-center"
                                }],
                                "fnDrawCallback": function(obj) {
                                    doctorObj.data = obj.json.data;
                                    data = obj.json.data;
                                },
                            });
                        } //
                    }
                }; //end kpiObj
                kpiObj.searchInit();
                kpiObj.tableInit();

            } //end init
    } //end return

    function makeLine() {
        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);

        var areaChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: "Electronics",
                fillColor: "rgba(210, 214, 222, 1)",
                strokeColor: "rgba(210, 214, 222, 1)",
                pointColor: "rgba(210, 214, 222, 1)",
                pointStrokeColor: "#c1c7d1",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40]
            }, {
                label: "Digital Goods",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: [28, 48, 40, 19, 86, 27, 90]
            }]
        };

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: true,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions);

    }

    function makeTable() {

    }
});
