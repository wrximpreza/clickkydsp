<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use Project\App\HTTPProcessors\Processor\UserProtected;
use PHPHtmlParser\Dom;
use \Curl\Curl;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use PHPixie\Debug;

/**
 * User dashboard
 */
class Dashboard extends UserProtected
{
    private $curl = null;
    private $login = 'clickky';
    private $password = 'Temp123#!';
    private $log;

    /*public function __construct()
    {
        $this->log = new Logger('parserfeed');
        $this->log->pushHandler(new StreamHandler(__DIR__.'/logs.log', Logger::ERROR));
    }*/

    /**
     * @param Request $request
     * @return mixed
     */
    public function defaultAction(Request $request)
    {

        if($this->loginClickky()){
            $dsps = $this->get('dsp');
            $ssps = $this->get('ssp');
        }
        return $this->components->template()->get('app:user/dashboard', array(
            'user' => $this->user,
            'dsps' => $dsps,
            'ssps' => $ssps
        ));

    }


    private function loginClickky(){
        $this->curl = new Curl();

        $this->curl->post('http://clickkydsp.com/login', array(
            'email' => $this->login,
            'password' => $this->password,
            'remember'=> 1
        ));

        if ($this->curl->error) {
             return false;
        }
        foreach ($this->curl->responseCookies as $k => $v) {
                $this->curl->setCookie($k, $v);
        }
        return true;
    }

    private function get($type){
        $dom = new Dom;

        $slice = new \PHPixie\Slice();
        $http = new \PHPixie\HTTP($slice);
        $request = $http->request();
        $query = $request->query();


        $url = 'http://clickkydsp.com/'.$type;
        $this->curl->get($url);
        if (!$this->curl->error) {

            $dom->load($this->curl->response);
            $contents = $dom->find('.table-scrollable tbody tr');

            $lists = array();
            $total_responses = 0;
            $total_impressions = 0;
            $total_revenue = 0;

            foreach ($contents as $content) {

                if($type == 'ssp'){
                    $name = strip_tags($content->find('td', 1)->InnerHtml);
                    $apiLink = $content->find('td', 13)->find('a')->getAttribute('href');
                }else{
                    $name = strip_tags($content->find('td', 1)->find('a')->InnerHtml);
                    $apiLink = $content->find('td', 14)->find('a')->getAttribute('href');
                }

                $url = parse_url($apiLink);
                $url_query = \GuzzleHttp\Psr7\parse_query($url['query']);

                $url_query['start'] = date('Y-d-m', time());
                $url_query['end'] = date('Y-d-m', time());

                $date = '';

                if($query->get('date')==2){

                    $url_query['end'] = date('Y-d-m', strtotime("-1 day"));
                    $date = date('d-m-Y', strtotime("-1 day")).' - '.date('d-m-Y', time());

                }elseif($query->get('date')==3){

                    $url_query['end'] = date('Y-d-m',  strtotime("-1 week"));
                    $date = date('d-m-Y', strtotime("-1 week")).' - '.date('d-m-Y', time());

                }elseif($query->get('date')==4){

                    $url_query['end'] = date('Y-d-m',  strtotime("-1 month"));
                    $date = date('d-m-Y', strtotime("-1 month")).' - '.date('d-m-Y', time());

                }elseif ($query->get('date')==5){
                    $date = '';
                    if($query->get('from')!=''){
                        $url_query['start'] = date('Y-d-m', strtotime($query->get('from')));
                        $date .= date('d-m-Y', strtotime($query->get('from')));
                    }else{
                        $date .= date('d-m-Y', time());
                    }

                    if($query->get('to')!=''){
                        $url_query['end'] = date('Y-d-m', strtotime($query->get('to')));
                        $date .= ' - '.date('d-m-Y', strtotime($query->get('to')));
                    }else{
                        $date .= ' - '.date('d-m-Y', time());
                    }

                }else{
                    $date = date('d-m-Y', time());
                }

                $result_url = $url['scheme'].'://'.$url['host'].$url['path'].'?'.http_build_query($url_query);

                try {
                    $xml = simplexml_load_file($result_url);

                    $responses = 0;
                    $impressions = 0;
                    $revenue = 0;

                    foreach ($xml->breakdown as $breakdown){
                        $responses += (int)$breakdown->responses;
                        $impressions += (int)$breakdown->impressions;
                        $revenue += (int)$breakdown->revenue;
                    }

                    $lists[$name] = array(
                        'responses' => $responses,
                        'impressions' => $impressions,
                        'revenue' => $revenue,
                        'selected_date' => $date
                    );

                    $total_responses += $responses;
                    $total_impressions += $impressions;
                    $total_revenue += $revenue;

                }catch (\Exception $e){
                    $lists[$name] = array(
                        'responses' => 'No load page',
                        'impressions' => 'No load page',
                        'revenue' => 'No load page',
                        'selected_date' => $date
                    );
                }


            }

            if(count($lists)>0) {
                $lists['total'] = array(
                    'responses' => $total_responses,
                    'impressions' => $total_impressions,
                    'revenue' => $total_revenue
                );
            }

            return $lists;

        }else{
            return false;
        }
    }

}