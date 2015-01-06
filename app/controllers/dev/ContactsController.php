<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use ContactRepositoryInterface;

/**
 * Class ContactsController
 * @package dev
 */
class ContactsController extends \BaseController
{

    /**
     * @var ContactRepositoryInterface
     */
    private $contact;

    /**
     * @param \ContactRepositoryInterface $contact
     *
     * @internal param $
     */
    public function __construct(ContactRepositoryInterface $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     * GET /contacts
     * @return mixed
     */
    public function index()
	{
        return $this->contact->findAll();
	}

}