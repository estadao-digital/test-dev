<?php

namespace File;

class Converter
{
    public static function XLStoCSV($inputPathXLS, $outputPathCSV)
    {
        if (!\File::exists($inputPathXLS))
            return false;
            
        if (!\File::exists($outputPathCSV))
        {
            \File::setContents($outputPathCSV, "");
            return false;
        }
            

        require_once __KRUPA_PATH_INTERNAL__ . 'Extension/PHPExcel/PHPExcel.php';
        
        $fileType = \PHPExcel_IOFactory::identify($inputPathXLS);
        $objReader = \PHPExcel_IOFactory::createReader($fileType);

        $objReader->setReadDataOnly(true);   
        $objPHPExcel = $objReader->load($inputPathXLS);    
     
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        
        $objWriter->save($outputPathCSV);
        return true;
    }
 
    public static function XLStoHTML($inputPathXLS, $outputPathCSV)
    {
        if (!\File::exists($inputPathXLS))
            return false;
            
        if (!\File::exists($outputPathCSV))
        {
            \File::setContents($outputPathCSV, "");
            return false;
        }
        
        require_once __KRUPA_PATH_INTERNAL__ . 'Extension/PHPExcel/PHPExcel.php';
        
        $fileType = \PHPExcel_IOFactory::identify($inputPathXLS);
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
 
        $objReader->setReadDataOnly(true);   
        $objPHPExcel = $objReader->load($inputPathXLS);    
     
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
        
        $objWriter->save($outputPathCSV);
        return true;
    }
}