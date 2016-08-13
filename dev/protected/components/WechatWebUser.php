<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class WechatWebUser extends CWebUser
{
	/**
	 * Overrides a Yii method that is used for roles in controllers (accessRules).
	 *
	 * @param string $operation Name of the operation required (here, a role).
	 * @param mixed $params (opt) Parameters for this operation, usually the object to access.
	 * @return bool Permission granted?
	 */
	public function checkAccess($operation, $params=array())
	{
		if (empty($this->id)) {
			// Not identified => no rights
			return false;
		}
		return ($operation===$this->getState("roles"));
	}
}