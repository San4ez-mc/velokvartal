<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerSuppler2Api extends Controller
{
    public function index()
    {
        //        $this->response->addHeader('Content-Type: application/json');
        $this->load->model('catalog/suppler2');
        echo 'Парсинг почався в ' . date('d.m.Y H:i:s') . ' </br>';
        $start = time();
        $supplers = $this->model_catalog_suppler2->getSupplers('status = 1');
        if (!empty($supplers)) {
            foreach ($supplers as $suppler) {
                try {
                    $logs = $this->model_catalog_suppler2->parse_xml($suppler['id']);
                    $this->model_catalog_suppler2->addLog([
                        'suppler_id' => $suppler['id'],
                        'rows' => $logs,
                        'status' => 1
                    ]);
                } catch (Exception $e) {
                    var_dump($e);
                    $this->model_catalog_suppler2->addLog([
                        'suppler_id' => $suppler['id'],
                        'data' => $e->getMessage(),
                        'status' => 0
                    ]);
                }
            }
        }

        echo 'Парсинг завершився в ' . date('d.m.Y H:i:s') . ' і тривав ' . ((time() - $start)) . ' секунд';
    }
}
