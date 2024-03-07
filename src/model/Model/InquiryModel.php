<?php

namespace Model\Model;

use Exception;
use Model\ClassMetier\Inquiry;
use Model\DAL\Gateway\IInquiryGateway;
use Model\DAL\Gateway\MySQLInquiryGateway;
use Model\Factory\IFactory;
use Model\Factory\MySQLInquiryFactory;

class InquiryModel
{
    private IInquiryGateway $gateway;
    private IFactory $inquiryFactory;
    private array $inquiries = [];

    public function __construct()
    {
        $this->gateway = new MySQLInquiryGateway();
        $this->inquiryFactory = new MySQLInquiryFactory();
    }

    /**
     * Summary : Permet de récupérer toutes les enquêtes et de les mettre da la liste attribut $inquiries.
     * @return array
     * @throws Exception
     */
    public function loadInquiries(): array
    {
        $res = $this->gateway->loadInquiry();
        $this->inquiries = $this->inquiryFactory->createObject($res);
        return $this->inquiries;
    }

    /**
     * Summary : Permet d'ajouter une enquête dans la liste attribut $inquiries.
     * @param Inquiry $inquiry
     * @return void
     */
    public function addInquiry(Inquiry $inquiry): void
    {
        $this->inquiries[] = $inquiry;
    }

    /**
     * Summary : Renvoie l'attribut $inquiries.
     * @return array
     */
    public function getInquiries(): array
    {
        return $this->inquiries;
    }

    /**
     * @param $id
     * @return Inquiry
     * @throws Exception
     */
    public function findInquiry($id): Inquiry
    {
        $tab = $this->gateway->findById($id);
        $inquiryTab = $this->inquiryFactory->createObject([[
            'id' => $tab['id'],
            'title' => $tab['title'],
            'description' => $tab['description'],
            'is_user' => $tab['is_user']]]);
        return $inquiryTab[0];
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getBaseNumber(int $id): string
    {
        $res = $this->gateway->findBaseNumber($id);
        return $res['database_name'];
    }
}
