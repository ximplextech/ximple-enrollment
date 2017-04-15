<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\classschedule\models\ClassScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Class Schedules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Class Schedule'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
			var start_time = moment(event.start).format("DD-MM-YYYY, h:mm:ss a");
		    	var end_time = moment(event.end).format("DD-MM-YYYY, h:mm:ss a");

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
		'header' => "<h3>".Yii::t('dash', 'Add Schedule')."</h3>",
	]);

	yii\bootstrap\Modal::end();
?>
  