<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\classschedule\models\ClassScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Class Schedules');
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/print/jspdf.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/print/html2canvas.min.js"></script>
<div class="class-schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Class Schedule'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $form = ActiveForm::begin([
                'id' => 'schedule-form',
                'enableAjaxValidation' => true,
                'fieldConfig' => [
                    'template' => "{label}{input}{error}",
                ],
    ]);
    ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'school_year_id')->dropDownList(ArrayHelper::map(app\modules\schoolyear\models\Schoolyear::findAll(['is_status' => 0]), 'school_year_id', 'school_year_alias')); ?>

        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'semester_id')->dropDownList(ArrayHelper::map(\app\modules\semester\models\Semester::findAll(['is_status' => 0]), 'semester_id', 'semester_name')); ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'professor_id')->dropDownList(ArrayHelper::map(app\modules\employee\models\EmpInfo::find()->all(), 'emp_info_id', 'EmpFullName'), ['prompt' => Yii::t('app', 'Select Professor')]); ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'room_id')->dropDownList(ArrayHelper::map(app\modules\room\models\Room::find()->all(), 'room_id', 'room_name'), ['prompt' => Yii::t('app', 'Select Room')]); ?>

        </div>
        <div class="col-md-2">
            <span id="AE_btn_pdf" class="cal-button btn btn-primary" style="margin-top: 25px;"><input type="hidden" id = "zz_pdf" value = "" /> <?= Yii::t('app', 'Export as Pdf') ?> </span>
            

        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="col-md-12">
        <div class="box-body">
            <?php
            $AEurl = Url::to(["schedule/add-event"]);
            $UEurl = Url::to(["schedule/update-event"]);
            $AddEvent = Yii::t('dash', 'Add Class Schedule');
            $JSEvent = <<<EOF
	function(start, end, allDay) {
		var start = moment(start).unix();
	   	var end = moment(end).unix();
		$.ajax({
		   url: "{$AEurl}",
		   data: { start_date : start, end_date : end, return_dashboard : 1 },
		   type: "GET",
		   success: function(data) {
//			   $(".modal-body").addClass("row");
//			   $(".modal-header").html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>{$AddEvent}</h3>');
//			   $('.modal-body').html(data);
//			   $('#eventModal').modal();
                           $('#eventModal').html('<div class="col-md-12">' + data + '</div>');
			   $('#eventModal').show();
		   }
	   	});
			}
EOF;
            $updateEvent = Yii::t('dash', 'Update Schedule');
            $JSEventClick = <<<EOF
	function(calEvent, jsEvent, view) {
                       
	    var eventId = calEvent.id;
                        console.log(eventId);
		$.ajax({
		   url: "{$UEurl}",
		   data: { event_id : eventId, return_dashboard : 1 },
		   type: "GET",
		   success: function(data) {
			   $(".modal-body").addClass("row");
			   $(".modal-header").html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3> {$updateEvent} </h3>');
			   //$('#eventModal').html(data);
                           $('.modal-body').html(data);
			   $('#eventModal').modal();
                           console.log('okok');
		   }
	   	});
		$(this).css('border-color', 'red');
	}
EOF;
            $eDetail = Yii::t('app', 'Schedule Detail');
            $eType = Yii::t('app', 'Schedule Type');
            $eStart = Yii::t('app', 'Start Time');
            $eEnd = Yii::t('app', 'End Time');
            $JsF = <<<EOF
		function (event, element) {
			var start_time = moment(event.start).format("h:mm:ss a");
		    	var end_time = moment(event.end).format("h:mm:ss a");

			element.popover({
		            title: event.title,
		            placement: 'top',
		            html: true,
			    global_close: true,
			    container: 'body',
			    trigger: 'hover',
			    delay: {"show": 500},
		            content: "<table class='table'><tr><th> {$eDetail} : </th><td>" + event.description + " </td></tr><tr><th> {$eType} : </th><td>" + event.event_type + "</td></tr><tr><th> {$eStart} : </t><td>" + start_time + "</td></tr><tr><th> {$eEnd} : </th><td>" + end_time + "</td></tr></table>"
        		});
               }
EOF;
            ?>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <?=
                    \yii2fullcalendar\yii2fullcalendar::widget([
                        //'options' => ['language' => 'en'],
                        'clientOptions' => [
                            'defaultView' => 'agendaWeek',
                            'fixedWeekCount' => false,
                            'weekNumbers' => false,
                            'editable' => true,
                            'selectable' => true,
                            'eventLimit' => true,
                            'eventLimitText' => 'more Schedules',
                            'selectHelper' => true,
                            'header' => [
                                'left' => '',
                                'center' => '',
                                'right' => ''
                            ],
                            'select' => new \yii\web\JsExpression($JSEvent),
                            'eventClick' => new \yii\web\JsExpression($JSEventClick),
                            'eventRender' => new \yii\web\JsExpression($JsF),
                            'aspectRatio' => 1.6,
                            'timeFormat' => 'hh(:mm) A',
                            'minTime' => "07:00:00",
                            'maxTime' => "21:00:00",
                            'allDaySlot' => false,
                            'columnFormat' => 'ddd'
                        ],
                        'ajaxEvents' => Url::toRoute(['/classschedule/default/view-events'])
                    ]);
                    ?>
                </div>
            </div> <!-- /.End ROW -->
            <div class="row">
                <!--                    <div class="col-sm-12 col-xs-12">
                                        <ul class="legend">
                                            <li><span class="holiday"></span> <?php echo Yii::t('dash', 'Holiday') ?></li>
                                            <li><span class="importantnotice"></span> <?php echo Yii::t('dash', 'Important Notice') ?></li>
                                            <li><span class="meeting"></span> <?php echo Yii::t('dash', 'Meeting') ?></li>
                                            <li><span class="messages"></span> <?php echo Yii::t('dash', 'Messages') ?></li>
                                        </ul>
                                    </div>-->
            </div>

        </div><!-- /.box-body -->
    </div>

</div>
<?php
yii\bootstrap\Modal::begin([
    'id' => 'eventModal',
    //'header' => "<div class='row'><div class='col-xs-6'><h3>Add Schedule</h3></div><div class='col-xs-6'>".Html::a('Delete', ['#'], ['class' => 'btn btn-danger pull-right', 'style' => 'margin-top:5px'])."</div></div>",
    'header' => "<h3>" . Yii::t('dash', 'Add Schedule') . "</h3>",
]);

yii\bootstrap\Modal::end();
?>
<script>
    $(document).ready(function () {
        /**
         * If Prof is selected, load all the prof schedule
         */

        $("#classschedulesearch-professor_id").on("change", function () {

            $.ajax({
                type: 'POST',
                url: '<?= Url::toRoute(['default/view-events']) ?>',
                data: {
                    professor_id: $("#classschedulesearch-professor_id option:selected").val(),
                    school_year_id: $("#classschedulesearch-school_year_id option:selected").val(),
                    semester_id: $("#classschedulesearch-semester_id option:selected").val(),
                    room_id: $("#classschedulesearch-room_id option:selected").val()
                },
                success: function (data) {
                    $("#w0").fullCalendar('removeEvents');
                    $('#w0').fullCalendar('addEventSource', data);

                }
            });



        });
        /**
         * 
         */

        $("#classschedulesearch-room_id").on("change", function () {

            $.ajax({
                type: 'POST',
                url: '<?= Url::toRoute(['default/view-events']) ?>',
                data: {
                    professor_id: $("#classschedulesearch-professor_id option:selected").val(),
                    school_year_id: $("#classschedulesearch-school_year_id option:selected").val(),
                    semester_id: $("#classschedulesearch-semester_id option:selected").val(),
                    room_id: $("#classschedulesearch-room_id option:selected").val()
                },
                success: function (data) {
                    $("#w0").fullCalendar('removeEvents');
                    $('#w0').fullCalendar('addEventSource', data);

                }
            });

        });
        
        $("#AE_btn_pdf").click(function () {
        
            //#AEFC is my div for FullCalendar
            html2canvas($('#w0'), {
                background:'#fff',
                logging: true,
                useCORS: true,
                onrendered: function (canvas) {
                    var imgData = canvas.toDataURL("image/jpeg");
                    var doc = new jsPDF();
                    doc.addImage(imgData, 'JPEG', 15, 40, 180, 160);
                    download(doc.output(), "Schedule.pdf", "text/pdf");

                }
            });
        });

    });
    
    function download(strData, strFileName, strMimeType) {
        var D = document,
                A = arguments,
                a = D.createElement("a"),
                d = A[0],
                n = A[1],
                t = A[2] || "text/plain";

        //build download link:
        a.href = "data:" + strMimeType + "," + escape(strData);

        if (window.MSBlobBuilder) {
            var bb = new MSBlobBuilder();
            bb.append(strData);
            return navigator.msSaveBlob(bb, strFileName);
        } /* end if(window.MSBlobBuilder) */

        if ('download' in a) {
            a.setAttribute("download", n);
            a.innerHTML = "downloading...";
            D.body.appendChild(a);
            setTimeout(function () {
                var e = D.createEvent("MouseEvents");
                e.initMouseEvent("click", true, false, window, 0, 0, 0, 0, 0, false, false,
                        false, false, 0, null);
                a.dispatchEvent(e);
                D.body.removeChild(a);
            }, 66);
            return true;
        } /* end if('download' in a) */

        //do iframe dataURL download:
        var f = D.createElement("iframe");
        D.body.appendChild(f);
        f.src = "data:" + (A[2] ? A[2] : "application/octet-stream") + (window.btoa ? ";base64"
                : "") + "," + (window.btoa ? window.btoa : escape)(strData);
        setTimeout(function () {
            D.body.removeChild(f);
        }, 333);
        return true;
    } /* end download() */
</script>