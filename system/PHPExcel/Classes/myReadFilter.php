<?php

// we use the PHPExcel package from http://phpexcel.codeplex.com/
	$cwd = getcwd();
    chdir( DIR_SYSTEM.'PHPExcel' );
	require_once( 'Classes/PHPExcel.php' );
	chdir( $cwd );

class myReadFilter implements PHPExcel_Reader_IReadFilter
{
    private $_startRow = 0;

    private $_endRow = 0;
	

    /**  Set the list of rows that we want to read  */
    public function setRows($startRow, $chunksize) {
        $this->_startRow    = $startRow;
        $this->_endRow      = $startRow + $chunksize;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
        if (($row >= $this->_startRow && $row < $this->_endRow)) {
            return true;
        }
        return false;
    }
}

?>