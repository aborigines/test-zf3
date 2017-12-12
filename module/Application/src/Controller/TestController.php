<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TestController extends AbstractActionController
{
    public function indexAction()
    {
    	var_dump($this->nMultipleNMinus1(3));
    	echo PHP_EOL;
    	var_dump($this->findX(99));
        return new ViewModel();
    }

	protected function nMultipleNMinus1($number)
	{
		$data = [];
		for($n = 1; $n <= 6; $n++)
		{
			$data[] = $number+($n*($n-1));
		}
		return $data;
	}

	protected function findX($result)
	{
		return ($result-24)-(10*2);
	}
}
