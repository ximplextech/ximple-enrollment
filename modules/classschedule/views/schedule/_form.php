<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;
use kartik\widgets\SwitchInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Events */
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
        echo Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('dash', 'Remove'), ['events/event-delete', 'e_id' => $_REQUEST['event_id'], 'return_dashboard' => 1], ['class' => 'btn btn-danger btn-block', 'title' => Yii::t('dash', 'Remove/Delete Event'), 'data' => ['confirm' => Yii::t('dash', 'Are you sure you want to delete this item?'), 'method' => 'post'],]);
    } else {
        echo Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('dash', 'Remove'), ['events/event-delete', 'e_id' => $_REQUEST['event_id']], ['class' => 'btn btn-danger btn-block', 'title' => Yii::t('dash', 'Remove/Delete Event'), 'data' => ['confirm' => Yii::t('dash', 'Are you sure you want to delete this item?'), 'method' => 'post'],]);
    }
    echo '</div>';

    $model->start_date = Yii::$app->formatter->asDateTime($model->start_date);
    $model->end_date = Yii::$app->formatter->asDateTime($model->end_date);
}
?>
<div class="col-xs-12 col-lg-12">
    <div class="events-form">

        <?php
        $form = ActiveForm::begin([
                    'id' => 'schedule-form',
                    'fieldConfig' => [
                        'template' => "{label}{input}{error}",
                    ],
        ]);
        ?>

        <div class="alert alert-success alert-dismissable" style="display: none">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <span id="message"></span>
        </div>
        <?= $form->field($model, 'title')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'details')->hiddenInput()->label(false) ?>
        <div class="col-xs-6 col-sm-6 col-lg-6">
            <?=
            $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                //'type' => DateTimePicker::TYPE_INPUT,
                'options' => ['placeholder' => '', 'readOnly' => true],
                'pluginOptions' => [
                    'autoclose' => true,
                    'maxView' => 0,
                    'startView' => 0,
                    'format' => 'yyyy-mm-dd',
                ],
            ]);
            ?>
        </div>
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
            $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                //'type' => DateTimePicker::TYPE_INPUT,
                'options' => ['placeholder' => '', 'readOnly' => true],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
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
            $form->field($model, 'mon')->widget(SwitchInput::classname(), [
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
                <?= Html::button($model->isNewRecord ? Yii::t('dash', 'Add Schedule') : Yii::t('dash', 'Update'), ['id' => 'save', 'class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-info btn-block']) ?> 
            </div>
            <div class="col-xs-6">
                <?php
                echo Html::a(Yii::t('dash', 'Cancel'), ['index'], ['class' => 'btn btn-default btn-block', 'data-dismiss' => "modal"]);
                ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#classscheduletemporary-title").val($("#classschedule-subject_id option:selected").text());
        $("#classscheduletemporary-details").val("Prof. " + $("#classschedule-professor_id option:selected").text());
        $("#save").on("click", function () {
            $.ajax({
                type: 'POST',
                url: '<?= Url::to(["schedule/add-event"]) ?>',
                data: $('#schedule-form').serialize(),
                success: function (data) {
                    if (data == 1) {
                        $("#message").html("<?= Yii::t('app', 'Class schedule successfully added. You can add another for this subject.'); ?>")
                        $(".alert-success").show();
                        $("#w1").fullCalendar('rerenderEvents');
                        $("#w1").fullCalendar('refetchEvents');
                    } else {
                        $("#message").html("<?= Yii::t('app', 'Failed saving the class schedule.'); ?>")

                    }
                }
            });
        });


    });
</script>