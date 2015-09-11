<?php

class Earthboundco_CatalogImageHelper_Helper_Image extends Mage_Catalog_Helper_Image
{
    public function __toString()
    {
        try {
            $model = $this->_getModel();

            Mage::log("Hello");

            // This is the only addition. All this hassle for one line. Ah, Magento.
            $model->setQuality(90);

            if ($this->getImageFile()) {
                $model->setBaseFile($this->getImageFile());
            } else {
                $model->setBaseFile($this->getProduct()->getData($model->getDestinationSubdir()));
            }

            if ($model->isCached()) {
                return $model->getUrl();
            } else {
                if ($this->_scheduleRotate) {
                    $model->rotate($this->getAngle());
                }

                if ($this->_scheduleResize) {
                    $model->resize();
                }

                if ($this->getWatermark()) {
                    $model->setWatermark($this->getWatermark());
                }

                $url = $model->saveFile()->getUrl();
            }
        } catch (Exception $e) {
            $url = Mage::getDesign()->getSkinUrl($this->getPlaceholder());
        }
        return $url;
    }
}
