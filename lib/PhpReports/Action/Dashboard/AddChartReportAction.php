<?php
namespace PhpReports\Action\Dashboard;

use PhpReports\Action\Action;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;

class AddChartReportAction extends Action {

	/** @var Report */
	protected $report;

	/** @var string */
	protected $chart;

	public function collect() {
		$this->report = ReportQuery::create()->findOneById((int)$this->request->data['report']);
		$this->chart = str_replace('data:image/png;base64,', '', $this->request->data['chart']);
	}

	public function validate() {
		if (!$this->report instanceof Report) {
			$this->validationErrors[] = new \Exception('Report is not found');
		}
		if (!$this->checkBase64Image($this->chart)) {
			$this->validationErrors[] = new \Exception('The given base64 string is not a valid image');
		}
		return (count($this->validationErrors) > 0 ? false : true);
	}

	/**
	 * Checks if the given base64 string is a valid image resource
	 * @param $base64
	 * @return bool
	 */
	protected function checkBase64Image($base64) {
		$image = imagecreatefromstring(base64_decode($base64));
		if (!$image) {
			return false;
		}

		imagepng($image, $this->report->getId() . 'tmp.png');
		$chartImageInfo = getimagesize($this->report->getId() . 'tmp.png');

		unlink($this->report->getId() . 'tmp.png');

		if ($chartImageInfo[0] > 0 && $chartImageInfo[1] > 0 && $chartImageInfo['mime']) {
			return true;
		}

		return false;
	}

	public function execute() {
		$this->report->setChartImage($this->chart);
		$this->report->setChartImageUpdatedAt(new \DateTime());
		$this->report->save();
	}
}