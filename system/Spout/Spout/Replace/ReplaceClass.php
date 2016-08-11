<?php

namespace Box\Spout\Reader\XLSX;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Reader\XLSX\RowIterator;
use Box\Spout\Common\Type;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Reader\Exception\XMLProcessingException;
use Box\Spout\Reader\IteratorInterface;
use Box\Spout\Reader\Wrapper\XMLReader;
use Box\Spout\Reader\XLSX\Helper\CellHelper;
use Box\Spout\Reader\XLSX\Helper\CellValueFormatter;
use Box\Spout\Reader\XLSX\Helper\StyleHelper;


   $cwd = getcwd();
   chdir( DIR_SYSTEM.'Spout' );
   require_once( 'Spout/Reader/XLSX/RowIterator.php' );
   chdir( $cwd );
   
   
   class CountRow extends RowIterator
   {
   
   
        public function MaxRow()
		{
		     $dimensionRef = $this->xmlReader->getAttribute(self::XML_ATTRIBUTE_REF);
		     return $dimensionRef;
		}
   
   
   
   
   
   
   }


















