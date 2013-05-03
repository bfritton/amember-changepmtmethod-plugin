<?php
/**
 * Class for interacting with credit card records in aMember
 *
 * @author		Brian Fritton <bfritton@gmail.com>
 * @copyright	GNU General Public License, version 3 (GPL-3.0)
 */
require_once(ROOT_DIR.'/application/default/models/Invoice.php');
class UtilitiesCreditCard extends CcRecordTable
{
    /**
     * Check to see if a user has an attached credit card
     *
     * @param User $user
     * @return \Am_Record|bool
     */
    public function checkForCcByUser(User $user)
    {
        $filters = array('user_id' => $user->user_id);
        $ccRecord = $this->findFirstBy($filters);
        if ($ccRecord) {
            return $ccRecord;
        }
        return false;
    }
}