<?php

class AdditiveController
{

    public function __construct()
    {
        AuthHelper::requireLogin();
    }

    public function index()
    {
        $work_id = $_GET['work_id'] ?? null;
        if (!$work_id) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $workModel = new Work();
        $work = $workModel->findById($work_id);

        if (!$work) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $additiveModel = new Additive();
        $subAdditiveModel = new SubAdditive();

        $additives = $additiveModel->getAllByWorkId($work_id);

        foreach ($additives as &$additive) {
            $additive['sub_additives'] = $subAdditiveModel->getAllByAdditiveId($additive['id']);
        }
        unset($additive);

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/additives/index.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    private function parseCurrency($value)
    {
        $value = preg_replace('/[^0-9,.]/', '', $value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return (float) $value;
    }

    public function create()
    {
        $work_id = $_POST['work_id'] ?? $_GET['work_id'] ?? null;

        if (!$work_id) {
            die('Obra não especificada.');
        }

        $workModel = new Work();
        $work = $workModel->findById($work_id);

        if (!$work) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $additiveModel = new Additive();

            $executed_percentage = $this->parseCurrency($_POST['executed_percentage'] ?? 0);
            if ($executed_percentage > 100)
                $executed_percentage = 100;

            $data = [
                'work_id' => $work_id,
                'name' => $_POST['name'],
                'value' => $this->parseCurrency($_POST['value'] ?? 0),
                'executed_percentage' => $executed_percentage,
                'paid_value' => $this->parseCurrency($_POST['paid_value'] ?? 0),
            ];

            if ($additiveModel->create($data)) {
                header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id);
                exit;
            } else {
                $error = "Erro ao criar aditivo.";
            }
        }

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/additives/create.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function edit($id)
    {
        $additiveModel = new Additive();
        $additive = $additiveModel->findById($id);

        if (!$additive) {
            header('Location: ' . BASE_URL . '/works');
            exit;
        }

        $workModel = new Work();
        $work = $workModel->findById($additive['work_id']);

        $subAdditiveModel = new SubAdditive();
        $subAdditives = $subAdditiveModel->getAllByAdditiveId($id);

        $additive['valor_devido'] = $additive['value'] * ($additive['executed_percentage'] / 100);

        require_once ROOT_PATH . '/app/Views/templates/header.php';
        require_once ROOT_PATH . '/app/Views/additives/edit.php';
        require_once ROOT_PATH . '/app/Views/templates/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $additiveModel = new Additive();
            $id = $_POST['id'];
            $work_id = $_POST['work_id'];

            $executed_percentage = $this->parseCurrency($_POST['executed_percentage'] ?? 0);
            if ($executed_percentage > 100)
                $executed_percentage = 100;

            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'value' => $this->parseCurrency($_POST['value'] ?? 0),
                'executed_percentage' => $executed_percentage,
                'paid_value' => $this->parseCurrency($_POST['paid_value'] ?? 0),
            ];

            if ($additiveModel->update($data)) {
                header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id);
                exit;
            } else {
                header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id . '&error=true');
            }
        }
    }

    public function delete($id)
    {
        $additiveModel = new Additive();
        $additive = $additiveModel->findById($id);

        if ($additive) {
            $work_id = $additive['work_id'];
            $additiveModel->delete($id);
            header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id);
        } else {
            header('Location: ' . BASE_URL . '/works');
        }
        exit;
    }

    public function createSubAdditive()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $additive_id = $_POST['additive_id'];
            $work_id = $_POST['work_id'];

            $data = [
                'additive_id' => $additive_id,
                'name' => $_POST['name'],
            ];

            $subAdditiveModel = new SubAdditive();
            if ($subAdditiveModel->create($data)) {
                header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id);
                exit;
            }
        }
    }

    public function updateSubAdditive()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $additive_id = $_POST['additive_id'];
            $work_id = $_POST['work_id'];

            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'status' => $_POST['status'] ?? 'pendente'
            ];

            $subAdditiveModel = new SubAdditive();
            if ($subAdditiveModel->update($data)) {
                header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id);
                exit;
            }
        }
    }

    public function deleteSubAdditive($id)
    {
        $work_id = $_GET['work_id'] ?? null;

        if ($id) {
            $subAdditiveModel = new SubAdditive();
            $subAdditive = $subAdditiveModel->findById($id);

            if ($subAdditive) {
                $subAdditiveModel->delete($id);
            }
        }

        if ($work_id) {
            header('Location: ' . BASE_URL . '/additives?work_id=' . $work_id);
        } else {
            header('Location: ' . BASE_URL . '/works');
        }
        exit;
    }
}
