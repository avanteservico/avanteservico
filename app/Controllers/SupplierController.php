<?php

require_once '../app/Models/Supplier.php';
require_once '../app/Helpers/AuthHelper.php';

class SupplierController
{
    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        // Check permission if needed, for now assume logged in users can see suppliers
        // if (!AuthHelper::hasPermission('suppliers', 'list')) ...

        $supplierModel = new Supplier();
        $suppliers = $supplierModel->getAll();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/suppliers/index.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function create()
    {
        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/suppliers/form.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'contact_name' => $_POST['contact_name'],
                'contact_phone' => $_POST['contact_phone'],
                'observations' => $_POST['observations']
            ];

            $supplierModel = new Supplier();
            if ($supplierModel->create($data)) {
                header('Location: ' . BASE_URL . '/suppliers');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/suppliers/create?error=true');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $supplierModel = new Supplier();
        $supplier = $supplierModel->findById($id);

        if (!$supplier) {
            header('Location: ' . BASE_URL . '/suppliers');
            exit;
        }

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/suppliers/form.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'contact_name' => $_POST['contact_name'],
                'contact_phone' => $_POST['contact_phone'],
                'observations' => $_POST['observations']
            ];

            $supplierModel = new Supplier();
            if ($supplierModel->update($data)) {
                header('Location: ' . BASE_URL . '/suppliers');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/suppliers/edit/' . $data['id'] . '?error=true');
                exit;
            }
        }
    }

    public function show($id)
    {
        $supplierModel = new Supplier();
        $supplier = $supplierModel->findById($id);

        if (!$supplier) {
            header('Location: ' . BASE_URL . '/suppliers');
            exit;
        }

        $expenses = $supplierModel->getExpenses($id);
        $summary = $supplierModel->getSummary($id);

        // Fetch Works and Expense Types for the "Add Expense" modal
        require_once '../app/Models/Work.php';
        require_once '../app/Models/ExpenseType.php';

        $workModel = new Work();
        $works = $workModel->getAllActive();

        $expenseTypeModel = new ExpenseType();
        $expenseTypes = $expenseTypeModel->getAll();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/suppliers/show.php';
        require_once '../app/Views/templates/footer.php';
    }

    public function delete($id)
    {
        if ($id) {
            $supplierModel = new Supplier();
            if ($supplierModel->delete($id)) {
                header('Location: ' . BASE_URL . '/suppliers?deleted=true');
            } else {
                header('Location: ' . BASE_URL . '/suppliers?error=dependence'); // Cannot delete due to foreign keys
            }
        } else {
            header('Location: ' . BASE_URL . '/suppliers');
        }
        exit;
    }

    public function linked()
    {
        require_once '../app/Models/Work.php';
        $workModel = new Work();
        $linkedData = $workModel->getAllSuppliersWithWorks();

        require_once '../app/Views/templates/header.php';
        require_once '../app/Views/suppliers/linked.php';
        require_once '../app/Views/templates/footer.php';
    }
}
