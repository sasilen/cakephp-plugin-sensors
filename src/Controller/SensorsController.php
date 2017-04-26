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
    public function index()
    {
        $sensors = $this->paginate($this->Sensors);

        $this->set(compact('sensors'));
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
            'contain' => ['SensorValues']
        ]);
        foreach($sensor['sensor_values'] as $sv):
          $time = new Time($sv->datetime);
          $values[$sv->type][$time->toUnixString()*1000][$sensor['name']][$time->toUnixString()*1000] = floatval($sv['value']);
        endforeach;
        
        foreach ($values as $type => $typeset) :
          foreach ($typeset as $time => $sensors) :
            $xAxisCategories[$type][] = $time;
            foreach ($sensors as $sensori => $value) :
              if ($type=='alarm') {
                foreach ($value as $x=>$y):
                  $chartDatas[$type][$sensori][] = array($time,$y);
                endforeach;
              } else {
                $chartDatas[$type][$sensori][] = array($time,$value);
              }
            endforeach;
          endforeach;
        endforeach;
       $chartName = 'Line Chart';

                $myChart = $this->Highcharts->createChart();
                $myChart->chart = array(
                    'renderTo' => 'linewrapper',
                    'type' => 'line',
                    'marginRight' => 290,
                    'marginBottom' => 25,
                    'zoomType' => 'x'
                );

                $myChart->title = array(
                    'text' => 'Temperatures',
                    'x' => - 20
                );

                $myChart->subtitle = array(
                    'text' => 'Raspberry PI, 1-wire',
                    'x' => - 20
                );

                $myChart->yAxis = array(
                    'title' => array(
                        'text' => 'Temperature (°C)'
                    ),
                    'plotLines' => array(
                        array(
                            'value' => 0,
                            'width' => 1,
                            'color' => '#808080'
                        )
                    )
                );
                $myChart->xAxis = array(
                  'title' => array(
                    'text' => 'Date'
                  ),
                  'type' => 'datetime',
                );

                $myChart->legend = array(
                    'layout' => 'vertical',
                    'align' => 'right',
                    'verticalAlign' => 'top',
                    'x' => 10,
                    'y' => 100,
                    'borderWidth' => 0
                );

                foreach ( $chartDatas['temperature'] as $sensori => $values ) :
                  $myChart->series[] = array(
                        'name' => $sensori,
                        'data' => $values);
                endforeach;


        $this->set('sensor', $sensor);
        $this->set(compact('myChart', 'chartName'));
        $this->set('_serialize', ['sensor']);
    }
    public function highcharts()
    {
        $this->paginate['limit'] = 30;
        $sensors = $this->paginate($this->Sensors->find()->contain(['SensorValues' => function ($q) {return $q
            ->where(['SensorValues.datetime >= ' => new \DateTime('-7 days')]);
//          ->order('datetime DESC');
    }]));
        $this->set('sensors',$sensors);
        $this->set('_serialize', ['sensors']);
    foreach ($sensors as $sensor) :
        foreach ($sensor['sensor_values'] as $SensorValue):
          $time = new Time($SensorValue->datetime);
          if ($sensor['type']=='alarm') {
            if ($SensorValue['value']==1) {
//             $date = $time->format('Y-m-d');
//              echo $time->format('Y-m-d'). " - ".$time->format('H:i:s')."<br>";
               $values['temperature'/*$sensor['type']*/][ strtotime($time->format('Y-m-d'))*1000 ][$sensor['description']][$time->toUnixString()*1000] = floatval($time->format('H').$time->format('i'));
               //$values[$sensor['type']][ $time->toUnixString()*1000 ][$sensor['description']] = intval($time->format('h'));
               
            }
          } else {
                  $values['temperature'/*$sensor['type']*/][ $time->toUnixString()*1000 ][$sensor['description']] = floatval($SensorValue['value']);
          }
        endforeach;
    endforeach;debug($values);
    ksort($values['temperature']);
    ksort($values['alarm']);
//    debug($values['alarm']);
    
    foreach ($values as $type => $typeset) :
      foreach ($typeset as $time => $sensors) :
        $xAxisCategories[$type][] = $time;
        foreach ($sensors as $sensor => $value) :
          if ($type=='alarm') {
            foreach ($value as $x=>$y):
            $chartDatas[$type][$sensor][] = array($time,$y);
            endforeach;
          } else {
            $chartDatas[$type][$sensor][] = array($time,$value);
          }
        endforeach;
      endforeach;
    endforeach;

 $chartName = 'Line Chart';

                $myChart = $this->Highcharts->createChart();
                $myChart->chart = array(
                    'renderTo' => 'linewrapper',
                    'type' => 'line',
                    'marginRight' => 290,
                    'marginBottom' => 25,
                    'zoomType' => 'x'
                );

                $myChart->title = array(
                    'text' => 'Temperatures',
                    'x' => - 20
                );
                
                $myChart->subtitle = array(
                    'text' => 'Raspberry PI, 1-wire',
                    'x' => - 20
                );

                $myChart->yAxis = array(
                    'title' => array(
                        'text' => 'Temperature (°C)'
                    ),
                    'plotLines' => array(
                        array(
                            'value' => 0,
                            'width' => 1,
                            'color' => '#808080'
                        )
                    )
                );
                $myChart->xAxis = array(
                  'title' => array(
                    'text' => 'Date'
                  ),
                  'type' => 'datetime',
                );

                $myChart->legend = array(
                    'layout' => 'vertical',
                    'align' => 'right',
                    'verticalAlign' => 'top',
                    'x' => 10,
                    'y' => 100,
                    'borderWidth' => 0
                );

                foreach ( $chartDatas['temperature'] as $sensor => $values ) :
                  $myChart->series[] = array(
                        'name' => $sensor,
                        'data' => $values);
                endforeach;


/*                $myChart->tooltip->formatter = $this->Highcharts->createJsExpr(
                "function() { return '<b>'+ this.series.name +'</b><br/>'+ this.x +': '+ this.y +'°C';}");
*/

                $this->set(compact('myChart', 'chartName'));

                            $ScatterChart = 'Scatter Chart';
                $myScatter = $this->Highcharts->createChart();
                $myScatter->chart->renderTo = 'scatterwrapper';
                $myScatter->chart->type = 'scatter';
                $myScatter->chart->zoomType = "xy";
                $myScatter->title->text = 'Door opening detections';
                $myScatter->subtitle->text = 'Source: Raspberry Pi, 1-wire';
                $myScatter->xAxis->title->enabled = 1;
                $myScatter->xAxis->title->text = 'Date';
                $myScatter->xAxis->type = 'datetime';
                $myScatter->xAxis->startOnTick = 1;

                $myScatter->xAxis->endOnTick = 1;
                $myScatter->xAxis->showLastLabel = 1;
                $myScatter->yAxis->title->text = "Time";
                $myScatter->tooltip->formatter = $this->Highcharts->createJsExpr(
                    "function() {
                        return ''+
                        Highcharts.dateFormat('%e - %b - %Y', new Date(this.x))+' d, '+ this.y +' h';
                    }"
                );
                $myScatter->legend->layout = 'vertical';
                $myScatter->legend->align = 'left';
                $myScatter->legend->verticalAlign = 'top';
                $myScatter->legend->x = 100;
                $myScatter->legend->y = 70;
                $myScatter->legend->floating = 1;
                $myScatter->legend->backgroundColor = '#FFFFFF';
                $myScatter->legend->borderWidth = 1;
                $myScatter->plotOptions->scatter->marker->radius = 5;
                $myScatter->plotOptions->scatter->marker->states->hover->enabled = 1;
                $myScatter->plotOptions->scatter->marker->states->hover->lineColor = "rgb(100,100,100)";
                $myScatter->plotOptions->scatter->states->hover->marker->enabled = false;
    foreach ( $chartDatas['alarm'] as $sensor => $values ) : 
                        $myScatter->series[] = array(
                            'name' => $sensor,
                            'color' => "rgba(223, 83, 83, .5)",
                            'data' => $values
                  );
                endforeach;
                $this->set(compact('myScatter', 'ScatterChart'));

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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
