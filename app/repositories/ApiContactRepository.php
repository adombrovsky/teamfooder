<?php
use Redbaron76\Googlavel\Support\Facades\Googlavel;

/**
 * Class ApiContactRepository
 */
class ApiContactRepository implements ContactRepositoryInterface
{
    const ITEMS_PER_PAGE = 250;

    /**
     * @return array
     */
    public function findAll ()
    {
        /**
         * @var $service Google_Service_Contacts
         * @var $x Google_Service_Contacts_Contacts
         */
        $service = Googlavel::getService('Contacts');
        $contactList = $service->contacts->listContacts('default',array('max-results'=>self::ITEMS_PER_PAGE));
        return $contactList->getContactsList();
    }

    /**
     * @param int $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate ($limit = self::ITEMS_PER_PAGE)
    {
        /**
         * @var $service Google_Service_Contacts
         * @var $x Google_Service_Contacts_Contacts
         */
        $service = Googlavel::getService('Contacts');
        return $service->contacts->listContacts('default',array('max-results'=>$limit));
    }
}