<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

/**
 * Grafikak
 *
 * @Route("admin/grafikak")
 */
class ChartController extends Controller
{
    /**
     *
     * @Route("/", name="admin_chart_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->chart->type('pie');
        $ob->title->text('Tramite zenbakia barrutika.');
        $ob->plotOptions->series(
            array(
                'dataLabels' => array(
                    'enabled' => true,
                    'format' => '{point.name}: {point.y:.1f}%'
                )
            )
        );

        $ob->tooltip->headerFormat('<span style="font-size:11px">{series.name}</span><br>');
        $ob->tooltip->pointFormat('<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>');

        $data = array(
            array(
                'name' => 'Antxo',
                'y' => 18.73,
                'drilldown' => 'Chrome',
                'visible' => true
            ),
            array(
                'name' => 'Trintxerpe',
                'y' => 53.61,
                'drilldown' => 'Microsoft Internet Explorer',
                'visible' => true
            ),
            array('San Pedro', 45.0),
            array('San Juan', 1.5)
        );

        $ob->series(
            array(
                array(
                    'name' => 'Browser share',
                    'colorByPoint' => true,
                    'data' => $data
                )
            )
        );

        $drilldown = array(
            array(
                'name' => 'Microsoft Internet Explorer',
                'id' => 'Microsoft Internet Explorer',
                'data' => array(
                    array("v8.0", 26.61),
                    array("v9.0", 16.96),
                    array("v6.0", 6.4),
                    array("v7.0", 3.55),
                    array("v8.0", 0.09)
                )
            ),
            array(
                'name' => 'Chrome',
                'id' => 'Chrome',
                'data' => array(
                    array("v19.0", 7.73),
                    array("v17.0", 1.13),
                    array("v16.0", 0.45),
                    array("v18.0", 0.26)
                )
            ),
        );
        $ob->drilldown->series($drilldown);




        /****/

        $series2 = array(
            array(
                'name'  => 'Tramite kopurua',
                'type'  => 'column',
                'color' => '#4572A7',
                'yAxis' => 1,
                'data'  => array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4),
            ),
            array(
                'name'  => 'Bisita',
                'type'  => 'spline',
                'color' => '#AA4643',
                'data'  => array(17.0, 16.9, 19.5, 114.5, 118.2, 211.5, 215.2, 126.5, 123.3, 118.3, 113.9, 9.6),
            ),
        );
        $yData2 = array(
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + "" }'),
                    'style'     => array('color' => '#AA4643')
                ),
                'title' => array(
                    'text'  => 'Bisita kopura',
                    'style' => array('color' => '#AA4643')
                ),
                'opposite' => true,
            ),
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " tramite" }'),
                    'style'     => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text'  => 'Tramiteak',
                    'style' => array('color' => '#4572A7')
                ),
            ),
        );
        $categories2 = array('Urt', 'Ots', 'Mar', 'Api', 'Mai', 'Eka', 'Uzt', 'Abu', 'Ira', 'Urr', 'Aza', 'Abe');

        $ob2 = new Highchart();
        $ob2->chart->renderTo('container'); // The #id of the div where to render the chart
        $ob2->chart->type('column');
        $ob2->title->text('Urteko bisita eta tramite kopurua hilabeteka.');
        $ob2->xAxis->categories($categories2);
        $ob2->yAxis($yData2);
        $ob2->legend->enabled(false);
        $formatter = new Expr('function () {
                 var unit = {
                     "Rainfall": "mm",
                     "Temperature": "degrees C"
                 }[this.series.name];
                 return this.x + ": <b>" + this.y + "</b> " + unit;
             }');
        $ob2->tooltip->formatter($formatter);
        $ob2->series($series2);








        return $this->render( 'chart/index.html.twig', array(
            'chart' => $ob,
            'chart2'=>$ob2
        ));
    }
}
