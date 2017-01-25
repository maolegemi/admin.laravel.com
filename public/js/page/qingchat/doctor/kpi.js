define(['chartjs', 'datatables', 'css!../../../../css/qingchat/doctor/kpi.css'], function(chart, datatables, css) {
    return {
        init: function() {
                kpiObj = {
                    table: '',
                    searchInit: function() {
                        setDateRange($("input[name='Stat_Time']"));
                    },
                    search: function() {
                        //kpiObj[table].draw();
                        if (this.table) {
                            this.table.draw();
                        }
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
                                    //kpiObj.data = obj.json.data;
                                    data = obj.json.data;
                                    //指标变换
                                    pointSelect($("div.pointBox"), data);
                                },
                            });
                        } //
                    }
                }; //end kpiObj
                kpiObj.searchInit();
                kpiObj.tableInit();

            } //end init
    } //end return
    //
    function setDateRange(obj) {
        obj.daterangepicker({
            opens: 'center', //日期选择框的弹出位置
            buttonClasses: ['btn btn-info'],
            applyClass: 'btn-small btn-primary blue',
            cancelClass: 'btn-small',
            locale: {
                format: "YYYY-MM-DD",
                separator: " ~ ",
                applyLabel: "确定",
                cancelLabel: "取消",
                fromLabel: "开始",
                toLabel: "结束",
                customRangeLabel: "自定义",
                weekLabel: "W",
                daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
                monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月 "],
                firstDay: 1
            }
        });
    }
    //
    function pointSelect(obj, data) {
        //console.log(data);
        var btn = $(obj).find('button');
        var box = btn.parent().find('div.contentBox');
        var input = box.find('input[type="checkbox"]');
        var state = 2;
        btn.click(function(event) {
            var _box = $(this).parent().find('div.contentBox');
            var status = _box.css('display');
            if (status == 'block') {
                state = state == 2 ? 2 : 1;
                _box.hide();
            } else {
                state = state == 1 ? 1 : 2;
                _box.show();
            }
            //  阻止事件冒泡
            event.stopPropagation();
        });
        //鼠标进入区域
        box.mouseenter(function() {
            state = 1;
        });
        //鼠标离开区域
        box.mouseleave(function() {
            state = 2;
        });
        $(document).bind("click", function() {
            if (state == 2) {
                box.hide();
            }
        });
        //初始化可视化线性图
        var line = $("#areaChart").get(0).getContext("2d");
        var labels = [];
        var datasets = [];
        $.each(input, function(k, v) {
            var key = $(v).val();
            var _label = $(v).parent().parent().parent().find('label').text();
            var _pointColor = "rgba("+(10*k)+", "+(15*k)+", "+(20*k)+", 1)";
            var _strokeColor = "rgba("+(10*k)+", "+(15*k)+", "+(20*k)+", 1)";;
            datasets[key] = {
                label: _label,
                pointColor: _pointColor,
                strokeColor: _strokeColor,
                data: [],
            };
            console.log(datasets[key]);
        });
        $.each(data,function(k,v){
            labels.push(v['Stat_Time']);
            $.each(v,function(kk,vv){
              if(datasets[kk]){
               datasets[kk].data.push(vv);
              }
            });
        });
        //console.log(datasets['Doctor_Num']);
        var clean = {
            labels: labels,
            datasets: [datasets['Doctor_Num'],datasets['Online_AnswerNum']]
        };
        makeLine(line, clean);
        //选中事件
        input.on('ifChecked', function(event) {
            var key = $(this).val();
            console.log(key);
        });
        //撤销选中事件
        input.on('ifUnchecked', function(event) {


        });
    }
    //
    function makeLine(areaChartCanvas, areaChartData) {
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);
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
            datasetFill: false,
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
