<?php
namespace Sensors\Controller;

use Sensors\Controller\AppController;
use Cake\I18n\Time;

/**
 * Sensors Controller
 *
 * @property \Sensors\Model\Table\SensorsTable $Sensors
 */
class SensorsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Highcharts.Highcharts');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($tag = null)
    {
        $series = array();
        $chart = array();

/*      $this->paginate['limit'] = 30;
      $sensors = $this->paginate($this->Sensors->find()->contain(['SensorValues' => function ($q) {return $q
          ->where(['SensorValues.datetime >= ' => new \DateTime('-7 days')]);
          ->order('datetime DESC');
*/
        if (!is_null($tag)) :
            $query = $this->Sensors->find()
                ->contain(['SensorValues' => ['sort'=> ['SensorValues.datetime' => 'ASC' ]],
                           'Tags'])
                ->matching('Tags', function ($q) use ($tag) {
                    return $q->where(['Tags.label LIKE "'. $tag .'"']);
            });
            $sensors = $this->paginate($query);
        else:
            $this->paginate = [
                'contain' => [
                    'SensorValues' => ['sort'=> ['SensorValues.datetime' => 'ASC']],
//                                       'filter'= ['SensorValues.datetime >= ' => new \DateTime('-7 days')]],
                    'Tags'
                ]
            ];
            $sensors = $this->paginate($this->Sensors);
        endif;

        $chartName = 'Line Chart';
        $myChart = $this->Highcharts->createChart();
        foreach($sensors as $sensor):
            foreach($sensor['sensor_values'] as $sv):
                $time = new Time($sv->datetime);
                if ($tag=='byAge'):
                  $age = date_diff(date_create($sensor->datetime),date_create($sv->datetime));
                  $series[$sv->type][$sensor->name][] = array(floatval($age->format('%a')/365),$sv->value);
                elseif(strpos( $sv->type, 'latch' ) !== false):
                  $series[$sv->type][$sensor->name][] = array($time->toUnixString()*1000,floatval($time->format('H').$time->format('i')));
                else:
                  $series[$sv->type][$sensor->name][] = array($time->toUnixString()*1000,$sv->value);
                endif;
            endforeach;
        endforeach; 

        foreach ( $series as $type => $sensor ) :
          $chart[$type] = $this->Highcharts->createChart();
          $chart[$type]->chart['renderTo'] = 'linewrapper_'.$type;
          if (strpos( $type, 'latch' ) === false) $chart[$type]->chart['type'] = 'line';
          else $chart[$type]->chart['type'] = 'scatter';
          $chart[$type]->title['text'] = $type;
          $chart[$type]->subtitle['text'] = 'Raspberry';
          $chart[$type]->yAxis['title']['text'] = $type;
          $chart[$type]->xAxis['title']['text'] = 'date';
          if ($tag!='Age') $chart[$type]->xAxis['type'] = 'datetime';
          $chart[$type]->plotOptions->line->marker->enabled = true;
          $chart[$type]->chart->zoomType = 'x';
          if (strpos( $type, 'latch' ) !== false) :
              $chart[$type]->tooltip->formatter = $this->Highcharts->createJsExpr(
                  "function() {
                        return ''+
                        Highcharts.dateFormat('%e - %b - %Y', new Date(this.x))+' d, '+ this.y +' h';
                  }"
              );
          endif;

        foreach ($sensor as $name => $values):
          $chart[$type]->series[] = array(
            'name' => $name,
            'data' => $values);
          endforeach;
        endforeach;

        $this->set(compact('sensors'));
        $this->set(compact('chart','chartName'));
        $this->set('_serialize', ['sensors']);
    }

    /**
     * View method
     *
     * @param string|null $id Sensor id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sensor = $this->Sensors->get($id, [
              'contain' => ['SensorValues','Tags']
        ]);
        foreach($sensor['sensor_values'] as $sv):
            $time = new Time($sv->datetime);
                if(strpos( $sv->type, 'latch' ) !== false):
                    $series[$sv->type][$sensor->name][] = array($time->toUnixString()*1000,floatval($time->format('H').$time->format('i')));
                else:
                    $series[$sv->type][$sensor->name][] = array($time->toUnixString()*1000,$sv->value);
                endif;
        endforeach;

        foreach ( $series as $type => $cat ) :
          $chart[$type] = $this->Highcharts->createChart();
          $chart[$type]->chart['renderTo'] = 'linewrapper_'.$type;
          if (strpos( $type, 'latch' ) === false) $chart[$type]->chart['type'] = 'line';
          else $chart[$type]->chart['type'] = 'scatter';
          $chart[$type]->title['text'] = $type;
          $chart[$type]->subtitle['text'] = 'Raspberry';
          $chart[$type]->yAxis['title']['text'] = $type;
          $chart[$type]->xAxis['title']['text'] = 'date';
          $chart[$type]->xAxis['type'] = 'datetime';
          $chart[$type]->plotOptions->line->marker->enabled = true;
          $chart[$type]->chart->zoomType = 'x';
          if (strpos( $type, 'latch' ) !== false) :
              $chart[$type]->tooltip->formatter = $this->Highcharts->createJsExpr(
                  "function() {
                        return ''+
                        Highcharts.dateFormat('%e - %b - %Y', new Date(this.x))+' d, '+ this.y +' h';
                  }"
              );
          endif;

          foreach ($cat as $name => $values):
          $chart[$type]->series[] = array(
            'name' => $name,
            'data' => $values);
          endforeach;
        endforeach;

        $this->set(compact('chart','chartName'));
        $this->set(compact('sensor'));
        $this->set('_serialize', ['sensor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sensor = $this->Sensors->newEntity();
        if ($this->request->is('post')) {
            $sensor = $this->Sensors->patchEntity($sensor, $this->request->getData());
            if ($this->Sensors->save($sensor)) {
                $this->Flash->success(__('The sensor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sensor could not be saved. Please, try again.'));
        }
        $this->set(compact('sensor'));
        $this->set('_serialize', ['sensor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sensor id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sensor = $this->Sensors->get($id, [
            'contain' => ['Tags']
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
        $this->set('_serialize', ['sensor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sensor id.
     * @return \Cake\Network\Response|null Redirects to index.
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
