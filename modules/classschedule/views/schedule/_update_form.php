<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;
use kartik\widgets\SwitchInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Schedules */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) {
    //echo ($_REQUEST['start_date']);
    //die(Yii::$app->dateformatter->getDTFormat($_REQUEST['start_date']));
    $model->start_date = Yii::$app->dateformatter->getDFormat($_REQUEST['start_date']);
    $model->end_date = Yii::$app->dateformatter->getDFormat($_REQUEST['start_date']);
    $model->start_time = Yii::$app->dateformatter->getTFormat($_REQUEST['start_date']);
    $model->end_time = Yii::$app->dateformatter->getETFormat($_REQUEST['start_date']);
}
if (isset($_REQUEST['event_id'])) {
    echo '<div class="visible-xs-4 col-sm-3 col-lg-3 pull-right">';
    if (isset($_GET['return_dashboard'])) {
        echo Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('dash', 'Remove'), ['schedule/event-delete', 'e_id' => $_REQUEST['event_id'], 'return_dashboard' => 1], ['class' => 'btn btn-danger btn-block', 'title' => Yii::t('dash', 'Remove/Delete Schedule'), 'data' => ['confirm' => Yii::t('dash', 'Are you sure you want to delete this item?'), 'method' => 'post'],]);
    } else {
        echo Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('dash', 'Remove'), ['schedule/event-delete', 'e_id' => $_REQUEST['event_id']], ['class' => 'btn btn-danger btn-block', 'title' => Yii::t('dash', 'Remove/Delete Schedule'), 'data' => ['confirm' => Yii::t('dash', 'Are you sure you want to delete this item?'), 'method' => 'post'],]);
    }
    echo '</div>';
    //die($model->start_time);
    $model->start_time = date("h:i:s a", strtotime($model->start_time)); //Yii::$app->dateformatter->getTFormat($model->start_time);
    $model->end_time = date("h:i:s a", strtotime($model->end_time)); //Yii::$app->dateformatter->getTFormat($model->end_time);
}
?>
<div class="col-xs-12 col-lg-12">
    <div class="events-form">

        <?php
        $form = ActiveForm::begin([
                    'id' => 'schedule-form',
                    'enableAjaxValidation' => true,
                    'fieldConfig' => [
                        'template' => "{label}{input}{error}",
                    ],
        ]);
        ?>
        <?= $form->errorSummary($model); ?>
        <div class="alert alert-success" style="display: none">
            <button type="button" class="close" data-hide="alert">&times;</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <span id="message"></span>
        </div>
        <div class="alert alert-danger" style="display: none">
            <button type="button" class="close" data-hide="alert">&times;</button>
            <h4><i class="icon fa fa-remove"></i>Error!</h4>
            <span id="error-message"></span>
        </div>
        <?php //echo $form->field($model, 'title')->hiddenInput()->label(false) ?>
        <?php //echo $form->field($model, 'details')->hiddenInput()->label(false) ?>
        <?php echo $form->field($model, 'subject_id')->hiddenInput()->label(false) ?>
        <?php echo $form->field($model, 'school_year_id')->hiddenInput()->label(false) ?>
        <?php echo $form->field($model, 'semester_id')->hiddenInput()->label(false) ?>
        <?php echo $form->field($model, 'professor_id')->hiddenInput()->label(false) ?>
        <?php echo $form->field($model, 'room_id')->hiddenInput()->label(false) ?>
        <?php echo $form->field($model, 'section_id')->hiddenInput()->label(false) ?>
        <div class="col-xs-6 col-sm-6 col-lg-6">
            <?=
            $form->field($model, 'start_time')->widget(TimePicker::classname(), [
                //'type' => TimePicker::TYPE_INPUT,
                'options' => ['placeholder' => '', 'readOnly' => true],
                'pluginOptions' => [
                    'autoclose' => true,
                    'maxView' => 0,
                    'startView' => 0,
                    'format' => 'hh:ii:ss',
                ],
            ]);
            ?>
        </div>
        <div class="col-xs-6 col-sm-6 col-lg-6">
            <?=
            $form->field($model, 'end_time')->widget(TimePicker::classname(), [
                //'type' => TimePicker::TYPE_INPUT,
                'options' => ['placeholder' => '', 'readOnly' => true],
                'pluginOptions' => [
                    'autoclose' => true,
                    'maxView' => 0,
                    'startView' => 0,
                    'format' => 'hh:ii:ss',
                ],
            ]);
            ?>
        </div>

        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'sun')->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],]);
            ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'mon', ['enableAjaxValidation' => true, 'validateOnChange' => false])->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],
            ]);
            ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'tue')->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],
            ]);
            ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'wed')->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],
            ]);
            ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'thu')->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],
            ]);
            ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'fri')->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],
            ]);
            ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-lg-2" style="width: 65px">
            <?=
            $form->field($model, 'sat')->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'mini'],
                'labelOptions' => ['style' => 'font-size: 12px'],
            ]);
            ?>
        </div>
        <div class="col-xs-12"></div>

        <div class="form-group col-xs-12 col-sm-12 col-lg-12 no-padding edusecArLangCss">
            <div class="col-xs-6">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('dash', 'Create') : Yii::t('dash', 'Update'), ['class' => $model->isNewRecord  ? 'btn btn-success btn-block' : 'btn btn-info btn-block']) ?> 
	</div>
            <!--            <div class="col-xs-6">
            <?php
            echo Html::a(Yii::t('dash', 'Cancel'), ['index'], ['class' => 'btn btn-default btn-block', 'data-dismiss' => "modal"]);
            ?>
                        </div>-->
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<script>
//    $(document).ready(function () {
//        $("#save").on("click", function () {
//            //console.log("ajaxStop in");
//            $("#classscheduletemporary-subject_id").val($("#classschedule-subject_id option:selected").val());
//            $("#classscheduletemporary-school_year_id").val($("#classschedule-school_year_id option:selected").val());
//            $("#classscheduletemporary-semester_id").val($("#classschedule-semester_id option:selected").val());
//            $("#classscheduletemporary-room_id").val($("#classschedule-room_id option:selected").val());
//            $("#classscheduletemporary-professor_id").val($("#classschedule-professor_id option:selected").val());
//            $("#classscheduletemporary-section_id").val($("#classschedule-section_id option:selected").val());
//
//
//
//            //$("#classscheduletemporary-details").val("Prof. " + $("#classschedule-professor_id option:selected").text());
//
//            $.ajax({
//                type: 'POST',
//                url: '<?= Url::to(["schedule/save-events"]) ?>',
//                data: $('#schedule-form').serialize(),
//                success: function (data) {
//                    if (data == 1) {
//                        $("#message").html("<?= Yii::t('app', 'Class schedule successfully added. You can add another for this subject.'); ?>")
//                        $(".alert-success").show();
//                        //$("#w1").fullCalendar('removeSchedules');
//                        $("#w1").fullCalendar('rerenderSchedules');
//                        $("#w1").fullCalendar('refetchSchedules');
//                    } else {
//                        $("#error-message").html("<?= Yii::t('app', 'Failed saving the class schedule. There might be conflicts on the added schedule.'); ?>");
//                        $(".alert-danger").show();
//
//                    }
//                }
//            });
//        });
//
//        $("[data-hide]").on("click", function () {
//            $(this).closest("." + $(this).attr("data-hide")).hide();
//        });
//    });
//
//    $(document).ajaxStop(function () {
//        console.log("ajaxStop out");
//
//    });
</script>