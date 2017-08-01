<?php

namespace App;

use mPDF;
use App\Models\Star;
use App\Models\Order;

class StarKit
{
    /** @var Order */
    protected $order;

    /** @var Star */
    protected $star;

    /** @var \mPDF */
    protected $mpdf;

    /** @var mixed */
    protected $ra;

    /** @var string */
    protected $raConverted;

    /** @var mixed */
    protected $dec;

    /** @var string */
    protected $decConverted;

    /** @var array */
    protected $ids;

    /** @var mixed */
    protected $vmag;

    /** @var mixed */
    protected $ppmxlId;

    /** @var mixed */
    protected $orderName;

    /** @var mixed */
    protected $createdAt;

    /** @var string */
    protected $storagePath;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->star = $order->star;

        $this->raConverted = Star::convert_ra($this->star->ra);
        $this->decConverted = Star::convert_dec($this->star->decl);

        $this->ids = array();
        $this->ids[] = $this->star->name;
        if (!empty($this->star->hd)) {
            $this->ids[] = "Henry Draper Catalog (HD or HDE) " . $this->star->hd;
        }
        if (!empty($this->star->dm)) {
            $this->ids[] = "Durchmusterung Identification " . $this->star->dm;
        }
        if (!empty($this->star->gc)) {
            $this->ids[] = "Boss General Catalog (GC) " . $this->star->gc;
        }

        $this->ra = $this->star->ra;
        $this->dec = $this->star->decl;
        $this->vmag = $this->star->vmag;
        $this->ppmxlId = $this->star->ppmxl_id;
        $this->orderName = $order->name;
        $this->createdAt = $order->created_at;

        $this->storagePath = storage_path('pdfs/' . md5($this->order->id . date("m-d-Y", strtotime($this->order->created_at))) . '.pdf');

        $this->mpdf = new mPDF('c','A4-L', '', '', 0, 0, 0, 0);
    }

    /** Public methods */

    public function buildKit()
    {
        $this->addStarMapPage();
        $this->addCertificatePage();
        $this->addClosingPage();
    }

    public function output()
    {
        $this->mpdf->Output();
    }

    /**
     * @return mixed
     */
    public function outputFromDisk()
    {
        return \Response::make(file_get_contents($this->storagePath), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; PDF-StarKit.pdf',
        ]);
    }

    /**
     * @return mixed
     */
    public function downloadFromDisk()
    {
        return \Response::download($this->storagePath, 'PDF-StarKit.pdf', ['Content-Type: application/pdf']);
    }

    public function saveToDisk()
    {
        $this->mpdf->Output($this->storagePath, 'F');
    }

    /**
     * @return mixed
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /** Internal protected methods */

    protected function addStarMapPage()
    {
        $viewData = [
            'orderName' => $this->orderName,
            'vmag' => $this->vmag,
            'ids' => $this->ids,
            'raConverted' => $this->raConverted,
            'ra' => $this->ra,
            'decConverted' => $this->decConverted,
            'dec' => $this->dec
        ];

        $this->mpdf->WriteHTML(\View::make('pdf.star-map', $viewData)->render());

        $this->mpdf->Image(public_path('images/star_maps/' . $this->order->star_map), 12, 1, 0, 0, '', '', true, true);
        $this->mpdf->Image(public_path('images/maps_border.png'), 12, 1, 0, 0, '', '', true, true);
        $this->mpdf->Image(public_path('images/' . $this->order->zodiac . '_256.png'), 236, 140, 50, 50, '', '', true, true);
        $this->mpdf->Image(public_path('images/comet.png'), 25, 10, 50, 40, '', '', true, true);
        // min x = 50, max x = 225, min y = 25, max y = 163
        $this->mpdf->Image(public_path('images/circle_star.png'), $this->order->star_x, $this->order->star_y, 15, 15, '', '', true, true);
    }

    protected function addCertificatePage()
    {
        $this->mpdf->AddPage('P', '', '', '', '', 50, 50, 50, 50, 10, 10);

        $this->mpdf->Image(public_path('images/certificate2.png'), 0, 0, 208, 298, '', '', true, false);
        $this->mpdf->Image(public_path('images/' . $this->order->zodiac . '_256.png'), 35, 182, 65, 65, '', '', true, true);

        $viewData = [
            'createdAt' => $this->createdAt,
            'ppmxlId' => $this->ppmxlId,
            'starName' => $this->star->name,
            'prefix' => $this->order->getDedicationPrefix(),
            'orderName' => $this->orderName,
            'raConverted' => $this->raConverted,
            'ra' => $this->ra,
            'decConverted' => $this->decConverted,
            'dec' => $this->dec,
            'vmag' => $this->vmag
        ];

        $this->mpdf->WriteHTML(\View::make('pdf.certificate-content', $viewData)->render());
    }

    protected function addClosingPage()
    {
        $this->mpdf->AddPage('L', '', '', '', '', 50, 50, 50, 50, 10, 10);
        $this->mpdf->WriteHTML(\View::make('pdf.closing')->render());
    }
}
