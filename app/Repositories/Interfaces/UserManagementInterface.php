<?php

namespace App\Repositories\Interfaces;

interface UserManagementInterface
{
   public function completeSignup($data,$token);
   public function find($id);

 //    Company Managers
   public function allCompanyManagers($company_id);
   public function createManager(array $data);
   public function deleteManager($id);
   public function updateManager($id, array $data);

//    Company Employees
   public function allCompanyEmployees($company_id);
   public function createEmployee(array $data);
   public function deleteEmployee($id);
   public function updateEmployee($id, array $data);
}
