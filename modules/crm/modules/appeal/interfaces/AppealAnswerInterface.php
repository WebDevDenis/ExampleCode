<?php




namespace frontend\modules\crm\modules\appeal\interfaces;


/**
 * Interface AppealAnswerInterface
 * @package frontend\modules\crm\modules\appeal\interfaces
 */
interface AppealAnswerInterface
{

	/**
	 * @return string
	 */
	public function getBody();

	/**
	 * @return string
	 */
	public function getTheme();
}