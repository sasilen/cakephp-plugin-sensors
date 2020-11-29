<?php
declare(strict_types=1);

namespace Sasilen\Sensors\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\I18n\Time;
/**
 * Sensors Controller
 *
 *
 * @method \Sensor\Model\Entity\Sensor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SensorsController extends AppController
{
    public function manipulate($sv)
    {
    $tags = array();
    if ($this->request->getQuery('tags')) $tags[] = $this->request->getQuery('tags');
    $time = new Time($sv->datetime);
    $result = ['x'=>$time->format('Y-m-d'),'y'=>$sv->value];
    if (!empty($tags)) :
        if (in_array('byAge',$tags)) :
            $time1 = new Time($sv->bdate);
            $time2 = new Time($sv->datetime);
            $age = $time1->diff($time2);
            $result = ['x'=>round(($age->format('%a')/365),3),'y'=>$sv->value];
        endif;
    endif;
    return $result;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $chart = $results = NULL;
    $tags = array();
    if ($this->request->getQuery('tags')) $tags[] = $this->request->getQuery('tags');
//    $parser = ['time'=>['unit'=> 'day','parser'=>'YYYY-MM-DD'],'type'=>'linear'];
    if (!empty($tags) && !in_array('byAge', $tags)) :
            $query = $this->Sensors->find()
                ->contain(['SensorValues' => function ($q) {return $q
                ->where(['SensorValues.datetime >= ' => new \DateTime('-3 days')])
//                ->limit(10000)
                ->order('SensorValues.datetime ASC');
                },'Tags'])
                ->matching('Tags', function ($q) use ($tags) {
                    return $q->where(['Tags.label LIKE "'. $tags[0] .'"']);
                });
    elseif (!empty($tags) && in_array('byAge', $tags)) :
//            $parser = ['time'=>['unit'=> 'day','parser'=>'YYYY-MM-DD'],'ticks'=>['stepSize'=>0.5],'type'=>'linear'];
            $query = $this->Sensors->find()
                ->contain(['SensorValues' => function ($q) {return $q
//                ->where(['SensorValues.datetime >= ' => new \DateTime('-3 days')])
//                ->limit(10000)
                ->order('SensorValues.datetime ASC');
                },'Tags'])
                ->matching('Tags', function ($q) use ($tags) {
                    return $q->where(['Tags.label LIKE "'. $tags[0] .'"']);
                });
    else :
        $query = $this->Sensors->find()->contain(['SensorValues' => function ($q) {return $q
                ->where(['SensorValues.datetime >= ' => new \DateTime('-3 days')])
//                ->limit(10000)
                ->order('SensorValues.datetime ASC');
                },'Tags']);
    endif;

    $sensors = $this->paginate($query);

    foreach ($sensors as $skey=>$sensor) :
        foreach ($sensor['sensor_values'] as $vkey=>$value) :
            $value['bdate'] = $sensor['datetime'];
            $results[$value['type']][$sensor['name']][] = $this->manipulate($value);
        endforeach;
    endforeach;

    if ($results!=NULL):
        foreach ($results as $key=>$types) :
//            $chart[$key]['options']['scales']['xAxes'][] = $parser;
            foreach ($types as $tkey=>$values) :
                $border = 0;
                $chart[$key]['type'] = 'line';
                $chart[$key]['data']['datasets'][] = [
                    'label' => $tkey,
                    'data' => $results[$key][$tkey],
                    'borderColor' => 'rgba('.($border=$border+50).',0,0,0.5)',
                    'fill' => False
                ];
            endforeach;
            $labels = array_unique(Hash::extract($chart[$key]['data']['datasets'], '{n}.data.{n}.x'));
            asort($labels);//SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
            $chart[$key]['data']['labels'] = array_values($labels);
        endforeach;
    endif;
    $tags = $this->Sensors->Tags->find()->select(['label'])->distinct(['label'])->all();
	$this->set(compact('sensors','tags'));
    $this->set('chart',$chart);
    }

    /**
     * View method
     *
     * @param string|null $id Sensor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sensor = $this->Sensors->get($id, [
            'contain' => ['SensorValues' =>['sort' => ['SensorValues.datetime'=>'ASC']],'Tags'],
        ]);
        $border = 0;
	$chart['type'] = 'line';
   	$chart['options']['scales']['xAxes'][] = ['time' =>  ['unit'=> 'day','parser'=>'YYYY-MM-DD']];

	foreach (array_unique(Hash::extract($sensor['sensor_values'], '{n}.type')) as $svtype) :
            $result[$svtype] = Hash::map($sensor['sensor_values'], "{n}[type=$svtype]", [$this, 'manipulate']);
            $chart['data']['datasets'][] = [
                'label' => $svtype,
                'data' => $result[$svtype],
                'borderColor' => 'rgba('.($border=$border+50).',0,0,0.5)',
                'fill' => False
            ];
	endforeach;

        $labels = array_unique(Hash::extract($chart['data']['datasets'], '{n}.data.{n}.x'));
        asort($labels,SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
	$chart['data']['labels'] = array_values($labels);

//	unset($chart['data']['datasets'][1]);

     	$this->set('sensor', $sensor);
    	$this->set('chart',$chart);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sensor = $this->Sensors->newEmptyEntity();
        if ($this->request->is('post')) {
            $sensor = $this->Sensors->patchEntity($sensor, $this->request->getData());
            if ($this->Sensors->save($sensor)) {
                $this->Flash->success(__('The sensor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sensor could not be saved. Please, try again.'));
        }
        $this->set(compact('sensor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sensor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sensor = $this->Sensors->get($id, [
            'contain' => ['Tags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sensor = $this->Sensors->patchEntity($sensor, $this->request->getData());
            if ($this->Sensors->save($sensor)) {
                $this->Flash->success(__('The sensor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sensor could not be saved. Please, try again.'));
	}
	$tags = [];
        $alltags = $sensor->tags;
        foreach ($alltags as $tag):
          $tags[] = $tag->label;
        endforeach;
        $sensor->tags = implode(',', $tags);
	$this->set(compact('sensor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sensor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sensor = $this->Sensors->get($id);
        if ($this->Sensors->delete($sensor)) {
            $this->Flash->success(__('The sensor has been deleted.'));
        } else {
            $this->Flash->error(__('The sensor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
