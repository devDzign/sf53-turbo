<?php


namespace App\Controller\Api;


use App\Entity\Company;

class CompanyPublishController
{
     public function __invoke(Company $data): Company
     {
         $data->setIsPublished(true);

         return $data;
     }
}