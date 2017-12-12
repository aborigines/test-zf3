<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Cache\StorageFactory;

class TestController extends AbstractActionController
{
    public function indexAction()
    {
    	$datas = [];

		$cache = StorageFactory::factory([
			'adapter' => 'filesystem',
			'plugins' => ['serializer'],
			'lifetime' => 3600,
		]);

		// nMultipleNMinus1
		$nMultipleNMinus1Key = 'nMultipleNMinus1';
		$nMultipleNMinus1Value = 3;
		$nMultipleNMinus1Format = '%s [3,5,9,15,x] , x = %d';
		if($cache->hasItem($nMultipleNMinus1Key))
		{
			$value = $cache->getItem($nMultipleNMinus1Key);
			$datas[0] = sprintf($nMultipleNMinus1Format,
				'Cache',
				$this->nMultipleNMinus1($value)
			);
		}
		else
		{
			$cache->setItem($nMultipleNMinus1Key, $nMultipleNMinus1Value);
			$datas[0] = sprintf($nMultipleNMinus1Format,
				'',
				$this->nMultipleNMinus1($nMultipleNMinus1Value)
			);	
		}

		// find x
		$findXKey = 'findX';
		$findXValue = 99;
		$findXFormat = '%s (x+24)+(10*2) = 99 , x = %d';
		if($cache->hasItem($findXKey))
		{
			$value = $cache->getItem($findXKey);
			$datas[1] = sprintf($findXFormat,
				'Cache',
				$this->findX($value)
			);	
		}
		else
		{
			$cache->setItem($findXKey, $findXValue);
			$datas[1] = sprintf($findXFormat,
				'',
				$this->findX($findXValue)
			);				
		}
        return new ViewModel(['datas' => $datas]);
    }

	protected function nMultipleNMinus1($number)
	{
		$data = [];
		for($n = 1; $n <= 5; $n++)
		{
			$data[] = $number+($n*($n-1));
		}
		return end($data);
	}

	protected function findX($result)
	{
		return ($result-24)-(10*2);
	}

	public function clearCacheAction()
	{
		$cache = StorageFactory::factory([
			'adapter' => 'filesystem',
			'plugins' => ['serializer'],
			'lifetime' => 3600,
		]);

		$cache->flush();
		return new ViewModel();
	}
}
