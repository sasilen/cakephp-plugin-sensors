<?php
declare(strict_types=1);

namespace Sensor\Controller;

/**
 * SensorValues Controller
 *
 * @property \Sensor\Model\Table\SensorValuesTable $SensorValues
 *
 * @method \Sensor\Model\Entity\SensorValue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SensorValuesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sensors'],
        ];
        $sensorValues = $this->paginate($this->SensorValues);

        $this->set(compact('sensorValues'));
    }

    /**
     * View method
     *
     * @param string|null $id Sensor Value id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sensorValue = $this->SensorValues->get($id, [
            'contain' => ['Sensors'],
        ]);

        $this->set('sensorValue', $sensorValue);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sensorValue = $this->SensorValues->newEmptyEntity();
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
    }

    /**
     * Edit method
     *
     * @param string|null $id Sensor Value id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sensorValue = $this->SensorValues->get($id, [
            'contain' => [],
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
    }

    /**
     * Delete method
     *
     * @param string|null $id Sensor Value id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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
