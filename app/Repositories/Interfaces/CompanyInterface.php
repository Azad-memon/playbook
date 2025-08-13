<?php
    namespace App\Repositories\Interfaces;

    interface CompanyInterface
    {
        public function createCompanyWithAdmin(array $data);
        public function all();
        public function find($id);
        public function update($id, array $data);
        public function delete($id);
    }

?>
