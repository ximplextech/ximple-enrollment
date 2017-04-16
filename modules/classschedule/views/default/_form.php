<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\classschedule\models\ClassSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="class-schedule-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'school_year_id')->dropDownList(ArrayHelper::map(app\modules\schoolyear\models\Schoolyear::findAll(['is_status' => 0]), 'school_year_id', 'school_year_alias')); ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'semester_id')->dropDownList(ArrayHelper::map(\app\modules\semester\models\Semester::findAll(['is_status' => 0]), 'semester_id', 'semester_name')); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'professor_id')->dropDownList(ArrayHelper::map(app\modules\employee\models\EmpInfo::find()->all(), 'emp_info_id', 'EmpFullName'), ['prompt' => Yii::t('app', 'Select Professor')]); ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'subject_id')->dropDownList(ArrayHelper::map(app\modules\subjects\models\Subjects::find()->all(), 'subject_id', 'subject_name'), ['prompt' => Yii::t('app', 'Select Subject')]); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'section_id')->dropDownList(ArrayHelper::map(\app\modules\course\models\Section::find()->all(), 'section_id', 'section_name'), ['prompt' => Yii::t('app', 'Select Section')]); ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'room_id')->dropDownList(ArrayHelper::map(app\modules\room\models\Room::find()->all(), 'room_id', 'room_name'), ['prompt' => Yii::t('app', 'Select Room')]); ?>

                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'class_intake_limit')->textInput() ?>

                </div>
            </div>

            <div class="row" id="eventModal" style="display: none">


            </div>

        </div>
        <div class="col-md-6" style="margin-top: -120px;">
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
                $updateEvent = Yii::t('dash', 'Update Event');
                $JSEventClick = <<<EOF
	function(calEvent, jsEvent, view) {
	    var eventId = calEvent.id;
		$.ajax({
		   url: "{$UEurl}",
		   data: { event_id : eventId, return_dashboard : 1 },
		   type: "GET",
		   success: function(data) {
			   //$(".modal-body").addClass("row");
			   //$(".modal-header").html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3> {$updateEvent} </h3>');
			   $('#eventModal').html('<div class="col-md-12">' + data + '</div>');
			   $('#eventModal').show();
		   }
	   	});
		$(this).css('border-color', 'red');
	}
EOF;
                $eDetail = Yii::t('app', 'Event Detail');
                $eType = Yii::t('app', 'Event Type');
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
                                'eventLimitText' => 'more Events',
                                'selectHelper' => true,
                                'header' => [
                                    'left' => '',
                                    'center' => '',
                                    'right' => ''
                                ],
                                'select' => new \yii\web\JsExpression($JSEvent),
                                'eventClick' => new \yii\web\JsExpression($JSEventClick),
                                'eventRender' => new \yii\web\JsExpression($JsF),
                                'aspectRatio' => 1,
                                'timeFormat' => 'hh(:mm) A',
                                'minTime' => "07:00:00",
                                'maxTime' => "21:00:00",
                                'allDaySlot' => false,
                                'columnFormat' => 'ddd'
                            ],
                            'ajaxEvents' => Url::toRoute(['/classschedule/schedule/view-events'])
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
    /**
     * Hidden inputs
     */
    if ($model->isNewRecord) {

        echo $form->field($model, 'created_by')->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 2])->label(false);
        echo $form->field($model, 'updated_by')->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 2])->label(false);
    } else {

        echo $form->field($model, 'updated_by')->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 2])->label(false);
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//yii\bootstrap\Modal::begin([
//    'id' => 'eventModal',
//    'header' => "<h3>" . Yii::t('dash', 'Add Class Schedule') . "</h3>",
//]);
//
//yii\bootstrap\Modal::end();
?>
<script>
    $(document).ready(function () {

        /**
         * Hide the calendar on load to disable adding schedule without filling up 
         * the required fields.
         */
        $("#w1").css({"visibility": "hidden"});
        /**
         * Check if all the required fields are filled and show the calendar
         */
        var empty_flds = 0;
        $('.form-control').on("change", function () {
            empty_flds = 0;
            $('.form-control').each(function () {
                if ($(this).parent().hasClass("required") && $(this).val() == "") {
                    empty_flds++;
                }
            });
            if (empty_flds == 0) {
                $("#w1").css({"visibility": "visible"});
            } else {
                $("#w1").css({"visibility": "hidden"});
            }
        });
        /**
         * If Prof is selected, load all the prof schedule
         */
        $("#classschedule-professor_id").data('pre', $(this).val());
        $("#classschedule-professor_id").on("change", function () {
            var previous = $(this).data('pre');//get the pre data
            if (empty_flds == 0 && previous != "") {

                var message = "<?php echo Yii::t('app', 'Unsaved changes might be lost. Do you still want to continue?'); ?>"
                bootbox.confirm(message, function (confirmed) {
                    if (confirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= Url::to(["schedule/load-event"]) ?>',
                            data: {
                                professor_id: $("#classschedule-professor_id option:selected").val(),
                                school_year_id: $("#classschedule-school_year_id option:selected").val(),
                                semester_id: $("#classschedule-semester_id option:selected").val(),
                                room_id: $("#classschedule-room_id option:selected").val()
                            },
                            success: function (data) {
                                //console.log("okok2");
                                if (data == 1) {
                                    $("#w1").fullCalendar('removeEvents');
                                    $("#w1").fullCalendar('rerenderEvents');
                                    $("#w1").fullCalendar('refetchEvents');
                                } else {
                                    $("#w1").fullCalendar('removeEvents');
                                    $("#w1").fullCalendar('rerenderEvents');
                                    $("#w1").fullCalendar('refetchEvents');
                                }
                            }
                        });
                    } else {
                        $("#classschedule-professor_id").val(previous);
                    }
                });
            }


        });
        /**
         * 
         */
        $("#classschedule-room_id").data('pre', $(this).val());

        $("#classschedule-room_id").on("change", function () {

            var previous_room = $(this).data('pre');//get the pre data
            //console.log(previous_room);
            console.log("before 1st if => " + $(this).data('pre'));
            if (empty_flds == 0 && previous_room != "") {

                var message = "<?php echo Yii::t('app', 'Unsaved changes might be lost. Do you still want to continue?'); ?>"
                bootbox.confirm(message, function (confirmed) {
                    if (confirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= Url::to(["schedule/load-event"]) ?>',
                            data: {
                                professor_id: $("#classschedule-professor_id option:selected").val(),
                                school_year_id: $("#classschedule-school_year_id option:selected").val(),
                                semester_id: $("#classschedule-semester_id option:selected").val(),
                                room_id: $("#classschedule-room_id option:selected").val()
                            },
                            success: function (data) {

                                if (data == 1) {
                                    $("#w1").fullCalendar('removeEvents');
                                    $("#w1").fullCalendar('rerenderEvents');
                                    $("#w1").fullCalendar('refetchEvents');
                                } else {
                                    $("#w1").fullCalendar('removeEvents');
                                    $("#w1").fullCalendar('rerenderEvents');
                                    $("#w1").fullCalendar('refetchEvents');
                                }
                            }
                        });
                        $(this).data('pre', $(this).val());//update the pre data
                        console.log("confirmed => " + $(this).data('pre'));
                        return;
                    } else {
                        $("#classschedule-room_id").val(previous_room);
                        //console.log($(this).val() + " +> " + previous_room);
                        $(this).data('pre', previous_room);//update the pre data
                        console.log(previous_room + " canceled => " + $(this).data('pre'));
                        return;
                    }
                });
            } else {
                $(this).data('pre', $(this).val());//update the pre data
                console.log("end => " + $(this).data('pre'));
            }




        });
    });

</script>

