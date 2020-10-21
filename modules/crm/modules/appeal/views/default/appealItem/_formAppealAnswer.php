<?php
use frontend\assets\AppAsset;
$this->registerJsFile('/js/sms/sms-count.js', ['depends' => [AppAsset::class]]);

$email='active';
$emailStars='';
$sms='';
$smsStars='';
$call='';
$callStars='';
switch ($type_contact){
    case 3:
	    $email='active';
	    $emailStars='<i class="fa fa-star"></i>';
	    break;
	case 4:
		$email='';
		$sms='active';
		$smsStars='<i class="fa fa-star"></i>';
		break;
	case 6:
		$email='';
		$call='active';
		$callStars='<i class="fa fa-star"></i>';
		break;

}
?>
<div style="padding: 0 50px 50px">
    <p>Если вкладка помечена иконкой - <i class="fa fa-star"></i>, то это приоритетный способ связи, который указал клиент</p>
    <div class="row">
        <div class="col-md-12">
            <div class="tabs tabs-primary">
                <ul class="nav nav-tabs">
                    <li class="<?php echo $email?>" >
                        <a href="#send_email" data-toggle="tab"><?php echo $emailStars?> Отправка email</a>
                    </li>
                    <li>
                        <a href="#send_comment" data-toggle="tab">Комментарий</a>
                    </li>
                    <li class="<?php echo $sms?>" >
                        <a href="#send_sms" data-toggle="tab"><?php echo $smsStars?> Отправка смс</a>
                    </li>
                    <li class="<?php echo $call?>">
                        <a href="#send_call" data-toggle="tab"><?php echo $callStars?> Звонок</a>
                    </li>
                </ul>
                <div class="tab-content" style="float: none">
                    <div id="send_email" class="tab-pane <?php echo $email?>">
						<?php
						echo $this->render( 'appealForm/_email', [ 'modelAnswer' => $modelAnswer ] );
						?>

                    </div>
                    <div id="send_comment" class="tab-pane ">
						<?php
						echo $this->render( 'appealForm/_comment', [ 'modelAnswer' => $modelAnswer ] );
						?>
                    </div>
                    <div id="send_sms" class="tab-pane <?php echo $sms?>">
						<?php
						echo $this->render( 'appealForm/_sms', [ 'modelAnswer' => $modelAnswer ] );
						?>
                    </div>
                    <div id="send_call" class="tab-pane <?php echo $call?>">
						<?php
						echo $this->render( 'appealForm/_call', [ 'modelAnswer' => $modelAnswer ] );
						?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



