<?php
namespace Sensors\Controller;

use Sensors\Controller\AppController;

/**
 * SensorValues Controller
 *
 * @property \Sensors\Model\Table\SensorValuesTable $SensorValues
 */
class SensorValuesController extends AppController
{

		public function initialize()
    {
      parent::initialize();
      $this->Auth->allow(['add','add.json']);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sensors']
        ];
        $sensorValues = $this->paginate($this->SensorValues);

        $this->set(compact('sensorValues'));
        $this->set('_serialize', ['sensorValues']);
    }

    /**
     * View method
     *
     * @param string|null $id Sensor Value id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sensorValue = $this->SensorValues->get($id, [
            'contain' => ['Sensors']
        ]);

        $this->set('sensorValue', $sensorValue);
        $this->set('_serialize', ['sensorValue']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sensorValue = $this->SensorValues->newEntity();
        if ($this->request->is('post')) {
            $sensorValue = $this->SensorValues->patchEntity($sensorValue, $this->request->getData());
            if ($this->SensorValues->save($sensorValue)) {
                $this->Flash->success(__('The sensor value has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sensor value could not be saved. Please, try again.'));
        }
        $sensors = $this->SensorValues->Sensors->find('list', ['limit' => 200]);
        $this->set(compact('sensorValue', 'sensors'));
        $this->set('_serialize', ['sensorValue']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sensor Value id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sensorValue = $this->SensorValues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sensorValue = $this->SensorValues->patchEntity($sensorValue, $this->request->getData());
            if ($this->SensorValues->save($sensorValue)) {
                $this->Flash->success(__('The sensor value has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sensor value could not be saved. Please, try again.'));
        }
        $sensors = $this->SensorValues->Sensors->find('list', ['limit' => 200]);
        $this->set(compact('sensorValue', 'sensors'));
        $this->set('_serialize', ['sensorValue']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sensor Value id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sensorValue = $this->SensorValues->get($id);
        if ($this->SensorValues->delete($sensorValue)) {
            $this->Flash->success(__('The sensor value has been deleted.'));
        } else {
            $this->Flash->error(__('The sensor value could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
